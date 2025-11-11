# Hero CTA Slider - MVC Module

## Overview
Complete refactor of the hero slider shortcode into a clean MVC architecture.

## Structure

```
cta-slider/
├── Controller/
│   └── HeroSliderController.php    # Handles shortcode, assets, rendering
├── Model/
│   ├── HeroSlide.php                # Value object for slide data
│   └── HeroSliderConfig.php         # Slide configuration provider
├── Service/
│   └── HeroSignupService.php        # AJAX form submission handler
├── View/
│   └── hero-slider.php              # Clean template markup
└── assets/
    ├── css/
    │   └── hero-slider.css          # Extracted slider styles
    └── js/
        └── hero-slider.js           # Slider navigation & form logic
```

## Features

- **3 Slides**: Sunlight Tarot, Maze Chronicles, The Maze Game
- **CTA Forms**: Expandable signup forms per slide
- **Navigation**: Prev/Next arrows with auto-play (15s interval)
- **AJAX Submission**: Form submissions via `sunlight_hero_signup` action
- **Responsive**: Mobile-optimized layouts

## Usage

```php
[sunlight_hero_slider]
```

## Wiring

The controller is initialized in `bootstrap.php`:

```php
new \LandingPage\CTASlider\Controller\HeroSliderController();
```

## AJAX Endpoint

- **Action**: `sunlight_hero_signup`
- **Handler**: `HeroSignupService::handleSignup()`
- **Nonce**: `sunlight_signup_nonce`

## Customization

Edit slide data in `Model/HeroSliderConfig.php`:
- Titles, descriptions, CTAs
- Background gradients and images
- Project slugs and form IDs
