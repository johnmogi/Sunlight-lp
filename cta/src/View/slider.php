<?php
/**
 * CTA Slider Template
 *
 * @var \CTA\Model\Slide[] $slides
 */
$isRtl = class_exists('LanguageSwitcher\\Support\\Context') && \LanguageSwitcher\Support\Context::isRtl();
$direction = $isRtl ? 'rtl' : 'ltr';
?>
<section class="cta-slider<?php echo $isRtl ? ' is-rtl' : ''; ?>" dir="<?php echo esc_attr($direction); ?>">
    <div class="cta-slider__container">
        <div class="cta-slider__track">
            <?php foreach ($slides as $index => $slide):
                $isActive = $index === 0;
                $form = $slide->getForm();
            ?>
                <article class="cta-slider__slide <?php echo $isActive ? 'is-active' : ''; ?>" data-slide="<?php echo $slide->getId(); ?>" data-index="<?php echo $index; ?>">
                    <div class="cta-slider__content">
                        <h2 class="cta-slider__title"><?php echo esc_html($slide->getTitle()); ?></h2>
                        <p class="cta-slider__description"><?php echo esc_html($slide->getDescription()); ?></p>
                        
                        <!-- Form (hidden by default) -->
                        <div class="cta-slider__form-wrapper <?php echo $isActive ? 'is-visible' : ''; ?>" id="form-<?php echo $slide->getId(); ?>">
                            <form class="cta-slider__form" data-slide-id="<?php echo $slide->getId(); ?>">
                                <div class="cta-slider__form-group">
                                    <input 
                                        type="text" 
                                        name="name" 
                                        placeholder="<?php echo esc_attr($form['name_placeholder'] ?? 'Your Name'); ?>" 
                                        required
                                        aria-label="<?php esc_attr_e('Name', 'cta'); ?>"
                                    >
                                    <input 
                                        type="email" 
                                        name="email" 
                                        placeholder="<?php echo esc_attr($form['email_placeholder'] ?? 'Your Email'); ?>" 
                                        required
                                        aria-label="<?php esc_attr_e('Email', 'cta'); ?>"
                                    >
                                    <button type="submit" class="cta-slider__form-submit">
                                        <span class="cta-slider__form-submit-text"><?php echo esc_html($form['submit_label'] ?? 'Submit'); ?></span>
                                        <span class="cta-slider__form-submit-icon">→</span>
                                    </button>
                                </div>
                                <!-- Honeypot field (hidden from users, catches bots) -->
                                <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off" aria-hidden="true">
                            </form>
                            <div class="cta-slider__message" role="alert" aria-live="polite"></div>
                        </div>

                        <!-- CTA Button -->
                        <button class="cta-slider__cta <?php echo $isActive ? 'is-active' : ''; ?>" data-form="form-<?php echo $slide->getId(); ?>">
                            <span class="cta-slider__cta-text"><?php echo esc_html($slide->getButtonText()); ?></span>
                            <span class="cta-slider__cta-icon">✨</span>
                        </button>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- Navigation -->
        <div class="cta-slider__nav">
            <button class="cta-slider__nav-btn cta-slider__nav-btn--prev" aria-label="<?php esc_attr_e('Previous slide', 'cta'); ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <div class="cta-slider__dots" role="tablist">
                <?php foreach ($slides as $index => $slide): ?>
                    <button 
                        class="cta-slider__dot <?php echo $index === 0 ? 'is-active' : ''; ?>" 
                        data-index="<?php echo $index; ?>"
                        role="tab"
                        aria-label="<?php echo esc_attr(sprintf(__('Go to slide %d', 'cta'), $index + 1)); ?>"
                        aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    ></button>
                <?php endforeach; ?>
            </div>
            <button class="cta-slider__nav-btn cta-slider__nav-btn--next" aria-label="<?php esc_attr_e('Next slide', 'cta'); ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    </div>
</section>
