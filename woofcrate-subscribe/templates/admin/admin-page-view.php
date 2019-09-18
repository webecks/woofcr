<?php
/**
 * Provide a admin area view for the plugin
 *
 * @since 1.0.0
 * @package woofcrate-subscribe
 * @author Gogo
 */
?>

<div class="wrap">
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ) ?>" method="post">
		<h3><?php esc_html_e( 'Pages', 'woofsubs' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="page"><?php esc_html_e( 'Subscription Page', 'woofsubs' ) ?></label>
				</th>
				<td>
					<select id="subscribe" name="subscribe">
<?php
$subscripe_page = isset( $woofsubs['subscribe_page'] ) ? $woofsubs['subscribe_page'] : 0;

foreach ( $pages as $page ) {
	echo '<option value="' . esc_attr( $page->ID ) . '"' . selected( $subscripe_page, $page->ID, false ) . '>' . esc_attr( $page->post_title ) . '</option>';
}
?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="page"><?php esc_html_e( 'Gift Page', 'woofsubs' ) ?></label>
				</th>
				<td>
					<select id="gift" name="gift">
<?php
$gift_page = isset( $woofsubs['gift_page'] ) ? $woofsubs['gift_page'] : 0;

foreach ( $pages as $page ) {
	echo '<option value="' . esc_attr( $page->ID ) . '"' . selected( $gift_page, $page->ID, false ) . '>' . esc_attr( $page->post_title ) . '</option>';
}
?>
					</select>
				</td>
			</tr>
		</table>
		<h3><?php esc_html_e( 'Gift Section Start', 'woofsubs' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="dgSize"><?php esc_html_e( 'Message', 'woofsubs' ) ?></label>
				</th>
				<td>
					<textarea id="dgSize" name="message_giftstart" row="2" class="regular-text" style="resize:none;"><?php echo esc_attr( isset( $woofsubs['messages']['giftstart'] ) ? $woofsubs['messages']['giftstart'] : '' ) ?></textarea>
				</td>
			</tr>
		</table>
		<h3><?php esc_html_e( 'Dog Information', 'woofsubs' ) ?></h3>
		<table class="form-table">
			<?php
			woofsubs_image_field(
				isset( $woofsubs['images']['doginfo'] ) ? $woofsubs['images']['doginfo'] : 0,
				'dgInfoImage',
				'dginfo_image'
			);
			?>
		</table>
		<h3><?php esc_html_e( 'Dog Size', 'woofsubs' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="dgSize"><?php esc_html_e( 'Message', 'woofsubs' ) ?></label>
				</th>
				<td>
					<textarea id="dgSize" name="message_dogsize" row="2" class="regular-text" style="resize:none;"><?php echo esc_attr( isset( $woofsubs['messages']['dogsize'] ) ? $woofsubs['messages']['dogsize'] : '' ) ?></textarea>
				</td>
			</tr>
		</table>
		<h3><?php esc_html_e( 'Dog Allergy', 'woofsubs' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="dgAllergy"><?php esc_html_e( 'Message', 'woofsubs' ) ?></label>
				</th>
				<td>
					<textarea id="dgAllergy" name="message_dogallergy" row="2" class="regular-text" style="resize:none;"><?php echo esc_attr( isset( $woofsubs['messages']['dogallergy'] ) ? $woofsubs['messages']['dogallergy'] : '' ) ?></textarea>
				</td>
			</tr>
			<?php
			woofsubs_image_field(
				isset( $woofsubs['images']['dogallergy'] ) ? $woofsubs['images']['dogallergy'] : 0,
				'dgAllergyImage',
				'dgallergy_image'
			);
			?>
		</table>
		<h3><?php esc_html_e( 'Crate Selection', 'woofsubs' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="dgCrate"><?php esc_html_e( 'Message', 'woofsubs' ) ?></label>
				</th>
				<td>
					<textarea id="dgCrate" name="message_dogcrate" row="2" class="regular-text" style="resize:none;"><?php echo esc_attr( isset( $woofsubs['messages']['dogcrate'] ) ? $woofsubs['messages']['dogcrate'] : '' ) ?></textarea>
				</td>
			</tr>
		</table>
		<h3><?php esc_html_e( 'Plan Selection', 'woofsubs' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="dgPlan"><?php esc_html_e( 'Message', 'woofsubs' ) ?></label>
				</th>
				<td>
					<textarea id="dgPlan" name="message_dogplan" row="2" class="regular-text" style="resize:none;"><?php echo esc_attr( isset( $woofsubs['messages']['dogplan'] ) ? $woofsubs['messages']['dogplan'] : '' ) ?></textarea>
				</td>
			</tr>
		</table>
		<h3><?php esc_html_e( 'Double Trouble', 'woofsubs' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="dgDouTro"><?php esc_html_e( 'Message', 'woofsubs' ) ?></label>
				</th>
				<td>
					<textarea id="dgDouTro" name="message_dogdoutro" row="2" class="regular-text" style="resize:none;"><?php echo esc_attr( isset( $woofsubs['messages']['dogdoutro'] ) ? $woofsubs['messages']['dogdoutro'] : '' ) ?></textarea>
				</td>
			</tr>
		</table>
		<h3><?php esc_html_e( 'Extra Toy', 'woofsubs' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="dgXToy"><?php esc_html_e( 'Message', 'woofsubs' ) ?></label>
				</th>
				<td>
					<textarea id="dgXToy" name="message_dogxtoy" row="2" class="regular-text" style="resize:none;"><?php echo esc_attr( isset( $woofsubs['messages']['dogxtoy'] ) ? $woofsubs['messages']['dogxtoy'] : '' ) ?></textarea>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="extraToyPrice"><?php esc_html_e( 'Price', 'woofsubs' ) ?></label>
				</th>
				<td>
					<input id="extraToyPrice" name="extratoy_price" type="text" value="<?php echo esc_attr( isset( $woofsubs['extratoy_price'] ) ? $woofsubs['extratoy_price'] : '' ) ?>" class="small-text">
				</td>
			</tr>
			<?php
			woofsubs_image_field(
				isset( $woofsubs['images']['dogxtoy'] ) ? $woofsubs['images']['dogxtoy'] : 0,
				'xToyImage1',
				'extratoy_image',
				__( 'Image', 'woofsubs' )
			);
			?>
		</table>
		<h3><?php esc_html_e( 'Error Messages', 'woofsubs' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="m1"><?php esc_html_e( 'Message 1', 'woofsubs' ) ?></label>
				</th>
				<td>
					<input id="m1" name="message_m1" type="text" value="<?php echo esc_attr( isset( $woofsubs['messages']['m1'] ) ? $woofsubs['messages']['m1'] : '' ) ?>" class="regular-text">
					<p class="description"><?php esc_html_e( 'Dog\'s information fields empty.', 'woofsubs' ) ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="m2"><?php esc_html_e( 'Message 2', 'woofsubs' ) ?></label>
				</th>
				<td>
					<input id="m2" name="message_m2" type="text" value="<?php echo esc_attr( isset( $woofsubs['messages']['m2'] ) ? $woofsubs['messages']['m2'] : '' ) ?>" class="regular-text">
					<p class="description"><?php esc_html_e( 'Dog\'s size not selected.', 'woofsubs' ) ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="m3"><?php esc_html_e( 'Message 3', 'woofsubs' ) ?></label>
				</th>
				<td>
					<input id="m3" name="message_m3" type="text" value="<?php echo esc_attr( isset( $woofsubs['messages']['m3'] ) ? $woofsubs['messages']['m3'] : '' ) ?>" class="regular-text">
					<p class="description"><?php esc_html_e( 'Dog\'s allergy not selected.', 'woofsubs' ) ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="m4"><?php esc_html_e( 'Message 4', 'woofsubs' ) ?></label>
				</th>
				<td>
					<input id="m4" name="message_m4" type="text" value="<?php echo esc_attr( isset( $woofsubs['messages']['m4'] ) ? $woofsubs['messages']['m4'] : '' ) ?>" class="regular-text">
					<p class="description"><?php esc_html_e( 'Dog has allergy but description empty.', 'woofsubs' ) ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="m5"><?php esc_html_e( 'Message 5', 'woofsubs' ) ?></label>
				</th>
				<td>
					<input id="m5" name="message_m5" type="text" value="<?php echo esc_attr( isset( $woofsubs['messages']['m5'] ) ? $woofsubs['messages']['m5'] : '' ) ?>" class="regular-text">
					<p class="description"><?php esc_html_e( 'Crate not selected.', 'woofsubs' ) ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="m6"><?php esc_html_e( 'Message 6', 'woofsubs' ) ?></label>
				</th>
				<td>
					<input id="m6" name="message_m6" type="text" value="<?php echo esc_attr( isset( $woofsubs['messages']['m6'] ) ? $woofsubs['messages']['m6'] : '' ) ?>" class="regular-text">
					<p class="description"><?php esc_html_e( 'Plan not selected.', 'woofsubs' ) ?></p>
				</td>
			</tr>
		</table>
		<p class="submit">
			<?php wp_nonce_field( 'woofsubs_admin_page_nonce', '_nonce' ) ?>
			<input type="hidden" name="action" value="save_subs_page">
			<button id="save" type="submit" name="save_page" class="button button-primary"><?php esc_html_e( 'Save', 'woofsubs' ) ?></button>
		</p>
	</form>
</div>
