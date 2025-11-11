<?php
/**
 * CTA Slider Template
 * @var \CTA\Model\Slide[] $slides
 */
?>
<div class="cta-slider">
    <div class="cta-slides">
        <?php foreach ($slides as $index => $slide): ?>
            <div class="cta-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $slide->getId(); ?>">
                <h2><?php echo esc_html($slide->getTitle()); ?></h2>
                <p><?php echo esc_html($slide->getDescription()); ?></p>
                
                <!-- Form (hidden by default) -->
                <div class="cta-form" id="form-<?php echo $slide->getId(); ?>">
                    <form class="cta-submit-form">
                        <div class="form-row">
                            <input type="text" name="name" placeholder="Your Name" required>
                            <input type="email" name="email" placeholder="Your Email" required>
                            <button type="submit">Submit</button>
                        </div>
                        <!-- Honeypot field (hidden from users, catches bots) -->
                        <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">
                    </form>
                    <div class="cta-message"></div>
                </div>

                <!-- CTA Button -->
                <button class="cta-toggle" data-form="form-<?php echo $slide->getId(); ?>">
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
