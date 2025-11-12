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

        $language = class_exists('LanguageSwitcher\\Support\\Context')
            ? \LanguageSwitcher\Support\Context::currentCode()
            : null;

        $intro = AboutConfig::getIntro($language);
        $cards = AboutConfig::getCards($language);
        $universe = AboutConfig::getUniverse($language);
        $quote = AboutConfig::getQuote($language);

        ob_start();
        include CTA_PLUGIN_DIR . '/src/View/about.php';
        return ob_get_clean();
    }
}
