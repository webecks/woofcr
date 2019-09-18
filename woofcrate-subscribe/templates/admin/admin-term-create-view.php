<?php
/**
 * Custom fields for taxonomy
 *
 * @since 1.0.0
 * @package woofcrate-subscribe
 * @author Gogo
 */
?>

<div class="form-field term-image-wrap">
	<label for="termImage"><?php esc_html_e( 'Image', 'woofsubs' ) ?></label>
	<input id="termImage" type="hidden" name="term_image" value="">
	<div class="image_wrapper"></div>
	<p>
		<button id="addImage" type="button" name="add_image" class="button button-secondary" data-target="termImage"><?php esc_attr_e( 'Add Image', 'woofsubs' ) ?></button>
		<button id="removeImage" type="button" name="remove_image" class="button button-secondary" data-target="termImage"><?php esc_attr_e( 'Remove Image', 'woofsubs' ) ?></button>
	</p>
	<?php wp_nonce_field( 'woofcrate_custom_fields_term_create', '_nonce' ) ?>
</div>
