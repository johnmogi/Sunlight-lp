<?php
/** @var array $intro */
/** @var array $cards */
/** @var array $quote */
?>
<section class="cta-about" id="cta-about" dir="ltr">
    <div class="cta-container">
        <div class="cta-about__intro">
            <span class="cta-section-label"><?php echo esc_html($intro['label']); ?></span>
            <h2 class="cta-section-title"><?php echo esc_html($intro['title']); ?></h2>
            <p class="cta-section-lead"><?php echo esc_html($intro['lead']); ?></p>
        </div>

        <div class="cta-about__grid">
            <?php foreach ($cards as $card): ?>
                <div class="cta-about__card">
                    <div class="cta-about__icon"><?php echo esc_html($card['icon']); ?></div>
                    <h3><?php echo esc_html($card['title']); ?></h3>
                    <p><?php echo wp_kses_post($card['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <?php $universe = \CTA\Config\AboutConfig::getUniverse(); ?>
        <div class="cta-about__universe">
            <h3 class="cta-about__universe-label"><?php echo esc_html($universe['label']); ?></h3>
            <p class="cta-about__universe-description"><?php echo esc_html($universe['description']); ?></p>
        </div>

        <div class="cta-about__quote">
            <blockquote>
                <?php echo esc_html($quote['text']); ?>
            </blockquote>
        </div>
    </div>
</section>
