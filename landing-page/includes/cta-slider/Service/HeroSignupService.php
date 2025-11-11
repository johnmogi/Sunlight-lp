<?php
namespace LandingPage\CTASlider\Service;

/**
 * Handles hero slider form submissions
 */
class HeroSignupService {
    
    public function __construct() {
        $this->registerAjaxHandlers();
    }

    private function registerAjaxHandlers() {
        add_action('wp_ajax_sunlight_hero_signup', [$this, 'handleSignup']);
        add_action('wp_ajax_nopriv_sunlight_hero_signup', [$this, 'handleSignup']);
    }

    public function handleSignup() {
        // Verify nonce
        $project = sanitize_text_field($_POST['project'] ?? '');
        $nonceName = $this->getNonceNameForProject($project);
        
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'sunlight_signup_nonce')) {
            wp_send_json_error(['message' => 'Security verification failed.']);
            return;
        }

        // Validate required fields
        if (empty($_POST['name']) || empty($_POST['email'])) {
            wp_send_json_error(['message' => 'Please fill in all required fields.']);
            return;
        }

        if (!isset($_POST['consent']) || $_POST['consent'] !== 'true') {
            wp_send_json_error(['message' => 'Please agree to receive updates.']);
            return;
        }

        // Sanitize input
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);

        // Validate email
        if (!is_email($email)) {
            wp_send_json_error(['message' => 'Please provide a valid email address.']);
            return;
        }

        // Check if user already exists
        if (email_exists($email)) {
            wp_send_json_error(['message' => 'This email is already registered.']);
            return;
        }

        // Create user
        $user_id = wp_create_user($email, wp_generate_password(), $email);

        if (is_wp_error($user_id)) {
            wp_send_json_error(['message' => 'Registration failed. Please try again.']);
            return;
        }

        // Update user meta
        wp_update_user([
            'ID' => $user_id,
            'first_name' => $name
        ]);

        update_user_meta($user_id, 'sunlight_signup_date', current_time('mysql'));
        update_user_meta($user_id, 'sunlight_consent', true);
        update_user_meta($user_id, 'sunlight_project', $project);

        $projectName = $this->getProjectName($project);
        wp_send_json_success(['message' => "Welcome to {$projectName}! Check your email for next steps."]);
    }

    private function getNonceNameForProject($project) {
        $map = [
            'sunlight-tarot' => 'tarot_signup_nonce',
            'maze-chronicles' => 'novels_signup_nonce',
            'maze-game' => 'game_signup_nonce'
        ];
        return $map[$project] ?? 'tarot_signup_nonce';
    }

    private function getProjectName($project) {
        $map = [
            'sunlight-tarot' => 'Sunlight Tarot',
            'maze-chronicles' => 'Maze Chronicles',
            'maze-game' => 'The Maze Game'
        ];
        return $map[$project] ?? 'Sunlight Project';
    }
}
