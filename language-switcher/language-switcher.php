<?php
/**
 * Plugin Name: Language Switcher
 * Description: Adds a simple language switcher to primary and mobile menus.
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('LANG_SWITCHER_DIR', __DIR__);

define('LANG_SWITCHER_URL', plugin_dir_url(__FILE__));

spl_autoload_register(function ($class) {
    $prefix = 'LanguageSwitcher\\';
    $baseDir = __DIR__ . '/src/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

add_action('plugins_loaded', function () {
    if (!class_exists('LanguageSwitcher\\Plugin')) {
        return;
    }

    (new LanguageSwitcher\Plugin())->boot();
});
