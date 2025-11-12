<?php
namespace CTA\Support;

if (!defined('ABSPATH')) {
    exit;
}

class SectionAssets
{
    private static bool $enqueued = false;
    private static bool $localized = false;

    public static function enqueue(): void
    {
        if (self::$enqueued) {
            self::localize();
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

        self::localize();
    }

    private static function localize(): void
    {
        if (self::$localized) {
            return;
        }

        if (!wp_script_is('cta-sections', 'enqueued')) {
            return;
        }

        wp_localize_script('cta-sections', 'ctaSectionsData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cta_nonce'),
            'messages' => [
                'success' => __('Thank you! Your submission has been received.', 'cta'),
                'error' => __('Something went wrong. Please try again.', 'cta'),
                'validation' => __('Please provide valid name and email.', 'cta'),
            ],
        ]);

        self::$localized = true;
    }
}
