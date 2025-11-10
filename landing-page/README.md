# Sunlight Landing Page Plugin

Complete landing page system for the Sunlight Tarot project.

## Features

✅ **Hero Section** - Full-screen hero with CTA button
✅ **About Section** - Project description and mission
✅ **Gallery with Tabs** - Image gallery with 4 tabs (The Deck, Concept Art, Inspiration, Symbols)
✅ **Video Section** - Embedded video support (YouTube, Vimeo, etc.)
✅ **Signup Form** - Email collection with WordPress user creation
✅ **Vision Section** - 5-item grid showcasing project universe
✅ **Footer** - Links and copyright information
✅ **Blank Header/Footer** - Clean, distraction-free landing page

## Usage

### Option 1: Full Page Shortcode
Create a new page in WordPress and add:
```
[sunlight_full_page]
```

### Option 2: Individual Sections
Build your own layout with individual shortcodes:
```
[sunlight_hero]
[sunlight_about]
[sunlight_gallery]
[sunlight_video url="https://youtube.com/watch?v=..."]
[sunlight_signup]
[sunlight_vision]
```

### Option 3: Custom Template
The plugin automatically applies a custom template to pages named "sunlight-project" or set as the front page.

## Customization

### Adding Gallery Images
Replace the placeholder divs in `Main.php` gallery section with:
```php
<div class="gallery-item">
    <img src="<?php echo esc_url('path/to/image.jpg'); ?>" alt="Description">
</div>
```

### Adding Video
Use the shortcode with a URL parameter:
```
[sunlight_video url="https://www.youtube.com/watch?v=YOUR_VIDEO_ID"]
```

### Styling
All styles are inline in the `get_inline_styles()` method. Modify colors, fonts, and layouts there.

## Email Signup

The signup form:
- Creates WordPress users automatically
- Stores consent in user meta
- Prevents duplicate signups
- Shows success/error messages
- Ready for mailing list integration (Mailchimp, etc.)

## File Structure

```
landing-page/
├── bootstrap.php           # Plugin entry point
├── includes/
│   └── Main.php           # All functionality
├── templates/
│   └── landing-page.php   # Custom page template
└── README.md              # This file
```

## Next Steps

1. Create a page called "Sunlight Project" in WordPress
2. Add `[sunlight_full_page]` shortcode
3. Upload images to replace placeholders
4. Add your video URL
5. Test the signup form
6. Customize colors and styling as needed

## Support

For customization or issues, edit `includes/Main.php` or contact the development team.
