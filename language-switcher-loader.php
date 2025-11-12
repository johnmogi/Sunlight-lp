<?php
/**
 * Language Switcher MU-Plugin Loader
 * 
 * WordPress only auto-loads files directly in mu-plugins/, not subdirectories.
 * This loader ensures the language-switcher plugin is bootstrapped.
 */

if (file_exists(__DIR__ . '/language-switcher/language-switcher.php')) {
    require_once __DIR__ . '/language-switcher/language-switcher.php';
}
