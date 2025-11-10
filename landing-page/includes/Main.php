<?php
namespace LandingPage;

class Main {
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts'], 999);

        // Register all shortcodes
        add_shortcode('sunlight_hero', [$this, 'hero_shortcode_v2']);
        add_shortcode('sunlight_hero_slider', [$this, 'hero_slider_shortcode']);
        add_shortcode('sunlight_about', [$this, 'about_shortcode']);
        add_shortcode('sunlight_gallery', [$this, 'gallery_shortcode']);
        add_shortcode('sunlight_video', [$this, 'video_shortcode']);
        add_shortcode('sunlight_signup', [$this, 'signup_shortcode']);
        add_shortcode('sunlight_vision', [$this, 'vision_shortcode']);
        add_shortcode('sunlight_full_page', [$this, 'full_page_shortcode']);

        // Handle form submissions
        add_action('wp_ajax_sunlight_signup', [$this, 'handle_signup']);
        add_action('wp_ajax_nopriv_sunlight_signup', [$this, 'handle_signup']);

        // Custom template
        add_filter('template_include', [$this, 'custom_template']);
        
        // Add inline styles and scripts directly
        add_action('wp_head', [$this, 'output_styles'], 999);
        add_action('wp_footer', [$this, 'output_scripts'], 999);
    }

    public function blank_header() {
        if ($this->is_landing_page()) {
            // Remove all header actions and output nothing
            remove_all_actions('wp_head');
            do_action('wp_head');

            // Remove all header content
            remove_all_actions('get_header');
            remove_all_actions('wp_body_open');

            // Output our clean HTML
            echo '<!DOCTYPE html><html><head>';
            wp_head();
            echo '</head><body class="sunlight-landing-page">';
        }
    }

    public function blank_footer() {
        if ($this->is_landing_page()) {
            // Footer is already included in vision_shortcode, just close HTML
            echo '</body></html>';

            // Remove all footer actions
            remove_all_actions('wp_footer');
            remove_all_actions('get_footer');
        }
    }

    public function enqueue_scripts() {
        wp_enqueue_script('jquery');
    }
    
    public function output_styles() {
        echo '<style id="sunlight-landing-styles">';
        echo $this->get_inline_styles();
        echo '</style>';
    }
    
    public function output_scripts() {
        ?>
        <script id="sunlight-landing-scripts">
        <?php echo $this->get_inline_scripts(); ?>
        </script>
        <?php
    }

    private function is_landing_page() {
        return is_page('sunlight-project') || is_front_page();
    }

    public function hero_shortcode_v2($atts) {
        $atts = shortcode_atts(array(
            'bg_image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'
        ), $atts);
        
        $bg_style = !empty($atts['bg_image']) ? 'background-image: url(' . esc_url($atts['bg_image']) . ');' : '';
        
        ob_start();
        ?>
        <section class="sunlight-hero-v2" id="hero">
            <div class="hero-overlay"></div>
            
            <!-- Carousel Container -->
            <div class="hero-carousel">
                <!-- Navigation Arrows -->
                <button class="carousel-nav carousel-prev" id="carousel-prev">‹</button>
                <button class="carousel-nav carousel-next" id="carousel-next">›</button>
                
                <!-- Carousel Slides -->
                <div class="carousel-track">
                    <!-- Slide 1: Sunlight Tarot -->
                    <div class="carousel-slide active slide-0" data-slide="0">
                        <div class="hero-content">
                            <div class="hero-brand">
                                <span class="hero-pre-title">✨ The Evolution of Tarot</span>
                                <h1 class="hero-title">Sunlight Tarot</h1>
                                <h2 class="hero-subtitle-main">A New Light on the Tarot Tradition</h2>
                            </div>
                            
                            <div class="hero-description-block">
                                <p class="hero-description">Not a tool for fortune-telling.<br>
                                A living map of consciousness — science, soul, and art entwined.</p>
                                <p class="hero-subtext">Reimagining the Tarot as a bridge between mysticism and modern understanding.</p>
                            </div>
                            
                            <div class="hero-cta-container">
                                <button class="hero-cta-toggle" data-form="form-tarot">
                                    <span class="cta-icon">✨</span>
                                    <span class="cta-text">I Want to Participate</span>
                                    <span class="cta-arrow">▼</span>
                                </button>
                                
                                <div class="hero-quick-signup" id="form-tarot">
                                    <div class="signup-header">
                                        <h3>Join the Sunlight Tarot Project</h3>
                                        <p>Early access to artwork, deck updates, and community</p>
                                    </div>
                                    <form class="quick-signup-form hero-signup-form">
                                        <?php wp_nonce_field('sunlight_signup_nonce', 'tarot_signup_nonce'); ?>
                                        <input type="hidden" name="project" value="sunlight-tarot">
                                        <div class="form-row">
                                            <input type="text" name="name" placeholder="Your Name" required>
                                            <input type="email" name="email" placeholder="Your Email" required>
                                            <button type="submit" class="quick-join-btn">
                                                <span>Join ✨</span>
                                            </button>
                                        </div>
                                        <div class="form-footer">
                                            <label class="consent-label">
                                                <input type="checkbox" name="consent" required>
                                                <span>I agree to receive updates about Sunlight Tarot.</span>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 2: Maze Chronicles Novels -->
                    <div class="carousel-slide slide-1" data-slide="1">
                        <div class="hero-content">
                            <div class="hero-brand">
                                <span class="hero-pre-title">📚 The Literary Journey</span>
                                <h1 class="hero-title">Maze Chronicles</h1>
                                <h2 class="hero-subtitle-main">Four Novels, One Consciousness</h2>
                            </div>
                            
                            <div class="hero-description-block">
                                <p class="hero-description">Beginning with <em>The Boring Field Guide to Fantastic Multidimensional Portals</em>.<br>
                                A mind-bending journey through consciousness, reality, and transformation.</p>
                                <p class="hero-subtext">Where every choice shapes reality and every page opens new dimensions.</p>
                            </div>
                            
                            <div class="hero-cta-container">
                                <button class="hero-cta-toggle" data-form="form-novels">
                                    <span class="cta-icon">📖</span>
                                    <span class="cta-text">Get Early Access</span>
                                    <span class="cta-arrow">▼</span>
                                </button>
                                
                                <div class="hero-quick-signup" id="form-novels">
                                    <div class="signup-header">
                                        <h3>Join the Maze Chronicles Journey</h3>
                                        <p>Get notified about releases, excerpts, and special editions</p>
                                    </div>
                                    <form class="quick-signup-form hero-signup-form">
                                        <?php wp_nonce_field('sunlight_signup_nonce', 'novels_signup_nonce'); ?>
                                        <input type="hidden" name="project" value="maze-chronicles">
                                        <div class="form-row">
                                            <input type="text" name="name" placeholder="Your Name" required>
                                            <input type="email" name="email" placeholder="Your Email" required>
                                            <button type="submit" class="quick-join-btn">
                                                <span>Join 📚</span>
                                            </button>
                                        </div>
                                        <div class="form-footer">
                                            <label class="consent-label">
                                                <input type="checkbox" name="consent" required>
                                                <span>I agree to receive updates about Maze Chronicles.</span>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 3: Maze Game -->
                    <div class="carousel-slide slide-2" data-slide="2">
                        <div class="hero-content">
                            <div class="hero-brand">
                                <span class="hero-pre-title">🎮 The Interactive Experience</span>
                                <h1 class="hero-title">The Maze Game</h1>
                                <h2 class="hero-subtitle-main">Play Your Way to Awakening</h2>
                            </div>
                            
                            <div class="hero-description-block">
                                <p class="hero-description">A tabletop and digital experience where consciousness is the game.<br>
                                Every choice matters. Every path leads to transformation.</p>
                                <p class="hero-subtext">Strategy meets mysticism in an unforgettable journey through the self.</p>
                            </div>
                            
                            <div class="hero-cta-container">
                                <button class="hero-cta-toggle" data-form="form-game">
                                    <span class="cta-icon">🎲</span>
                                    <span class="cta-text">Join the Playtest</span>
                                    <span class="cta-arrow">▼</span>
                                </button>
                                
                                <div class="hero-quick-signup" id="form-game">
                                    <div class="signup-header">
                                        <h3>Join the Maze Game Community</h3>
                                        <p>Playtest access, development updates, and exclusive content</p>
                                    </div>
                                    <form class="quick-signup-form hero-signup-form">
                                        <?php wp_nonce_field('sunlight_signup_nonce', 'game_signup_nonce'); ?>
                                        <input type="hidden" name="project" value="maze-game">
                                        <div class="form-row">
                                            <input type="text" name="name" placeholder="Your Name" required>
                                            <input type="email" name="email" placeholder="Your Email" required>
                                            <button type="submit" class="quick-join-btn">
                                                <span>Join 🎮</span>
                                            </button>
                                        </div>
                                        <div class="form-footer">
                                            <label class="consent-label">
                                                <input type="checkbox" name="consent" required>
                                                <span>I agree to receive updates about the Maze Game.</span>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <button class="indicator active"></button>
                    <button class="indicator"></button>
                    <button class="indicator"></button>
                </div>
            </div>
        </section>
        </div>
        <?php
        return ob_get_clean();
    }

    public function hero_slider_shortcode($atts) {
        $atts = shortcode_atts(array(), $atts);

        ob_start();
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
                    <!-- Slide 1: Sunlight Tarot -->
                    <div class="carousel-slide active slide-0" data-slide="0">
                        <div class="hero-content">
                            <div class="hero-brand">
                                <span class="hero-pre-title">✨ The Evolution of Tarot</span>
                                <h1 class="hero-title">Sunlight Tarot</h1>
                                <h2 class="hero-subtitle-main">A New Light on the Tarot Tradition</h2>
                            </div>

                            <div class="hero-description-block">
                                <p class="hero-description">Not a tool for fortune-telling.<br>
                                A living map of consciousness — science, soul, and art entwined.</p>
                                <p class="hero-subtext">Reimagining the Tarot as a bridge between mysticism and modern understanding.</p>
                            </div>

                            <div class="hero-cta-container">
                                <button class="hero-cta-toggle" data-form="form-tarot">
                                    <span class="cta-icon">✨</span>
                                    <span class="cta-text">I Want to Participate</span>
                                    <span class="cta-arrow">▼</span>
                                </button>
                            </div>

                            <div class="hero-quick-signup" id="form-tarot">
                                <div class="signup-header">
                                    <h3>Join the Sunlight Tarot Project</h3>
                                    <p>Early access to artwork, deck updates, and community</p>
                                </div>
                                <form class="quick-signup-form hero-signup-form">
                                    <?php wp_nonce_field('sunlight_signup_nonce', 'tarot_signup_nonce'); ?>
                                    <input type="hidden" name="project" value="sunlight-tarot">
                                    <div class="form-row">
                                        <input type="text" name="name" placeholder="Your Name" required>
                                        <input type="email" name="email" placeholder="Your Email" required>
                                        <button type="submit" class="quick-join-btn">
                                            <span>Join ✨</span>
                                        </button>
                                    </div>
                                    <div class="form-footer">
                                        <label class="consent-label">
                                            <input type="checkbox" name="consent" required>
                                            <span>I agree to receive updates about Sunlight Tarot.</span>
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Maze Chronicles Novels -->
                    <div class="carousel-slide slide-1" data-slide="1">
                        <div class="hero-content">
                            <div class="hero-brand">
                                <span class="hero-pre-title">📚 The Literary Journey</span>
                                <h1 class="hero-title">Maze Chronicles</h1>
                                <h2 class="hero-subtitle-main">Four Novels, One Consciousness</h2>
                            </div>

                            <div class="hero-description-block">
                                <p class="hero-description">Beginning with <em>The Boring Field Guide to Fantastic Multidimensional Portals</em>.<br>
                                A mind-bending journey through consciousness, reality, and transformation.</p>
                                <p class="hero-subtext">Where every choice shapes reality and every page opens new dimensions.</p>
                            </div>

                            <div class="hero-cta-container">
                                <button class="hero-cta-toggle" data-form="form-novels">
                                    <span class="cta-icon">📖</span>
                                    <span class="cta-text">Get Early Access</span>
                                    <span class="cta-arrow">▼</span>
                                </button>
                            </div>

                            <div class="hero-quick-signup" id="form-novels">
                                <div class="signup-header">
                                    <h3>Join the Maze Chronicles Journey</h3>
                                    <p>Get notified about releases, excerpts, and special editions</p>
                                </div>
                                <form class="quick-signup-form hero-signup-form">
                                    <?php wp_nonce_field('sunlight_signup_nonce', 'novels_signup_nonce'); ?>
                                    <input type="hidden" name="project" value="maze-chronicles">
                                    <div class="form-row">
                                        <input type="text" name="name" placeholder="Your Name" required>
                                        <input type="email" name="email" placeholder="Your Email" required>
                                        <button type="submit" class="quick-join-btn">
                                            <span>Join 📚</span>
                                        </button>
                                    </div>
                                    <div class="form-footer">
                                        <label class="consent-label">
                                            <input type="checkbox" name="consent" required>
                                            <span>I agree to receive updates about Maze Chronicles.</span>
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Maze Game -->
                    <div class="carousel-slide slide-2" data-slide="2">
                        <div class="hero-content">
                            <div class="hero-brand">
                                <span class="hero-pre-title">🎮 The Interactive Experience</span>
                                <h1 class="hero-title">The Maze Game</h1>
                                <h2 class="hero-subtitle-main">Play Your Way to Awakening</h2>
                            </div>

                            <div class="hero-description-block">
                                <p class="hero-description">A tabletop and digital experience where consciousness is the game.<br>
                                Every choice matters. Every path leads to transformation.</p>
                                <p class="hero-subtext">Strategy meets mysticism in an unforgettable journey through the self.</p>
                            </div>

                            <div class="hero-cta-container">
                                <button class="hero-cta-toggle" data-form="form-game">
                                    <span class="cta-icon">🎲</span>
                                    <span class="cta-text">Join the Playtest</span>
                                    <span class="cta-arrow">▼</span>
                                </button>
                            </div>

                            <div class="hero-quick-signup" id="form-game">
                                <div class="signup-header">
                                    <h3>Join the Maze Game Community</h3>
                                    <p>Playtest access, development updates, and exclusive content</p>
                                </div>
                                <form class="quick-signup-form hero-signup-form">
                                    <?php wp_nonce_field('sunlight_signup_nonce', 'game_signup_nonce'); ?>
                                    <input type="hidden" name="project" value="maze-game">
                                    <div class="form-row">
                                        <input type="text" name="name" placeholder="Your Name" required>
                                        <input type="email" name="email" placeholder="Your Email" required>
                                        <button type="submit" class="quick-join-btn">
                                            <span>Join 🎮</span>
                                        </button>
                                    </div>
                                    <div class="form-footer">
                                        <label class="consent-label">
                                            <input type="checkbox" name="consent" required>
                                            <span>I agree to receive updates about the Maze Game.</span>
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <button class="indicator active"></button>
                    <button class="indicator"></button>
                    <button class="indicator"></button>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    public function hero_shortcode($atts) {
        $atts = shortcode_atts(array(
            'bg_image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'
        ), $atts);
        
        $bg_style = !empty($atts['bg_image']) ? 'background-image: url(' . esc_url($atts['bg_image']) . ');' : '';
        
        ob_start();
        ?>
        <section class="sunlight-hero" id="hero">
            <div class="hero-carousel">
                <!-- Navigation Arrows -->
                <button class="carousel-nav carousel-prev" id="carousel-prev">‹</button>
                <button class="carousel-nav carousel-next" id="carousel-next">›</button>
                
                <!-- Carousel Slides -->
                <div class="carousel-track">
                    <!-- Slide 1: Sunlight Tarot -->
                    <div class="carousel-slide active slide-0" data-slide="0">
                        <div class="hero-content">
                            <div class="hero-brand">
                                <span class="hero-pre-title">✨ The Evolution of Tarot</span>
                                <h1 class="hero-title">Sunlight Tarot</h1>
                                <h2 class="hero-subtitle-main">A New Light on the Tarot Tradition</h2>
                            </div>
                            
                            <div class="hero-description-block">
                                <p class="hero-description">Not a tool for fortune-telling.<br>
                                A living map of consciousness — science, soul, and art entwined.</p>
                                <p class="hero-subtext">Reimagining the Tarot as a bridge between mysticism and modern understanding.</p>
                            </div>
                            
                            <div class="hero-cta-container">
                                <button class="hero-cta-toggle" data-form="form-tarot">
                                    <span class="cta-icon">✨</span>
                                    <span class="cta-text">I Want to Participate</span>
                                    <span class="cta-arrow">▼</span>
                                </button>
                                
                                <div class="hero-quick-signup" id="form-tarot">
                                    <div class="signup-header">
                                        <h3>Join the Sunlight Tarot Project</h3>
                                        <p>Early access to artwork, deck updates, and community</p>
                                    </div>
                                    <form class="quick-signup-form hero-signup-form">
                                        <?php wp_nonce_field('sunlight_signup_nonce', 'tarot_signup_nonce'); ?>
                                        <input type="hidden" name="project" value="sunlight-tarot">
                                        <div class="form-row">
                                            <input type="text" name="name" placeholder="Your Name" required>
                                            <input type="email" name="email" placeholder="Your Email" required>
                                            <button type="submit" class="quick-join-btn">
                                                <span>Join ✨</span>
                                            </button>
                                        </div>
                                        <div class="form-footer">
                                            <label class="consent-label">
                                                <input type="checkbox" name="consent" required>
                                                <span>I agree to receive updates about Sunlight Tarot.</span>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 2: Maze Chronicles Novels -->
                    <div class="carousel-slide slide-1" data-slide="1">
                        <div class="hero-content">
                            <div class="hero-brand">
                                <span class="hero-pre-title">📚 The Literary Journey</span>
                                <h1 class="hero-title">Maze Chronicles</h1>
                                <h2 class="hero-subtitle-main">Four Novels, One Consciousness</h2>
                            </div>
                            
                            <div class="hero-description-block">
                                <p class="hero-description">Beginning with <em>The Boring Field Guide to Fantastic Multidimensional Portals</em>.<br>
                                A mind-bending journey through consciousness, reality, and transformation.</p>
                                <p class="hero-subtext">Where every choice shapes reality and every page opens new dimensions.</p>
                            </div>
                            
                            <div class="hero-cta-container">
                                <button class="hero-cta-toggle" data-form="form-novels">
                                    <span class="cta-icon">📖</span>
                                    <span class="cta-text">Get Early Access</span>
                                    <span class="cta-arrow">▼</span>
                                </button>
                                
                                <div class="hero-quick-signup" id="form-novels">
                                    <div class="signup-header">
                                        <h3>Join the Maze Chronicles Journey</h3>
                                        <p>Get notified about releases, excerpts, and special editions</p>
                                    </div>
                                    <form class="quick-signup-form hero-signup-form">
                                        <?php wp_nonce_field('sunlight_signup_nonce', 'novels_signup_nonce'); ?>
                                        <input type="hidden" name="project" value="maze-chronicles">
                                        <div class="form-row">
                                            <input type="text" name="name" placeholder="Your Name" required>
                                            <input type="email" name="email" placeholder="Your Email" required>
                                            <button type="submit" class="quick-join-btn">
                                                <span>Join 📚</span>
                                            </button>
                                        </div>
                                        <div class="form-footer">
                                            <label class="consent-label">
                                                <input type="checkbox" name="consent" required>
                                                <span>I agree to receive updates about Maze Chronicles.</span>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 3: Maze Game -->
                    <div class="carousel-slide slide-2" data-slide="2">
                        <div class="hero-content">
                            <div class="hero-brand">
                                <span class="hero-pre-title">🎮 The Interactive Experience</span>
                                <h1 class="hero-title">The Maze Game</h1>
                                <h2 class="hero-subtitle-main">Play Your Way to Awakening</h2>
                            </div>
                            
                            <div class="hero-description-block">
                                <p class="hero-description">A tabletop and digital experience where consciousness is the game.<br>
                                Every choice matters. Every path leads to transformation.</p>
                                <p class="hero-subtext">Strategy meets mysticism in an unforgettable journey through the self.</p>
                            </div>
                            
                            <div class="hero-cta-container">
                                <button class="hero-cta-toggle" data-form="form-game">
                                    <span class="cta-icon">🎲</span>
                                    <span class="cta-text">Join the Playtest</span>
                                    <span class="cta-arrow">▼</span>
                                </button>
                                
                                <div class="hero-quick-signup" id="form-game">
                                    <div class="signup-header">
                                        <h3>Join the Maze Game Community</h3>
                                        <p>Playtest access, development updates, and exclusive content</p>
                                    </div>
                                    <form class="quick-signup-form hero-signup-form">
                                        <?php wp_nonce_field('sunlight_signup_nonce', 'game_signup_nonce'); ?>
                                        <input type="hidden" name="project" value="maze-game">
                                        <div class="form-row">
                                            <input type="text" name="name" placeholder="Your Name" required>
                                            <input type="email" name="email" placeholder="Your Email" required>
                                            <button type="submit" class="quick-join-btn">
                                                <span>Join 🎮</span>
                                            </button>
                                        </div>
                                        <div class="form-footer">
                                            <label class="consent-label">
                                                <input type="checkbox" name="consent" required>
                                                <span>I agree to receive updates about the Maze Game.</span>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <button class="indicator active"></button>
                    <button class="indicator"></button>
                    <button class="indicator"></button>
                </div>
            </div>
            
            <!-- Floating CTA for mobile -->
            <div class="floating-cta" id="floating-cta">
                <button class="floating-cta-btn">
                    <span>✨ Join</span>
                </button>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    public function about_shortcode($atts) {
        ob_start();
        ?>
        <section class="sunlight-about" id="about">
            <div class="container">
                <div class="about-intro">
                    <span class="section-label">Three Journeys, One Vision</span>
                    <h2 class="section-title">The Sunlight Universe</h2>
                    <p class="section-lead">Where consciousness meets creativity through three interconnected experiences.</p>
                </div>
                
                <div class="about-grid">
                    <div class="about-card">
                        <div class="card-icon">✨</div>
                        <h3>Sunlight Tarot</h3>
                        <p>A revolutionary reimagining of the Tarot — not for fortune-telling, but as a living map of consciousness. Each card is a bridge between mysticism and modern understanding, combining science, soul, and art into a transformative experience for the modern seeker.</p>
                    </div>
                    
                    <div class="about-card">
                        <div class="card-icon">📚</div>
                        <h3>Maze Chronicles</h3>
                        <p>Four interconnected novels beginning with <em>The Boring Field Guide to Fantastic Multidimensional Portals</em> by Adam Douglas. A mind-bending literary journey through consciousness, reality, and transformation where every choice shapes your understanding of existence.</p>
                    </div>
                    
                    <div class="about-card">
                        <div class="card-icon">🎮</div>
                        <h3>The Maze Game</h3>
                        <p>Both a tabletop and digital experience where consciousness is the game itself. Every mechanic reflects the Tarot's philosophy: choices matter, consciousness expands, and every path leads to awakening. Strategy meets mysticism in an unforgettable journey.</p>
                    </div>
                    
                    <div class="about-card">
                        <div class="card-icon">💫</div>
                        <h3>One Connected Universe</h3>
                        <p>The cards, novels, and game are not separate — they're facets of the same light. Inspired by the revolutionary spirit of Osho and Eileen Connolly, we continue their legacy: breaking conventions, opening hearts, and bringing light to shadow.</p>
                    </div>
                </div>
                
                <div class="about-quote">
                    <blockquote>
                        "The Tarot is not about knowing the future. It's about understanding the now — through cards, stories, and play."
                    </blockquote>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    public function gallery_shortcode($atts) {
        ob_start();
        ?>
        <section class="sunlight-gallery" id="gallery">
            <div class="container">
                <div class="gallery-intro-section">
                    <span class="section-label">Visual Journey</span>
                    <h2 class="section-title">The Vision in Images</h2>
                    <p class="gallery-intro">Every card, every color, every line is part of a larger symphony — the rebirth of Tarot.<br>
                    Explore early concept art, elemental angels, sketches of "The Dreamer Awake," and glimpses of the Sunlight world taking form.</p>
                </div>
                
                <div class="gallery-interactive">
                    <div class="gallery-tabs-container">
                        <div class="gallery-tabs">
                            <button class="tab-button active" onclick="switchGalleryTab(event, 'deck')">
                                <span class="tab-icon">🃏</span>
                                <span class="tab-label">The Deck</span>
                                <span class="tab-count">12</span>
                            </button>
                            <button class="tab-button" onclick="switchGalleryTab(event, 'concept')">
                                <span class="tab-icon">🎨</span>
                                <span class="tab-label">Concept Art</span>
                                <span class="tab-count">8</span>
                            </button>
                            <button class="tab-button" onclick="switchGalleryTab(event, 'inspiration')">
                                <span class="tab-icon">💡</span>
                                <span class="tab-label">Inspiration</span>
                                <span class="tab-count">6</span>
                            </button>
                            <button class="tab-button" onclick="switchGalleryTab(event, 'symbols')">
                                <span class="tab-icon">✨</span>
                                <span class="tab-label">Symbols</span>
                                <span class="tab-count">15</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="gallery-content">
                        <div class="tab-pane active" id="gallery-deck">
                            <div class="tab-header">
                                <h3>The Core Cards</h3>
                                <p>The foundation of Sunlight Tarot — each Major Arcana card represents a stage in the Dreamer's awakening journey.</p>
                            </div>
                            <div class="gallery-grid">
                                <div class="gallery-item featured">
                                    <div class="gallery-image">
                                        <div class="placeholder-large">
                                            <div class="placeholder-icon">🌅</div>
                                            <h4>The Dreamer</h4>
                                            <p>Major Arcana I</p>
                                        </div>
                                    </div>
                                    <div class="gallery-info">
                                        <h4>The Dreamer Awakens</h4>
                                        <p>The beginning of consciousness, the spark of awareness that illuminates the path ahead.</p>
                                        <div class="gallery-meta">
                                            <span class="meta-tag">Major Arcana</span>
                                            <span class="meta-date">Coming 2025</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gallery-item">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">🌙</div>
                                            <p>The Moon</p>
                                            <small>Major Arcana</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gallery-item">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">⭐</div>
                                            <p>The Star</p>
                                            <small>Major Arcana</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gallery-item">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">☀️</div>
                                            <p>The Sun</p>
                                            <small>Major Arcana</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gallery-item">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">🌊</div>
                                            <p>Cups Suite</p>
                                            <small>Elemental</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gallery-item">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">🔥</div>
                                            <p>Wands Suite</p>
                                            <small>Elemental</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="gallery-concept">
                            <div class="tab-header">
                                <h3>Behind the Scenes</h3>
                                <p>Early sketches, digital concepts, and the creative process that brings each card to life.</p>
                            </div>
                            <div class="gallery-grid">
                                <div class="gallery-item concept-sketch">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">✏️</div>
                                            <p>Initial Sketches</p>
                                            <small>Hand-drawn concepts</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gallery-item concept-digital">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">💻</div>
                                            <p>Digital Concepts</p>
                                            <small>3D renderings</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gallery-item concept-color">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">🎨</div>
                                            <p>Color Studies</p>
                                            <small>Palette exploration</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="gallery-inspiration">
                            <div class="tab-header">
                                <h3>Mystical Sources</h3>
                                <p>The spiritual traditions, symbols, and philosophies that inspire our modern Tarot system.</p>
                            </div>
                            <div class="gallery-grid">
                                <div class="gallery-item inspiration">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">🕉️</div>
                                            <p>Osho Philosophy</p>
                                            <small>Consciousness & Awareness</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gallery-item inspiration">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">🔮</div>
                                            <p>Eileen Connolly</p>
                                            <small>Modern Mysticism</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gallery-item inspiration">
                                    <div class="gallery-image">
                                        <div class="placeholder-content">
                                            <div class="placeholder-icon">🧬</div>
                                            <p>Science & Spirit</p>
                                            <small>Quantum Consciousness</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="gallery-symbols">
                            <div class="tab-header">
                                <h3>The Visual Language</h3>
                                <p>Sacred geometry, elemental symbols, and the iconography that connects all cards together.</p>
                            </div>
                            <div class="gallery-grid symbols-grid">
                                <div class="symbol-item">
                                    <div class="symbol-icon">⚡</div>
                                    <div class="symbol-text">Lightning</div>
                                    <div class="symbol-meaning">Sudden insight</div>
                                </div>
                                
                                <div class="symbol-item">
                                    <div class="symbol-icon">🌸</div>
                                    <div class="symbol-text">Lotus</div>
                                    <div class="symbol-meaning">Enlightenment</div>
                                </div>
                                
                                <div class="symbol-item">
                                    <div class="symbol-icon">🔺</div>
                                    <div class="symbol-text">Triangle</div>
                                    <div class="symbol-meaning">Manifestation</div>
                                </div>
                                
                                <div class="symbol-item">
                                    <div class="symbol-icon">🌑</div>
                                    <div class="symbol-text">Eclipse</div>
                                    <div class="symbol-meaning">Transformation</div>
                                </div>
                                
                                <div class="symbol-item">
                                    <div class="symbol-icon">🔥</div>
                                    <div class="symbol-text">Fire</div>
                                    <div class="symbol-meaning">Passion & Will</div>
                                </div>
                                
                                <div class="symbol-item">
                                    <div class="symbol-icon">💧</div>
                                    <div class="symbol-text">Water</div>
                                    <div class="symbol-meaning">Emotion & Intuition</div>
                                </div>
                                
                                <div class="symbol-item">
                                    <div class="symbol-icon">🌱</div>
                                    <div class="symbol-text">Earth</div>
                                    <div class="symbol-meaning">Stability & Growth</div>
                                </div>
                                
                                <div class="symbol-item">
                                    <div class="symbol-icon">💨</div>
                                    <div class="symbol-text">Air</div>
                                    <div class="symbol-meaning">Thought & Communication</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    public function video_shortcode($atts) {
        $atts = shortcode_atts(array(
            'url' => ''
        ), $atts);

        ob_start();
        ?>
        <section class="sunlight-video" id="video">
            <div class="container">
                <h2 class="section-title">The Story Begins Here</h2>
                <p class="video-intro">Watch the first glimpse of Sunlight Tarot — a journey through art, spirit, and imagination.<br>
                This short film introduces the light behind the cards, the music that moves them, and the vision that connects everything together.</p>
                
                <div class="video-wrapper">
                    <?php if (!empty($atts['url'])) : ?>
                        <div class="video-embed">
                            <?php echo wp_oembed_get($atts['url']); ?>
                        </div>
                    <?php else : ?>
                        <div class="video-placeholder">
                            <div class="placeholder-icon">🎬</div>
                            <p>Video Coming Soon</p>
                            <small>Use: [sunlight_video url="your-youtube-url"]</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    public function signup_shortcode($atts) {
        ob_start();
        ?>
        <section class="sunlight-signup" id="signup">
            <div class="container">
                <h2 class="section-title">Be Part of the Creation</h2>
                <p class="signup-intro">We're inviting dreamers, artists, seekers, and visionaries to join us at the beginning of something luminous.<br>
                By leaving your email, you'll become part of the Head Start phase — early updates, artwork reveals, and opportunities to contribute or test the first prototypes.<br>
                We promise: no spam. Only light, beauty, and meaning.</p>
                
                <form id="sunlight-signup-form" class="signup-form" method="post">
                    <?php wp_nonce_field('sunlight_signup_nonce', 'signup_nonce'); ?>
                    
                    <div class="form-group">
                        <label for="signup-name">Name</label>
                        <input type="text" id="signup-name" name="name" required placeholder="Your name">
                    </div>
                    
                    <div class="form-group">
                        <label for="signup-email">Email</label>
                        <input type="email" id="signup-email" name="email" required placeholder="your@email.com">
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="consent" required>
                            <span>I agree to receive occasional updates about the project.</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="signup-submit">
                        <span class="submit-icon">✨</span> Join the Sunlight Project
                    </button>
                    
                    <div class="form-message" style="display:none;"></div>
                </form>
                
                <div class="signup-success" style="display:none;">
                    <h3>Thank you for joining the Sunlight Project.</h3>
                    <p>You're now part of a journey to bring the Tarot back to life — one card, one story, one spark of light at a time.</p>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    public function vision_shortcode($atts) {
        ob_start();
        ?>
        <section class="sunlight-vision" id="vision">
            <div class="container">
                <h2 class="section-title">The Universe of Sunlight</h2>
                <p class="vision-intro">Sunlight Tarot is the heart — but around it grows an entire creative world:</p>
                
                <div class="vision-grid">
                    <div class="vision-item">
                        <div class="vision-icon">🌞</div>
                        <h3>The Deck</h3>
                        <p>9 Major Arcana cards reimagined as the Dreamer's awakening, and 9×4 elemental paths guided by angels.</p>
                    </div>
                    
                    <div class="vision-item">
                        <div class="vision-icon">📘</div>
                        <h3>Four Interconnected Novels</h3>
                        <p>A literary saga beginning with <em>The Boring Field Guide to Fantastic Multidimensional Portals</em> by Adam Douglas. Each of the four books explores consciousness, mystery, and transformation.</p>
                    </div>
                    
                    <div class="vision-item">
                        <div class="vision-icon">🎲</div>
                        <h3>The Games</h3>
                        <p>Tabletop and digital experiences inspired by the cards.</p>
                    </div>
                    
                    <div class="vision-item">
                        <div class="vision-icon">🎨</div>
                        <h3>Coloring Books</h3>
                        <p>Meditative art journeys for children and adults alike.</p>
                    </div>
                    
                    <div class="vision-item">
                        <div class="vision-icon">🎵</div>
                        <h3>The Music</h3>
                        <p>Original soundscapes written to accompany each card's energy.</p>
                    </div>
                </div>
                
                <p class="vision-footer">Each part connects to the others — one project, one light, many expressions.</p>
            </div>
        </section>
        
        <footer class="sunlight-footer">
            <div class="container">
                <p class="footer-tagline">A light for those who dream awake.</p>
                <div class="footer-links">
                    <a href="#about">About</a>
                    <a href="mailto:contact@sunlightproject.com">Contact</a>
                    <a href="#">Instagram</a>
                    <a href="#">YouTube</a>
                    <a href="#">Privacy</a>
                </div>
                <p class="footer-copyright">© 2025 Sunlight Project. All Rights Reserved.</p>
            </div>
        </footer>
        <?php
        return ob_get_clean();
    }

    public function full_page_shortcode($atts) {
        ob_start();
        echo '<!DOCTYPE html><html><head>';
        wp_head();
        echo '</head><body class="sunlight-landing-page">';
        echo $this->hero_shortcode($atts);
        echo $this->about_shortcode($atts);
        echo $this->gallery_shortcode($atts);
        echo $this->video_shortcode($atts);
        echo $this->signup_shortcode($atts);
        echo $this->vision_shortcode($atts);
        wp_footer();
        echo '</body></html>';
        return ob_get_clean();
    }

    public function handle_signup() {
        check_ajax_referer('sunlight_signup_nonce', 'nonce');

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $consent = isset($_POST['consent']) ? true : false;

        if (empty($name) || empty($email) || !$consent) {
            wp_send_json_error(['message' => 'Please fill in all required fields.']);
        }

        if (!is_email($email)) {
            wp_send_json_error(['message' => 'Please enter a valid email address.']);
        }

        if (email_exists($email)) {
            wp_send_json_error(['message' => 'This email is already registered.']);
        }

        $user_id = wp_create_user($email, wp_generate_password(), $email);

        if (is_wp_error($user_id)) {
            wp_send_json_error(['message' => 'Registration failed. Please try again.']);
        }

        wp_update_user([
            'ID' => $user_id,
            'display_name' => $name,
            'first_name' => $name
        ]);

        update_user_meta($user_id, 'sunlight_signup_date', current_time('mysql'));
        update_user_meta($user_id, 'sunlight_consent', true);

        wp_send_json_success(['message' => 'Thank you for joining the Sunlight Project!']);
    }

    public function custom_template($template) {
        if ($this->is_landing_page()) {
            $custom_template = LANDING_PAGE_DIR . '/templates/landing-page.php';
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }
        return $template;
    }

    private function get_inline_styles() {
        return "
        * { margin: 0; padding: 0; box-sizing: border-box; }
        .sunlight-full-width {
            width: 100vw !important;
            margin-left: calc(50% - 50vw) !important;
            margin-right: calc(50% - 50vw) !important;
            padding: 0 !important;
            max-width: none !important;
        }
        body.sunlight-landing-page { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; line-height: 1.6; color: #2d3436; overflow-x: hidden; }
        
            padding: 2rem !important;
            box-sizing: border-box !important;
        }
        
        /* Force all sections to be full width */
        .sunlight-hero, .sunlight-about, .sunlight-gallery, .sunlight-video, .sunlight-signup, .sunlight-vision, .sunlight-footer {
            width: 100vw !important;
            margin-left: calc(50% - 50vw) !important;
            margin-right: calc(50% - 50vw) !important;
            max-width: none !important;
            padding-left: 3rem !important;
            padding-right: 3rem !important;
            box-sizing: border-box !important;
        }

        /* Override WordPress Astra and any other theme containers */
        body.page-id-2 .ast-container,
        body.page-id-2 .site-content,
        body.page-id-2 .content-area,
        body.page-id-2 #primary,
        body.page-id-2 .entry-content,
        body.page-id-2 #content,
        body.page-id-2 .site-main,
        body.page-id-2 .wp-site-blocks,
        body.page-id-2 .is-layout-constrained {
            width: 100vw !important;
            margin: 0 !important;
            padding: 0 !important;
            max-width: none !important;
        }

        /* Ensure hero content is centered within full width */
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: 0 3rem 3rem 3rem;
            text-align: center;
        }

        /* Force LTR for landing page */
        body.sunlight-landing-page,
        body.page-id-2,
        .sunlight-hero,
        .sunlight-about,
        .sunlight-gallery,
        .sunlight-video,
        .sunlight-signup,
        .sunlight-vision,
        .sunlight-footer {
            direction: ltr !important;
        }

        .sunlight-hero-slider {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 50%, #e17055 100%);
            background-size: cover;
            background-position: center;
            color: #2d3436;
            text-align: center;
            width: 100vw !important;
            margin-left: calc(50% - 50vw) !important;
            margin-right: calc(50% - 50vw) !important;
            padding: 3rem 0 4rem !important;
            box-sizing: border-box !important;
            overflow: hidden;
        }
        .sunlight-hero-slider .carousel-slide {
            display: none;
            position: relative;
            min-height: 50vh;
            padding: 4rem 2rem;
            width: 100vw;
            max-width: none;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
        }
        .sunlight-hero-slider .carousel-slide.active {
            display: block;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: calc(50% - 50vw);
            width: 100vw;
            height: 60vh;
            background: rgba(0,0,0,0.35);
            z-index: 1;
            pointer-events: none;
        }
        
        /* Carousel Container */
        .hero-carousel {
            position: relative;
            width: 100vw;
            max-width: none;
            padding: 0 2rem;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            height: 60vh; /* Fixed height instead of 100% */
            z-index: 2;
            margin-bottom: 3rem; /* Add spacing before forms */
        }
        
        /* Carousel Track */
        .carousel-track {
            position: relative;
            width: 100%;
            height: 100%;
        }
        
        /* Carousel Slides */
        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.6s ease, visibility 0.6s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
        }
        
        .carousel-slide.active {
            opacity: 1;
            visibility: visible;
            z-index: 1;
        }
        
        /* Slide-specific backgrounds */
        .carousel-slide.slide-0 {
            background: linear-gradient(135deg, rgba(255,234,167,0.9) 0%, rgba(253,203,110,0.9) 50%, rgba(225,112,85,0.9) 100%),
                        url('https://images.unsplash.com/photo-1518562180175-34a163b1a9a6?w=1920&q=80');
        }
        .carousel-slide.slide-1 {
            background: linear-gradient(135deg, rgba(116,185,255,0.85) 0%, rgba(162,155,254,0.85) 50%, rgba(223,230,233,0.85) 100%),
                        url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&q=80');
        }
        .carousel-slide.slide-2 {
            background: linear-gradient(135deg, rgba(253,121,168,0.85) 0%, rgba(99,110,114,0.85) 50%, rgba(45,52,54,0.85) 100%),
                        url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=1920&q=80');
        }
        
        /* Carousel Navigation Arrows */
        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.9);
            border: none;
            border-radius: 50%;
            width: 58px;
            height: 58px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        .carousel-nav:hover {
            background: #fff;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }

        .carousel-nav .nav-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            position: relative;
        }

        .carousel-nav .nav-icon::before,
        .carousel-nav .nav-icon::after {
            content: '';
            position: absolute;
            width: 4px;
            height: 100%;
            background: #2d3436;
            border-radius: 4px;
            top: 0;
            transition: transform 0.3s ease;
        }

        .nav-icon-prev::before { left: 7px; transform: rotate(40deg); }
        .nav-icon-prev::after { left: 7px; transform: rotate(-40deg); }

        .nav-icon-next::before { right: 7px; transform: rotate(-40deg); }
        .nav-icon-next::after { right: 7px; transform: rotate(40deg); }

        .carousel-prev {
            left: 2rem;
        }
        
        .carousel-next {
            right: 2rem;
        }
        
        /* Carousel Indicators */
        .carousel-indicators {
            position: absolute;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 1rem;
            z-index: 100;
        }
        
        .carousel-indicators .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            border: 2px solid rgba(255,255,255,0.8);
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
        }
        
        .carousel-indicators .indicator:hover {
            background: rgba(255,255,255,0.8);
            transform: scale(1.2);
        }
        
        .carousel-indicators .indicator.active {
            background: #fff;
            width: 40px;
            border-radius: 10px;
        }
        .hero-pre-title { display: inline-block; font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; background: rgba(255,255,255,0.95); color: #2d3436; padding: 0.5rem 1.5rem; border-radius: 25px; }
        .hero-title { font-size: clamp(2.5rem, 6vw, 4.5rem); margin-bottom: 0.5rem; font-weight: 800; text-shadow: 3px 3px 8px rgba(0,0,0,0.5), 0 0 20px rgba(255,255,255,0.3); color: #fff; }
        .hero-subtitle-main { font-size: clamp(1.5rem, 3vw, 2.5rem); margin-bottom: 1.5rem; font-weight: 300; font-style: italic; text-shadow: 2px 2px 6px rgba(0,0,0,0.5); color: #fff; }
        .hero-description-block { background: rgba(255,255,255,0.9); padding: 1.5rem 2rem; border-radius: 15px; margin: 2rem auto; max-width: 700px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); }
        .hero-description { font-size: clamp(1.1rem, 2.5vw, 1.5rem); margin-bottom: 1rem; line-height: 1.6; font-weight: 500; color: #2d3436; }
        .hero-subtext { font-size: clamp(1rem, 2vw, 1.2rem); margin-bottom: 0; color: #636e72; max-width: 700px; margin-left: auto; margin-right: auto; }
        
        /* Hero CTA Container - Rebuilt */
        .hero-cta-container { 
            margin: 1.5rem auto 0.75rem; 
            position: relative;
            z-index: 100;
            max-width: 600px;
        }
        
        .hero-cta-toggle { 
            padding: 1.2rem 3rem; 
            background: #2d3436; 
            color: #ffeaa7; 
            border: none; 
            border-radius: 50px; 
            font-size: 1.3rem; 
            font-weight: 700; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.3); 
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .hero-cta-toggle:hover { 
            background: #1a1a1a; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.4); 
            transform: translateY(-3px); 
        }
        
        .hero-cta-toggle.active { 
            background: #1a1a1a; 
        }
        
        .cta-icon { 
            font-size: 1.2em; 
        }
        
        .cta-arrow { 
            display: inline-block; 
            transition: transform 0.3s ease; 
            margin-left: 0.5rem;
        }
        
        .hero-cta-toggle.active .cta-arrow {
            transform: rotate(180deg);
        }
        
        /* Quick Signup Form - Rebuilt */
        .hero-quick-signup {
            margin: 1rem auto 0;
            background: rgba(255,255,255,0.98);
            padding: 1.75rem;
            border-radius: 15px;
            box-shadow: 0 12px 32px rgba(0,0,0,0.25);
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.35s ease;
            max-width: 560px;
        }

        .hero-quick-signup.show {
            max-height: 520px;
            opacity: 1;
            margin-top: 0.75rem;
            transform: translateY(0);
        }
        .signup-header { margin-bottom: 1.5rem; }
        .signup-header h3 { font-size: 1.8rem; margin-bottom: 0.5rem; color: #2d3436; }
        .signup-header p { color: #636e72; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .quick-signup-form .form-row { display: flex; gap: 0.75rem; max-width: 520px; margin: 0 auto; flex-wrap: nowrap; align-items: center; direction: ltr; }
        .quick-signup-form input { flex: 1; min-width: 150px; padding: 0.9rem 1.35rem; border: 2px solid #dfe6e9; background: #fff; border-radius: 50px; font-size: 1rem; transition: all 0.3s ease; }
        .quick-signup-form input:focus { outline: none; border-color: #fdcb6e; box-shadow: 0 0 0 3px rgba(253,203,110,0.2); }
        .quick-join-btn { padding: 0.95rem 2.25rem; background: #2d3436; color: #ffeaa7; border: none; border-radius: 50px; font-size: 1.05rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; white-space: nowrap; }
        .quick-join-btn:hover { background: #1a1a1a; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .form-footer { margin-top: 1rem; text-align: left; }
        .consent-label { display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; color: #636e72; cursor: pointer; direction: ltr; text-align: left; }
        .signup-benefits { display: none; }
        .consent-label input[type=checkbox] { width: 18px; height: 18px; cursor: pointer; }
        
        /* Hero Scroll Hint */
        .hero-scroll-hint { margin-top: 2.5rem; opacity: 0.7; animation: bounce 2s infinite; }
        @keyframes bounce { 0%, 20%, 50%, 80%, 100% { transform: translateY(0); } 40% { transform: translateY(-10px); } 60% { transform: translateY(-5px); } }
        .hero-scroll-hint span { font-size: 2rem; display: block; }
        .hero-scroll-hint p { font-size: 0.9rem; margin-top: 0.5rem; }
        
        /* Container & Sections */
        .container { max-width: 1200px; margin: 0 auto; padding: 5rem 2rem; }
        .section-label { display: inline-block; padding: 0.5rem 1.5rem; background: #fdcb6e; color: #2d3436; border-radius: 20px; font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; }
        .section-title { font-size: clamp(2.5rem, 5vw, 3.5rem); text-align: center; margin-bottom: 1rem; color: #2d3436; font-weight: 700; }
        .section-lead { text-align: center; font-size: 1.3rem; color: #636e72; margin-bottom: 3rem; font-style: italic; }
        
        /* About Section - Enhanced */
        .sunlight-about { background: linear-gradient(to bottom, #fff 0%, #f8f9fa 100%); }
        .about-intro { text-align: center; margin-bottom: 3rem; }
        .about-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 3rem; }
        .about-card { background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 2px solid transparent; }
        .about-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); border-color: #fdcb6e; }
        .card-icon { font-size: 3rem; margin-bottom: 1rem; }
        .about-card h3 { font-size: 1.5rem; margin-bottom: 1rem; color: #2d3436; }
        .about-card p { font-size: 1.05rem; line-height: 1.7; color: #636e72; }
        .about-quote { text-align: center; margin-top: 3rem; }
        .about-quote blockquote { font-size: 1.8rem; font-style: italic; color: #e17055; font-weight: 300; max-width: 700px; margin: 0 auto; padding: 2rem; border-left: 4px solid #fdcb6e; background: rgba(253,203,110,0.1); border-radius: 10px; }
        
        /* Gallery Section - Enhanced */
        .sunlight-gallery { background: #f8f9fa; }
        .gallery-intro-section { text-align: center; margin-bottom: 3rem; }
        .gallery-intro { font-size: 1.15rem; color: #636e72; line-height: 1.8; max-width: 800px; margin: 0 auto; }
        .gallery-tabs-container { margin-bottom: 3rem; }
        .gallery-tabs { display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; }
        .tab-button { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; padding: 1rem 2rem; border: 3px solid #fdcb6e; background: white; color: #2d3436; cursor: pointer; border-radius: 15px; font-weight: 600; transition: all 0.3s ease; min-width: 140px; }
        .tab-button:hover { background: rgba(253,203,110,0.2); transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .tab-button.active { background: #fdcb6e; color: white; box-shadow: 0 5px 20px rgba(253,203,110,0.4); }
        .tab-icon { font-size: 2rem; }
        .tab-label { font-size: 1rem; }
        .tab-pane { display: none; animation: fadeIn 0.3s ease; }
        .tab-pane.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .tab-description { text-align: center; font-size: 1.1rem; color: #636e72; margin-bottom: 2rem; font-style: italic; }
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; }
        .gallery-item { aspect-ratio: 1; border-radius: 15px; overflow: hidden; transition: transform 0.3s ease; }
        .gallery-item:hover { transform: scale(1.05); }
        .gallery-item.placeholder { background: linear-gradient(135deg, #e0e0e0, #f5f5f5); display: flex; align-items: center; justify-content: center; text-align: center; }
        .placeholder-content { padding: 2rem; }
        .placeholder-icon { font-size: 3rem; margin-bottom: 1rem; }
        .placeholder-content p { font-size: 1.2rem; color: #666; font-weight: 600; margin-bottom: 0.5rem; }
        .placeholder-content small { font-size: 0.95rem; color: #999; }
        .sunlight-video { background: #fff; }
        .video-intro { text-align: center; font-size: 1.1rem; margin-bottom: 2rem; color: #636e72; }
        .video-wrapper { max-width: 800px; margin: 0 auto; }
        .video-placeholder { aspect-ratio: 16/9; background: linear-gradient(135deg, #e0e0e0, #f5f5f5); display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 10px; }
        .placeholder-icon { font-size: 4rem; margin-bottom: 1rem; }
        .video-embed { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; }
        .video-embed iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        .sunlight-signup { background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%); }
        .signup-intro { text-align: center; font-size: 1.1rem; margin-bottom: 2rem; color: #2d3436; }
        .signup-form { max-width: 600px; margin: 0 auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2d3436; }
        .form-group input[type='text'], .form-group input[type='email'] { width: 100%; padding: 0.75rem; border: 2px solid #dfe6e9; border-radius: 5px; font-size: 1rem; }
        .checkbox-group label { display: flex; align-items: center; gap: 0.5rem; font-weight: normal; }
        .signup-submit { width: 100%; padding: 1rem; background: #2d3436; color: #ffeaa7; border: none; border-radius: 50px; font-size: 1.2rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        .signup-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .signup-success { max-width: 600px; margin: 0 auto; background: white; padding: 2rem; border-radius: 10px; text-align: center; }
        .form-message { margin-top: 1rem; padding: 0.75rem; border-radius: 5px; text-align: center; }
        .sunlight-vision { background: #fff; }
        .vision-intro { text-align: center; font-size: 1.2rem; margin-bottom: 2rem; color: #636e72; }
        .vision-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem; }
        .vision-item { text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 10px; transition: transform 0.3s ease; }
        .vision-item:hover { transform: translateY(-5px); }
        .vision-icon { font-size: 3rem; margin-bottom: 1rem; }
        .vision-item h3 { margin-bottom: 1rem; color: #2d3436; }
        .vision-footer { text-align: center; font-size: 1.1rem; font-style: italic; color: #636e72; }
        .sunlight-footer { background: #2d3436; color: #ffeaa7; padding: 3rem 2rem 2rem; text-align: center; }
        .footer-tagline { font-size: 1.5rem; font-style: italic; margin-bottom: 1.5rem; }
        .footer-links { display: flex; justify-content: center; gap: 2rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .footer-links a { color: #ffeaa7; text-decoration: none; transition: opacity 0.3s ease; }
        .footer-links a:hover { opacity: 0.7; }
        .footer-copyright { font-size: 0.9rem; opacity: 0.8; }
        
        /* Responsive Mobile Styles */
        @media (max-width: 768px) {
            .sunlight-hero { padding: 1rem; }
            .hero-content { padding: 0 1rem 4rem 1rem; }
            .hero-description-block { padding: 1rem 1.5rem; }
            .hero-cta-toggle { font-size: 1.1rem; padding: 1rem 2rem; }
            .hero-quick-signup { padding: 1.5rem; }
            .signup-header h3 { font-size: 1.4rem; }
            .quick-signup-form .form-row { flex-wrap: wrap; }
            .quick-signup-form input { min-width: 100%; }
            .quick-join-btn { width: 100%; }
            .container { padding: 3rem 1.5rem; }
            
            /* Carousel mobile adjustments */
            .carousel-nav {
                width: 45px;
                height: 45px;
                font-size: 1.8rem;
            }
            .carousel-prev {
                left: 0.5rem;
            }
            .carousel-next {
                right: 0.5rem;
            }
            .carousel-indicators {
                bottom: 0.75rem;
            }
            .carousel-indicators .indicator {
                width: 8px;
                height: 8px;
                border-width: 1px;
            }
            .carousel-indicators .indicator.active {
                width: 24px;
            }

            /* Hero slider mobile adjustments */
            .hero-carousel {
                height: 50vh !important; /* Shorter on mobile */
                margin-bottom: 2rem !important;
            }
            .sunlight-hero-slider .carousel-slide {
                min-height: 40vh !important; /* Shorter slides on mobile */
                padding: 2rem 1rem !important;
            }
            .sunlight-hero-slider .hero-forms-section {
                margin-top: 2rem !important;
                padding: 1rem !important;
            }
        }
        
        /* Hero Slider Forms Section */
        .sunlight-hero-slider .hero-forms-section {
            margin-top: 4rem;
            padding: 2rem 2rem 0;
            width: 100vw;
            max-width: none;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            margin-bottom: 4rem;
            position: relative;
            z-index: 3;
        }
        body.page-id-2 #masthead,
        body.page-id-2 .site-header,
        body.page-id-2 .entry-header,
        body.page-id-2 .entry-title,
        body.page-id-2 #wpadminbar,
        body.logged-in #wpadminbar { display: none !important; }
        
        /* Remove padding/margin from WordPress content wrappers */
        body.page-id-2 #content,
        body.page-id-2 .site-content,
        body.page-id-2 #primary,
        body.page-id-2 .content-area,
        body.page-id-2 .entry-content { 
            padding: 0 !important; 
            margin: 0 !important; 
        }
        body.page-id-2 .sunlight-about,
        body.page-id-2 .sunlight-gallery,
        body.page-id-2 .sunlight-video,
        body.page-id-2 .sunlight-signup,
        body.page-id-2 .sunlight-vision,
        body.page-id-2 .sunlight-footer {
            width: 100vw !important;
            margin-left: calc(50% - 50vw) !important;
            margin-right: calc(50% - 50vw) !important;
            padding: 5rem 2rem !important;
            box-sizing: border-box !important;
        }
        ";
    }

    private function get_inline_scripts() {
        $ajax_url = admin_url('admin-ajax.php');
        return "
        // Gallery tab switching function (global)
        function switchGalleryTab(event, tabName) {
            event.preventDefault();
            var buttons = document.querySelectorAll('.tab-button');
            var panes = document.querySelectorAll('.tab-pane');
            
            buttons.forEach(function(btn) {
                btn.classList.remove('active');
            });
            panes.forEach(function(pane) {
                pane.classList.remove('active');
            });
            
            event.currentTarget.classList.add('active');
            document.getElementById('gallery-' + tabName).style.display = 'block';
            document.getElementById('gallery-' + tabName).style.opacity = '1';
        }
        
        jQuery(document).ready(function(\$) {
            // Initialize - forms start hidden via CSS
            
            // Carousel Variables
            var currentSlide = 0;
            var totalSlides = 3;
            
            // Carousel Navigation Function (for old hero)
            function goToSlide(slideIndex) {
                // Hide all forms when switching slides
                \$('.hero-quick-signup').removeClass('show');
                \$('.hero-cta-toggle').removeClass('active');
                
                // Remove active class from all slides and indicators
                \$('.carousel-slide').removeClass('active');
                \$('.carousel-indicators .indicator').removeClass('active');
                
                // Add active class to current slide and indicator
                \$('.carousel-slide.slide-' + slideIndex).addClass('active');
                \$('.carousel-indicators .indicator').eq(slideIndex).addClass('active');
                
                currentSlide = slideIndex;
            }
            
            // Slider Navigation Function (for new hero_slider - forms stay active per slide)
            function goToSliderSlide(slideIndex) {
                // Hide all forms when switching slides
                \$('.sunlight-hero-slider .hero-quick-signup').removeClass('show');
                \$('.sunlight-hero-slider .hero-cta-toggle').removeClass('active');
                
                // Remove active class from all slides and indicators
                \$('.sunlight-hero-slider .carousel-slide').removeClass('active');
                \$('.sunlight-hero-slider .carousel-indicators .indicator').removeClass('active');
                
                // Add active class to current slide and indicator
                \$('.sunlight-hero-slider .carousel-slide.slide-' + slideIndex).addClass('active');
                \$('.sunlight-hero-slider .carousel-indicators .indicator').eq(slideIndex).addClass('active');
                
                currentSlide = slideIndex;
            }
            
            // Next Slide (old hero)
            \$('#carousel-next').on('click', function() {
                var nextSlide = (currentSlide + 1) % totalSlides;
                goToSlide(nextSlide);
            });
            
            // Previous Slide (old hero)
            \$('#carousel-prev').on('click', function() {
                var prevSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                goToSlide(prevSlide);
            });
            
            // Next Slide (new hero slider)
            \$('#slider-next').on('click', function() {
                var nextSlide = (currentSlide + 1) % totalSlides;
                goToSliderSlide(nextSlide);
            });
            
            // Previous Slide (new hero slider)
            \$('#slider-prev').on('click', function() {
                var prevSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                goToSliderSlide(prevSlide);
            });
            
            // Indicator Navigation (old hero)
            \$('.carousel-indicators .indicator').on('click', function() {
                var slideIndex = \$(this).index();
                goToSlide(slideIndex);
            });
            
            // Indicator Navigation (new hero slider)
            \$('.sunlight-hero-slider .carousel-indicators .indicator').on('click', function() {
                var slideIndex = \$(this).index();
                goToSliderSlide(slideIndex);
            });
            
            // Auto-play Carousel (slowed down to 15 seconds)
            var autoPlayInterval = setInterval(function() {
                var nextSlide = (currentSlide + 1) % totalSlides;
                goToSlide(nextSlide);
            }, 15000);
            
            // Auto-play Slider (for new hero slider)
            var sliderAutoPlayInterval = setInterval(function() {
                var nextSlide = (currentSlide + 1) % totalSlides;
                goToSliderSlide(nextSlide);
            }, 15000);
            
            // Pause auto-play on user interaction
            \$('.carousel-nav, .carousel-indicators .indicator').on('click', function() {
                clearInterval(autoPlayInterval);
                clearInterval(sliderAutoPlayInterval);
            });
            
            // Hero CTA Toggle - Rebuilt with simple class-based approach
            \$('.hero-cta-toggle').on('click', function(e) {
                e.preventDefault();
                
                var \$button = \$(this);
                var formId = \$button.data('form');
                var \$form = \$('#' + formId);
                
                // Close all other forms
                \$('.hero-quick-signup').not(\$form).removeClass('show');
                \$('.hero-cta-toggle').not(\$button).removeClass('active');
                
                // Toggle this form
                \$form.toggleClass('show');
                \$button.toggleClass('active');
            });
            
            // Hero Signup Forms - Handle all forms dynamically
            \$('.hero-signup-form').on('submit', function(e) {
                e.preventDefault();
                
                var \$thisForm = \$(this);
                var project = \$thisForm.find('input[name=project]').val();
                var nonceName = project === 'sunlight-tarot' ? 'tarot_signup_nonce' : 
                                (project === 'maze-chronicles' ? 'novels_signup_nonce' : 'game_signup_nonce');
                
                var formData = {
                    action: 'sunlight_signup',
                    nonce: \$thisForm.find('#' + nonceName).val(),
                    name: \$thisForm.find('input[name=name]').val(),
                    email: \$thisForm.find('input[name=email]').val(),
                    project: project,
                    consent: \$thisForm.find('input[name=consent]').is(':checked')
                };
                
                \$.ajax({
                    url: '{$ajax_url}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            var projectName = project === 'sunlight-tarot' ? 'Sunlight Tarot' : 
                                            (project === 'maze-chronicles' ? 'Maze Chronicles' : 'The Maze Game');
                            var emoji = project === 'sunlight-tarot' ? '✨' : 
                                       (project === 'maze-chronicles' ? '📚' : '🎮');
                            
                            \$thisForm.closest('.hero-quick-signup').html('<div class=\"signup-success-message\" style=\"background:white;padding:2rem;border-radius:10px;text-align:center;border:2px solid #fdcb6e;\"><h3>' + emoji + ' Welcome to ' + projectName + '!</h3><p>' + response.data.message + '</p><p style=\"margin-top:1rem;font-size:0.9rem;\">Check your email for next steps.</p></div>');
                        } else {
                            alert('Error: ' + response.data.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            // Smooth scroll
            \$('a.smooth-scroll').on('click', function(e) {
                e.preventDefault();
                var target = \$(this).attr('href');
                \$('html, body').animate({
                    scrollTop: \$(target).offset().top - 50
                }, 800);
            });

            \$('#sunlight-signup-form').on('submit', function(e) {
                e.preventDefault();
                
                var formData = {
                    action: 'sunlight_signup',
                    nonce: \$('#signup_nonce').val(),
                    name: \$('#signup-name').val(),
                    email: \$('#signup-email').val(),
                    consent: \$('input[name=consent]').is(':checked')
                };
                
                \$.ajax({
                    url: '{$ajax_url}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            \$('.signup-form').fadeOut(function() {
                                \$('.signup-success').fadeIn();
                            });
                        } else {
                            \$('.form-message').text(response.data.message).css({color: 'red', background: '#ffe0e0', display: 'block'});
                        }
                    },
                    error: function() {
                        \$('.form-message').text('An error occurred. Please try again.').css({color: 'red', background: '#ffe0e0', display: 'block'});
                    }
                });
            });
        });
        ";
    }
}
