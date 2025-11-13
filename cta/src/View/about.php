<?php
/** @var array $intro */
/** @var array $cards */
/** @var array $universe */
/** @var array $quote */
$isRtl = class_exists('LanguageSwitcher\\Support\\Context') && \LanguageSwitcher\Support\Context::isRtl();
$direction = $isRtl ? 'rtl' : 'ltr';
?>
<section class="cta-about<?php echo $isRtl ? ' is-rtl' : ''; ?>" id="cta-about" dir="<?php echo esc_attr($direction); ?>">
    <div class="cta-container">
        <header class="cta-about__header">
            <span class="cta-about__label"><?php echo esc_html($intro['label']); ?></span>
            <h2 class="cta-about__title"><?php echo esc_html($intro['title']); ?></h2>
            <p class="cta-about__lead"><?php echo esc_html($intro['lead']); ?></p>
        </header>

        <div class="cta-about__grid">
            <?php foreach ($cards as $index => $card): ?>
                <article class="cta-about__card" data-index="<?php echo esc_attr($index); ?>">
                    <div class="cta-about__card-icon"><?php echo $card['icon']; ?></div>
                    <h3 class="cta-about__card-title"><?php echo esc_html($card['title']); ?></h3>
                    <p class="cta-about__card-description"><?php echo wp_kses_post($card['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="cta-about__universe">
            <div class="cta-about__universe-content">
                <h3 class="cta-about__universe-title"><?php echo esc_html($universe['label']); ?></h3>
                <p class="cta-about__universe-text"><?php echo esc_html($universe['description']); ?></p>
            </div>
        </div>

        <div class="cta-about__quote">
            <blockquote class="cta-about__blockquote">
                <span class="cta-about__quote-mark">"</span>
                <p><?php echo esc_html($quote['text']); ?></p>
            </blockquote>
        </div>
    </div>
</section>
