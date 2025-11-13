<?php
namespace CTA\Repository;

use wpdb;

class GalleryFeedbackRepository
{
    private const OPTION_KEY = 'cta_gallery_feedback_schema_version';
    private const SCHEMA_VERSION = 1;

    public static function tableName(): string
    {
        global $wpdb;
        return $wpdb->prefix . 'cta_gallery_feedback';
    }

    public static function ensureTable(): void
    {
        $storedVersion = (int) get_option(self::OPTION_KEY, 0);
        if ($storedVersion >= self::SCHEMA_VERSION) {
            return;
        }

        global $wpdb;
        $table = self::tableName();
        $charsetCollate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$table} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            image_id VARCHAR(191) NOT NULL,
            rating TINYINT UNSIGNED NOT NULL,
            reaction VARCHAR(12) NOT NULL,
            comment TEXT NULL,
            name VARCHAR(150) NULL,
            email VARCHAR(150) NULL,
            ip_hash CHAR(64) NULL,
            created_at DATETIME NOT NULL,
            PRIMARY KEY  (id),
            KEY image_reaction (image_id, reaction),
            KEY image_created (image_id, created_at)
        ) {$charsetCollate};";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        update_option(self::OPTION_KEY, self::SCHEMA_VERSION);
    }

    public static function insert(array $data): bool
    {
        global $wpdb;

        $defaults = [
            'image_id' => '',
            'rating' => null,
            'reaction' => '',
            'comment' => null,
            'name' => null,
            'email' => null,
            'ip_hash' => null,
            'created_at' => current_time('mysql'),
        ];

        $payload = wp_parse_args($data, $defaults);

        return (bool) $wpdb->insert(
            self::tableName(),
            [
                'image_id' => $payload['image_id'],
                'rating' => $payload['rating'],
                'reaction' => $payload['reaction'],
                'comment' => $payload['comment'],
                'name' => $payload['name'],
                'email' => $payload['email'],
                'ip_hash' => $payload['ip_hash'],
                'created_at' => $payload['created_at'],
            ],
            [
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ]
        );
    }

    public static function recentComments(string $imageId, int $limit = 3): array
    {
        global $wpdb;
        $limit = max(1, min($limit, 10));

        $sql = $wpdb->prepare(
            "SELECT name, comment, reaction, rating, created_at FROM " . self::tableName() . " WHERE image_id = %s AND comment <> '' ORDER BY created_at DESC LIMIT %d",
            $imageId,
            $limit
        );

        return $wpdb->get_results($sql, ARRAY_A) ?: [];
    }

    public static function aggregates(string $imageId): array
    {
        global $wpdb;

        $table = self::tableName();
        $sql = $wpdb->prepare(
            "SELECT 
                COUNT(*) as total,
                AVG(rating) as avg_rating,
                SUM(CASE WHEN reaction = 'like' THEN 1 ELSE 0 END) as likes,
                SUM(CASE WHEN reaction = 'love' THEN 1 ELSE 0 END) as loves,
                SUM(CASE WHEN reaction = 'dislike' THEN 1 ELSE 0 END) as dislikes
            FROM {$table}
            WHERE image_id = %s",
            $imageId
        );

        $row = $wpdb->get_row($sql, ARRAY_A) ?: [];

        return [
            'total' => (int) ($row['total'] ?? 0),
            'avg_rating' => $row['avg_rating'] ? round((float) $row['avg_rating'], 1) : null,
            'likes' => (int) ($row['likes'] ?? 0),
            'loves' => (int) ($row['loves'] ?? 0),
            'dislikes' => (int) ($row['dislikes'] ?? 0),
        ];
    }

    public static function recentlySubmitted(string $imageId, string $ipHash, int $seconds = 300): bool
    {
        global $wpdb;

        $sql = $wpdb->prepare(
            "SELECT COUNT(*) FROM " . self::tableName() . " WHERE image_id = %s AND ip_hash = %s AND created_at >= (NOW() - INTERVAL %d SECOND)",
            $imageId,
            $ipHash,
            $seconds
        );

        return (int) $wpdb->get_var($sql) > 0;
    }
}
