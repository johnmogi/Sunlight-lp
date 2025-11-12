<?php
namespace LanguageSwitcher\Config;

class Languages
{
    public static function all(): array
    {
        return [
            [
                'code' => 'en',
                'label' => 'English',
                'locale' => 'en_US',
                'rtl' => false,
            ],
            [
                'code' => 'fr',
                'label' => 'Français',
                'locale' => 'fr_FR',
                'rtl' => false,
            ],
            [
                'code' => 'es',
                'label' => 'Español',
                'locale' => 'es_ES',
                'rtl' => false,
            ],
            [
                'code' => 'he',
                'label' => 'עברית',
                'locale' => 'he_IL',
                'rtl' => true,
            ],
        ];
    }
}
