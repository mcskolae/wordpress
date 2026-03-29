<?php

/**
 * Plugin Name: Switch to
 * Description: Gives the ability to "switch" to the selected user
 * Version: 1.0
 * Author: Max Chen
 */

if (!defined('ABSPATH')) {
    exit;
}

define('SWITCHTO_URL', plugin_dir_url(__FILE__));
define('SWITCHTO_PATH', plugin_dir_path(__FILE__));

require_once SWITCHTO_PATH . 'includes/front.php';
require_once SWITCHTO_PATH . 'includes/dashboard.php';
