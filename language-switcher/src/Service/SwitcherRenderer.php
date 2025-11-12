<?php
namespace LanguageSwitcher\Service;

use LanguageSwitcher\Config\Languages;

class SwitcherRenderer
{
    public static function render(string $context = 'menu'): string
    {
        $languages = Languages::all();
        $currentLocale = function_exists('determine_locale') ? determine_locale() : get_locale();
        $currentLanguage = self::resolveCurrentLanguage($languages, $currentLocale);
        $viewContext = $context;

        ob_start();
        include LANG_SWITCHER_DIR . '/src/View/switcher.php';
        return trim(ob_get_clean());
    }

    public static function generateLanguageUrl(array $language): string
    {
        $requestUri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '/';
        $currentUrl = home_url($requestUri);
        $currentUrl = remove_query_arg('lang', $currentUrl);

        $target = add_query_arg('lang', $language['code'] ?? '', $currentUrl);

        /**
         * Filter the generated language switcher URL.
         *
         * @param string $target
         * @param array $language
         */
        $target = apply_filters('language_switcher_url', $target, $language);

        return $target;
    }

    private static function resolveCurrentLanguage(array $languages, string $currentLocale): ?array
    {
        foreach ($languages as $language) {
            if (!empty($language['locale']) && $language['locale'] === $currentLocale) {
                return $language;
            }
            if (!empty($language['code']) && $language['code'] === substr($currentLocale, 0, 2)) {
                return $language;
            }
        }

        return $languages[0] ?? null;
    }
}
