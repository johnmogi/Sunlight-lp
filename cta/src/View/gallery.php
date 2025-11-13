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
$isRtl = class_exists('LanguageSwitcher\\Support\\Context') && \LanguageSwitcher\Support\Context::isRtl();
$direction = $isRtl ? 'rtl' : 'ltr';
?>
<section class="cta-gallery<?php echo $isRtl ? ' is-rtl' : ''; ?>" id="cta-gallery" dir="<?php echo esc_attr($direction); ?>">
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
                                $isFeatured = !empty($item['featured']);
                                $alt = $title ?: $subtitle;
                                $feedback = $item['feedback'] ?? [];
                                $feedbackId = $feedback['id'] ?? ($tabId . '-' . $itemIndex);
                                $meta = $feedback['meta'] ?? [];
                                $metaAttr = !empty($meta) ? ' data-feedback-meta="' . esc_attr(wp_json_encode($meta)) . '"' : '';
                                ?>
                                <article class="cta-gallery-card<?php echo $isFeatured ? ' is-featured' : ''; ?>" data-feedback-id="<?php echo esc_attr($feedbackId); ?>"<?php echo $metaAttr; ?>>
                                    <div class="cta-gallery-card__media">
                                        <?php if (!empty($image)): ?>
                                            <button type="button" class="cta-gallery-card__image" <?php echo $triggerAttribute; ?> data-group="<?php echo esc_attr($lightboxId); ?>" data-index="<?php echo esc_attr($tabId . '-' . $itemIndex); ?>" data-image="<?php echo esc_url($image); ?>" data-title="<?php echo esc_attr($title); ?>" data-headline="<?php echo esc_attr($headline); ?>" data-caption="<?php echo esc_attr($description); ?>" data-alt="<?php echo esc_attr($alt); ?>">
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($alt); ?>">
                                                <span class="cta-gallery-card__image-overlay">
                                                    <span class="cta-gallery-card__image-icon" aria-hidden="true">🔍</span>
                                                    <span class="cta-gallery-card__image-label"><?php echo esc_html($feedback_strings['modal_title'] ?? 'Tell us what you think'); ?></span>
                                                </span>
                                            </button>
                                        <?php else: ?>
                                            <div class="cta-gallery-card__placeholder">
                                                <span class="cta-gallery-card__placeholder-icon"><?php echo esc_html($icon); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cta-gallery-card__body">
                                        <?php if (!empty($subtitle) || !empty($icon)): ?>
                                            <div class="cta-gallery-card__eyebrow">
                                                <?php if (!empty($icon)): ?>
                                                    <span class="cta-gallery-card__eyebrow-icon" aria-hidden="true"><?php echo esc_html($icon); ?></span>
                                                <?php endif; ?>
                                                <?php if (!empty($subtitle)): ?>
                                                    <span class="cta-gallery-card__eyebrow-text"><?php echo esc_html($subtitle); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($title)): ?>
                                            <h4 class="cta-gallery-card__title"><?php echo esc_html($title); ?></h4>
                                        <?php endif; ?>

                                        <?php if (!empty($headline)): ?>
                                            <p class="cta-gallery-card__headline"><?php echo esc_html($headline); ?></p>
                                        <?php endif; ?>

                                        <?php if (!empty($description)): ?>
                                            <p class="cta-gallery-card__description"><?php echo esc_html($description); ?></p>
                                        <?php endif; ?>

                                        <div class="cta-gallery-card__feedback-preview" data-feedback-preview role="status" aria-live="polite"></div>
                                    </div>
                                    <footer class="cta-gallery-card__footer">
                                        <button type="button" class="cta-gallery-card__feedback-button" data-feedback-open data-feedback-target="<?php echo esc_attr($feedbackId); ?>">
                                            <?php echo esc_html($feedback_strings['button_label'] ?? 'Share your thoughts'); ?>
                                        </button>
                                    </footer>
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

    <div class="cta-gallery__feedback-modal" data-feedback-modal aria-hidden="true" role="dialog" aria-modal="true">
        <div class="cta-gallery__feedback-backdrop" data-feedback-close></div>
        <div class="cta-gallery__feedback-dialog">
            <button type="button" class="cta-gallery__feedback-close" aria-label="<?php echo esc_attr__('Close feedback', 'cta'); ?>" data-feedback-close>&times;</button>
            <div class="cta-gallery__feedback-media" data-feedback-media>
                <img src="" alt="" data-feedback-image>
                <div class="cta-gallery__feedback-meta">
                    <h4 data-feedback-title></h4>
                    <p data-feedback-caption></p>
                </div>
            </div>
            <form class="cta-gallery__feedback-form" data-feedback-form novalidate>
                <input type="hidden" name="image_id" value="">
                <input type="hidden" name="rating" value="" data-feedback-rating-input>
                <input type="text" name="cta_feedback_url" value="" tabindex="-1" autocomplete="off" aria-hidden="true">

                <div class="cta-gallery__feedback-field">
                    <label for="cta-feedback-name"><?php echo esc_html($feedback_strings['name_label'] ?? 'Name (optional)'); ?></label>
                    <input type="text" id="cta-feedback-name" name="name" maxlength="150" data-feedback-name>
                </div>

                <div class="cta-gallery__feedback-field">
                    <label for="cta-feedback-email"><?php echo esc_html($feedback_strings['email_label'] ?? 'Email (optional)'); ?></label>
                    <input type="email" id="cta-feedback-email" name="email" maxlength="150" data-feedback-email>
                </div>

                <fieldset class="cta-gallery__feedback-reactions">
                    <legend><?php echo esc_html($feedback_strings['reaction_label'] ?? 'How does it make you feel?'); ?></legend>
                    <div class="cta-gallery__feedback-reaction-list" data-feedback-reactions>
                        <?php
                        $reactionValues = [
                            'love' => 10,
                            'like' => 7,
                            'dislike' => 3,
                        ];
                        foreach (($feedback_strings['reactions'] ?? []) as $reactionKey => $reactionData):
                            $ratingValue = $reactionValues[$reactionKey] ?? 5;
                            $label = $reactionData['label'] ?? ucfirst($reactionKey);
                            $icon = $reactionData['icon'] ?? '';
                            $inputId = 'cta-feedback-reaction-' . esc_attr($reactionKey);
                        ?>
                            <label class="cta-gallery__feedback-reaction" for="<?php echo esc_attr($inputId); ?>">
                                <input type="radio" name="reaction" id="<?php echo esc_attr($inputId); ?>" value="<?php echo esc_attr($reactionKey); ?>" data-rating="<?php echo esc_attr($ratingValue); ?>">
                                <span class="cta-gallery__feedback-reaction-icon"><?php echo esc_html($icon); ?></span>
                                <span class="cta-gallery__feedback-reaction-label"><?php echo esc_html($label); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <div class="cta-gallery__feedback-field">
                    <label for="cta-feedback-comment"><?php echo esc_html($feedback_strings['comment_label'] ?? 'Leave a comment (optional)'); ?></label>
                    <textarea id="cta-feedback-comment" name="comment" maxlength="1000" rows="4" data-feedback-comment></textarea>
                </div>

                <div class="cta-gallery__feedback-actions">
                    <span class="cta-gallery__feedback-response" data-feedback-response role="status" aria-live="polite"></span>
                    <button type="submit" class="cta-gallery__feedback-submit" data-feedback-submit>
                        <?php echo esc_html($feedback_strings['submit_label'] ?? 'Send feedback'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
