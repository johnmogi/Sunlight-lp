<?php
namespace LanguageSwitcher\Service;

use LanguageSwitcher\Config\Languages;

class MenuLanguageSwitcher
{
    /** @var string[] */
    private array $targetLocations = ['primary', 'mobile', 'mobile_menu'];

    public function register(): void
    {
        add_filter('wp_nav_menu_items', [$this, 'appendSwitcher'], 10, 2);
    }

    public function appendSwitcher(string $items, $args): string
    {
        if (!isset($args->theme_location) || !in_array($args->theme_location, $this->targetLocations, true)) {
            return $items;
        }

        $switcherMarkup = $this->getSwitcherMarkup();

        return $items . $switcherMarkup;
    }

    private function getSwitcherMarkup(): string
    {
        $languages = Languages::all();
        $currentLocale = function_exists('determine_locale') ? determine_locale() : get_locale();

        ob_start();
        include LANG_SWITCHER_DIR . '/src/View/switcher.php';
        return ob_get_clean();
    }
}
