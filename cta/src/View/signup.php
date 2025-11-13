<?php
/**
 * Signup shortcode template
 * @var array $content
 */

$label = $content['label'] ?? '';
$title = $content['title'] ?? '';
$lead = $content['lead'] ?? '';
$button = $content['button'] ?? 'Subscribe';
$privacy = $content['privacy'] ?? '';
$isRtl = class_exists('LanguageSwitcher\\Support\\Context') && \LanguageSwitcher\Support\Context::isRtl();
$direction = $isRtl ? 'rtl' : 'ltr';
?>
<section class="cta-signup<?php echo $isRtl ? ' is-rtl' : ''; ?>" id="cta-signup" dir="<?php echo esc_attr($direction); ?>">
    <div class="cta-container">
        <div class="cta-signup__hero">
            <?php if (!empty($label)): ?>
                <span class="cta-signup__label"><?php echo $label; ?></span>
            <?php endif; ?>
            
            <?php if (!empty($title)): ?>
                <h2 class="cta-signup__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            
            <?php if (!empty($lead)): ?>
                <p class="cta-signup__lead"><?php echo esc_html($lead); ?></p>
            <?php endif; ?>

            <form class="cta-signup-form">
                <div class="cta-signup__input-group">
                    <input 
                        type="email" 
                        id="cta-signup-email" 
                        name="email" 
                        required 
                        placeholder="<?php esc_attr_e('your@email.com', 'cta'); ?>"
                        aria-label="<?php esc_attr_e('Email address', 'cta'); ?>"
                    >
                    <button type="submit" class="cta-signup__submit" data-loading-text="<?php esc_attr_e('Sending…', 'cta'); ?>">
                        <?php echo esc_html($button); ?>
                    </button>
                </div>

                <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">

                <div class="cta-signup__message" data-signup-message style="display:none;"></div>
            </form>

            <?php if (!empty($privacy)): ?>
                <p class="cta-signup__privacy"><?php echo esc_html($privacy); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
