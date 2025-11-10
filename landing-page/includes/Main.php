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
        add_shortcode('sunlight_hero', [$this, 'hero_shortcode']);
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

    public function hero_shortcode($atts) {
        $atts = shortcode_atts(array(
            'bg_image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'
        ), $atts);
        
        $bg_style = !empty($atts['bg_image']) ? 'background-image: url(' . esc_url($atts['bg_image']) . ');' : '';
        
        ob_start();
        ?>
        <section class="sunlight-hero" id="hero" style="<?php echo $bg_style; ?>">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <div class="hero-brand">
                    <span class="hero-pre-title">✨ The Evolution of Tarot</span>
                    <h1 class="hero-title">Sunlight Tarot</h1>
                    <h2 class="hero-subtitle-main">A New Light on the Tarot Tradition</h2>
                </div>
                
                <div class="hero-description-block">
                    <p class="hero-description">Not a tool for fortune-telling.<br>
                    A living map of consciousness — science, soul, and art entwined.</p>
                    <p class="hero-subtext">Reimagining the Tarot as a bridge between mysticism and modern understanding. Join us at the beginning of something luminous.</p>
                </div>
                
                <div class="hero-cta-container">
                    <button class="hero-cta-toggle" id="hero-cta-toggle">
                        <span class="cta-icon">✨</span>
                        <span class="cta-text">I Want to Participate</span>
                        <span class="cta-arrow">▼</span>
                    </button>
                    
                    <div class="hero-quick-signup" id="hero-quick-signup" style="opacity: 0 !important; visibility: hidden !important; transform: translateY(-10px) !important;">
                        <div class="signup-header">
                            <h3>Join the Sunlight Project</h3>
                            <p>Early access to artwork, updates, and community</p>
                        </div>
                        <form class="quick-signup-form" id="hero-signup-form">
                            <?php wp_nonce_field('sunlight_signup_nonce', 'hero_signup_nonce'); ?>
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
                                    <span>I agree to receive occasional updates about the project.</span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="hero-scroll-hint">
                    <span>↓</span>
                    <p>Discover the Vision</p>
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
                    <span class="section-label">The Beginning</span>
                    <h2 class="section-title">What Is the Sunlight Project?</h2>
                    <p class="section-lead">A creative evolution of the Tarot — reimagined for the modern seeker.</p>
                </div>
                
                <div class="about-grid">
                    <div class="about-card">
                        <div class="card-icon">🌅</div>
                        <h3>A Bridge Between Worlds</h3>
                        <p>The Sunlight Project reimagines the Tarot as a bridge between mysticism and modern understanding. But it's more than cards — it's a complete universe of storytelling, play, and transformation.</p>
                    </div>
                    
                    <div class="about-card">
                        <div class="card-icon">📚</div>
                        <h3>Four Novels, One Journey</h3>
                        <p>At the heart of the project are four interconnected novels, beginning with <em>The Boring Field Guide to Fantastic Multidimensional Portals</em> by Adam Douglas. Each book explores consciousness, transformation, and the magic hidden in everyday reality.</p>
                    </div>
                    
                    <div class="about-card">
                        <div class="card-icon">🎮</div>
                        <h3>Play, Explore, Transform</h3>
                        <p>The Sunlight universe includes both a digital game and a tabletop experience. Each game mechanic reflects the tarot's philosophy: choices matter, consciousness expands, and every path leads to awakening.</p>
                    </div>
                    
                    <div class="about-card">
                        <div class="card-icon">💫</div>
                        <h3>Continuing a Legacy</h3>
                        <p>Inspired by the revolutionary spirit of Osho and Eileen Connolly, we continue their legacy: breaking conventions, opening hearts, and bringing light to shadow. This is Tarot as meditation, art, and awakening.</p>
                    </div>
                </div>
                
                <div class="about-quote">
                    <blockquote>
                        "The Tarot is not about knowing the future. It's about understanding the now."
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
        body.sunlight-landing-page { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; line-height: 1.6; color: #2d3436; overflow-x: hidden; }
        
        /* AGGRESSIVE FULL WIDTH OVERRIDE */
        html, body, body.sunlight-landing-page, body.page-id-2 {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden !important;
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
            padding: 0 4rem;
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

        /* Hero Section - Enhanced Full Width */
        .sunlight-hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 50%, #e17055 100%);
            background-size: cover;
            background-position: center;
            color: #2d3436;
            text-align: center;
            width: 100vw !important;
            margin-left: calc(50% - 50vw) !important;
            margin-right: calc(50% - 50vw) !important;
            padding: 2rem !important;
            box-sizing: border-box !important;
        }
        .hero-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.35); z-index: 1; }
        .hero-pre-title { display: inline-block; font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; background: rgba(255,255,255,0.95); color: #2d3436; padding: 0.5rem 1.5rem; border-radius: 25px; }
        .hero-title { font-size: clamp(2.5rem, 6vw, 4.5rem); margin-bottom: 0.5rem; font-weight: 800; text-shadow: 3px 3px 8px rgba(0,0,0,0.5), 0 0 20px rgba(255,255,255,0.3); color: #fff; }
        .hero-subtitle-main { font-size: clamp(1.5rem, 3vw, 2.5rem); margin-bottom: 1.5rem; font-weight: 300; font-style: italic; text-shadow: 2px 2px 6px rgba(0,0,0,0.5); color: #fff; }
        .hero-description-block { background: rgba(255,255,255,0.9); padding: 1.5rem 2rem; border-radius: 15px; margin: 2rem auto; max-width: 700px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); }
        .hero-description { font-size: clamp(1.1rem, 2.5vw, 1.5rem); margin-bottom: 1rem; line-height: 1.6; font-weight: 500; color: #2d3436; }
        .hero-subtext { font-size: clamp(1rem, 2vw, 1.2rem); margin-bottom: 0; color: #636e72; max-width: 700px; margin-left: auto; margin-right: auto; }
        
        /* Hero CTA Container */
        .hero-cta-container { margin: 2rem 0; }
        .hero-cta-toggle { padding: 1.2rem 3rem; background: #2d3436; color: #ffeaa7; border: none; border-radius: 50px; font-size: 1.3rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 5px 20px rgba(0,0,0,0.3); }
        .hero-cta-toggle:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.4); background: #1a1a1a; }
        
        /* Quick Signup Form */
        .hero-quick-signup {
            margin-top: 1.5rem;
            background: rgba(255,255,255,0.95) !important;
            padding: 2rem !important;
            border-radius: 15px !important;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2) !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            z-index: 1000 !important;
        }
        .signup-header { margin-bottom: 1.5rem; }
        .signup-header h3 { font-size: 1.8rem; margin-bottom: 0.5rem; color: #2d3436; }
        .signup-header p { color: #636e72; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .quick-signup-form .form-row { display: flex; gap: 1rem; max-width: 700px; margin: 0 auto; flex-wrap: nowrap; align-items: center; direction: ltr; }
        .quick-signup-form input { flex: 1; min-width: 150px; padding: 1rem 1.5rem; border: 2px solid #dfe6e9; background: #fff; border-radius: 50px; font-size: 1rem; transition: all 0.3s ease; }
        .quick-signup-form input:focus { outline: none; border-color: #fdcb6e; box-shadow: 0 0 0 3px rgba(253,203,110,0.2); }
        .quick-join-btn { padding: 1rem 2.5rem; background: #2d3436; color: #ffeaa7; border: none; border-radius: 50px; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; white-space: nowrap; }
        .quick-join-btn:hover { background: #1a1a1a; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .form-footer { margin-top: 1rem; text-align: left; }
        .consent-label { display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; color: #636e72; cursor: pointer; direction: ltr; text-align: left; }
        .signup-benefits { display: none; }
        .consent-label input[type=checkbox] { width: 18px; height: 18px; cursor: pointer; }
        
        /* Hero Scroll Hint */
        .hero-scroll-hint { margin-top: 3rem; opacity: 0.7; animation: bounce 2s infinite; }
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
            .hero-content { padding: 0 1rem; }
            .hero-description-block { padding: 1rem 1.5rem; }
            .hero-cta-toggle { font-size: 1.1rem; padding: 1rem 2rem; }
            .hero-quick-signup { padding: 1.5rem; }
            .signup-header h3 { font-size: 1.4rem; }
            .quick-signup-form .form-row { flex-wrap: wrap; }
            .quick-signup-form input { min-width: 100%; }
            .quick-join-btn { width: 100%; }
            .container { padding: 3rem 1.5rem; }
        }
        
        /* Full Width Override for WordPress Containers */
        .sunlight-landing-page .entry-content,
        .sunlight-landing-page .site-content,
        .sunlight-landing-page .ast-container { max-width: 100% !important; padding: 0 !important; margin: 0 !important; }
        
        /* Hide WordPress Header and Page Title on Sample Page */
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
            max-width: none !important;
            width: 100vw !important;
        }
        
        /* Override Astra container constraints */
        body.page-id-2 .ast-container,
        .sunlight-landing-page .entry-content,
        .sunlight-landing-page .site-content,
        .sunlight-landing-page .ast-container {
            max-width: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100vw !important;
        }
        
        /* Ensure all sections span full width and are centered */
        body.page-id-2 .sunlight-hero,
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
            document.getElementById('gallery-' + tabName).classList.add('active');
        }
        
        jQuery(document).ready(function(\$) {
            console.log('Sunlight Project scripts loaded');
            
            // Hero CTA Toggle
            \$('#hero-cta-toggle').on('click', function(e) {
                e.preventDefault();
                console.log('Toggle button clicked');
                
                var \$signup = \$('#hero-quick-signup');
                var \$arrow = \$(this).find('.cta-arrow');
                
                console.log('Signup element found:', \$signup.length);
                console.log('Current style attribute:', \$signup.attr('style'));
                
                // Check if form is currently visible (has opacity: 1 in style)
                var isVisible = \$signup.attr('style') && \$signup.attr('style').indexOf('opacity: 1') !== -1;
                
                if (!isVisible) {
                    console.log('Showing form...');
                    \$signup.attr('style', 'opacity: 1 !important; visibility: visible !important; transform: translateY(0) !important; display: block !important;');
                    \$(this).addClass('active');
                    \$arrow.css('transform', 'rotate(180deg)');
                } else {
                    console.log('Hiding form...');
                    \$signup.attr('style', 'opacity: 0 !important; visibility: hidden !important; transform: translateY(-10px) !important;');
                    \$(this).removeClass('active');
                    \$arrow.css('transform', 'rotate(0deg)');
                }
                
                console.log('After toggle - opacity:', \$signup.css('opacity'));
                console.log('After toggle - visibility:', \$signup.css('visibility'));
            });
            
            // Hero Quick Signup Form
            \$('#hero-signup-form').on('submit', function(e) {
                e.preventDefault();
                
                var formData = {
                    action: 'sunlight_signup',
                    nonce: \$('#hero_signup_nonce').val(),
                    name: \$(this).find('input[name=name]').val(),
                    email: \$(this).find('input[name=email]').val(),
                    consent: true
                };
                
                \$.ajax({
                    url: '{$ajax_url}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            \$('#hero-quick-signup').html('<div class=\"signup-success-message\" style=\"background:white;padding:2rem;border-radius:10px;text-align:center;border:2px solid #fdcb6e;\"><h3>✨ Welcome to the Journey!</h3><p>' + response.data.message + '</p><p style=\"margin-top:1rem;font-size:0.9rem;\">Check your email for next steps.</p></div>');
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
