<?php
/**
 * Custom fields for taxonomy
 *
 * @since 1.0.0
 * @package woofcrate-subscribe
 * @author Gogo
 */
?>

<tr valign="top" class="<?php echo esc_attr( $tr_class ) ?>">
	<th scope="row">
		<label for="<?php echo esc_attr( $field_id ) ?>"><?php echo esc_html( $field_label ) ?></label>
	</th>
	<td>
		<input id="<?php echo esc_attr( $field_id ) ?>" type="hidden" name="<?php echo esc_attr( $field_name ) ?>" value="<?php echo esc_attr( $image_id ) ?>">
		<div class="image_wrapper"><?php echo ( ! empty( $image_id ) ) ? wp_get_attachment_image( $image_id, 'thumbnail' ) : '' ?></div>
		<p>
			<button id="add<?php echo esc_attr( $field_id ) ?>" type="button" name="add_image" class="button button-secondary" data-target="<?php echo esc_attr( $field_id ) ?>"><?php esc_attr_e( 'Add Image', 'woofsubs' ) ?></button>
			<button id="remove<?php echo esc_attr( $field_id ) ?>" type="button" name="remove_image" class="button button-secondary" data-target="<?php echo esc_attr( $field_id ) ?>"><?php esc_attr_e( 'Remove Image', 'woofsubs' ) ?></button>
		</p>
	</td>
</tr>
