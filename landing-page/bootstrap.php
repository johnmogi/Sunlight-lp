<?php
/**
 * Landing Page Plugin for Sunlight Project
 *
 * Custom functionality for the Sunlight Tarot landing page
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('LANDING_PAGE_DIR', __DIR__);

// Autoloader for the plugin
spl_autoload_register(function ($class) {
    $prefix = 'LandingPage\\';
    $base_dir = __DIR__ . '/includes/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Initialize the plugin
if (function_exists('add_action')) {
    add_action('plugins_loaded', function() {
        // Initialize the landing page functionality
        if (class_exists('\\LandingPage\\Main')) {
            \LandingPage\Main::get_instance();
        }
    });
} else {
    // Fallback for when WordPress functions aren't available yet
    error_log('Landing Page Plugin: WordPress not fully loaded, skipping hooks');
}
