jQuery(document).ready(function($) {
	var $body = $('body').first(),
		$contactFormModal = $('#site-wide-contact-form-modal').first(),
		$siteHeader = $('#masthead').first(),
		mouseDetected = false;

	function detectMouse(){
		function checkPointer(mediaQueryItem) {
			if (mediaQueryItem.matches) {
				mouseDetected = true;
				$(window).trigger('mouseDetected');
			} else {
				mouseDetected = false;
				$(window).trigger('mouseUndetected');
			}
			return mediaQueryItem;
		}
		var mediaRule = window.matchMedia('(pointer:fine)');
		checkPointer(mediaRule);
		mediaRule.addEventListener('change', function(){
			checkPointer(this);
		});
	}

	function addHTMLValidationToCF() {
		$('form.wpcf7-form').each(function () {
			$(this)
				.removeAttr('novalidate')
				.find('[aria-required="true"]')
				.prop('required', true);
		});
	}
	function validateInput() {
		$('.validateInput ').each(function() {
			function coreFunc( input, $indicator ) {
				var validity = input.checkValidity();
				if ( validity === true && input.type === 'tel' ) {
					var patt = new RegExp("^[+]?[0-9()/ -]*$");
					if ( ! patt.test(input.value) ) {
						validity = false;
					}
				}
				if ( input.value !== '' ) {
					$indicator.addClass('validity-checked');
				}
				if ( validity === true ) {
					$indicator.addClass('valid');
				} else {
					$indicator.removeClass('valid');
				}
			}

			var $indicator = $(this),
				$parent = $(this).closest('.validateInputParent'),
				$inputs = $parent.find('input, select, textarea');

			$inputs.each(function() {
				coreFunc( this, $indicator );
			}).on('input', function() {
				coreFunc( this, $indicator );
			});
		});
	}
	function preventExpandedCollapse() {
		$('.preventExpandedCollapse').on('click keyup', function(e) {
			if ($(this).attr('aria-expanded') == 'true') {
				var key = e.key || e.keyCode;
				if (key) {
					var enterKey = key === "Enter" || key === 13;
					var spaceKey = key === " " || key === 32;
					if (!(enterKey || spaceKey)) {
						return;
					}
				}
				e.stopImmediatePropagation();
				e.preventDefault();
			}
		});
	}
	function preFillContactForm() {
		$('.preFillContactForm').on('click keyup', function(e) {
			var key = e.key || e.keyCode,
			fillContent = $(this).attr('data-pre-fill'),
			serviceCat = $(this).attr('data-service-category'),
			modal = $(this).attr('data-target'),
			$modal = $(modal),
			$serviceSel = $modal.find('.preFillContactFormServiceCat'),
			$messageTextArea = $modal.find('.preFillContactFormMessage');
			if (key) {
				var enterKey = key === "Enter" || key === 13;
				var spaceKey = key === " " || key === 32;
				if (!(enterKey || spaceKey)) {
					return;
				}
			}
			$serviceSel.val(serviceCat);
			$messageTextArea.val(fillContent);
		});
	}

	function scrollToTarget($target, offset) {
		// Make sure $target is a jQuery object.
		$target = $target instanceof jQuery ? $target : $($target);
		var targetTop = $target.position().top;
		if ( ! offset ) {
			var siteHeaderHeight =  parseFloat(window.siteHeaderHeight) ||
			$siteHeader[0].getBoundingClientRect().height,
			headerCompensation;

			if ( $target.is('.scrollToCenter') ) {
				headerCompensation = window.innerHeight / 2 - siteHeaderHeight;
			} else {
				var padding = 30;
				headerCompensation = siteHeaderHeight - padding;
			}
			offset = headerCompensation;
		}
		var scrollPosition = targetTop - offset;
		$("html, body").animate({ scrollTop: scrollPosition }, 350);
	}
	function interceptHashChange($target) {
		$(window).on("load hashchange", function (e, $target) {
			$target = $target || null;
			if (window.location.hash && $(window.location.hash).length) {
				$target = $target || $(window.location.hash);
			}
			if ($target !== null && $target.length) {
				e.stopImmediatePropagation();
				e.preventDefault();
				scrollToTarget($target);
				var $anchors = $('[href="' + window.location.hash + '"');
				$anchors.each(function(){
					this.boundClickHandler = this.boundClickHandler || false;
					if ( this.boundClickHandler === false ) {
						$(this).on('click', function(e){
							e.preventDefault();
							this.boundClickHandler = true;
							scrollToTarget($target);
						});
					}
				});
			}
		});
	}
	function contactUsClick() {
		var _hash = '#contact-us';
		function coreFunc($this) {
			var targetForm;
			$contactFormModal.modal("show");
			targetForm = $contactFormModal;

			// Not the initial load _hash check usage.
			if ( $this !== undefined ) {
				history.replaceState(
					null,
					null,
					document.location.pathname + $this.attr("href")
				);
			}
			targetForm.find('input:visible, select:visible, textarea:visible').first().focus();
		}
		$('[href*="' + _hash + '"]').on("click keyup", function (e) {
			var key = e.key || e.keyCode;
			if (key) {
				var enterKey = key === "Enter" || key === 13;
				var spaceKey = key === " " || key === 32;
				if (!(enterKey || spaceKey)) {
					return;
				}
			}
			e.stopImmediatePropagation();
			e.preventDefault();
			coreFunc( $(this) );
		});
		// Fire on Load if location hash is _hash
		if ( location.hash === _hash ) {
			coreFunc();
		}
	}
	// Highly modified version of thise function.
	// Only aware of vertical (Y) positions.
	function isElementPartiallyInViewport(el, vertOffSet) {
			//special bonus for those using jQuery
			if (typeof jQuery !== 'undefined' && el instanceof jQuery) el = el[0];

			var rect = el.getBoundingClientRect();
			var percentage = .75;
			var vertOffSet = vertOffSet || null;
			var windowHeight = (window.innerHeight || document.documentElement.clientHeight) + vertOffSet;
			// var windowWidth = (window.innerWidth || document.documentElement.clientWidth);

			var windowFrame = windowHeight - windowHeight * percentage;
			var windowFrameTop = (windowHeight - windowFrame) / 2;
			var windowFrameBottom = windowFrameTop + windowFrame;

			var vertInView = (rect.top <= windowFrameBottom) && ((rect.top + rect.height) >= windowFrameTop);
			// var horInView = (rect.left <= windowWidth) && ((rect.left + rect.width) >= 0);
			var vertReturn = {
				topOffSet: false,
				bottomOffSet: false
			};
			if (vertInView) {
				vertReturn.topOffSet = (rect.top + rect.height) - windowFrameTop;
				vertReturn.bottomOffSet = windowFrameBottom - rect.top;
			}
			// return (vertInView && horInView);
			return vertReturn;
	}
	function scrollSpy() {
		function coreFunc() {
			$('.component-service-categories-list').each(function(){
				// disable Bootstrap ScrollSpy
				var $scrollNav = $(this).find('.service-categories-list-scroll-nav'),
					$scrollSpies = $(this).find('.scrollSpy'),
					headerHeight = parseFloat(window.siteHeaderHeight) ||
						$siteHeader[0].getBoundingClientRect().height,
					scrollNavHeight = $scrollNav[0].getBoundingClientRect().height,
					vertOffSet = headerHeight + scrollNavHeight,
					mostProminent = [],
					$navLinks = $scrollNav.find('.nav-link');

				$scrollSpies.each(function(){
					var isElInFrame = isElementPartiallyInViewport(this, vertOffSet);
					if ( isElInFrame.topOffSet && isElInFrame.bottomOffSet ) {
						mostProminent.push({
							'$el': $(this),
							'isElInFrame': isElInFrame
						});
					}
					$(this).add($navLinks).removeClass('active');
				});

				var mostProminentDefault = {
					topOffSet: 0,
					bottomOffSet: 0
				},
				$mostProminent = $([]);
				if ( mostProminent.length ) {
					for ( var i = mostProminent.length - 1; i >= 0; i-- ) {
						if (
							(mostProminent[i].isElInFrame.topOffSet >= mostProminentDefault.topOffSet) &&
							(mostProminent[i].isElInFrame.bottomOffSet >= mostProminentDefault.bottomOffSet)
						) {
							if ('$el' in mostProminent[i] ) {
								mostProminentDefault.topOffSet = mostProminent[i].isElInFrame.topOffSet;
								mostProminentDefault.bottomOffSet = mostProminent[i].isElInFrame.bottomOffSet;

								$mostProminent = $mostProminent.add(mostProminent[i]['$el']);
							}
						}
					}

					$mostProminent.each(function(){
						var id = $(this).attr('id'),
						$scrollNavLink = $scrollNav.find('[href="#' + id + '"]');
						$(this).add($scrollNavLink).addClass('active');
					});
				}
			});
		}
		function bindCoreFunc() {
			coreFunc();
			$(this).on('scroll', coreFunc);
		}
		function unbindCoreFunc() {
			$(this).unbind('scroll', coreFunc);
		}
		$(window).on('mouseUndetected', bindCoreFunc).
			on('mouseDetected', unbindCoreFunc);
	}
	function readyFuncs() {
		detectMouse();
		interceptHashChange();
		addHTMLValidationToCF();
		validateInput();
		preventExpandedCollapse();
		preFillContactForm();
		contactUsClick();
		scrollSpy();
	}
	readyFuncs();

	// function scrollFuncs() {
		
	// }
	// $(window).on('scroll', function() {
	// 	scrollFuncs();
	// });
});