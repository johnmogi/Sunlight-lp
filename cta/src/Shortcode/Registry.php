<?php
namespace CTA\Shortcode;

use CTA\Shortcode\About\AboutShortcode;
use CTA\Shortcode\Slider\SliderShortcode;
use CTA\Shortcode\Video\VideoShortcode;
use CTA\Shortcode\Gallery\GalleryShortcode;
use CTA\Shortcode\Signup\SignupShortcode;

class Registry
{
    public static function register(): void
    {
        new SliderShortcode();
        new AboutShortcode();
        new VideoShortcode();
        new GalleryShortcode();
        new SignupShortcode();
        // @todo register other shortcodes as they are implemented
    }
}
