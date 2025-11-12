<?php
namespace CTA\Config;

class AboutConfig
{
    private static array $content = [
        'en' => [
            'intro' => [
                'label' => 'Three Journeys, One Vision',
                'title' => 'The Sunlight Universe',
                'lead' => 'Where consciousness meets creativity through three interconnected experiences.'
            ],
            'cards' => [
                [
                    'icon' => '✨',
                    'title' => 'Sunlight Tarot',
                    'description' => 'A revolutionary reimagining of the Tarot — not for fortune-telling, but as a living map of consciousness. Each card is a bridge between mysticism and modern understanding, combining science, soul, and art into a transformative experience for the modern seeker.'
                ],
                [
                    'icon' => '📜',
                    'title' => 'Scroll Maze Novels',
                    'description' => 'Four interconnected novels beginning with <em>The Boring Field Guide to Practical Paradoxical Fantastical Parallel Dimensions</em>. A mind-bending literary journey where a young creator rebuilds reality through imagination, science, and spirit.'
                ],
                [
                    'icon' => '🎮',
                    'title' => 'Scroll Maze Game',
                    'description' => 'Both a tabletop and digital experience where consciousness is the game itself. Choices matter, consciousness expands, and every path leads to awakening. Strategy meets mysticism in an unforgettable journey.'
                ],
            ],
            'universe' => [
                'label' => 'One Connected Universe',
                'description' => 'Cards, stories, and games are facets of the same light. Inspired by innovators like Osho and Eileen Connolly, we continue their legacy—breaking conventions, opening hearts, and bringing light to shadow.'
            ],
            'quote' => [
                'text' => 'The Tarot is not about knowing the future. It\'s about understanding the now — through cards, stories, and play.'
            ],
        ],
        'fr' => [
            'intro' => [
                'label' => 'Trois voyages, une vision',
                'title' => 'L\'univers Sunlight',
                'lead' => '[FR] Placeholder intro text.'
            ],
            'cards' => [
                0 => [
                    'title' => 'Sunlight Tarot',
                    'description' => '[FR] Placeholder description for Sunlight Tarot.'
                ],
                1 => [
                    'title' => 'Romans Scroll Maze',
                    'description' => '[FR] Placeholder description for Scroll Maze novels.'
                ],
                2 => [
                    'title' => 'Jeu Scroll Maze',
                    'description' => '[FR] Placeholder description for Scroll Maze game.'
                ],
            ],
            'universe' => [
                'label' => 'Un univers connecté',
                'description' => '[FR] Placeholder universe description.'
            ],
            'quote' => [
                'text' => '[FR] Placeholder quote text.'
            ],
        ],
        'es' => [
            'intro' => [
                'label' => 'Tres viajes, una visión',
                'title' => 'El universo Sunlight',
                'lead' => '[ES] Texto de introducción de marcador.'
            ],
            'cards' => [
                0 => [
                    'title' => 'Sunlight Tarot',
                    'description' => '[ES] Descripción de marcador para Sunlight Tarot.'
                ],
                1 => [
                    'title' => 'Novelas Scroll Maze',
                    'description' => '[ES] Descripción de marcador para las novelas Scroll Maze.'
                ],
                2 => [
                    'title' => 'Juego Scroll Maze',
                    'description' => '[ES] Descripción de marcador para el juego Scroll Maze.'
                ],
            ],
            'universe' => [
                'label' => 'Un universo conectado',
                'description' => '[ES] Descripción de universo de marcador.'
            ],
            'quote' => [
                'text' => '[ES] Texto de cita de marcador.'
            ],
        ],
        'he' => [
            'intro' => [
                'label' => 'שלושה מסעות, חזון אחד',
                'title' => 'יקום Sunlight',
                'lead' => '[HE] טקסט פתיח זמני.'
            ],
            'cards' => [
                0 => [
                    'title' => 'חפיסת Sunlight Tarot',
                    'description' => '[HE] תיאור זמני לחפיסת הטארוט.'
                ],
                1 => [
                    'title' => 'רומנים של Scroll Maze',
                    'description' => '[HE] תיאור זמני לרומני Scroll Maze.'
                ],
                2 => [
                    'title' => 'משחק Scroll Maze',
                    'description' => '[HE] תיאור זמני למשחק Scroll Maze.'
                ],
            ],
            'universe' => [
                'label' => 'יקום מחובר אחד',
                'description' => '[HE] תיאור זמני של היקום.'
            ],
            'quote' => [
                'text' => '[HE] טקסט ציטוט זמני.'
            ],
        ],
    ];

    public static function getIntro(?string $language = null): array
    {
        $language = self::resolveLanguage($language);
        return array_merge(self::$content['en']['intro'], self::$content[$language]['intro'] ?? []);
    }

    public static function getCards(?string $language = null): array
    {
        $language = self::resolveLanguage($language);
        $base = self::$content['en']['cards'];
        $overrides = self::$content[$language]['cards'] ?? [];

        $cards = [];
        foreach ($base as $index => $card) {
            $cards[] = array_merge($card, $overrides[$index] ?? []);
        }

        return $cards;
    }

    public static function getUniverse(?string $language = null): array
    {
        $language = self::resolveLanguage($language);
        return array_merge(self::$content['en']['universe'], self::$content[$language]['universe'] ?? []);
    }

    public static function getQuote(?string $language = null): array
    {
        $language = self::resolveLanguage($language);
        return array_merge(self::$content['en']['quote'], self::$content[$language]['quote'] ?? []);
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
