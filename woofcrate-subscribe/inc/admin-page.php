<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @since 1.0.0
 * @package woofcrate-subscribe
 * @author Gogo
 */

// Add menu item on admin Settings
add_action( 'admin_menu', function() {
	$page_title = __( 'Woofcrate Subscribe', 'woofsubs' );
	$menu_title = __( 'Woofcrate Subscribe', 'woofsubs' );

	add_options_page($page_title, $menu_title, 'manage_options', 'woofcrate-subscribe', function() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'woofsubs' ) );
		}

		$pages = get_pages();
		$woofsubs = get_option( 'woofsubs' );

		include_once WOOFSUBS_PATH . 'templates/admin/admin-page-view.php';
	});
} );

// Save setting page
add_action( 'admin_post_save_subs_page', function() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}

	check_admin_referer( 'woofsubs_admin_page_nonce', '_nonce' );

	$woofsubs = get_option( 'woofsubs' );
	$woofsubs['subscribe_page'] = (int) sanitize_text_field( wp_unslash( $_POST['subscribe'] ) );
	$woofsubs['gift_page'] = (int) sanitize_text_field( wp_unslash( $_POST['gift'] ) );
	$woofsubs['extratoy_price'] = (float) sanitize_text_field( wp_unslash( $_POST['extratoy_price'] ) );
	$woofsubs['images'] = [
		'doginfo' => (int) sanitize_text_field( wp_unslash( $_POST['dginfo_image'] ) ),
		'dogallergy' => (int) sanitize_text_field( wp_unslash( $_POST['dgallergy_image'] ) ),
		'dogxtoy' => (int) sanitize_text_field( wp_unslash( $_POST['extratoy_image'] ) ),
	];
	$woofsubs['messages'] = [
		'm1' => sanitize_text_field( wp_unslash( $_POST['message_m1'] ) ),
		'm2' => sanitize_text_field( wp_unslash( $_POST['message_m2'] ) ),
		'm3' => sanitize_text_field( wp_unslash( $_POST['message_m3'] ) ),
		'm4' => sanitize_text_field( wp_unslash( $_POST['message_m4'] ) ),
		'm5' => sanitize_text_field( wp_unslash( $_POST['message_m5'] ) ),
		'm6' => sanitize_text_field( wp_unslash( $_POST['message_m6'] ) ),
		'dogsize' => sanitize_textarea_field( wp_unslash( $_POST['message_dogsize'] ) ),
		'dogallergy' => sanitize_textarea_field( wp_unslash( $_POST['message_dogallergy'] ) ),
		'dogcrate' => sanitize_textarea_field( wp_unslash( $_POST['message_dogcrate'] ) ),
		'dogplan' => sanitize_textarea_field( wp_unslash( $_POST['message_dogplan'] ) ),
		'dogdoutro' => sanitize_textarea_field( wp_unslash( $_POST['message_dogdoutro'] ) ),
		'dogxtoy' => sanitize_textarea_field( wp_unslash( $_POST['message_dogxtoy'] ) ),
		'giftstart' => sanitize_textarea_field( wp_unslash( $_POST['message_giftstart'] ) ),
	];

	update_option( 'woofsubs', $woofsubs );

	wp_safe_redirect( sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) ) );
	exit;
} );

// Add image to terms
foreach ( woofsubs_pa() as $v ) {
	// Add image field to attribute term create
	add_action( $v . '_add_form_fields', function( $taxonomy ) {
		include_once WOOFSUBS_PATH . 'templates/admin/admin-term-create-view.php';
	}, 10, 1 );

	// Save image field on attribute term create
	add_action( 'created_' . $v, function( $term_id, $tt_id ) {
		check_admin_referer( 'woofcrate_custom_fields_term_create', '_nonce' );

		if ( isset( $_POST['term_image'] ) && '' !== $_POST['term_image'] ) {
			add_term_meta( $term_id, 'image_id', (int) sanitize_text_field( wp_unslash( $_POST['term_image'] ) ), true );
		}
	}, 10, 2 );

	// Add image field to attribute term edit
	add_action( $v . '_edit_form_fields', function( $term, $taxonomy ) {
		woofsubs_image_field(
			get_term_meta( $term->term_id, 'image_id', true ),
			'termImage',
			'term_image',
			'',
			'form-field term-image-wrap'
		);
		wp_nonce_field( 'woofcrate_custom_fields_term_edit', '_nonce' );
	}, 10, 2 );

	// Save image field on attribute term edit
	add_action( 'edited_' . $v, function( $term_id, $tt_id ) {
		check_admin_referer( 'woofcrate_custom_fields_term_edit', '_nonce' );

		if ( isset( $_POST['term_image'] ) && '' !== $_POST['term_image'] ) {
			update_term_meta( $term_id, 'image_id', (int) sanitize_text_field( wp_unslash( $_POST['term_image'] ) ) );
		} else {
			update_term_meta( $term_id, 'image_id', 0 );
		}
	}, 10, 2 );
}
