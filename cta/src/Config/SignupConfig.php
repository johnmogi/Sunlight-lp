<?php
namespace CTA\Config;

class SignupConfig
{
    private static array $content = [
        'en' => [
            'label' => 'Join the Circle',
            'title' => 'Be Part of the Creation',
            'lead' => 'Leave your details to receive art reveals, story chapters, and invitations to early play sessions. No noise — only light.',
            'bullet_points' => [
                'First look at new Tarot artwork and symbolism reveals',
                'Invitations to closed Scroll Maze playtests and salons',
                'Opportunities to contribute to music, story, and game design',
            ],
            'privacy' => 'We respect your time and your inbox. Expect only meaningful updates, never spam.'
        ],
        'fr' => [
            'label' => 'Rejoignez le cercle',
            'title' => 'Participez à la création',
            'lead' => 'Laissez-nous vos coordonnées pour recevoir des révélations artistiques, des chapitres d’histoire et des invitations aux sessions anticipées. Aucun bruit — uniquement de la lumière.',
            'bullet_points' => [
                'Aperçu exclusif des nouvelles œuvres et symboles du Tarot',
                'Invitations aux playtests privés du Scroll Maze et aux salons',
                'Occasions de contribuer à la musique, à l’histoire et au game design',
            ],
            'privacy' => 'Nous respectons votre temps et votre boîte de réception. Attendez-vous à des messages précieux, jamais du spam.'
        ],
        'es' => [
            'label' => 'Únete al círculo',
            'title' => 'Forma parte de la creación',
            'lead' => 'Déjanos tus datos para recibir revelaciones artísticas, capítulos de la historia e invitaciones a sesiones tempranas. Sin ruido — solo luz.',
            'bullet_points' => [
                'Primer vistazo a las nuevas ilustraciones y símbolos del Tarot',
                'Invitaciones a pruebas cerradas de Scroll Maze y encuentros privados',
                'Oportunidades para contribuir a la música, la historia y el diseño del juego',
            ],
            'privacy' => 'Respetamos tu tiempo y tu bandeja de entrada. Solo recibirás actualizaciones significativas, nunca spam.'
        ],
        'he' => [
            'label' => 'הצטרפו למעגל',
            'title' => 'היו חלק מהיצירה',
            'lead' => 'השאירו פרטים כדי לקבל חשיפות אמנות, פרקי סיפור והזמנות למפגשי משחק מוקדמים. ללא רעש — רק אור.',
            'bullet_points' => [
                'הצצה ראשונה לאמנות החדשה ולסמלי הטארוט',
                'הזמנות למשחקי ניסיון סגורים של Scroll Maze ולמפגשי סלון',
                'הזדמנויות לתרום למוזיקה, לסיפור ולעיצוב המשחק',
            ],
            'privacy' => 'אנחנו מכבדים את זמנכם ואת תיבת הדואר שלכם. רק עדכונים משמעותיים, לעולם לא ספאם.'
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
