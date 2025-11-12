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

        $language = class_exists('LanguageSwitcher\\Support\\Context')
            ? \LanguageSwitcher\Support\Context::currentCode()
            : null;

        $intro = GalleryConfig::getIntro($language);
        $tabs = GalleryConfig::getTabs($language);

        ob_start();
        include CTA_PLUGIN_DIR . '/src/View/gallery.php';
        return ob_get_clean();
    }
}
