<?php
namespace CTA\Service;

use CTA\Repository\GalleryCommentRepository;

class GalleryCommentService
{
    private static bool $booted = false;

    public static function boot(): void
    {
        if (self::$booted) {
            return;
        }

        self::$booted = true;

        add_action('init', [self::class, 'registerPostType']);
        add_filter('manage_' . GalleryCommentRepository::POST_TYPE . '_posts_columns', [self::class, 'registerColumns']);
        add_action('manage_' . GalleryCommentRepository::POST_TYPE . '_posts_custom_column', [self::class, 'renderColumn'], 10, 2);
        add_filter('dashboard_glance_items', [self::class, 'dashboardGlance']);
        add_action('save_post_' . GalleryCommentRepository::POST_TYPE, [self::class, 'notifyPending'], 10, 3);
    }

    public static function registerPostType(): void
    {
        register_post_type(GalleryCommentRepository::POST_TYPE, [
            'labels' => [
                'name' => __('Gallery Feedback', 'cta'),
                'singular_name' => __('Gallery Comment', 'cta'),
                'add_new' => __('Add Feedback', 'cta'),
                'add_new_item' => __('Add Gallery Feedback', 'cta'),
                'edit_item' => __('Edit Gallery Feedback', 'cta'),
                'new_item' => __('New Gallery Feedback', 'cta'),
                'view_item' => __('View Gallery Feedback', 'cta'),
                'search_items' => __('Search Gallery Feedback', 'cta'),
                'not_found' => __('No gallery feedback found', 'cta'),
                'not_found_in_trash' => __('No gallery feedback found in Trash', 'cta'),
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-format-chat',
            'supports' => ['title', 'editor'],
            'capability_type' => 'post',
        ]);
    }

    public static function registerColumns(array $columns): array
    {
        $new = [];
        $new['cb'] = $columns['cb'] ?? null;
        $new['title'] = __('Author', 'cta');
        $new['cta_image'] = __('Image ID', 'cta');
        $new['cta_reaction'] = __('Reaction', 'cta');
        $new['cta_rating'] = __('Rating', 'cta');
        $new['date'] = $columns['date'] ?? __('Date', 'cta');

        return array_filter($new);
    }

    public static function renderColumn(string $column, int $postId): void
    {
        switch ($column) {
            case 'cta_image':
                echo esc_html(get_post_meta($postId, '_cta_image_id', true));
                break;
            case 'cta_reaction':
                echo esc_html(get_post_meta($postId, '_cta_reaction', true));
                break;
            case 'cta_rating':
                $rating = get_post_meta($postId, '_cta_rating', true);
                echo $rating !== '' ? esc_html($rating) : '&mdash;';
                break;
        }
    }

    public static function dashboardGlance(array $items): array
    {
        $count = wp_count_posts(GalleryCommentRepository::POST_TYPE);
        if (isset($count->pending) && $count->pending > 0) {
            $items[] = sprintf(
                '<a href="%s">%d %s</a>',
                esc_url(admin_url('edit.php?post_status=pending&post_type=' . GalleryCommentRepository::POST_TYPE)),
                $count->pending,
                _n('gallery feedback pending', 'gallery feedback pending', (int) $count->pending, 'cta')
            );
        }

        return $items;
    }

    public static function notifyPending(int $postId, \WP_Post $post, bool $update): void
    {
        if ($update) {
            return;
        }

        if ($post->post_status !== 'pending') {
            return;
        }

        $adminEmail = get_option('admin_email');
        if (!$adminEmail) {
            return;
        }

        $subject = __('New gallery comment awaiting moderation', 'cta');
        $message = sprintf(
            "%s\n\n%s",
            __('A new gallery comment has been submitted and is awaiting your approval.', 'cta'),
            admin_url('post.php?post=' . $postId . '&action=edit')
        );

        wp_mail($adminEmail, $subject, $message);
    }
}
