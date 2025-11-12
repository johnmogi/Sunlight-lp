<?php
namespace LanguageSwitcher;

use LanguageSwitcher\Service\MenuLanguageSwitcher;
use LanguageSwitcher\Support\Assets;
use LanguageSwitcher\Support\Context;
use LanguageSwitcher\Service\SwitcherRenderer;

class Plugin
{
    /** @var bool */
    private bool $headerRendered = false;

    public function boot(): void
    {
        add_action('init', [Context::class, 'boot'], 0);
        add_action('init', [$this, 'loadAssets']);
        (new MenuLanguageSwitcher())->register();
        add_action('astra_masthead_top', [$this, 'renderHeaderSwitcher'], 20);
        add_action('astra_header_after', [$this, 'renderHeaderSwitcher'], 5);
        add_action('astra_header_menu_1', [$this, 'renderHeaderSwitcher'], 99, 1);
        add_action('astra_header_menu_2', [$this, 'renderHeaderSwitcher'], 99, 1);
        add_action('astra_header_menu_mobile', [$this, 'renderHeaderSwitcher'], 99, 1);
    }

    public function loadAssets(): void
    {
        add_action('wp_enqueue_scripts', [Assets::class, 'enqueue']);
    }

    public function renderHeaderSwitcher($unused = null): void
    {
        error_log('LanguageSwitcher: renderHeaderSwitcher called. Already rendered: ' . ($this->headerRendered ? 'yes' : 'no'));
        
        if ($this->headerRendered) {
            return;
        }

        $markup = SwitcherRenderer::render('header');
        error_log('LanguageSwitcher: Generated markup length: ' . strlen($markup));
        echo $markup;
        $this->headerRendered = true;
    }
}
