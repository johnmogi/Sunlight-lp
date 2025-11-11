# CTA Slider Plugin

Clean, simple MVC plugin for a 3-slide carousel with form submissions.

## Structure

```
cta/
├── cta.php                          # Main plugin file
├── src/
│   ├── Controller/
│   │   └── SliderController.php     # Handles shortcode & assets
│   ├── Model/
│   │   ├── Slide.php                # Slide data object
│   │   └── SlideConfig.php          # Slide configuration
│   ├── Service/
│   │   └── SubmissionService.php    # CPT & AJAX handler
│   └── View/
│       └── slider.php               # Template
└── assets/
    ├── slider.css                   # Styles
    └── slider.js                    # JavaScript
```

## Usage

Add the shortcode to any page:

```
[cta_slider]
```

## Features

- 3 slides with prev/next navigation
- Click button to reveal form
- Form submissions saved to CPT `cta_submission`
- AJAX form handling
- Clean MVC architecture

## Submissions

View submissions in WordPress admin under "CTA Submissions"
