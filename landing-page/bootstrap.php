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
    
    // Convert namespace to file path
    // Handle special case: CTASlider namespace -> cta-slider directory
    $relative_class = str_replace('CTASlider\\', 'cta-slider/', $relative_class);
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
        } else {
            error_log('Landing Page Plugin: Main class not found');
        }
        
        // Initialize the CTA Slider Controller
        if (class_exists('\\LandingPage\\CTASlider\\Controller\\HeroSliderController')) {
            new \LandingPage\CTASlider\Controller\HeroSliderController();
            error_log('Landing Page Plugin: HeroSliderController initialized');
        } else {
            error_log('Landing Page Plugin: HeroSliderController class not found');
        }
    });
} else {
    // Fallback for when WordPress functions aren't available yet
    error_log('Landing Page Plugin: WordPress not fully loaded, skipping hooks');
}
