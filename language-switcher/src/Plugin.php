<?php
namespace LanguageSwitcher;

use LanguageSwitcher\Service\MenuLanguageSwitcher;
use LanguageSwitcher\Support\Assets;

class Plugin
{
    public function boot(): void
    {
        add_action('init', [$this, 'loadAssets']);
        (new MenuLanguageSwitcher())->register();
    }

    public function loadAssets(): void
    {
        add_action('wp_enqueue_scripts', [Assets::class, 'enqueue']);
    }
}
