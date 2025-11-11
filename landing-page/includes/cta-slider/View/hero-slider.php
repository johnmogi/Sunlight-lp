<?php
/**
 * Hero Slider Template
 * 
 * @var \LandingPage\CTASlider\Model\HeroSlide[] $slides
 */
?>
<div class="sunlight-full-width">
    <section class="sunlight-hero-slider" id="hero-slider">
        <div class="hero-overlay"></div>

        <!-- Carousel Container -->
        <div class="hero-carousel">
            <!-- Navigation Arrows -->
            <button class="carousel-nav carousel-prev" id="slider-prev" aria-label="Previous slide">
                <span class="nav-icon nav-icon-prev"></span>
            </button>
            <button class="carousel-nav carousel-next" id="slider-next" aria-label="Next slide">
                <span class="nav-icon nav-icon-next"></span>
            </button>

            <!-- Carousel Slides -->
            <div class="carousel-track">
                <?php foreach ($slides as $index => $slide): ?>
                    <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?> <?php echo esc_attr($slide->getSlideClass()); ?>" 
                         data-slide="<?php echo esc_attr($slide->getId()); ?>"
                         style="background: <?php echo esc_attr($slide->getBackgroundGradient()); ?>, url('<?php echo esc_url($slide->getBackgroundImage()); ?>');">
                        <div class="hero-content">
                            <div class="hero-brand">
                                <span class="hero-pre-title"><?php echo wp_kses_post($slide->getPreTitle()); ?></span>
                                <h1 class="hero-title"><?php echo esc_html($slide->getTitle()); ?></h1>
                                <h2 class="hero-subtitle-main"><?php echo esc_html($slide->getSubtitle()); ?></h2>
                            </div>

                            <div class="hero-description-block">
                                <p class="hero-description"><?php echo wp_kses_post($slide->getDescription()); ?></p>
                                <p class="hero-subtext"><?php echo esc_html($slide->getSubtext()); ?></p>
                            </div>

                            <!-- Signup Form -->
                            <div class="hero-quick-signup" id="<?php echo esc_attr($slide->getFormId()); ?>">
                                <div class="signup-header">
                                    <h3><?php echo esc_html($slide->getFormTitle()); ?></h3>
                                    <p><?php echo esc_html($slide->getFormDescription()); ?></p>
                                </div>
                                <form class="quick-signup-form hero-signup-form">
                                    <?php wp_nonce_field('sunlight_signup_nonce', $slide->getNonceName()); ?>
                                    <input type="hidden" name="project" value="<?php echo esc_attr($slide->getProjectSlug()); ?>">
                                    <div class="form-row">
                                        <input type="text" name="name" placeholder="Your Name" required>
                                        <input type="email" name="email" placeholder="Your Email" required>
                                        <button type="submit" class="quick-join-btn">
                                            <span>Join <?php echo esc_html($slide->getCtaIcon()); ?></span>
                                        </button>
                                    </div>
                                    <div class="form-footer">
                                        <label class="consent-label">
                                            <input type="checkbox" name="consent" required>
                                            <span>I agree to receive updates about <?php echo esc_html($slide->getProjectName()); ?>.</span>
                                        </label>
                                    </div>
                                </form>
                            </div>

                            <!-- CTA Button -->
                            <div class="hero-cta-container">
                                <button class="hero-cta-toggle" data-form="<?php echo esc_attr($slide->getFormId()); ?>">
                                    <span class="cta-icon"><?php echo esc_html($slide->getCtaIcon()); ?></span>
                                    <span class="cta-text"><?php echo esc_html($slide->getCtaText()); ?></span>
                                    <span class="cta-arrow">▼</span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>
