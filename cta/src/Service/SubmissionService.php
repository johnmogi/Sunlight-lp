<?php
namespace CTA\Service;

class SubmissionService {
    
    public function __construct() {
        $this->registerCPT();
        $this->registerAjaxHandlers();
        $this->registerAdminColumns();
    }

    private function registerCPT() {
        add_action('init', function() {
            register_post_type('cta_submission', [
                'labels' => [
                    'name' => 'CTA Submissions',
                    'singular_name' => 'Submission'
                ],
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'supports' => ['title'],
                'menu_icon' => 'dashicons-email'
            ]);
        });
    }

    private function registerAjaxHandlers() {
        add_action('wp_ajax_cta_submit', [$this, 'handleSubmission']);
        add_action('wp_ajax_nopriv_cta_submit', [$this, 'handleSubmission']);
    }

    public function handleSubmission() {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cta_nonce')) {
            wp_send_json_error(['message' => 'Security check failed']);
            return;
        }

        // Honeypot check - if filled, it's a bot
        if (!empty($_POST['website'])) {
            error_log('CTA Plugin: Honeypot triggered - bot detected');
            wp_send_json_success(['message' => 'Thank you! Your submission has been received.']); // Fake success for bot
            return;
        }

        // Validate
        $name = sanitize_text_field($_POST['name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');

        if (empty($name) || empty($email) || !is_email($email)) {
            wp_send_json_error(['message' => 'Please provide valid name and email']);
            return;
        }

        // Create submission
        $post_id = wp_insert_post([
            'post_type' => 'cta_submission',
            'post_title' => $name,
            'post_status' => 'publish'
        ]);

        if ($post_id) {
            update_post_meta($post_id, '_cta_name', $name);
            update_post_meta($post_id, '_cta_email', $email);
            update_post_meta($post_id, '_cta_date', current_time('mysql'));

            wp_send_json_success(['message' => 'Thank you! Your submission has been received.']);
        } else {
            wp_send_json_error(['message' => 'Something went wrong. Please try again.']);
        }
    }

    private function registerAdminColumns() {
        add_filter('manage_cta_submission_posts_columns', function ($columns) {
            $newColumns = [];

            if (isset($columns['cb'])) {
                $newColumns['cb'] = $columns['cb'];
            }

            $newColumns['title'] = __('Name', 'cta');
            $newColumns['cta_email'] = __('Email', 'cta');

            if (isset($columns['date'])) {
                $newColumns['date'] = $columns['date'];
            }

            return $newColumns;
        });

        add_action('manage_cta_submission_posts_custom_column', function ($column, $post_id) {
            if ($column === 'cta_email') {
                echo esc_html(get_post_meta($post_id, '_cta_email', true));
            }
        }, 10, 2);
    }
}
