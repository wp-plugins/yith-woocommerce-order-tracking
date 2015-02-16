<?php
/*
Plugin Name: YITH WooCommerce Order Tracking
Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-order-tracking/
Description: Easy managing order tracking information for WooCommerce orders. Set the carrier and the tracking code and your customers will get notified about their shipping.
Author: Yithemes
Text Domain: ywot
Version: 1.0.1
Author URI: http://yithemes.com/
*/

//region    ****    Check if prerequisites are satisfied before enabling and using current plugin

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'WC' ) ) {
	function yith_ywot_install_woocommerce_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( 'YITH WooCommerce Order Tracking is enabled but not effective. It requires Woocommerce in order to work.', 'ywot' ); ?></p>
		</div>
	<?php
	}

	add_action( 'admin_notices', 'yith_ywot_install_woocommerce_admin_notice' );

	return;
}

if ( defined( 'YITH_YWOT_PREMIUM' ) ) {
	function yith_ywot_install_free_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Advanced Reviews while you are using the premium one.', 'ywot' ); ?></p>
		</div>
	<?php
	}

	add_action( 'admin_notices', 'yith_ywot_install_free_admin_notice' );

	deactivate_plugins( plugin_basename( __FILE__ ) );

	return;
}

//  Stop activation if the premium version of the same plugin is still active
if ( defined( 'YITH_YWOT_VERSION' ) ) {
	return;
}
//endregion

//region    ****    Define constants
if ( ! defined( 'YITH_YWOT_FREE_INIT' ) ) {
	define( 'YITH_YWOT_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_YWOT_VERSION' ) ) {
	define( 'YITH_YWOT_VERSION', '1.0.1' );
}

if ( ! defined( 'YITH_YWOT_FILE' ) ) {
	define( 'YITH_YWOT_FILE', __FILE__ );
}

if ( ! defined( 'YITH_YWOT_DIR' ) ) {
	define( 'YITH_YWOT_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YITH_YWOT_URL' ) ) {
	define( 'YITH_YWOT_URL', plugins_url( '/', __FILE__ ) );
}

if ( ! defined( 'YITH_YWOT_ASSETS_URL' ) ) {
	define( 'YITH_YWOT_ASSETS_URL', YITH_YWOT_URL . 'assets' );
}

if ( ! defined( 'YITH_YWOT_TEMPLATE_PATH' ) ) {
	define( 'YITH_YWOT_TEMPLATE_PATH', YITH_YWOT_DIR . 'templates' );
}

if ( ! defined( 'YITH_YWOT_ASSETS_IMAGES_URL' ) ) {
	define( 'YITH_YWOT_ASSETS_IMAGES_URL', YITH_YWOT_ASSETS_URL . '/images/' );
}
//endregion

/**
 * Load text domain and start plugin
 */
load_plugin_textdomain( 'ywot', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Init default plugin settings
 */
if ( !function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

require_once( YITH_YWOT_DIR . 'class.yith-woocommerce-order-tracking.php' );

$YWOT_Instance = new Yith_WooCommerce_Order_Tracking();
