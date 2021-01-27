<?php
/**
 * Modals that can be called at anytime.
 *
 * @package xten
 */

// Get Started Modal - displays first contact form.
$contact_form_title = get_field( 'contact_form_title', 'options' );
$contact_form       = get_field( 'contact_form', 'options' );
?>
<div class="modal fade xten-modal" id="site-wide-contact-form-modal" tabindex="-1" role="dialog" aria-labelledby="Contact Form" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content primary-gradient">
			<button type="button" class="close btn btn-theme-style btn-color-white fa fa-times" data-dismiss="modal" aria-label="Close"></button>
			<div class="contact-form-wrapper">
				<?php if ( $contact_form_title ) : ?>
					<h3 class="contact-form-title"><?php echo esc_attr( $contact_form_title, $contact_form ); ?></h3>
				<?php endif; ?>
				<?php echo xten_render_component( 'contact-form' ); ?>
			</div>
		</div>
	</div>
</div><!-- /#site-wide-contact-form-modal -->