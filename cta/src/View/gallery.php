<?php
/**
 * Gallery shortcode template
 *
 * @var array $intro
 * @var array $tabs
 */

$firstTabId = $tabs[0]['id'] ?? null;
$lightboxId = function_exists('wp_generate_uuid4') ? 'cta-gallery-lightbox-' . wp_generate_uuid4() : 'cta-gallery-lightbox-' . uniqid();
$triggerAttribute = 'data-trigger="gallery"';
?>
<section class="cta-gallery" id="cta-gallery" dir="ltr">
    <div class="cta-container">
        <?php if (!empty($intro)): ?>
            <div class="cta-gallery__intro">
                <?php if (!empty($intro['label'])): ?>
                    <span class="cta-section-label"><?php echo esc_html($intro['label']); ?></span>
                <?php endif; ?>
                <?php if (!empty($intro['title'])): ?>
                    <h2 class="cta-section-title"><?php echo esc_html($intro['title']); ?></h2>
                <?php endif; ?>
                <?php if (!empty($intro['lead'])): ?>
                    <p class="cta-section-lead"><?php echo esc_html($intro['lead']); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($tabs)): ?>
            <div class="cta-gallery__tabs">
                <?php foreach ($tabs as $index => $tab):
                    $tabId = sanitize_title($tab['id']);
                    $isActive = ($tabId === $firstTabId || ($index === 0 && $firstTabId === null));
                    ?>
                    <button type="button" class="<?php echo $isActive ? 'is-active' : ''; ?>" data-target="cta-gallery-pane-<?php echo esc_attr($tabId); ?>">
                        <span class="cta-gallery__icon"><?php echo esc_html($tab['icon'] ?? ''); ?></span>
                        <span class="cta-gallery__label"><?php echo esc_html($tab['label'] ?? ''); ?></span>
                        <?php if (isset($tab['count'])): ?>
                            <span class="cta-gallery__count"><?php echo esc_html($tab['count']); ?></span>
                        <?php endif; ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <?php foreach ($tabs as $index => $tab):
                $tabId = sanitize_title($tab['id']);
                $paneId = 'cta-gallery-pane-' . $tabId;
                $isActive = ($tabId === $firstTabId || ($index === 0 && $firstTabId === null));
                $items = $tab['items'] ?? [];
                ?>
                <div class="cta-gallery__pane <?php echo $isActive ? 'is-active' : ''; ?>" id="<?php echo esc_attr($paneId); ?>">
                    <div class="cta-gallery__header">
                        <?php if (!empty($tab['title'])): ?>
                            <h3><?php echo esc_html($tab['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($tab['description'])): ?>
                            <p><?php echo esc_html($tab['description']); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($items)): ?>
                        <div class="cta-gallery__grid">
                            <?php foreach ($items as $itemIndex => $item):
                                $icon = $item['icon'] ?? '';
                                $title = $item['title'] ?? '';
                                $subtitle = $item['subtitle'] ?? '';
                                $image = $item['image'] ?? '';
                                $headline = $item['headline'] ?? '';
                                $description = $item['description'] ?? '';
                                $meta = $item['meta'] ?? [];
                                $isFeatured = !empty($item['featured']);
                                $caption = $headline ?: $description;
                                $alt = $title ?: $subtitle;
                                ?>
                                <article class="cta-gallery__item <?php echo $isFeatured ? 'cta-gallery__item--featured' : ''; ?>">
                                    <div class="cta-gallery__image">
                                        <?php if (!empty($image)): ?>
                                            <button type="button" class="cta-gallery__trigger" <?php echo $triggerAttribute; ?> data-group="<?php echo esc_attr($lightboxId); ?>" data-index="<?php echo esc_attr($tabId . '-' . $itemIndex); ?>" data-image="<?php echo esc_url($image); ?>" data-title="<?php echo esc_attr($title); ?>" data-headline="<?php echo esc_attr($headline); ?>" data-caption="<?php echo esc_attr($description); ?>" data-alt="<?php echo esc_attr($alt); ?>">
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($alt); ?>">
                                            </button>
                                        <?php else: ?>
                                            <div class="cta-gallery__placeholder">
                                                <span class="cta-gallery__icon"><?php echo esc_html($icon); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cta-gallery__body">
                                        <?php if ($isFeatured && !empty($meta)): ?>
                                            <div class="cta-gallery__meta">
                                                <span><?php echo esc_html($meta[0] ?? ''); ?></span>
                                                <span><?php echo esc_html($meta[1] ?? ''); ?></span>
                                            </div>
                                        <?php elseif (!empty($icon) || !empty($subtitle)): ?>
                                            <div class="cta-gallery__meta">
                                                <span class="cta-gallery__icon">&nbsp;<?php echo esc_html($icon); ?></span>
                                                <span><?php echo esc_html($subtitle); ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($title)): ?>
                                            <h4 class="cta-gallery__title"><?php echo esc_html($title); ?></h4>
                                        <?php endif; ?>

                                        <?php if (!empty($headline)): ?>
                                            <p class="cta-gallery__headline"><?php echo esc_html($headline); ?></p>
                                        <?php endif; ?>

                                        <?php if (!empty($description)): ?>
                                            <p class="cta-gallery__subtitle"><?php echo esc_html($description); ?></p>
                                        <?php elseif (!empty($subtitle) && empty($headline)): ?>
                                            <p class="cta-gallery__subtitle"><?php echo esc_html($subtitle); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="cta-gallery__lightbox" id="<?php echo esc_attr($lightboxId); ?>" data-group="<?php echo esc_attr($lightboxId); ?>" aria-hidden="true">
        <div class="cta-gallery__lightbox-backdrop" data-lightbox-close></div>
        <div class="cta-gallery__lightbox-content" role="dialog" aria-modal="true" aria-live="polite">
            <button type="button" class="cta-gallery__lightbox-close" aria-label="<?php echo esc_attr__('Close gallery', 'cta'); ?>" data-lightbox-close>&times;</button>
            <button type="button" class="cta-gallery__lightbox-prev" aria-label="<?php echo esc_attr__('Previous image', 'cta'); ?>" data-lightbox-prev>&lsaquo;</button>
            <button type="button" class="cta-gallery__lightbox-next" aria-label="<?php echo esc_attr__('Next image', 'cta'); ?>" data-lightbox-next>&rsaquo;</button>
            <figure class="cta-gallery__lightbox-figure">
                <img class="cta-gallery__lightbox-image" src="" alt="">
                <figcaption class="cta-gallery__lightbox-caption">
                    <h4 class="cta-gallery__lightbox-title"></h4>
                    <p class="cta-gallery__lightbox-text"></p>
                </figcaption>
            </figure>
        </div>
    </div>
</section>
