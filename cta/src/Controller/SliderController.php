<?php
namespace CTA\Controller;

use CTA\Model\SlideConfig;
use CTA\Service\SubmissionService;

class SliderController {
    private $submissionService;

    public function __construct() {
        $this->submissionService = new SubmissionService();
        $this->registerShortcode();
        $this->enqueueAssets();
    }

    private function registerShortcode() {
        add_shortcode('cta_slider', [$this, 'render']);
    }

    private function enqueueAssets() {
        add_action('wp_enqueue_scripts', function() {
            wp_enqueue_style('cta-slider', CTA_PLUGIN_URL . 'assets/slider.css', [], '1.0.0');
            wp_enqueue_script('cta-slider', CTA_PLUGIN_URL . 'assets/slider.js', ['jquery'], '1.0.0', true);
            wp_localize_script('cta-slider', 'ctaData', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('cta_nonce')
            ]);
        });
    }

    public function render() {
        $slides = SlideConfig::getSlides();
        ob_start();
        include CTA_PLUGIN_DIR . '/src/View/slider.php';
        return ob_get_clean();
    }
}
