# Sunlight Project - Must-Use Plugins

This folder contains WordPress Must-Use (MU) plugins for the Sunlight Project website.

## 🚀 Landing Page Plugin

### Overview
The landing page plugin provides a beautiful, full-width, interactive landing page for the Sunlight Project - a modern Tarot deck reimagining.

### Features
- **Full-Width Design**: Breaks out of WordPress theme constraints for immersive experience
- **LTR Text Direction**: Forces left-to-right text flow regardless of theme settings
- **Hidden WordPress UI**: Removes header, footer, and admin bar for clean presentation
- **Interactive Signup Form**: Toggle-able form with smooth animations
- **Responsive Layout**: Works perfectly on desktop and mobile devices
- **Professional Design**: Gradient backgrounds, smooth transitions, and modern UI elements

### File Structure
```
mu-plugins/
├── README.md                    # This file
├── mu-loader.php               # Plugin loader
└── landing-page/
    ├── README.md               # Plugin-specific documentation
    ├── USAGE.md                # Usage instructions
    ├── bootstrap.php           # Plugin bootstrap
    ├── includes/Main.php       # Main plugin class
    └── templates/
        └── landing-page.php    # Page template
```

### Installation
1. Copy the `landing-page` folder to your WordPress `wp-content/mu-plugins/` directory
2. Ensure `mu-loader.php` is in the `mu-plugins` root directory
3. Create a WordPress page with the slug `sample-page` (or modify the `is_landing_page()` method in `Main.php`)
4. The landing page will automatically load when visiting that page

### Customization
- **Content**: Edit the shortcode methods in `Main.php` to modify text and sections
- **Styling**: Modify the CSS in the `get_inline_styles()` method
- **JavaScript**: Update interactions in the `get_inline_scripts()` method
- **Layout**: Adjust the HTML structure in the various shortcode methods

### Shortcodes Available
- `[sunlight_hero]` - Hero section with toggle button and signup form
- `[sunlight_about]` - About section with feature cards
- `[sunlight_gallery]` - Interactive gallery with tabs
- `[sunlight_video]` - Video section (supports YouTube embed)
- `[sunlight_signup]` - Standalone signup form
- `[sunlight_vision]` - Vision section and footer
- `[sunlight_full_page]` - Complete landing page

### Dependencies
- WordPress 5.0+
- PHP 7.4+
- jQuery (included with WordPress)

### Browser Support
- Chrome/Edge 88+
- Firefox 85+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📧 Contact
For questions about the Sunlight Project, visit [sunlightproject.com](https://sunlightproject.com)

## 📄 License
This plugin is part of the Sunlight Project and is provided as-is for use with the project website.
