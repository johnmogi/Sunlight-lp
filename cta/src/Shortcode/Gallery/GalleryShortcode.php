<?php
namespace CTA\Shortcode\Gallery;

use CTA\Config\GalleryConfig;
use CTA\Support\SectionAssets;

class GalleryShortcode
{
    public function __construct()
    {
        add_shortcode('cta_gallery', [$this, 'render']);
    }

    public function render(): string
    {
        SectionAssets::enqueue();

        $intro = GalleryConfig::getIntro();
        $tabs = GalleryConfig::getTabs();

        ob_start();
        include CTA_PLUGIN_DIR . '/src/View/gallery.php';
        return ob_get_clean();
    }
}
