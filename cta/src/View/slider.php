<?php
/**
 * CTA Slider Template
 *
 * @var \CTA\Model\Slide[] $slides
 */
$isRtl = class_exists('LanguageSwitcher\\Support\\Context') && \LanguageSwitcher\Support\Context::isRtl();
$direction = $isRtl ? 'rtl' : 'ltr';
?>
<div class="cta-slider<?php echo $isRtl ? ' is-rtl' : ''; ?>" dir="<?php echo esc_attr($direction); ?>">
    <div class="cta-slides">
        <?php foreach ($slides as $index => $slide):
            $isActive = $index === 0;
            $form = $slide->getForm();
        ?>
            <div class="cta-slide <?php echo $isActive ? 'active' : ''; ?>" data-slide="<?php echo $slide->getId(); ?>">
                <h2><?php echo esc_html($slide->getTitle()); ?></h2>
                <p><?php echo esc_html($slide->getDescription()); ?></p>
                
                <!-- Form (hidden by default) -->
                <div class="cta-form <?php echo $isActive ? 'show' : ''; ?>" id="form-<?php echo $slide->getId(); ?>">
                    <form class="cta-submit-form">
                        <div class="form-row">
                            <input type="text" name="name" placeholder="<?php echo esc_attr($form['name_placeholder'] ?? 'Your Name'); ?>" required>
                            <input type="email" name="email" placeholder="<?php echo esc_attr($form['email_placeholder'] ?? 'Your Email'); ?>" required>
                            <button type="submit"><?php echo esc_html($form['submit_label'] ?? 'Submit'); ?></button>
                        </div>
                        <!-- Honeypot field (hidden from users, catches bots) -->
                        <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">
                    </form>
                    <div class="cta-message"></div>
                </div>

                <!-- CTA Button -->
                <button class="cta-toggle <?php echo $isActive ? 'active' : ''; ?>" data-form="form-<?php echo $slide->getId(); ?>">
                    <?php echo esc_html($slide->getButtonText()); ?>
                </button>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Navigation -->
    <div class="cta-nav">
        <button class="cta-prev">←</button>
        <button class="cta-next">→</button>
    </div>
</div>
