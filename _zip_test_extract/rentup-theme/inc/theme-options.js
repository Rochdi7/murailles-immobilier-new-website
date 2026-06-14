/**
 * Murailles Immobilier — Theme Options (Phase 1 redesign)
 * Vanilla JS. Loaded ONLY on the options page. Uses wp.media (global) for uploads.
 * Does NOT touch the shared admin-assets.js used by property/agent meta boxes.
 */
(function () {
	'use strict';

	var app = document.querySelector('.murailles-app');
	if (!app) { return; }

	/* ─────────────────────────────────────────────────────────────────────────
	   MEDIA: pick / replace / remove + drag-drop, with live thumbnail
	───────────────────────────────────────────────────────────────────────── */
	function setMedia(field, url) {
		var input   = field.querySelector('.mi-media-input');
		var preview = field.querySelector('.mi-media-preview');
		var empty   = field.querySelector('.mi-media-empty');
		var removeB = field.querySelector('.mi-media-remove');
		if (input) { input.value = url || ''; }

		var img = preview ? preview.querySelector('img') : null;
		if (url) {
			if (!img) {
				img = document.createElement('img');
				preview.appendChild(img);
			}
			img.src = url;
			if (empty) { empty.style.display = 'none'; }
			if (removeB) { removeB.style.display = ''; }
		} else {
			if (img) { img.remove(); }
			if (empty) { empty.style.display = ''; }
			if (removeB) { removeB.style.display = 'none'; }
		}
		// Notify live-preview listeners (Phase 2)
		app.dispatchEvent(new CustomEvent('mi:media-change', { detail: { field: field } }));
	}

	function openMediaFrame(field) {
		if (typeof wp === 'undefined' || !wp.media) { return; }
		var frame = wp.media({
			title: 'Choisir une image',
			button: { text: 'Utiliser cette image' },
			multiple: false
		});
		frame.on('select', function () {
			var att = frame.state().get('selection').first().toJSON();
			setMedia(field, att.url);
		});
		frame.open();
	}

	app.addEventListener('click', function (e) {
		var pick = e.target.closest('.mi-media-pick');
		if (pick) {
			e.preventDefault();
			openMediaFrame(pick.closest('.mi-media'));
			return;
		}
		var rem = e.target.closest('.mi-media-remove');
		if (rem) {
			e.preventDefault();
			setMedia(rem.closest('.mi-media'), '');
			return;
		}
	});

	// Drag & drop onto the preview box opens the library (browser cannot upload
	// a dropped file straight to wp.media reliably, so we open the picker — the
	// drop gesture is a familiar affordance).
	app.querySelectorAll('.mi-media-preview').forEach(function (box) {
		['dragenter', 'dragover'].forEach(function (ev) {
			box.addEventListener(ev, function (e) { e.preventDefault(); box.classList.add('is-dragover'); });
		});
		['dragleave', 'drop'].forEach(function (ev) {
			box.addEventListener(ev, function (e) { e.preventDefault(); box.classList.remove('is-dragover'); });
		});
		box.addEventListener('drop', function () { openMediaFrame(box.closest('.mi-media')); });
		box.addEventListener('click', function () {
			var field = box.closest('.mi-media');
			if (field && !field.querySelector('.mi-media-input').value) { openMediaFrame(field); }
		});
	});

	/* ─────────────────────────────────────────────────────────────────────────
	   REPEATER: add / remove / reorder. Re-indexes name="prefix[N][key]".
	───────────────────────────────────────────────────────────────────────── */
	function reindex(container) {
		var prefix = container.getAttribute('data-prefix');
		var rows = container.querySelectorAll(':scope > .mi-repeat-row');
		rows.forEach(function (row, i) {
			var num = row.querySelector('.mi-repeat-num');
			if (num) { num.textContent = i + 1; }
			row.querySelectorAll('[name]').forEach(function (input) {
				var name = input.getAttribute('name');
				// prefix[<anything>][key]  ->  prefix[i][key]
				var re = new RegExp('^' + prefix.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '\\[\\d+\\]');
				if (re.test(name)) {
					input.setAttribute('name', name.replace(re, prefix + '[' + i + ']'));
				}
			});
		});
	}

	app.addEventListener('click', function (e) {
		// Add row: clone the template stored in the container's <template>
		var addBtn = e.target.closest('.mi-repeat-add');
		if (addBtn) {
			e.preventDefault();
			var container = document.querySelector(addBtn.getAttribute('data-target'));
			var tpl = container.querySelector('template.mi-repeat-tpl');
			if (tpl) {
				var node = tpl.content.firstElementChild.cloneNode(true);
				container.insertBefore(node, tpl);
				wireRow(node);
				reindex(container);
				node.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
				node.querySelector('input, textarea') && node.querySelector('input, textarea').focus();
			}
			return;
		}
		// Remove row
		var del = e.target.closest('.mi-repeat-del');
		if (del) {
			e.preventDefault();
			var row = del.closest('.mi-repeat-row');
			var cont = row.parentElement;
			if (window.confirm('Supprimer cet élément ?')) {
				row.remove();
				reindex(cont);
			}
			return;
		}
	});

	// Drag-to-reorder using the handle (HTML5 DnD, no jQuery UI)
	function wireRow(row) {
		var handle = row.querySelector('.mi-repeat-handle');
		if (!handle) { return; }
		handle.setAttribute('draggable', 'true');
		handle.addEventListener('dragstart', function (e) {
			row.classList.add('is-dragging');
			e.dataTransfer.effectAllowed = 'move';
			e.dataTransfer.setData('text/plain', '');
		});
		handle.addEventListener('dragend', function () {
			row.classList.remove('is-dragging');
			row.parentElement.querySelectorAll('.drop-target').forEach(function (r) { r.classList.remove('drop-target'); });
			reindex(row.parentElement);
		});
	}

	app.querySelectorAll('.mi-repeater').forEach(function (container) {
		container.querySelectorAll(':scope > .mi-repeat-row').forEach(wireRow);
		container.addEventListener('dragover', function (e) {
			e.preventDefault();
			var dragging = container.querySelector('.is-dragging');
			if (!dragging) { return; }
			var after = getDragAfter(container, e.clientY);
			if (after == null) { container.insertBefore(dragging, container.querySelector('template.mi-repeat-tpl')); }
			else { container.insertBefore(dragging, after); }
		});
	});

	function getDragAfter(container, y) {
		var rows = Array.prototype.slice.call(
			container.querySelectorAll(':scope > .mi-repeat-row:not(.is-dragging)')
		);
		return rows.reduce(function (closest, child) {
			var box = child.getBoundingClientRect();
			var offset = y - box.top - box.height / 2;
			if (offset < 0 && offset > closest.offset) { return { offset: offset, element: child }; }
			return closest;
		}, { offset: -Infinity, element: null }).element;
	}

	/* ─────────────────────────────────────────────────────────────────────────
	   LANGUAGE TABS (testimonials FR / EN)
	───────────────────────────────────────────────────────────────────────── */
	app.addEventListener('click', function (e) {
		var tab = e.target.closest('.mi-langtab');
		if (!tab) { return; }
		var group = tab.closest('[data-langgroup]');
		var lang = tab.getAttribute('data-lang');
		group.querySelectorAll('.mi-langtab').forEach(function (t) {
			t.classList.toggle('is-active', t === tab);
			t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
		});
		group.querySelectorAll('.mi-langpane').forEach(function (p) {
			p.classList.toggle('is-active', p.getAttribute('data-lang') === lang);
		});
	});

	/* ─────────────────────────────────────────────────────────────────────────
	   CHARACTER COUNTERS (SEO description, etc.)  data-counter="min,max"
	───────────────────────────────────────────────────────────────────────── */
	app.querySelectorAll('[data-counter]').forEach(function (input) {
		var out = document.getElementById(input.getAttribute('data-counter-for'));
		if (!out) { return; }
		var range = (input.getAttribute('data-counter') || '0,160').split(',');
		var min = parseInt(range[0], 10), max = parseInt(range[1], 10);
		function update() {
			var n = input.value.length;
			out.textContent = n + ' / ' + max;
			out.classList.remove('is-good', 'is-warn', 'is-over');
			if (n > max) { out.classList.add('is-over'); }
			else if (n >= min) { out.classList.add('is-good'); }
			else { out.classList.add('is-warn'); }
		}
		input.addEventListener('input', update);
		update();
	});

})();
