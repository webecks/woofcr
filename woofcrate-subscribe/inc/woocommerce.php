<?php
/**
 * Add/Overwrite Woocommerce functionality.
 *
 * @since 1.0.0
 * @package woofcrate-subscribe
 * @author Gogo
 */

add_filter( 'woocommerce_ship_to_different_address_checked', function() {
	$mode = get_transient( 'woofsubs_mode' );

	if ( false !== $mode ) {
		if ( 'subscribe' === $mode ) {
			return false;
		} elseif ( 'gift' === $mode ) {
			return true;
		}
	}
}, 34 );

add_action( 'woocommerce_thankyou', function() {
	delete_transient( 'woofsubs_mode' );
}, 34 );

// Display Metadata in the Cart
add_filter( 'woocommerce_get_item_data', function( $item_data, $cart_item ) {
	if ( array_key_exists( 'meta', $cart_item ) ) {
		$order_info = woofsubs_meta_key_to_display();

		foreach ( $cart_item['meta'] as $k => $v ) {
			if ( array_key_exists( $k, $order_info ) ) {
				$item_data[] = [
					'key' => $order_info[ $k ],
					'value' => wc_clean( $v ),
					'display' => '',
				];
			}
		}
	}

	return $item_data;
}, 10, 2 );

// Save Metadata to the Order
add_action( 'woocommerce_checkout_create_order_line_item', function( $item, $cart_item_key, $values, $order ) {
	if ( array_key_exists( 'meta', $values ) ) {
		$order_info = woofsubs_meta_key_to_display();

		foreach ( $values['meta'] as $k => $v ) {
			if ( array_key_exists( $k, $order_info ) ) {
				$item->add_meta_data( $order_info[ $k ], $v, true );
			}
		}
	}
}, 10, 4 );

// Add Toy (fee)
add_action( 'woocommerce_cart_calculate_fees', function( $cart_obj ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}

	$woofsubs = get_option( 'woofsubs' );

	foreach ( $cart_obj->cart_contents as $item ) {
		if ( WC_Subscriptions_Product::is_subscription( $item['data']->get_id() ) ) {
			if ( 'yes' === strtolower( $item['meta']['extra_toy'] ) ) {
				$cart_obj->add_fee( __( 'Extra Toy', 'woofsubs' ), $woofsubs['extratoy_price'] );
			}
		}
	}
} );
