<?php
namespace CTA\Shortcode\About;

use CTA\Config\AboutConfig;
use CTA\Support\SectionAssets;

class AboutShortcode
{
    public function __construct()
    {
        add_shortcode('cta_about', [$this, 'render']);
    }

    public function render(): string
    {
        SectionAssets::enqueue();

        $intro = AboutConfig::getIntro();
        $cards = AboutConfig::getCards();
        $quote = AboutConfig::getQuote();

        ob_start();
        include CTA_PLUGIN_DIR . '/src/View/about.php';
        return ob_get_clean();
    }
}
