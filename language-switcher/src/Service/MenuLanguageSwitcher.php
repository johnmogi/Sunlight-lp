<?php
namespace LanguageSwitcher\Service;

use LanguageSwitcher\Service\SwitcherRenderer;

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
        if (!isset($args->theme_location) || !$this->shouldAppendToLocation($args->theme_location)) {
            return $items;
        }

        $switcherMarkup = $this->getSwitcherMarkup();

        return $items . $switcherMarkup;
    }

    private function getSwitcherMarkup(): string
    {
        return SwitcherRenderer::render('menu');
    }

    private function shouldAppendToLocation(string $location): bool
    {
        if (in_array($location, $this->targetLocations, true)) {
            return true;
        }

        return strpos($location, 'menu_') === 0;
    }
}
