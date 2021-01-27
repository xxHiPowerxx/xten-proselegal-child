jQuery(document).ready(function($) {
	function addHTMLValidationToCF() {
		$("form.wpcf7-form").each(function () {
			$(this)
				.removeAttr("novalidate")
				.find('[aria-required="true"]')
				.prop("required", true);
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
	function readyFuncs() {
		addHTMLValidationToCF();
		validateInput();
		preventExpandedCollapse();
	}
	readyFuncs();
});