<?php
namespace CTA\Repository;

class GalleryCommentRepository
{
    public const POST_TYPE = 'cta_gallery_comment';

    public static function createPending(array $data): int
    {
        $defaults = [
            'image_id' => '',
            'comment' => '',
            'name' => '',
            'email' => '',
            'reaction' => '',
            'rating' => null,
        ];

        $payload = wp_parse_args($data, $defaults);

        $postId = wp_insert_post([
            'post_type' => self::POST_TYPE,
            'post_status' => 'pending',
            'post_title' => self::resolveTitle($payload),
            'post_content' => $payload['comment'],
            'meta_input' => [
                '_cta_image_id' => $payload['image_id'],
                '_cta_name' => $payload['name'],
                '_cta_email' => $payload['email'],
                '_cta_reaction' => $payload['reaction'],
                '_cta_rating' => $payload['rating'],
            ],
        ]);

        return (int) $postId;
    }

    public static function getApproved(string $imageId, int $limit = 3): array
    {
        $limit = max(1, min($limit, 10));

        $query = new \WP_Query([
            'post_type' => self::POST_TYPE,
            'post_status' => 'publish',
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_key' => '_cta_image_id',
            'meta_value' => $imageId,
        ]);

        if (!$query->have_posts()) {
            return [];
        }

        $results = [];

        foreach ($query->posts as $post) {
            $name = get_post_meta($post->ID, '_cta_name', true);
            $reaction = get_post_meta($post->ID, '_cta_reaction', true);
            $rating = get_post_meta($post->ID, '_cta_rating', true);

            $results[] = [
                'id' => $post->ID,
                'comment' => $post->post_content,
                'name' => $name,
                'reaction' => $reaction,
                'rating' => $rating !== '' ? (int) $rating : null,
                'created_at' => mysql2date('c', $post->post_date_gmt, false),
            ];
        }

        wp_reset_postdata();

        return $results;
    }

    private static function resolveTitle(array $payload): string
    {
        if (!empty($payload['name'])) {
            return wp_strip_all_tags($payload['name']);
        }

        if (!empty($payload['comment'])) {
            return wp_trim_words(wp_strip_all_tags($payload['comment']), 6, '…');
        }

        return 'Gallery Feedback';
    }
}
