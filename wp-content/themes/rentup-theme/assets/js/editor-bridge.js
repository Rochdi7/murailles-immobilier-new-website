(function($) {
	'use strict';

	function openMediaFrame(targetId) {
		var field = $('#' + targetId);
		if (!field.length) {
			return;
		}

		var frame = wp.media({
			title: 'Select image',
			button: {
				text: 'Use this image'
			},
			multiple: false
		});

		frame.on('select', function() {
			var attachment = frame.state().get('selection').first().toJSON();
			var preview = field.closest('.murailles-media-field').find('.murailles-media-preview');
			var clear = field.closest('.murailles-media-field').find('.murailles-media-clear');
			var imageUrl = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;

			field.val(attachment.id);
			preview.removeClass('is-empty').html('<img src="' + imageUrl + '" alt="" />');
			clear.removeClass('is-hidden');
		});

		frame.open();
	}

	$(document).on('click', '.murailles-media-select', function(event) {
		event.preventDefault();
		openMediaFrame($(this).data('target'));
	});

	$(document).on('click', '.murailles-media-clear', function(event) {
		event.preventDefault();

		var field = $('#' + $(this).data('target'));
		var preview = field.closest('.murailles-media-field').find('.murailles-media-preview');

		field.val('');
		preview.addClass('is-empty').html('<span>No image selected. The frontend fallback image will be used.</span>');
		$(this).addClass('is-hidden');
	});
})(jQuery);
