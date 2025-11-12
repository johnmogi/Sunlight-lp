<?php
namespace LanguageSwitcher\Support;

use LanguageSwitcher\Config\Languages;

class Context
{
    private static string $currentCode = 'en';
    private static string $currentLocale = 'en_US';
    private static bool $booted = false;
    private static bool $currentRtl = false;

    public static function boot(): void
    {
        if (self::$booted) {
            return;
        }

        self::$booted = true;

        $languages = Languages::all();
        $default = $languages[0] ?? ['code' => 'en', 'locale' => 'en_US'];

        $requested = isset($_GET['lang']) ? sanitize_key(wp_unslash($_GET['lang'])) : null;

        $selected = self::findByCode($requested, $languages);

        if (!$selected) {
            $locale = function_exists('determine_locale') ? determine_locale() : get_locale();
            $selected = self::findByLocale($locale, $languages);
        }

        if (!$selected) {
            $selected = $default;
        }

        self::$currentCode = $selected['code'] ?? $default['code'];
        self::$currentLocale = $selected['locale'] ?? $default['locale'];
        self::$currentRtl = (bool)($selected['rtl'] ?? false);
    }

    public static function currentCode(): string
    {
        return self::$currentCode;
    }

    public static function currentLocale(): string
    {
        return self::$currentLocale;
    }

    public static function isRtl(): bool
    {
        return self::$currentRtl;
    }

    public static function supportedCodes(): array
    {
        return array_map(static fn ($language) => $language['code'] ?? null, Languages::all());
    }

    private static function findByCode(?string $code, array $languages): ?array
    {
        if (!$code) {
            return null;
        }

        foreach ($languages as $language) {
            if (($language['code'] ?? null) === $code) {
                return $language;
            }
        }

        return null;
    }

    private static function findByLocale(?string $locale, array $languages): ?array
    {
        if (!$locale) {
            return null;
        }

        foreach ($languages as $language) {
            if (($language['locale'] ?? null) === $locale) {
                return $language;
            }

            $code = $language['code'] ?? '';
            if ($code && strpos($locale, $code) === 0) {
                return $language;
            }
        }

        return null;
    }
}
