<?php
namespace LanguageSwitcher\Support;

class Assets
{
    public static function enqueue(): void
    {
        $handle = 'language-switcher';
        $version = defined('WP_DEBUG') && WP_DEBUG ? time() : '1.0.0';

        wp_enqueue_style(
            $handle,
            LANG_SWITCHER_URL . 'assets/css/switcher.css',
            [],
            $version
        );

        wp_enqueue_script(
            $handle,
            LANG_SWITCHER_URL . 'assets/js/switcher.js',
            ['jquery'],
            $version,
            true
        );
    }
}
