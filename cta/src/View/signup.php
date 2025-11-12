<?php
/**
 * Signup shortcode template
 * @var array $content
 */

$label = $content['label'] ?? '';
$title = $content['title'] ?? '';
$lead = $content['lead'] ?? '';
$bullet_points = $content['bullet_points'] ?? [];
$privacy = $content['privacy'] ?? '';
?>
<section class="cta-signup" id="cta-signup" dir="ltr">
    <div class="cta-container">
        <div class="cta-signup__content">
            <?php if (!empty($label)): ?>
                <span class="cta-section-label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>
            <?php if (!empty($title)): ?>
                <h2 class="cta-section-title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php if (!empty($lead)): ?>
                <p class="cta-section-lead"><?php echo esc_html($lead); ?></p>
            <?php endif; ?>

            <?php if (!empty($bullet_points)): ?>
                <ul class="cta-signup__list">
                    <?php foreach ($bullet_points as $item): ?>
                        <li><?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="cta-signup__form">
            <form class="cta-signup-form">
                <div class="cta-signup__field">
                    <label for="cta-signup-name"><?php esc_html_e('Name', 'cta'); ?></label>
                    <input type="text" id="cta-signup-name" name="name" required placeholder="<?php esc_attr_e('Your name', 'cta'); ?>">
                </div>

                <div class="cta-signup__field">
                    <label for="cta-signup-email"><?php esc_html_e('Email', 'cta'); ?></label>
                    <input type="email" id="cta-signup-email" name="email" required placeholder="<?php esc_attr_e('your@email.com', 'cta'); ?>">
                </div>

                <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">

                <button type="submit" class="cta-signup__submit" data-loading-text="<?php esc_attr_e('Sending…', 'cta'); ?>">
                    <span class="cta-signup__submit-icon">✨</span>
                    <?php esc_html_e('Join the Sunlight Project', 'cta'); ?>
                </button>

                <div class="cta-signup__message" data-signup-message style="display:none;"></div>
            </form>

            <?php if (!empty($privacy)): ?>
                <p class="cta-signup__privacy"><?php echo esc_html($privacy); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
