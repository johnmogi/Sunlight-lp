<?php
namespace CTA\Shortcode\Slider;

use CTA\Controller\SliderController;

class SliderShortcode
{
    private static bool $initialized = false;

    public function __construct()
    {
        if (self::$initialized) {
            return;
        }

        self::$initialized = true;

        if (class_exists(SliderController::class)) {
            new SliderController();
        }
    }
}
