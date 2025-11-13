<?php
namespace CTA\Support;

use CTA\Config\GalleryConfig;

if (!defined('ABSPATH')) {
    exit;
}

class SectionAssets
{
    private static bool $enqueued = false;
    private static bool $localized = false;
    private static bool $feedbackInjected = false;

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
        $feedbackScriptPath = CTA_PLUGIN_DIR . '/assets/gallery-feedback.js';
        $feedbackScriptVersion = file_exists($feedbackScriptPath) ? filemtime($feedbackScriptPath) : time();

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

        wp_enqueue_script(
            'cta-gallery-feedback',
            CTA_PLUGIN_URL . 'assets/gallery-feedback.js',
            ['jquery', 'cta-sections'],
            '1.0.' . $feedbackScriptVersion,
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

        $language = class_exists('LanguageSwitcher\\Support\\Context')
            ? \LanguageSwitcher\Support\Context::currentCode()
            : null;

        wp_localize_script('cta-sections', 'ctaSectionsData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cta_nonce'),
            'messages' => [
                'success' => __('Thank you! Your submission has been received.', 'cta'),
                'error' => __('Something went wrong. Please try again.', 'cta'),
                'validation' => __('Please provide valid name and email.', 'cta'),
            ],
        ]);

        if (wp_script_is('cta-gallery-feedback', 'enqueued')) {
            $feedbackStrings = GalleryConfig::getFeedbackStrings($language);

            wp_localize_script('cta-gallery-feedback', 'ctaGalleryFeedback', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('cta_nonce'),
                'strings' => $feedbackStrings,
                'messages' => [
                    'success' => $feedbackStrings['success_message'] ?? __('Thank you for your feedback!', 'cta'),
                    'error' => $feedbackStrings['error_message'] ?? __('Unable to save feedback. Please try again.', 'cta'),
                    'throttle' => $feedbackStrings['throttle_message'] ?? __('You recently submitted feedback for this image. Please try again later.', 'cta'),
                    'reactionRequired' => $feedbackStrings['reaction_required'] ?? __('Please choose a reaction.', 'cta'),
                    'ratingRequired' => $feedbackStrings['rating_required'] ?? __('Please choose a rating.', 'cta'),
                    'commentPending' => __('Thank you! Your comment will appear after it is approved.', 'cta'),
                    'commentApproved' => $feedbackStrings['success_message'] ?? __('Thank you for your feedback!', 'cta'),
                ],
                'reactions' => $feedbackStrings['reactions'] ?? [],
            ]);
        }

        self::$localized = true;
    }

    public static function injectFeedbackData(array $data): void
    {
        if (!wp_script_is('cta-gallery-feedback', 'enqueued')) {
            return;
        }

        $json = wp_json_encode($data);

        if (false === $json) {
            return;
        }

        wp_add_inline_script(
            'cta-gallery-feedback',
            'window.ctaGalleryFeedback = window.ctaGalleryFeedback || {}; window.ctaGalleryFeedback.initial = ' . $json . ';',
            'after'
        );
    }
}
