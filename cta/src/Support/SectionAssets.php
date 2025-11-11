<?php
namespace CTA\Support;

if (!defined('ABSPATH')) {
    exit;
}

class SectionAssets
{
    private static bool $enqueued = false;

    public static function enqueue(): void
    {
        if (self::$enqueued) {
            return;
        }

        self::$enqueued = true;

        $stylePath = CTA_PLUGIN_DIR . '/assets/sections.css';
        $scriptPath = CTA_PLUGIN_DIR . '/assets/sections.js';

        $styleVersion = file_exists($stylePath) ? filemtime($stylePath) : time();
        $scriptVersion = file_exists($scriptPath) ? filemtime($scriptPath) : time();

        wp_enqueue_style(
            'cta-sections',
            CTA_PLUGIN_URL . 'assets/sections.css',
            [],
            '1.0.' . $styleVersion
        );

        wp_enqueue_script(
            'cta-sections',
            CTA_PLUGIN_URL . 'assets/sections.js',
            ['jquery'],
            '1.0.' . $scriptVersion,
            true
        );
    }
}
