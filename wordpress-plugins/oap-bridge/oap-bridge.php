<?php
/**
 * Plugin Name: OAP Bridge
 * Description: Connects WordPress with the Open Agent Protocol (OAP) Framework (OAEP, OACP, OAPP).
 * Version: 0.1.0
 * Author: OAP Foundation
 */

if (!defined('ABSPATH')) {
    exit;
}

define('OAP_BRIDGE_PATH', plugin_dir_path(__FILE__));
define('OAP_BRIDGE_URL', plugin_dir_url(__FILE__));

// Autoload OAP Framework dependencies
// Assuming the plugin is located at oap-framework/wp-plugin/oap-bridge
// and protocols are at oap-framework/oaep, oap-framework/oacp, oap-framework/oapp
$framework_root = dirname(dirname(dirname(__FILE__)));

// We need to require the autoloaders for the protocols if they exist
// In a real setup, these would be composer dependencies.
// For this demo, we might need to map them manually or use a combined autoloader.

require_once OAP_BRIDGE_PATH . 'includes/class-oap-bridge.php';
require_once OAP_BRIDGE_PATH . 'includes/class-oap-rest-controller.php';
require_once OAP_BRIDGE_PATH . 'includes/class-oap-agent-interface.php';
require_once OAP_BRIDGE_PATH . 'includes/class-oap-mock-data.php';

function oap_bridge_init()
{
    $bridge = OAP_Bridge::get_instance();
    $bridge->init();
}
add_action('plugins_loaded', 'oap_bridge_init');
