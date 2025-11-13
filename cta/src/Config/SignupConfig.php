<?php
namespace CTA\Config;

class SignupConfig
{
    private static array $content = [
        'en' => [
            'label' => '✨ Newsletter',
            'title' => 'Join the Sunlight Tarot Journey',
            'lead' => 'Be the first to explore our open-source tarot deck and follow its creation from concept to Kickstarter launch. Sign up with your email for exclusive updates, behind-the-scenes peeks, and early access offers. No spam—just meaningful insights into the deck and its magic.',
            'button' => 'Subscribe & Stay Inspired',
            'privacy' => 'We respect your inbox. Unsubscribe anytime.'
        ],
        'fr' => [
            'label' => '✨ Newsletter',
            'title' => 'Rejoignez l\'aventure Sunlight Tarot',
            'lead' => 'Soyez parmi les premiers à découvrir notre jeu de tarot open-source et suivez sa création du concept au lancement Kickstarter. Inscrivez-vous avec votre email pour des mises à jour exclusives, des aperçus en coulisses et des offres d\'accès anticipé. Pas de spam—seulement des informations significatives sur le jeu et sa magie.',
            'button' => 'S\'abonner et rester inspiré',
            'privacy' => 'Nous respectons votre boîte de réception. Désabonnez-vous à tout moment.'
        ],
        'es' => [
            'label' => '✨ Newsletter',
            'title' => 'Únete al viaje de Sunlight Tarot',
            'lead' => 'Sé de los primeros en explorar nuestro mazo de tarot de código abierto y sigue su creación desde el concepto hasta el lanzamiento en Kickstarter. Regístrate con tu email para actualizaciones exclusivas, vistazos detrás de escena y ofertas de acceso anticipado. Sin spam—solo información significativa sobre el mazo y su magia.',
            'button' => 'Suscríbete y mantente inspirado',
            'privacy' => 'Respetamos tu bandeja de entrada. Cancela en cualquier momento.'
        ],
        'he' => [
            'label' => '✨ ניוזלטר',
            'title' => 'הצטרפו למסע Sunlight Tarot',
            'lead' => 'היו הראשונים לחקור את חפיסת הטארוט בקוד פתוח שלנו ולעקוב אחר יצירתה מהרעיון ועד להשקה ב-Kickstarter. הירשמו עם האימייל שלכם לעדכונים בלעדיים, הצצות מאחורי הקלעים והצעות גישה מוקדמת. ללא ספאם—רק תובנות משמעותיות על החפיסה והקסם שלה.',
            'button' => 'הירשמו והישארו בהשראה',
            'privacy' => 'אנחנו מכבדים את תיבת הדואר שלכם. בטלו את המנוי בכל עת.'
        ],
    ];

    public static function getContent(?string $language = null): array
    {
        $language = self::resolveLanguage($language);

        $base = self::$content['en'];

        if ($language === 'en') {
            return $base;
        }

        return array_replace_recursive($base, self::$content[$language] ?? []);
    }

    private static function resolveLanguage(?string $language): string
    {
        if ($language) {
            return self::normalize($language);
        }

        if (class_exists('LanguageSwitcher\\Support\\Context')) {
            return self::normalize(\LanguageSwitcher\Support\Context::currentCode());
        }

        $requested = isset($_GET['lang']) ? sanitize_key(wp_unslash($_GET['lang'])) : '';

        return self::normalize($requested);
    }

    private static function normalize(?string $language): string
    {
        if (!$language) {
            return 'en';
        }

        $language = strtolower($language);

        return array_key_exists($language, self::$content) ? $language : 'en';
    }
}
