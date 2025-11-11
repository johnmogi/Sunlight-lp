<?php
namespace LandingPage\CTASlider\Controller;

use LandingPage\CTASlider\Model\HeroSliderConfig;
use LandingPage\CTASlider\Service\HeroSignupService;

/**
 * Hero Slider Controller
 * Handles shortcode registration, asset enqueuing, and rendering
 */
class HeroSliderController {
    private $config;
    private $signupService;
    private $assetsUrl;

    public function __construct() {
        $this->config = new HeroSliderConfig();
        $this->signupService = new HeroSignupService();
        // Get the base plugin URL and append the cta-slider assets path
        $this->assetsUrl = plugin_dir_url(dirname(dirname(__FILE__))) . 'cta-slider/assets/';
        
        $this->registerHooks();
    }

    private function registerHooks() {
        add_shortcode('sunlight_hero_slider', [$this, 'renderShortcode']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function enqueueAssets() {
        // Only enqueue if shortcode is present
        global $post;
        if (!is_a($post, 'WP_Post') || !has_shortcode($post->post_content, 'sunlight_hero_slider')) {
            return;
        }

        // Enqueue CSS
        wp_enqueue_style(
            'hero-slider-css',
            $this->assetsUrl . 'css/hero-slider.css',
            [],
            '1.0.' . time()
        );

        // Enqueue JS
        wp_enqueue_script(
            'hero-slider-js',
            $this->assetsUrl . 'js/hero-slider.js',
            ['jquery'],
            '1.0.' . time(),
            true
        );

        // Localize script for AJAX
        wp_localize_script('hero-slider-js', 'heroSliderData', [
            'ajaxUrl' => admin_url('admin-ajax.php')
        ]);
    }

    public function renderShortcode($atts) {
        $atts = shortcode_atts([], $atts);
        
        $slides = $this->config->getSlides();
        
        ob_start();
        include dirname(__FILE__) . '/../View/hero-slider.php';
        return ob_get_clean();
    }
}
