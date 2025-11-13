<?php
namespace CTA\Controller;

use CTA\Repository\GalleryFeedbackRepository;
use CTA\Repository\GalleryCommentRepository;

class GalleryFeedbackController
{
    private static bool $booted = false;
    private const REACTIONS = ['like', 'love', 'dislike'];

    public static function boot(): void
    {
        if (self::$booted) {
            return;
        }

        self::$booted = true;

        GalleryFeedbackRepository::ensureTable();

        add_action('wp_ajax_cta_gallery_feedback', [self::class, 'handle']);
        add_action('wp_ajax_nopriv_cta_gallery_feedback', [self::class, 'handle']);
    }

    public static function handle(): void
    {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
        if (!$nonce || !wp_verify_nonce($nonce, 'cta_nonce')) {
            wp_send_json_error(['message' => __('Security check failed.', 'cta')], 403);
        }

        $honeypot = isset($_POST['cta_feedback_url']) ? trim((string) wp_unslash($_POST['cta_feedback_url'])) : '';
        if (!empty($honeypot)) {
            wp_send_json_success(['message' => __('Thank you for your feedback!', 'cta')]);
        }

        $imageId = isset($_POST['image_id']) ? sanitize_text_field(wp_unslash($_POST['image_id'])) : '';
        if (empty($imageId)) {
            wp_send_json_error(['message' => __('Invalid image reference.', 'cta')], 400);
        }

        $reaction = isset($_POST['reaction']) ? sanitize_text_field(wp_unslash($_POST['reaction'])) : '';
        if (!in_array($reaction, self::REACTIONS, true)) {
            wp_send_json_error(['message' => __('Please select a reaction.', 'cta')], 400);
        }

        $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
        if ($rating < 1 || $rating > 10) {
            wp_send_json_error(['message' => __('Please provide a rating between 1 and 10.', 'cta')], 400);
        }

        $comment = isset($_POST['comment']) ? sanitize_textarea_field(wp_unslash($_POST['comment'])) : '';
        if (strlen($comment) > 1000) {
            wp_send_json_error(['message' => __('Comment is too long.', 'cta')], 400);
        }

        $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
        if ($name !== '' && strlen($name) > 150) {
            wp_send_json_error(['message' => __('Name is too long.', 'cta')], 400);
        }

        $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        if ($email !== '' && !is_email($email)) {
            wp_send_json_error(['message' => __('Please provide a valid email address.', 'cta')], 400);
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $ipHash = $ip ? hash('sha256', $ip . NONCE_SALT) : null;

        if ($ipHash && GalleryFeedbackRepository::recentlySubmitted($imageId, $ipHash)) {
            wp_send_json_error(['message' => __('You recently submitted feedback for this image. Please try again later.', 'cta')], 429);
        }

        $inserted = GalleryFeedbackRepository::insert([
            'image_id' => $imageId,
            'rating' => $rating,
            'reaction' => $reaction,
            'comment' => null,
            'name' => $name ?: null,
            'email' => $email ?: null,
            'ip_hash' => $ipHash,
        ]);

        if (!$inserted) {
            wp_send_json_error(['message' => __('Unable to save feedback. Please try again.', 'cta')], 500);
        }

        $commentPending = false;

        if ($comment !== '') {
            $commentId = GalleryCommentRepository::createPending([
                'image_id' => $imageId,
                'comment' => $comment,
                'name' => $name,
                'email' => $email,
                'reaction' => $reaction,
                'rating' => $rating,
            ]);

            if ($commentId) {
                $commentPending = true;
            }
        }

        $aggregates = GalleryFeedbackRepository::aggregates($imageId);
        $recentComments = GalleryCommentRepository::getApproved($imageId);

        wp_send_json_success([
            'message' => $commentPending
                ? __('Thank you! Your comment will appear after it is approved.', 'cta')
                : __('Thank you for your feedback!', 'cta'),
            'aggregates' => $aggregates,
            'comments' => $recentComments,
            'comment_pending' => $commentPending,
        ]);
    }
}
