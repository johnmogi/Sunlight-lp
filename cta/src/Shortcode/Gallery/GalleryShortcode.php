<?php
namespace CTA\Shortcode\Gallery;

use CTA\Config\GalleryConfig;
use CTA\Repository\GalleryFeedbackRepository;
use CTA\Support\SectionAssets;

class GalleryShortcode
{
    public function __construct()
    {
        add_shortcode('cta_gallery', [$this, 'render']);
    }

    public function render(): string
    {
        SectionAssets::enqueue();

        $language = class_exists('LanguageSwitcher\\Support\\Context')
            ? \LanguageSwitcher\Support\Context::currentCode()
            : null;

        $intro = GalleryConfig::getIntro($language);
        $tabs = GalleryConfig::getTabs($language);
        [$tabs, $feedbackDataset] = $this->attachFeedbackData($tabs);
        $feedbackStrings = GalleryConfig::getFeedbackStrings($language);

        $feedback_strings = $feedbackStrings;
        $feedback_dataset = $feedbackDataset;

        SectionAssets::injectFeedbackData([
            'strings' => $feedbackStrings,
            'items' => $feedbackDataset,
        ]);

        ob_start();
        include CTA_PLUGIN_DIR . '/src/View/gallery.php';
        return ob_get_clean();
    }

    /**
     * @param array $tabs
     * @return array<array, array>
     */
    private function attachFeedbackData(array $tabs): array
    {
        $feedbackDataset = [];

        foreach ($tabs as $tabIndex => $tab) {
            $tabId = $tab['id'] ?? ('tab-' . $tabIndex);

            if (empty($tab['items']) || !is_array($tab['items'])) {
                continue;
            }

            foreach ($tab['items'] as $itemIndex => $item) {
                $imageId = $this->resolveImageId($tabId, $item, $itemIndex);
                $aggregates = GalleryFeedbackRepository::aggregates($imageId);
                $comments = GalleryFeedbackRepository::recentComments($imageId);
                $meta = [
                    'tab' => $tabId,
                    'index' => $itemIndex,
                    'title' => $item['title'] ?? '',
                    'subtitle' => $item['subtitle'] ?? '',
                    'headline' => $item['headline'] ?? '',
                    'description' => $item['description'] ?? '',
                    'image' => $item['image'] ?? '',
                    'icon' => $item['icon'] ?? '',
                ];

                $tabs[$tabIndex]['items'][$itemIndex]['feedback'] = [
                    'id' => $imageId,
                    'aggregates' => $aggregates,
                    'comments' => $comments,
                    'meta' => $meta,
                ];

                $feedbackDataset[$imageId] = [
                    'aggregates' => $aggregates,
                    'comments' => $comments,
                    'meta' => $meta,
                ];
            }
        }

        return [$tabs, $feedbackDataset];
    }

    private function resolveImageId(string $tabId, array $item, int $index): string
    {
        if (!empty($item['id'])) {
            return sanitize_key($item['id']);
        }

        if (!empty($item['image'])) {
            return 'img_' . substr(md5((string) $item['image']), 0, 16);
        }

        $title = $item['title'] ?? '';

        if (!empty($title)) {
            return sanitize_title($tabId . '-' . $title);
        }

        return sanitize_key($tabId . '-' . $index);
    }
}
