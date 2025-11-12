<?php
namespace CTA\Service;

class EmbedService
{
    private static bool $booted = false;

    public static function boot(): void
    {
        if (self::$booted) {
            return;
        }

        self::$booted = true;

        add_action('wp_ajax_cta_oembed', [self::class, 'handle']);
        add_action('wp_ajax_nopriv_cta_oembed', [self::class, 'handle']);
    }

    public static function handle(): void
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'] ?? '')), 'cta_nonce')) {
            wp_send_json_error(['message' => __('Security check failed.', 'cta')], 403);
        }

        $url = isset($_POST['url']) ? esc_url_raw(wp_unslash($_POST['url'])) : '';

        if (empty($url)) {
            wp_send_json_error(['message' => __('Invalid media URL.', 'cta')], 400);
        }

        $embed = wp_oembed_get($url);

        if (!$embed) {
            $embed = sprintf('<iframe src="%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', esc_url($url));
        }

        wp_send_json_success([
            'embed' => $embed,
        ]);
    }
}
