<?php
namespace CTA\Shortcode\Video;

use CTA\Config\VideoConfig;
use CTA\Support\SectionAssets;

class VideoShortcode
{
    public function __construct()
    {
        add_shortcode('cta_video', [$this, 'render']);
    }

    public function render($atts = []): string
    {
        SectionAssets::enqueue();

        $atts = shortcode_atts([
            'url' => '',
        ], $atts, 'cta_video');

        $language = class_exists('LanguageSwitcher\\Support\\Context')
            ? \LanguageSwitcher\Support\Context::currentCode()
            : null;

        $content = VideoConfig::getContent($language);
        $ajax = [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cta_nonce'),
        ];

        ob_start();
        include CTA_PLUGIN_DIR . '/src/View/video.php';
        return ob_get_clean();
    }
}
