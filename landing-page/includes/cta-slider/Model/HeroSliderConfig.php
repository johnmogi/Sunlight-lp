<?php
namespace LandingPage\CTASlider\Model;

/**
 * Configuration and data provider for hero slider
 */
class HeroSliderConfig {
    private $slides = [];

    public function __construct() {
        $this->initializeSlides();
    }

    private function initializeSlides() {
        $this->slides = [
            new HeroSlide([
                'id' => 0,
                'pre_title' => '✨ The Sunlight Codex',
                'title' => 'Sunlight Tarot',
                'subtitle' => 'A New Light on the Tarot Tradition',
                'description' => 'Not a tool for fortune-telling.<br>A living map of consciousness — science, soul, and art entwined.',
                'subtext' => 'Reimagining the Tarot as a bridge between mysticism and modern understanding.',
                'cta_icon' => '✨',
                'cta_text' => 'I Want to Participate',
                'form_id' => 'form-tarot',
                'form_title' => 'Join the Sunlight Tarot Project',
                'form_description' => 'Early access to artwork, deck updates, and community',
                'project_slug' => 'sunlight-tarot',
                'project_name' => 'Sunlight Tarot',
                'nonce_name' => 'tarot_signup_nonce',
                'background_gradient' => 'linear-gradient(135deg, rgba(255,234,167,0.9) 0%, rgba(253,203,110,0.9) 50%, rgba(225,112,85,0.9) 100%)',
                'background_image' => 'https://images.unsplash.com/photo-1518562180175-34a163b1a9a6?w=1920&q=80'
            ]),
            new HeroSlide([
                'id' => 1,
                'pre_title' => '📚 Novel Crafting',
                'title' => 'Maze Chronicles',
                'subtitle' => 'Four Novels, One Consciousness',
                'description' => 'Beginning with <em>The Boring Field Guide to Fantastic Multidimensional Portals</em>.<br>A mind-bending journey through consciousness, reality, and transformation.',
                'subtext' => 'Where every choice shapes reality and every page opens new dimensions.',
                'cta_icon' => '📖',
                'cta_text' => 'Get Early Access',
                'form_id' => 'form-novels',
                'form_title' => 'Join the Maze Chronicles Journey',
                'form_description' => 'Get notified about releases, excerpts, and special editions',
                'project_slug' => 'maze-chronicles',
                'project_name' => 'Maze Chronicles',
                'nonce_name' => 'novels_signup_nonce',
                'background_gradient' => 'linear-gradient(135deg, rgba(116,185,255,0.85) 0%, rgba(162,155,254,0.85) 50%, rgba(223,230,233,0.85) 100%)',
                'background_image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&q=80'
            ])
        ];
    }

    public function getSlides() {
        return $this->slides;
    }

    public function getSlideCount() {
        return count($this->slides);
    }
}
