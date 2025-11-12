<?php
namespace CTA\Model;

class SlideConfig {
    private static array $slides = [
        'en' => [
            1 => [
                'id' => 1,
                'title' => '✨ Sunlight Tarot Deck',
                'description' => 'An open-source tarot deck in development. Leave your email to stay updated on progress and the upcoming Kickstarter launch. No spam, no sharing your info—just updates on this meaningful project.',
                'button' => 'Keep Me Updated',
                'form' => [
                    'name_placeholder' => 'Your Name',
                    'email_placeholder' => 'Your Email',
                    'submit_label' => 'Submit',
                ],
            ],
            2 => [
                'id' => 2,
                'title' => '📜 Scroll Maze Novel',
                'description' => 'Diary of a Wimpy Kid meets Terry Pratchett meets The NeverEnding Story. A kid recreates the world through his rich imagination, exploring science and spirituality. First chapter: "Adam\'s Boring Guide to Practical Paradoxical Fantastical Parallel Dimensions." Hand-built, crowdfunded, and destined to become a game.',
                'button' => 'Get Early Access',
                'form' => [
                    'name_placeholder' => 'Your Name',
                    'email_placeholder' => 'Your Email',
                    'submit_label' => 'Submit',
                ],
            ],
            3 => [
                'id' => 3,
                'title' => '🎮 Scroll Maze Game',
                'description' => 'Coming soon: the interactive game based on Scroll Maze. Where imagination becomes reality and every choice reshapes the world. Join the journey from novel to game.',
                'button' => 'Join the Adventure',
                'form' => [
                    'name_placeholder' => 'Your Name',
                    'email_placeholder' => 'Your Email',
                    'submit_label' => 'Submit',
                ],
            ],
        ],
        'fr' => [
            1 => [
                'title' => '✨ Jeu de Tarot Sunlight',
                'description' => 'Un jeu de tarot open source en développement. Laissez votre email pour recevoir les mises à jour et l’annonce du Kickstarter. Aucun spam — uniquement des nouvelles de ce projet lumineux.',
                'button' => 'Tenez-moi informé·e',
                'form' => [
                    'name_placeholder' => 'Votre nom',
                    'email_placeholder' => 'Votre e-mail',
                    'submit_label' => 'Envoyer',
                ],
            ],
            2 => [
                'title' => '📜 Roman Scroll Maze',
                'description' => 'Diary of a Wimpy Kid rencontre Terry Pratchett et L’Histoire sans fin. Un enfant recrée le monde grâce à son imagination, explorant science et spiritualité. Chapitre un : « Guide pratique (et paradoxal) des dimensions parallèles fantastiques » d’Adam.',
                'button' => 'Accès anticipé',
                'form' => [
                    'name_placeholder' => 'Votre nom',
                    'email_placeholder' => 'Votre e-mail',
                    'submit_label' => 'Envoyer',
                ],
            ],
            3 => [
                'title' => '🎮 Jeu Scroll Maze',
                'description' => 'Bientôt : l’expérience interactive inspirée de Scroll Maze. Là où l’imagination devient réalité et chaque choix transforme le monde. Rejoignez le voyage.',
                'button' => 'Rejoindre l’aventure',
                'form' => [
                    'name_placeholder' => 'Votre nom',
                    'email_placeholder' => 'Votre e-mail',
                    'submit_label' => 'Envoyer',
                ],
            ],
        ],
        'es' => [
            1 => [
                'title' => '✨ Baraja Sunlight Tarot',
                'description' => 'Un mazo de tarot de código abierto en desarrollo. Deja tu correo para recibir avances y el anuncio del próximo Kickstarter. Sin spam, solo noticias significativas.',
                'button' => 'Manténme al tanto',
                'form' => [
                    'name_placeholder' => 'Tu nombre',
                    'email_placeholder' => 'Tu correo electrónico',
                    'submit_label' => 'Enviar',
                ],
            ],
            2 => [
                'title' => '📜 Novela Scroll Maze',
                'description' => 'Diary of a Wimpy Kid se encuentra con Terry Pratchett y La historia interminable. Un niño recrea el mundo con su imaginación, explorando ciencia y espiritualidad. Capítulo uno: “La guía aburrida de Adam sobre dimensiones fantásticas y paradójicas.”',
                'button' => 'Acceso anticipado',
                'form' => [
                    'name_placeholder' => 'Tu nombre',
                    'email_placeholder' => 'Tu correo electrónico',
                    'submit_label' => 'Enviar',
                ],
            ],
            3 => [
                'title' => '🎮 Juego Scroll Maze',
                'description' => 'Próximamente: la experiencia interactiva basada en Scroll Maze. Donde la imaginación se hace realidad y cada decisión moldea el mundo. Únete a la travesía.',
                'button' => 'Únete a la aventura',
                'form' => [
                    'name_placeholder' => 'Tu nombre',
                    'email_placeholder' => 'Tu correo electrónico',
                    'submit_label' => 'Enviar',
                ],
            ],
        ],
        'he' => [
            1 => [
                'title' => '✨ חפיסת הטארוט Sunlight',
                'description' => 'חפיסת טארוט בקוד פתוח בפיתוח. השאירו אימייל כדי לקבל עדכונים והשקה קרובה ב-Head Start. בלי ספאם — רק חדשות משמעותיות על הפרויקט.',
                'button' => 'עדכנו אותי',
                'form' => [
                    'name_placeholder' => 'השם שלך',
                    'email_placeholder' => 'האימייל שלך',
                    'submit_label' => 'שליחה',
                ],
            ],
            2 => [
                'title' => '📜 רומן Scroll Maze',
                'description' => 'יומנו של חנון פוגש את טרי פראצ׳ט ואת הסיפור שאינו נגמר. ילד בורא מחדש את העולם דרך דמיון עשיר, חוקר מדע ורוח. פרק ראשון: "המדריך המשעמם של אדם לפרדוקסים מעשיים ולממדים פנטסטיים".',
                'button' => 'קבלו גישה מוקדמת',
                'form' => [
                    'name_placeholder' => 'השם שלך',
                    'email_placeholder' => 'האימייל שלך',
                    'submit_label' => 'שליחה',
                ],
            ],
            3 => [
                'title' => '🎮 משחק Scroll Maze',
                'description' => 'בקרוב: החוויה האינטראקטיבית המבוססת על Scroll Maze. המקום שבו הדמיון נהפך למציאות וכל בחירה מעצבת את העולם. הצטרפו למסע.',
                'button' => 'הצטרפו להרפתקה',
                'form' => [
                    'name_placeholder' => 'השם שלך',
                    'email_placeholder' => 'האימייל שלך',
                    'submit_label' => 'שליחה',
                ],
            ],
        ],
    ];

    public static function getSlides(?string $language = null): array {
        $language = self::resolveLanguage($language);

        $baseSlides = self::$slides['en'];
        $localizedSlides = self::$slides[$language] ?? [];

        $slides = [];

        foreach ($baseSlides as $id => $base) {
            $data = array_merge($base, $localizedSlides[$id] ?? []);

            $slides[] = new Slide(
                $data['id'],
                $data['title'],
                $data['description'],
                $data['button'],
                $data['form'] ?? []
            );
        }

        return $slides;
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

        return array_key_exists($language, self::$slides) ? $language : 'en';
    }
}
