(function($) {
$(function() {
    "use strict";

	// Preloader — hide on window load (all assets done), not just DOM ready.
	// The CSS-only 2 s fallback in header.php covers JS errors / slow networks.
	function muraillesHidePreloader() {
		$('.preloader').stop(true, true).fadeOut(300, function() {
			$(this).remove();
		});
	}
	$(window).on('load', muraillesHidePreloader);
	// Safety net: also dismiss on DOM ready in case window.load already fired
	// (e.g. cached page where resources arrive before the script runs).
	$(document).ready(function() {
		if (document.readyState === 'complete') {
			muraillesHidePreloader();
		}
	});
	$(".preloader_disabler").on('click', function() {
		muraillesHidePreloader();
	});
	
	// Tooltip
	if ( window.bootstrap && typeof bootstrap.Tooltip === 'function' ) {
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		tooltipTriggerList.map(function(tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl);
		});
	}
	
	// Script Navigation
	! function(n, e, i, a) {
		n.navigation = function(t, s) {
			var o = {
					responsive: !0,
					mobileBreakpoint:992,
					showDuration: 300,
					hideDuration: 300,
					showDelayDuration: 0,
					hideDelayDuration: 0,
					submenuTrigger: "hover",
					effect: "fade",
					submenuIndicator: !0,
					hideSubWhenGoOut: !0,
					visibleSubmenusOnMobile: !1,
					fixed: !1,
					overlay: !0,
					overlayColor: "rgba(0, 0, 0, 0.5)",
					hidden: !1,
					offCanvasSide: "left",
					onInit: function() {},
					onShowOffCanvas: function() {},
					onHideOffCanvas: function() {}
				},
				u = this,
				r = Number.MAX_VALUE,
				d = 1,
				f = "click.nav touchstart.nav",
				l = "mouseenter.nav",
				c = "mouseleave.nav";
			u.settings = {};
			var t = (n(t), t);
			n(t).find(".nav-menus-wrapper").prepend("<span class='nav-menus-wrapper-close-button'>✕</span>"), n(t).find(".nav-search").length > 0 && n(t).find(".nav-search").find("form").prepend("<span class='nav-search-close-button'>✕</span>"), u.init = function() {
				u.settings = n.extend({}, o, s), "right" == u.settings.offCanvasSide && n(t).find(".nav-menus-wrapper").addClass("nav-menus-wrapper-right"), u.settings.hidden && (n(t).addClass("navigation-hidden"), u.settings.mobileBreakpoint = 99999), v(), u.settings.fixed && n(t).addClass("navigation-fixed"), n(t).find(".nav-toggle").on("click touchstart", function(n) {
					n.stopPropagation(), n.preventDefault(), u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")
				}), n(t).find(".nav-menus-wrapper-close-button").on("click touchstart", function(n) {
					n && n.preventDefault && n.preventDefault(), n && n.stopPropagation && n.stopPropagation(), u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")
				}), n(t).find(".nav-search-button").on("click touchstart", function(n) {
					n.stopPropagation(), n.preventDefault(), u.toggleSearch()
				}), n(t).find(".nav-search-close-button").on("click touchstart", function() {
					u.toggleSearch()
				}), n(t).find(".megamenu-tabs").length > 0 && y(), n(e).resize(function() {
					m(), C()
				}), m(), s !== a && u.callback("onInit")
			};
			var v = function() {
				n(t).find("li").each(function() {
					n(this).children(".nav-dropdown,.megamenu-panel").length > 0 && (n(this).children(".nav-dropdown,.megamenu-panel").addClass("nav-submenu"), u.settings.submenuIndicator && n(this).children("a").append("<span class='submenu-indicator'><span class='submenu-indicator-chevron'></span></span>"))
				})
			};
			u.showSubmenu = function(e, i) {
				g() > u.settings.mobileBreakpoint && n(t).find(".nav-search").find("form").slideUp(), "fade" == i ? n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).fadeIn(u.settings.showDuration) : n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).slideDown(u.settings.showDuration), n(e).addClass("nav-submenu-open")
			}, u.hideSubmenu = function(e, i) {
				"fade" == i ? n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).fadeOut(u.settings.hideDuration) : n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).slideUp(u.settings.hideDuration), n(e).removeClass("nav-submenu-open").find(".nav-submenu-open").removeClass("nav-submenu-open")
			};
			var h = function() {
					n("body").addClass("no-scroll"), u.settings.overlay && (n(t).append("<div class='nav-overlay-panel'></div>"), n(t).find(".nav-overlay-panel").css("background-color", u.settings.overlayColor).fadeIn(300).on("click touchstart", function(n) {
						u.hideOffcanvas()
					}))
				},
				p = function() {
					n("body").removeClass("no-scroll"), u.settings.overlay && n(t).find(".nav-overlay-panel").fadeOut(400, function() {
						n(this).remove()
					})
				};
			u.showOffcanvas = function() {
				h(), "left" == u.settings.offCanvasSide ? n(t).find(".nav-menus-wrapper").css("transition-property", "left").addClass("nav-menus-wrapper-open") : n(t).find(".nav-menus-wrapper").css("transition-property", "right").addClass("nav-menus-wrapper-open")
			}, u.hideOffcanvas = function() {
				n(t).find(".nav-menus-wrapper").removeClass("nav-menus-wrapper-open").on("webkitTransitionEnd moztransitionend transitionend oTransitionEnd", function() {
					n(t).find(".nav-menus-wrapper").css("transition-property", "none").off()
				}), p()
			}, u.toggleOffcanvas = function() {
				g() <= u.settings.mobileBreakpoint && (n(t).find(".nav-menus-wrapper").hasClass("nav-menus-wrapper-open") ? (u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")) : (u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")))
			}, u.toggleSearch = function() {
				"none" == n(t).find(".nav-search").find("form").css("display") ? (n(t).find(".nav-search").find("form").slideDown(), n(t).find(".nav-submenu").fadeOut(200)) : n(t).find(".nav-search").find("form").slideUp()
			};
			var m = function() {
					u.settings.responsive ? (g() <= u.settings.mobileBreakpoint && r > u.settings.mobileBreakpoint && (n(t).addClass("navigation-portrait").removeClass("navigation-landscape"), D()), g() > u.settings.mobileBreakpoint && d <= u.settings.mobileBreakpoint && (n(t).addClass("navigation-landscape").removeClass("navigation-portrait"), k(), p(), u.hideOffcanvas()), r = g(), d = g()) : k()
				},
				b = function() {
					n("body").on("click.body touchstart.body", function(e) {
						0 === n(e.target).closest(".navigation").length && (n(t).find(".nav-submenu").fadeOut(), n(t).find(".nav-submenu-open").removeClass("nav-submenu-open"), n(t).find(".nav-search").find("form").slideUp())
					})
				},
				g = function() {
					return e.innerWidth || i.documentElement.clientWidth || i.body.clientWidth
				},
				w = function() {
					n(t).find(".nav-menu").find("li, a").off(f).off(l).off(c)
				},
				C = function() {
					if (g() > u.settings.mobileBreakpoint) {
						var e = n(t).outerWidth(!0);
						n(t).find(".nav-menu").children("li").children(".nav-submenu").each(function() {
							n(this).parent().position().left + n(this).outerWidth() > e ? n(this).css("right", 0) : n(this).css("right", "auto")
						})
					}
				},
				y = function() {
					function e(e) {
						var i = n(e).children(".megamenu-tabs-nav").children("li"),
							a = n(e).children(".megamenu-tabs-pane");
						n(i).on("click.tabs touchstart.tabs", function(e) {
							e.stopPropagation(), e.preventDefault(), n(i).removeClass("active"), n(this).addClass("active"), n(a).hide(0).removeClass("active"), n(a[n(this).index()]).show(0).addClass("active")
						})
					}
					if (n(t).find(".megamenu-tabs").length > 0)
						for (var i = n(t).find(".megamenu-tabs"), a = 0; a < i.length; a++) e(i[a])
				},
				k = function() {
					w(), n(t).find(".nav-submenu").hide(0), navigator.userAgent.match(/Mobi/i) || navigator.maxTouchPoints > 0 || "click" == u.settings.submenuTrigger ? n(t).find(".nav-menu, .nav-dropdown").children("li").children("a").on(f, function(i) {
						if (u.hideSubmenu(n(this).parent("li").siblings("li"), u.settings.effect), n(this).closest(".nav-menu").siblings(".nav-menu").find(".nav-submenu").fadeOut(u.settings.hideDuration), n(this).siblings(".nav-submenu").length > 0) {
							if (i.stopPropagation(), i.preventDefault(), "none" == n(this).siblings(".nav-submenu").css("display")) return u.showSubmenu(n(this).parent("li"), u.settings.effect), C(), !1;
							if (u.hideSubmenu(n(this).parent("li"), u.settings.effect), "_blank" == n(this).attr("target") || "blank" == n(this).attr("target")) e.open(n(this).attr("href"));
							else {
								if ("#" == n(this).attr("href") || "" == n(this).attr("href")) return !1;
								e.location.href = n(this).attr("href")
							}
						}
					}) : n(t).find(".nav-menu").find("li").on(l, function() {
						u.showSubmenu(this, u.settings.effect), C()
					}).on(c, function() {
						u.hideSubmenu(this, u.settings.effect)
					}), u.settings.hideSubWhenGoOut && b()
				},
				D = function() {
					w(), n(t).find(".nav-submenu").hide(0), u.settings.visibleSubmenusOnMobile ? n(t).find(".nav-submenu").show(0) : (n(t).find(".nav-submenu").hide(0), n(t).find(".submenu-indicator").removeClass("submenu-indicator-up"), u.settings.submenuIndicator ? n(t).find(".submenu-indicator").on(f, function(e) {
						return e.stopPropagation(), e.preventDefault(), u.hideSubmenu(n(this).parent("a").parent("li").siblings("li"), "slide"), u.hideSubmenu(n(this).closest(".nav-menu").siblings(".nav-menu").children("li"), "slide"), "none" == n(this).parent("a").siblings(".nav-submenu").css("display") ? (n(this).addClass("submenu-indicator-up"), n(this).parent("a").parent("li").siblings("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), n(this).closest(".nav-menu").siblings(".nav-menu").find(".submenu-indicator").removeClass("submenu-indicator-up"), u.showSubmenu(n(this).parent("a").parent("li"), "slide"), !1) : (n(this).parent("a").parent("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), void u.hideSubmenu(n(this).parent("a").parent("li"), "slide"))
					}) : k())
				};
			u.callback = function(n) {
				s[n] !== a && s[n].call(t)
			}, u.init()
		}, n.fn.navigation = function(e) {
			return this.each(function() {
				if (a === n(this).data("navigation")) {
					var i = new n.navigation(this, e);
					n(this).data("navigation", i)
				}
			})
		}
	}
	(jQuery, window, document), $(document).ready(function() {
		if ( typeof $.fn.navigation === 'function' && $("#navigation").length ) {
			$("#navigation").navigation();
		}
	});
	
	
	// Script Show Calling Number
	$('#number').on('click', function() {
		var tel = $(this).data('last');
		$(this).find('span').html( '<a href="tel:' + tel + '">' + tel + '</a>' );
	});
	
	
	// Script For Select Adult & Child Number
	$(function() {

	  var guestAmount = $('#guestNo');

	  $('#cnt-up').on('click', function() {
		guestAmount.val(Math.min(parseInt($('#guestNo').val()) + 1, 20));
	  });
	  $('#cnt-down').on('click', function() {
		guestAmount.val(Math.max(parseInt($('#guestNo').val()) - 1, 1));
	  });

	});
	
	$(function() {

	  var guestAmount = $('#kidsNo');

	  $('#kcnt-up').on('click', function() {
		guestAmount.val(Math.min(parseInt($('#kidsNo').val()) + 1, 20));
	  });
	  $('#kcnt-down').on('click', function() {
		guestAmount.val(Math.max(parseInt($('#kidsNo').val()) - 1, 0));
	  });
	});
	
	
	// Check In & Check Out Daterange Script
	if ( typeof $.fn.daterangepicker === 'function' ) {
		$(function() {
		  $('input[name="checkout"]').daterangepicker({
			singleDatePicker: true,
		  });
			$('input[name="checkout"]').val('');
			$('input[name="checkout"]').attr("placeholder","Check Out");
		});
		$(function() {
		  $('input[name="checkin"]').daterangepicker({
			singleDatePicker: true,
			
		  });
			$('input[name="checkin"]').val('');
			$('input[name="checkin"]').attr("placeholder","Check In");
		});
	}
	
	
	// Tooltip
	if ( window.bootstrap && typeof bootstrap.Tooltip === 'function' ) {
		$('[data-bs-toggle="tooltip"]').each(function() {
			bootstrap.Tooltip.getOrCreateInstance(this);
		});
	}
	
	
	// Range Slider Script
	if ( typeof $.fn.ionRangeSlider === 'function' ) {
		$(".js-range-slider").ionRangeSlider({
			type: "double",
			min: 0,
			max: 1000,
			from: 200,
			to: 500,
			grid: true
		});
	}
	
	// Bottom To Top Scroll Script
	$(window).on('scroll', function() {
		var height = $(window).scrollTop();
		if (height > 100) {
			$('#back2Top').fadeIn();
		} else {
			$('#back2Top').fadeOut();
		}
	});
	
	
	// Script For Fix Header on Scroll
	$(window).on('scroll', function() {    
		var scroll = $(window).scrollTop();

		if (scroll >= 50) {
			$(".header").addClass("header-fixed");
		} else {
			$(".header").removeClass("header-fixed");
		}
	});
	
	
	// ─── Slick availability flag ────────────────────────────────────────────
	// All carousel inits are gated on this flag so a missing slick bundle
	// (CDN failure, caching edge case) cannot throw uncaught ReferenceErrors.
	var hasSlick = typeof $.fn.slick === 'function';
	var hasMagnific = typeof $.fn.magnificPopup === 'function';

	try { // top-level safety net: one broken slider cannot crash the rest

	// smart_textimonials_style
	if ( hasSlick && $('.modern-testimonial').not('.slick-initialized').length ) {
	$('.modern-testimonial').not('.slick-initialized').slick({
	  slidesToShow:1,
	  arrows: false,
	  dots: true,
	  autoplay:true,
	  responsive: [
		{
		  breakpoint: 768,
		  settings: {
			arrows: false,
			dots: true,
			slidesToShow:1
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			arrows: false,
			dots: true,
			slidesToShow:1
		  }
		}
	  ]
	});
	}

	// smart_textimonials_style
	if ( hasSlick && $('.list_views').not('.slick-initialized').length ) {
	$('.list_views').not('.slick-initialized').slick({
	  slidesToShow:1,
	  arrows: false,
	  dots: true,
	  autoplay:true,
	  responsive: [
		{
		  breakpoint: 768,
		  settings: {
			arrows: false,
			dots: true,
			slidesToShow:1
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			arrows: false,
			dots: true,
			slidesToShow:1
		  }
		}
	  ]
	});
	}

	// Property Slide — outer card carousel.
	// Inner .click image sliders are initialised AFTER Slick has built its DOM
	// (in the 'init' callback below) to avoid nesting conflicts.
	if ( hasSlick && $('.item-slide').not('.slick-initialized').length ) {
	$('.item-slide').not('.slick-initialized').on('init', function() {
		$(this).find('.click').each(function() {
			if ( ! $(this).hasClass('slick-initialized') ) {
				try {
					$(this).slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: false,
						autoplay: true,
						fade: true,
						dots: true,
						autoplaySpeed: 4000,
					});
				} catch(e) { /* inner slider failed silently */ }
			}
		});
	}).slick({
	  slidesToShow:3,
	  slidesToScroll:1,
	  arrows: true,
	  dots: true,
	  infinite: true,
	  autoplaySpeed:4000,
	  autoplay:true,
	  responsive: [
		{
		  breakpoint:1920,
		  settings: {
			arrows: true,
			dots: true,
			slidesToShow:3
		  }
		},
		{
		  breakpoint:993,
		  settings: {
			arrows: true,
			dots: true,
			slidesToShow:2
		  }
		},
		{
		  breakpoint: 600,
		  settings: {
			arrows: true,
			dots: true,
			slidesToShow:1
		  }
		}
	  ]
	});
	}


	// location Slide
	if ( hasSlick && $('.item-slide-2').not('.slick-initialized').length ) {
	$('.item-slide-2').not('.slick-initialized').slick({
	  slidesToShow:3,
	  slidesToScroll:1,
	  arrows: true,
	  dots: true,
	  infinite: true,
	  speed: 500,
	  fade: false,
	  cssEase: 'linear',
	  autoplaySpeed: 2000,
	  centerPadding: '20px',
	  autoplay:true,
	  responsive: [
		{
		  breakpoint: 1024,
		  settings: {
			arrows: true,
			dots: true,
			slidesToShow:2
		  }
		},
		{
		  breakpoint: 600,
		  settings: {
			arrows: true,
			dots: true,
			slidesToShow:1
		  }
		}
	  ]
	});
	}

	// Property Slide
	if ( hasSlick && $('.testi-slide').not('.slick-initialized').length ) {
	$('.testi-slide').not('.slick-initialized').slick({
	  slidesToShow:3,
	  slidesToScroll:1,
	  arrows: true,
	  dots: true,
	  autoplay:true,
	  responsive: [
		{
		  breakpoint: 1023,
		  settings: {
			arrows: true,
			dots: true,
			slidesToShow:2
		  }
		},
		{
		  breakpoint: 768,
		  settings: {
			arrows: true,
			dots: true,
			slidesToShow:2
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			arrows: true,
			dots: true,
			slidesToShow:1
		  }
		}
	  ]
	});
	}

	// Select2 initializations disabled — every <select.form-control> is now
	// enhanced by the murailles-dropdown.js component for design consistency.



	// Home Slider
	if ( hasSlick && $('.home-slider').not('.slick-initialized').length ) {
	$('.home-slider').not('.slick-initialized').slick({
	  centerMode:false,
	  slidesToShow:1,
	  responsive: [
		{
		  breakpoint: 768,
		  settings: {
			arrows:true,
			slidesToShow:1
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			arrows: false,
			slidesToShow:1
		  }
		}
	  ]
	});
	}

	// .click image sliders inside .item-slide are initialised in the
	// .item-slide 'init' callback above to prevent nesting conflicts.
	// For .click sliders that exist OUTSIDE of .item-slide (e.g. standalone
	// property archive cards), init them here with the same guard.
	if ( hasSlick ) {
	$('.click').not('.item-slide .click').not('.slick-initialized').each(function() {
		if ( ! $(this).hasClass('slick-initialized') ) {
			try {
				$(this).slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					autoplay: true,
					fade: true,
					dots: true,
					autoplaySpeed: 4000,
				});
			} catch(e) { /* standalone .click slider failed silently */ }
		}
	});
	}

	// Advance Single Slider — single property gallery (slider-for + slider-nav asNavFor pair).
	// Note: no nested $(function(){}) wrapper — we are already inside DOM ready.
	// Card's slider
	  var $carousel = $('.slider-for').not('.slick-initialized');

	  if ( hasSlick && hasMagnific && $carousel.length ) {
	  $carousel
		.slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  arrows: false,
		  fade: true,
		  adaptiveHeight: true,
		  asNavFor: '.slider-nav'
		})
		.magnificPopup({
		  type: 'image',
		  delegate: 'a:not(.slick-cloned)',
		  closeOnContentClick: false,
		  tLoading: 'Загрузка...',
		  mainClass: 'mfp-zoom-in mfp-img-mobile',
		  image: {
			verticalFit: true,
			tError: '<a href="%url%">Фото #%curr%</a> не загрузилось.'
		  },
		  gallery: {
			enabled: true,
			navigateByImgClick: true,
			tCounter: '<span class="mfp-counter">%curr% из %total%</span>', // markup of counte
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		  },
		  zoom: {
			enabled: true,
			duration: 300
		  },
		  removalDelay: 300, //delay removal by X to allow out-animation
		  callbacks: {
			open: function() {
			  //overwrite default prev + next function. Add timeout for css3 crossfade animation
			  $.magnificPopup.instance.next = function() {
				var self = this;
				self.wrap.removeClass('mfp-image-loaded');
				setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
			  };
			  $.magnificPopup.instance.prev = function() {
				var self = this;
				self.wrap.removeClass('mfp-image-loaded');
				setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
			  };
			  var current = $('.slider-for').slick('slickCurrentSlide');
			  $('.slider-for').magnificPopup('goTo', current);
			  muraillesEnhanceMagnificAccessibility();
			},
			imageLoadComplete: function() {
			  var self = this;
			  setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
			},
			beforeClose: function() {
			  $('.slider-for').slick('slickGoTo', parseInt(this.index));
			}
		  }
		});
	  if ( $('.slider-nav').not('.slick-initialized').length ) {
	  $('.slider-nav').not('.slick-initialized').slick({
		slidesToShow:6,
		slidesToScroll:1,
		asNavFor: '.slider-for',
		dots: false,
		centerMode: false,
		focusOnSelect: true
	  });
	  }
	  } // end if hasSlick && $carousel.length

	// Featured Slick Slider
	if ( hasSlick && $('.featured_slick_gallery-slide').not('.slick-initialized').length ) {
	$('.featured_slick_gallery-slide').not('.slick-initialized').slick({
		centerMode: true,
		infinite:true,
		centerPadding: '80px',
		slidesToShow:1,
		responsive: [
		{
		breakpoint: 768,
		settings: {
		arrows:true,
		centerMode: true,
		centerPadding: '20px',
		slidesToShow:1
		}
		},
		{
		breakpoint: 480,
		settings: {
		arrows: false,
		centerMode: true,
		centerPadding: '10px',
		slidesToShow: 1
		}
		}
		]
	});
	}

	// Featured Slick Slider
	if ( hasSlick && $('.featured_slick_gallery-slide-single').not('.slick-initialized').length ) {
	$('.featured_slick_gallery-slide-single').not('.slick-initialized').slick({
		centerMode: true,
		centerPadding: '0px',
		slidesToShow:1,
		responsive: [
		{
		breakpoint: 768,
		settings: {
		arrows:true,
		centerMode: false,
		centerPadding: '0px',
		slidesToShow:1
		}
		},
		{
		breakpoint: 480,
		settings: {
		arrows: false,
		centerMode: false,
		centerPadding: '0px',
		slidesToShow:1
		}
		}
		]
	});
	}

	} catch(slickInitError) {
		// One broken slider init threw — remaining carousels may still work.
		// Log to console for diagnostics but do not re-throw.
		if ( window.console && console.error ) {
			console.error( '[Murailles] Slider init error:', slickInitError );
		}
	}
	
	function muraillesInitInnerCardSliders($scope) {
		if ( ! hasSlick ) {
			return;
		}

		$scope.find('.click').each(function() {
			if ( $(this).hasClass('slick-initialized') ) {
				return;
			}

			try {
				$(this).slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					autoplay: true,
					fade: true,
					dots: true,
					autoplaySpeed: 4000
				});
			} catch (innerSliderError) {
				if ( window.console && console.warn ) {
					console.warn( '[Murailles] Inner card slider init skipped:', innerSliderError );
				}
			}
		});
	}

	function muraillesFallbackInitSlick($elements, options, onInit) {
		if ( ! hasSlick || ! $elements.length ) {
			return;
		}

		$elements.not('.slick-initialized').each(function() {
			var $slider = $(this);
			if ( typeof onInit === 'function' && ! $slider.data('murailles-init-bound') ) {
				$slider.on('init.muraillesFallback', function() {
					onInit($(this));
				});
				$slider.data('murailles-init-bound', true);
			}

			try {
				$slider.slick(options);
			} catch (fallbackSliderError) {
				if ( window.console && console.warn ) {
					console.warn( '[Murailles] Fallback slider init skipped:', fallbackSliderError );
				}
			}
		});
	}

	function muraillesBootstrapPendingCarousels() {
		muraillesFallbackInitSlick($('.modern-testimonial'), {
			slidesToShow: 1,
			arrows: false,
			dots: true,
			autoplay: true
		});

		muraillesFallbackInitSlick($('.list_views'), {
			slidesToShow: 1,
			arrows: false,
			dots: true,
			autoplay: true
		});

		muraillesFallbackInitSlick($('.item-slide'), {
			slidesToShow: 3,
			slidesToScroll: 1,
			arrows: true,
			dots: true,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 4000,
			responsive: [
				{ breakpoint: 993, settings: { arrows: true, dots: true, slidesToShow: 2 } },
				{ breakpoint: 600, settings: { arrows: true, dots: true, slidesToShow: 1 } }
			]
		}, muraillesInitInnerCardSliders);

		muraillesFallbackInitSlick($('.item-slide-2'), {
			slidesToShow: 3,
			slidesToScroll: 1,
			arrows: true,
			dots: true,
			infinite: true,
			speed: 500,
			fade: false,
			cssEase: 'linear',
			autoplaySpeed: 2000,
			centerPadding: '20px',
			autoplay: true,
			responsive: [
				{ breakpoint: 1024, settings: { arrows: true, dots: true, slidesToShow: 2 } },
				{ breakpoint: 600, settings: { arrows: true, dots: true, slidesToShow: 1 } }
			]
		});

		muraillesFallbackInitSlick($('.testi-slide'), {
			slidesToShow: 3,
			slidesToScroll: 1,
			arrows: true,
			dots: true,
			autoplay: true,
			responsive: [
				{ breakpoint: 1023, settings: { arrows: true, dots: true, slidesToShow: 2 } },
				{ breakpoint: 768, settings: { arrows: true, dots: true, slidesToShow: 2 } },
				{ breakpoint: 480, settings: { arrows: true, dots: true, slidesToShow: 1 } }
			]
		});

		muraillesFallbackInitSlick($('.home-slider'), {
			centerMode: false,
			slidesToShow: 1,
			responsive: [
				{ breakpoint: 768, settings: { arrows: true, slidesToShow: 1 } },
				{ breakpoint: 480, settings: { arrows: false, slidesToShow: 1 } }
			]
		});
	}

	function muraillesSyncNavigationMode() {
		var $nav = $('#navigation');
		if ( ! $nav.length ) {
			return;
		}

		var isMobile = window.innerWidth <= 992;
		var $wrapper = $nav.find('.nav-menus-wrapper').first();
		if ( isMobile ) {
			$nav.addClass('navigation-portrait').removeClass('navigation-landscape');
			return;
		}

		$nav.addClass('navigation-landscape').removeClass('navigation-portrait');
		$wrapper.removeClass('nav-menus-wrapper-open');
		$('body').removeClass('no-scroll');
		$nav.find('.nav-overlay-panel').remove();
		muraillesSetNavAriaState(false);
	}

	function muraillesGetNavInstance() {
		var $nav = $('#navigation');
		return $nav.length ? $nav.data('navigation') : null;
	}

	function muraillesNavIsOpen() {
		var $nav = $('#navigation');
		return $nav.length && $nav.find('.nav-menus-wrapper').first().hasClass('nav-menus-wrapper-open');
	}

	function muraillesSetNavAriaState(isOpen) {
		var $nav = $('#navigation');
		var $toggle = $nav.find('.nav-toggle').first();
		var $close = $nav.find('.nav-menus-wrapper-close-button').first();

		if ( $toggle.length ) {
			$toggle.attr('aria-expanded', isOpen ? 'true' : 'false');
			$toggle.attr('aria-label', isOpen ? 'Close menu' : 'Open menu');
		}

		if ( $close.length ) {
			$close.attr({
				'role': 'button',
				'tabindex': '0',
				'aria-label': 'Close menu'
			});
		}
	}

	function muraillesToggleNavFallback(forceOpen) {
		var $nav = $('#navigation');
		var $wrapper = $nav.find('.nav-menus-wrapper').first();
		if ( ! $nav.length || ! $wrapper.length || window.innerWidth > 992 ) {
			return;
		}

		var shouldOpen = typeof forceOpen === 'boolean' ? forceOpen : ! $wrapper.hasClass('nav-menus-wrapper-open');
		$wrapper.toggleClass('nav-menus-wrapper-open', shouldOpen);
		$('body').toggleClass('no-scroll', shouldOpen);

		if ( shouldOpen ) {
			if ( ! $nav.find('.nav-overlay-panel').length ) {
				$nav.append('<div class=\"nav-overlay-panel\"></div>');
			}
		} else {
			$nav.find('.nav-overlay-panel').remove();
		}

		muraillesSetNavAriaState(shouldOpen);
	}

	function muraillesCloseNav() {
		if ( window.innerWidth > 992 ) {
			return;
		}

		var navInstance = muraillesGetNavInstance();
		if ( navInstance && typeof navInstance.hideOffcanvas === 'function' ) {
			navInstance.hideOffcanvas();
			muraillesSetNavAriaState(false);
			return;
		}

		muraillesToggleNavFallback(false);
	}

	function muraillesOpenNav() {
		if ( window.innerWidth > 992 ) {
			return;
		}

		var navInstance = muraillesGetNavInstance();
		if ( navInstance && typeof navInstance.showOffcanvas === 'function' ) {
			navInstance.showOffcanvas();
			muraillesSetNavAriaState(true);
			return;
		}

		muraillesToggleNavFallback(true);
	}

	function muraillesEnhanceSlickAccessibility() {
		$('.slick-slider').each(function() {
			var $slider = $(this);
			if ( ! $slider.hasClass('slick-initialized') ) {
				return;
			}

			$slider.attr('aria-roledescription', 'carousel');
			$slider.find('.slick-prev').attr({ 'aria-label': 'Previous slide', 'type': 'button' });
			$slider.find('.slick-next').attr({ 'aria-label': 'Next slide', 'type': 'button' });
			$slider.find('.slick-track').removeAttr('role');
			$slider.find('.slick-slide').removeAttr('role aria-describedby');
			$slider.find('.slick-dots').removeAttr('role');
			$slider.find('.slick-dots li').removeAttr('role aria-selected aria-controls aria-hidden id');
			$slider.find('.slick-dots li').each(function(index) {
				var $dot = $(this);
				$dot.find('button').first()
					.attr('aria-label', 'Go to slide ' + (index + 1))
					.attr('aria-current', $dot.hasClass('slick-active') ? 'true' : 'false')
					.attr('type', 'button');
			});

			$slider.find('.slick-slide').each(function() {
				var $slide = $(this);
				var active = $slide.hasClass('slick-active') && ! $slide.hasClass('slick-cloned');
				$slide.attr('aria-hidden', active ? 'false' : 'true');
				$slide.find('a, button, input, select, textarea, [tabindex]').each(function() {
					var $el = $(this);
					if ( active ) {
						if ( $el.is('[data-murailles-tabindex-set="1"]') ) {
							var original = $el.attr('data-murailles-orig-tabindex');
							if ( typeof original === 'undefined' || original === '' ) {
								$el.removeAttr('tabindex');
							} else {
								$el.attr('tabindex', original);
							}
							$el.removeAttr('data-murailles-tabindex-set');
							$el.removeAttr('data-murailles-orig-tabindex');
						}
						return;
					}

					if ( ! $el.is('[data-murailles-tabindex-set="1"]') ) {
						$el.attr('data-murailles-tabindex-set', '1');
						$el.attr('data-murailles-orig-tabindex', typeof $el.attr('tabindex') === 'undefined' ? '' : $el.attr('tabindex') );
					}
					$el.attr('tabindex', '-1');
				});
			});
		});
		muraillesEnhanceMagnificAccessibility();
	}

	function muraillesEnhanceMagnificAccessibility() {
		var $wrap = $('.mfp-wrap');
		if ( ! $wrap.length ) {
			return;
		}

		$wrap.find('.mfp-close').attr({
			'aria-label': 'Fermer la galerie',
			'type': 'button'
		});
		$wrap.find('.mfp-arrow-left').attr('aria-label', 'Image précédente');
		$wrap.find('.mfp-arrow-right').attr('aria-label', 'Image suivante');
	}

	muraillesSyncNavigationMode();
	muraillesBootstrapPendingCarousels();
	muraillesSetNavAriaState(false);
	muraillesEnhanceSlickAccessibility();
	$(document).on('init reInit afterChange', '.slick-slider', muraillesEnhanceSlickAccessibility);
	$('#navigation').find('.nav-toggle').on('click.muraillesState touchstart.muraillesState', function() {
		if ( window.innerWidth > 992 ) {
			return;
		}
		setTimeout(function() {
			muraillesSetNavAriaState(muraillesNavIsOpen());
		}, 0);
	});
	$('#navigation').find('.nav-menus-wrapper-close-button').on('click.muraillesFix touchstart.muraillesFix', function(event) {
		if ( window.innerWidth > 992 ) {
			return;
		}
		event.preventDefault();
		event.stopPropagation();
		muraillesCloseNav();
	});
	$('#navigation').on('click.muraillesFix touchstart.muraillesFix', '.nav-overlay-panel', function(event) {
		if ( window.innerWidth > 992 ) {
			return;
		}
		event.preventDefault();
		event.stopPropagation();
		muraillesCloseNav();
	});
	$(window).on('load orientationchange resize', function() {
		muraillesSyncNavigationMode();
		muraillesBootstrapPendingCarousels();
		muraillesEnhanceSlickAccessibility();
	});

	$(document).on('click touchstart', '#navigation .nav-toggle', function(event) {
		if ( window.innerWidth > 992 ) {
			return;
		}
		event.preventDefault();
		event.stopPropagation();
		if ( muraillesNavIsOpen() ) {
			muraillesCloseNav();
			return;
		}
		muraillesOpenNav();
	});

	$(document).on('click touchstart', '#navigation .nav-menus-wrapper-close-button, #navigation .nav-overlay-panel', function(event) {
		event.preventDefault();
		event.stopPropagation();
		muraillesCloseNav();
	});

	$(document).on('click', '.dropdown-item[data-murailles-orderby]', function(event) {
		var orderby = $(this).attr('data-murailles-orderby');
		if ( ! orderby ) {
			return;
		}
		event.preventDefault();
		if ( typeof window.URL === 'function' ) {
			var url = new URL( window.location.href );
			url.searchParams.set( 'orderby', orderby );
			window.location.href = url.toString();
			return;
		}
		var href = window.location.href.split( '#' )[ 0 ];
		href = href.replace( /([?&])orderby=[^&]*/i, '$1' ).replace( /[?&]$/, '' );
		href += ( href.indexOf( '?' ) === -1 ? '?' : '&' ) + 'orderby=' + encodeURIComponent( orderby );
		window.location.href = href;
	});

	$(document).on('keydown', '#navigation .nav-toggle, #navigation .nav-menus-wrapper-close-button', function(event) {
		if ( event.key !== 'Enter' && event.key !== ' ' && event.key !== 'Spacebar' ) {
			return;
		}
		event.preventDefault();
		$(this).trigger('click');
	});

	$(document).on('keydown', function(event) {
		if ( event.key === 'Escape' && muraillesNavIsOpen() ) {
			muraillesCloseNav();
		}
	});

	$(document).on('click touchstart', function(event) {
		if ( window.innerWidth > 992 || ! muraillesNavIsOpen() ) {
			return;
		}

		var $target = $(event.target);
		if ( $target.closest('#navigation .nav-menus-wrapper, #navigation .nav-toggle, #navigation .mobile_nav').length ) {
			return;
		}

		muraillesCloseNav();
	});

	$(document).on('init reInit afterChange', '.slick-slider', function() {
		muraillesEnhanceSlickAccessibility();
	});

	// MagnificPopup
	if ( hasMagnific ) {
		$('body').magnificPopup({
			type: 'image',
			delegate: 'a.mfp-gallery',
			fixedContentPos: true,
			fixedBgPos: true,
			overflowY: 'auto',
			closeBtnInside: false,
			preloader: true,
			removalDelay: 0,
			mainClass: 'mfp-fade',
			gallery: {
				enabled: true
			},
			callbacks: {
				open: function() {
					muraillesEnhanceMagnificAccessibility();
				}
			}
		});
	}

	function muraillesEnhanceAccessibility() {
		$('select, input, textarea').each(function() {
			var $field = $(this);
			if ($field.attr('aria-label') || $field.attr('aria-labelledby')) {
				return;
			}
			var labelText = '';
			var fieldId = $field.attr('id');
			if (fieldId) {
				var $label = $('label[for="' + fieldId + '"]').first();
				if ($label.length) {
					labelText = $.trim($label.text());
				}
			}
			if (!labelText) {
				var $closestLabel = $field.closest('.form-group, .simple-input, .input-with-icon').find('label').first();
				if ($closestLabel.length) {
					labelText = $.trim($closestLabel.text());
				}
			}
			if (!labelText) {
				labelText = $field.attr('placeholder') || $field.find('option:first').text() || $field.attr('name') || '';
			}
			if (labelText) {
				$field.attr('aria-label', $.trim(labelText));
			}
		});

		$('a, button, label').each(function() {
			var $el = $(this);
			if ($el.attr('aria-label') || $el.attr('aria-labelledby')) {
				return;
			}
			var text = $.trim($el.text());
			if (text) {
				return;
			}
			var tooltip = $el.attr('data-bs-title') || $el.attr('title') || $el.attr('data-original-title') || '';
			if (!tooltip) {
				return;
			}
			$el.attr('aria-label', $.trim(tooltip));
		});
	}
	muraillesEnhanceAccessibility();
	
	// fullwidth home slider
	function inlineCSS() {
		$(".home-slider .item").each(function() {
			var attrImageBG = $(this).attr('data-background-image');
			var attrColorBG = $(this).attr('data-background-color');
			if (attrImageBG !== undefined) {
				$(this).css('background-image', 'url(' + attrImageBG + ')');
			}
			if (attrColorBG !== undefined) {
				$(this).css('background', '' + attrColorBG + '');
			}
		});
	}
	inlineCSS();
	
	// Search Radio
	function searchTypeButtons() {
		$('.property_search_filter label.active input[type="radio"]').prop('checked', true);
		var buttonWidth = $('.property_search_filter label.active').width();
		var arrowDist = $('.property_search_filter label.active').position();
		$('.property_search_filter-arrow').css('left', arrowDist + (buttonWidth / 2));
		$('.property_search_filter label').on('change', function() {
			$('.property_search_filter input[type="radio"]').parent('label').removeClass('active');
			$('.property_search_filter input[type="radio"]:checked').parent('label').addClass('active');
			var buttonWidth = $('.property_search_filter label.active').width();
			var arrowDist = $('.property_search_filter label.active').position().left;
			$('.property_search_filter-arrow').css({
				'left': arrowDist + (buttonWidth / 1.7),
				'transition': 'left 0.4s cubic-bezier(.95,-.41,.19,1.44)'
			});
		});
	}
	if ($(".hero_banner").length) {
		searchTypeButtons();
		$(window).on('load resize', function() {
			searchTypeButtons();
		});
	}
	
});
})(jQuery);
