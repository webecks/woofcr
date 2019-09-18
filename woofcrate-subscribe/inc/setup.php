<?php
/**
 * Setup the plugin.
 *
 * @since 1.0.0
 * @package woofcrate-subscribe
 * @author Gogo
 */

defined( 'WPINC' ) || exit;

add_action( 'wp_enqueue_scripts', function() {
	$woofsubs = get_option( 'woofsubs' );

	if ( is_page( $woofsubs['subscribe_page'] ) || is_page( $woofsubs['gift_page'] ) ) {
		$mode = get_the_ID() === $woofsubs['subscribe_page'] ? 'subscribe' : 'gift';

		set_transient( 'woofsubs_mode', $mode, ( 60 * 60 * 6 ) );

		wp_register_style(
			'fontawsome',
			'https://use.fontawesome.com/releases/v5.7.2/css/all.css',
			[],
			'5.7.2'
		);

		wp_register_style(
			'google-fonts',
			'https://fonts.googleapis.com/css?family=Baloo+Paaji',
			[],
			'1.0'
		);

		wp_enqueue_style(
			'woofsubs-style',
			WOOFSUBS_URL . 'assets/public/style.min.css',
			[ 'google-fonts', 'fontawsome' ],
			filemtime( WOOFSUBS_PATH . 'assets/public/style.min.css' )
		);

		wp_register_script(
			'jquery-steps',
			WOOFSUBS_URL . 'assets/public/jquery.steps.min.js',
			[ 'jquery' ],
			'1.1.0',
			true
		);

		wp_enqueue_script(
			'woofsubs-script',
			WOOFSUBS_URL . 'assets/public/script.min.js',
			[ 'jquery-steps' ],
			filemtime( WOOFSUBS_PATH . 'assets/public/script.min.js' ),
			true
		);

		wp_localize_script(
			'woofsubs-script',
			'woSu',
			[
				'mode' => $mode,
				'checkoutURL' => esc_url( get_permalink( wc_get_page_id( 'checkout' ) ) ),
				'currency' => esc_html( get_woocommerce_currency_symbol() ),
				'message' => [
					'm1' => $woofsubs['messages']['m1'],
					'm2' => $woofsubs['messages']['m2'],
					'm3' => $woofsubs['messages']['m3'],
					'm4' => $woofsubs['messages']['m4'],
					'm5' => $woofsubs['messages']['m5'],
					'm6' => $woofsubs['messages']['m6'],
				],
			]
		);
	}
}, 34 );

add_action( 'admin_enqueue_scripts', function( $hook ) {
	$attrs = array_map( function( $a ) {
		return 'edit-' . $a;
	}, woofsubs_pa() );

	if ( ! in_array( get_current_screen()->id, $attrs, true ) && 'settings_page_woofcrate-subscribe' !== $hook ) {
		return;
	}

	wp_enqueue_script(
		'woofsubs-script',
		WOOFSUBS_URL . 'assets/admin/script.min.js',
		[ 'jquery' ],
		filemtime( WOOFSUBS_PATH . 'assets/admin/script.min.js' ),
		true
	);
}, 34, 1 );

add_action( 'after_setup_theme', function() {
	if ( ! is_admin() ) {
		show_admin_bar( false );
	}
} );

/* Functions/Helpers */
// Translate meta keys
function woofsubs_meta_key_to_display() {
	return [
		'dog_name' => __( 'Name', 'woofsubs' ),
		'dog_gender' => __( 'Gender', 'woofsubs' ),
		'dog_mob' => __( 'Birthday', 'woofsubs' ),
		'dog_size' => __( 'Size', 'woofsubs' ),
		'allergy' => __( 'Allergy', 'woofsubs' ),
		'gift_to' => __( 'Gift To', 'woofsubs' ),
		'gift_from' => __( 'Gift From', 'woofsubs' ),
		'gift_message' => __( 'Gift Message', 'woofsubs' ),
	];
}

// Product attributes
function woofsubs_pa() {
	return [ 'pa_plans', 'pa_dog-size' ];
}

// Process output
function woofsubs_po( $input = '', $args = [] ) {
	$output = nl2br( $input );

	if ( strpos( $output, '{dogname}' ) !== false && ( isset( $args['dogname'] ) && ! empty( $args['dogname'] ) ) ) {
		$output = str_replace( '{dogname}', '<span class="dog-name">' . esc_html( $args['dogname'] ) . '</span>', $output );
	}

	if ( strpos( $output, '{currency}' ) !== false && ( isset( $args['currency'] ) && ! empty( $args['currency'] ) ) ) {
		$output = str_replace( '{currency}', esc_html( $args['currency'] ), $output );
	}

	if ( strpos( $output, '{nominal}' ) !== false && ( isset( $args['nominal'] ) && ! empty( $args['nominal'] ) ) ) {
		$output = str_replace( '{nominal}', esc_html( $args['nominal'] ), $output );
	}

	return $output;
}

// Output image field on setting
function woofsubs_image_field( $image_id, $field_id, $field_name, $field_label = '', $tr_class = '' ) {
	$field_label = empty( $field_label ) ? __( 'Image', 'woofsubs' ) : $field_label;

	include WOOFSUBS_PATH . 'templates/admin/admin-term-edit-view.php';
}
