jQuery(document).ready(function($) {
	var $body = $('body').first(),
		$contactFormModal = $('#site-wide-contact-form-modal').first(),
		$siteHeader = $('#masthead').first();
		window.mouseDetected = window.mouseDetected || false;

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
		var targetTop = $target.offset().top;
		if ( ! offset ) {
			var siteHeaderHeight = parseFloat(window.siteHeaderHeight) ||
				$siteHeader[0].getBoundingClientRect().height,
			headerCompensation;

			if ( $target.is('.scrollToCenter') ) {
				headerCompensation = window.innerHeight / 2 - siteHeaderHeight;
			} else {
				var padding = 60;
				headerCompensation = siteHeaderHeight + padding;
			}
			offset = headerCompensation;
		}
		var scrollPosition = targetTop - offset;
		$("html, body").animate({ scrollTop: scrollPosition }, 350);
	}

	function activateTarget($target) {
		// Bail if not .activateOnHash.
		if ( ! $target.is('.activateOnHash') ) {
			return;
		}
		// find nearest child [data-toggle].
		var $activateController = $target.is('[data-toggle]') ?
				$target :
				$target.find('[data-toggle]').first();
		if ($activateController.length === 0 ) {
			return;
		}
		// Action can be either "collapse", "modal", "dropdown", or "tab".
		var action = $activateController.attr('data-toggle'),
		$activateTarget = $($activateController.attr('data-target'));
		switch(action) {
			case 'collapse':
				$activateTarget.collapse('show');
				break;
			case 'modal':
				$activateTarget.modal('show');
				break;
			case 'dropdown':
				$activateTarget.dropdown('toggle');
				break;
			case 'tab':
				$activateTarget.tab('show');
				break;
		} 
	}

	function scrollActivate($target) {
		// If no $target is passed, use hash.
		if ( $target === undefined ) {
			var hash = window.location.hash;
			if (hash !== '' && $(hash).length) {
				$target = $target || $(hash);
			}
		}
		if ( ! $target || ! $target.length) {
			return;
		}
		scrollToTarget($target);
		activateTarget($target);
	}

	function bindScrollActivate() {
		// Find links whose href STARTS WITH # but IS NOT #contact-us.
		var $anchors = $('[href^="#"]:not([href="#contact-us"])');
		$anchors.each(function(){
			this.boundClickHandler = this.boundClickHandler || false;
			if ( this.boundClickHandler === false ) {
				$(this).on('click', function(e){
					e.stopImmediatePropagation();
					e.preventDefault();
					this.boundClickHandler = true;
					var href = $(this).attr('href');
					$target = $(href);
					history.pushState({}, '', href);
					scrollActivate($target);
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

	function touchSolutionToHover() {
		$('.touchSolutionToHover').each(function(){
			if (
				! window.mouseDetected &&
				$(this).is('a')
			) {
				$(this).on('click', function(e) {
					// Only prevent Default if not from clickTrigger
					this.clickFromTrigger = this.clickFromTrigger || false;
					if ( ! this.clickFromTrigger) {
						e.preventDefault();
					}
				});

				$hoverTrigger = $(this).find('.hoverTrigger'),
				$clickTrigger = $(this).find('.clickTrigger');
				$($hoverTrigger, $(this)).on('click', function(){
					var $anchor = $(this).closest('.touchSolutionToHover');
					$anchor.addClass('active').siblings().removeClass('active');
				});
				$($clickTrigger, $(this)).on('click', function() {
					var $anchor = $(this).closest('.touchSolutionToHover');
					$anchor[0].clickFromTrigger = true;
					$anchor.trigger('click');
				});
			}
		});
	}

	function serviceCatsNavScrollSpy() {
		var $serviceCatsNav = $('.service-categories-list-scroll-nav:visible');
		$serviceCatsNav.each(function(){
			var $parent = $(this).closest('.xten-section'),
			$parent = $parent.length ?
				$parent :
				$(this).closest('.component-service-categories-list'),
				serviceCatsNavRect = this.getBoundingClientRect(),
				siteHeaderHeight = parseFloat(window.siteHeaderHeight) ||
					$siteHeader[0].getBoundingClientRect().height,
				navAndSiteHeaderHeight = siteHeaderHeight + serviceCatsNavRect.height,
				parentRect,
				parentTop,
				parentBottom;

			if ( ! $parent[0] ) {
				return;
			} else {
				parentRect = $parent[0].getBoundingClientRect()
				parentTop = parentRect.top;
				parentBottom = parentTop + parentRect.height;
			}

			$parent.css('position', 'relative');
			if ( parentTop <= serviceCatsNavRect.height && parentBottom >= navAndSiteHeaderHeight ) {
				$(this).addClass('scroll-nav-active');
			} else {
				$(this).removeClass('scroll-nav-active');
			}
		});
	}
	
	function setScrollSpyOffset() {
		var $serviceCatsNav = $('.service-categories-list-scroll-nav:visible');
		$serviceCatsNav.each(function(){
			var $parent = $(this).closest('.xten-section'),
				$parent = $parent.length ?
					$parent :
					$(this).closest('.component-service-categories-list'),
				$serviceCats = $parent.find('.component-service-category'),
				headerHeight = parseFloat(window.siteHeaderHeight) ||
					$siteHeader[0].getBoundingClientRect().height,
				headerCompensation = window.innerHeight / 2 - headerHeight,
				tallestServiceCategory = 0;
			$serviceCats.each(function(){
				var thisHeight = this.getBoundingClientRect().height;
				tallestServiceCategory = thisHeight > tallestServiceCategory ?
					thisHeight :
					tallestServiceCategory;
			});

			headerCompensation += (tallestServiceCategory / 2);
			
			$body.each(function(){
				$(this).scrollspy('dispose').scrollspy({
					target: '.xten-scroll-nav',
					offset: headerCompensation
				});
			});
		});
	}

	function sizeOfficeTitles() {
		$('.component-offices-list').each(function(){
			var $origOfficeTitles = $(this).find('.office-title'),
				minHeightVal = 'auto',
				$parent = $(this).closest('.xten-section-contact-section, .site-footer');
			if ($parent.length) {
				var $clone = $parent.clone();
				$clone.css({
					'visibility': 'hidden',
					'position': 'absolute',
					'bottom': 0,
					'z-index': -9999,
				}).appendTo($body);
				$clone.each(function(){
					var $officeTitle = $(this).find('.office-title'),
						tallestHeight = 0;
					$officeTitle.css('min-height', 'auto').each(function(){
						var height = $(this).outerHeight();
						if (height > tallestHeight) {
							tallestHeight = height;
						}
					});
					minHeightVal = tallestHeight + 'px';
				}).remove();
			}
			$origOfficeTitles.css('min-height', minHeightVal);
		});
	}
	
	function readyFuncs() {
		scrollActivate();
		bindScrollActivate();
		addHTMLValidationToCF();
		validateInput();
		preventExpandedCollapse();
		preFillContactForm();
		contactUsClick();
		serviceCatsNavScrollSpy();
		touchSolutionToHover();
		setScrollSpyOffset();
		sizeOfficeTitles();
	}
	readyFuncs();

	function scrollFuncs() {
		serviceCatsNavScrollSpy();
	}

	function resizeFuncs() {
		setScrollSpyOffset();
		sizeOfficeTitles();
	}

	$(window).on('scroll', function() {
		scrollFuncs();
	}).on('resize', function () {
		resizeFuncs();
	});
});