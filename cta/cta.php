<?php
/**
 * Plugin Name: CTA Slider
 * Description: Simple 3-slide carousel with form submissions
 * Version: 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CTA_PLUGIN_DIR', __DIR__);
define('CTA_PLUGIN_URL', plugin_dir_url(__FILE__));

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'CTA\\';
    $base_dir = __DIR__ . '/src/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relative_class = substr($class, strlen($prefix));
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Initialize plugin
add_action('plugins_loaded', function() {
    if (class_exists('CTA\Repository\GalleryFeedbackRepository')) {
        \CTA\Repository\GalleryFeedbackRepository::ensureTable();
    }

    if (class_exists('CTA\Service\GalleryCommentService')) {
        \CTA\Service\GalleryCommentService::boot();
    }

    if (class_exists('CTA\Controller\GalleryFeedbackController')) {
        \CTA\Controller\GalleryFeedbackController::boot();
    }

    if (class_exists('CTA\Shortcode\Registry')) {
        \CTA\Shortcode\Registry::register();
    }

    if (class_exists('CTA\Service\EmbedService')) {
        \CTA\Service\EmbedService::boot();
    }
});
