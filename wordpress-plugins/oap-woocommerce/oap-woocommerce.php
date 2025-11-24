<?php
/**
 * Plugin Name: OAP WooCommerce Integration
 * Plugin URI: https://oap.foundation
 * Description: Exposes WooCommerce products and orders to the Open Agent Protocol (OAP) network.
 * Version: 0.1.0
 * Author: OAP Foundation
 * Text Domain: oap-woocommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

define('OAP_WC_PATH', plugin_dir_path(__FILE__));
define('OAP_WC_URL', plugin_dir_url(__FILE__));

require_once OAP_WC_PATH . 'includes/class-oap-wc-bridge.php';

function oap_wc_init()
{
    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p>OAP WooCommerce Integration requires WooCommerce to be installed and active.</p></div>';
        });
        return;
    }

    $bridge = OAP_WC_Bridge::get_instance();
    $bridge->init();
}
add_action('plugins_loaded', 'oap_wc_init');
