<?php
/**
 * The public-specific functionality of the plugin.
 *
 * @since 1.0.0
 * @package woofcrate-subscribe
 * @author Gogo
 */

// Replace content for subscribe page.
add_filter( 'the_content', function( $content ) {
	$woofsubs = get_option( 'woofsubs' );
	$id = get_the_ID();

	if ( $id !== $woofsubs['subscribe_page'] && $id !== $woofsubs['gift_page'] ) {
		return $content;
	} else {
		$mode = $id === $woofsubs['subscribe_page'] ? 'subscribe' : 'gift';
	}

	$modes = get_terms([
		'taxonomy' => 'pa_mode',
		'hide_empty' => false,
	]);
	$plans = get_terms([
		'taxonomy' => 'pa_plans',
		'hide_empty' => false,
	]);
	$dog_sizes = get_terms([
		'taxonomy' => 'pa_dog-size',
		'hide_empty' => false,
	]);
	$products = new WP_Query([
		'post_type' => 'product',
		'order' => 'ASC',
		'tax_query' => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			[
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => 'crates',
			],
		],
	]);
	$crates = [];
	$dou_tro = [ 0, 0, '' ];
	$currency = get_woocommerce_currency_symbol();
	$allowed_html = [
		'span' => [ 'class' => [] ],
		'br' => [],
	];

	while ( $products->have_posts() ) {
		$products->the_post();

		$post_id = get_the_ID();
		$product = wc_get_product( $post_id );
		$pid = $product->get_id();

		if ( 'simple' !== $product->get_type() ) {
			$variations = $product->get_available_variations();
			$variants = [];
			$image = has_post_thumbnail( $pid ) ? get_post_thumbnail_id( $pid ) : 0;

			foreach ( $variations as $v ) {
				if ( $mode === $v['attributes']['attribute_pa_mode'] ) {
					$attributes = [];

					foreach ( $v['attributes'] as $ka => $va ) {
						if ( 'attribute_pa_mode' !== $ka ) {
							$attributes[ $ka ] = $va;
						}
					}

					$variation = [
						'variation_id' => $v['variation_id'],
						'display_price' => $v['display_price'],
						'display_regular_price' => $v['display_regular_price'],
						'attributes' => $attributes,
					];
					$variants[] = $variation;
				}
			}

			$crates[ $product->get_slug() ] = [ $post_id, $product->get_name(), $image, $product->get_description(), wp_json_encode( $variants ) ];
		} else {
			if ( 'double-trouble' === $product->get_slug() ) {
				$image = get_post_thumbnail_id( $pid );
				$dou_tro = [ $post_id, $product->get_price(), $image ];
			}
		}
	}

	wp_reset_query();

	ob_start();

	if ( 'gift' === $mode ) {
		$dog_name = 'the lucky doggo';
		$sub_url = get_permalink( $woofsubs['subscribe_page'] );
	} else {
		$dog_name = 'your dog';
	}

	include WOOFSUBS_PATH . 'templates/public/public-subscribe-view.php';

	return ob_get_clean();
} );

// Add order to cart
function woofsubs_add_to_cart() {
	// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

	$meta = [
		'dog_name' => sanitize_text_field( wp_unslash( $_POST['dogName'] ) ),
		'dog_gender' => sanitize_text_field( wp_unslash( $_POST['dogGender'] ) ),
		'dog_mob' => sanitize_text_field( wp_unslash( $_POST['dogMOB'] ) ),
		'dog_size' => sanitize_text_field( wp_unslash( $_POST['dogSize'] ) ),
		'allergy' => sanitize_text_field( wp_unslash( $_POST['dogAllergy'] ) ),
		'extra_toy' => sanitize_text_field( wp_unslash( $_POST['extraToy'] ) ),
	];

	if ( isset( $_POST['gift'] ) && 1 === (int) sanitize_text_field( wp_unslash( $_POST['gift'] ) ) ) {
		$meta['gift_to'] = sanitize_text_field( wp_unslash( $_POST['giftToName'] ) );
		$meta['gift_from'] = sanitize_text_field( wp_unslash( $_POST['giftFromName'] ) );
		$meta['gift_message'] = sanitize_text_field( wp_unslash( $_POST['giftMessage'] ) );
	}

	$cart_item_key = WC()->cart->add_to_cart(
		(int) sanitize_text_field( wp_unslash( $_POST['pID'] ) ),
		1,
		(int) sanitize_text_field( wp_unslash( $_POST['vID'] ) ),
		[ 'Plans' => sanitize_text_field( wp_unslash( $_POST['vName'] ) ) ],
		[ 'meta' => $meta ]
	);

	if ( 'yes' === strtolower( sanitize_text_field( wp_unslash( $_POST['douTro'] ) ) ) ) {
		$dou_tro = (int) sanitize_text_field( wp_unslash( $_POST['dt'] ) );
		$found = false;

		if ( count( WC()->cart->get_cart() ) > 0 ) {
			foreach ( WC()->cart->get_cart() as $key => $item ) {
				if ( $item['data']->get_id() === $dou_tro ) {
					$found = true;
				}
			}
		}

		if ( ! $found ) {
			WC()->cart->add_to_cart( $dou_tro );
		}
	}

	// phpcs:enable
	if ( false === $cart_item_key ) {
		echo wp_json_encode( [
			'status' => 'error',
			'message' => __( 'Failed to add to cart!', 'woofsubs' ),
		] );
	} else {
		echo wp_json_encode( [
			'status' => 'ok',
			'message' => $cart_item_key,
		] );
	}

	exit;
}
add_action( 'wp_ajax_woofsubsAddToCart', 'woofsubs_add_to_cart' );
add_action( 'wp_ajax_nopriv_woofsubsAddToCart', 'woofsubs_add_to_cart' );
