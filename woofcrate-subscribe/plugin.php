<?php
/**
 * Plugin Name: Woofcrate Subscribe
 * Plugin URI: https://donnystudio.com/plugins/woofcrate-subscribe/
 * Description: This plugin to create subscribe functionality for Woofcrate. Requires WooCommerce & WooCommerce Subscription.
 * Version: 1.0.0
 * Author: Donny Studio
 * Author URI: https://donnystudio.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: woofsubs
 * Domain Path: /languages
 *
 * WC requires at least: 3.5
 * WC tested up to: 3.5.4
 *
 * @since 1.0.0
 * @package woofcrate-subscribe
 * @author DS
 */

defined( 'WPINC' ) || exit;

define( 'WOOFSUBS_VERSION', '1.0.0' );
define( 'WOOFSUBS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WOOFSUBS_URL', plugin_dir_url( __FILE__ ) );

register_activation_hook(
	__FILE__,
	function() {
		$woofsubs_options = get_option( 'woofsubs' );

		if ( false === $woofsubs_options ) {
			add_option( 'woofsubs', [] );
		}
	}
);

register_deactivation_hook(
	__FILE__,
	function() {}
);

if (
	in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true )
	&&
	in_array( 'woocommerce-subscriptions/woocommerce-subscriptions.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true )
) {
	require_once WOOFSUBS_PATH . 'inc/setup.php';
	require_once WOOFSUBS_PATH . 'inc/admin-page.php';
	require_once WOOFSUBS_PATH . 'inc/public-page.php';
	require_once WOOFSUBS_PATH . 'inc/woocommerce.php';
}
