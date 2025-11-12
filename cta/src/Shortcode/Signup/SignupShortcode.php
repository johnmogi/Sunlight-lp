<?php
namespace CTA\Shortcode\Signup;

use CTA\Config\SignupConfig;
use CTA\Support\SectionAssets;

class SignupShortcode
{
    public function __construct()
    {
        add_shortcode('cta_signup', [$this, 'render']);
    }

    public function render(): string
    {
        SectionAssets::enqueue();

        $language = class_exists('LanguageSwitcher\\Support\\Context')
            ? \LanguageSwitcher\Support\Context::currentCode()
            : null;

        $content = SignupConfig::getContent($language);

        ob_start();
        include CTA_PLUGIN_DIR . '/src/View/signup.php';
        return ob_get_clean();
    }
}
