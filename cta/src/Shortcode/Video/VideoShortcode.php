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

        $content = VideoConfig::getContent();

        ob_start();
        include CTA_PLUGIN_DIR . '/src/View/video.php';
        return ob_get_clean();
    }
}
