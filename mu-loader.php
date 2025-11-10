<?php
/**
 * Plugin Name: EMU Plugins Loader
 * Description: Loads all EMU plugins from the mu-plugins directory
 * Version: 1.0.0
 * Author: Your Name
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define the main plugins directory
define('EMU_PLUGINS_DIR', __DIR__);

// Function to load all plugins
function emu_load_plugins() {
    // Get all plugin directories (exclude files and specific directories)
    $plugins = glob(EMU_PLUGINS_DIR . '/*', GLOB_ONLYDIR);

    foreach ($plugins as $plugin_dir) {
        $plugin_name = basename($plugin_dir);
        $bootstrap_file = $plugin_dir . '/bootstrap.php';

        // Skip system directories and files that aren't plugins
        $skip_dirs = ['emu-plugins', '.', '..'];
        $skip_patterns = ['-disabled', 'disabled-'];
        $should_skip = in_array($plugin_name, $skip_dirs);

        foreach ($skip_patterns as $pattern) {
            if (strpos($plugin_name, $pattern) !== false) {
                $should_skip = true;
                break;
            }
        }

        if ($should_skip || !is_dir($plugin_dir)) {
            continue;
        }

        // If the plugin has a bootstrap.php file, include it
        if (file_exists($bootstrap_file)) {
            require_once $bootstrap_file;
        }
    }
}

// Hook into WordPress (only if WordPress functions are available)
if (function_exists('add_action')) {
    add_action('muplugins_loaded', 'emu_load_plugins');
}
