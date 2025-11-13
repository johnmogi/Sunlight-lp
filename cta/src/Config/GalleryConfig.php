<?php
namespace CTA\Config;

class GalleryConfig
{
    private static array $translations = [
        'en' => [
            'feedback' => [],
        ],
        'fr' => [
            'intro' => [
                'label' => 'Voyage visuel',
                'title' => 'L’univers en images',
                'lead' => '[FR] Texte de présentation temporaire pour la galerie.'
            ],
            'feedback' => [
                'button_label' => 'Partager votre avis',
                'modal_title' => 'Donnez votre ressenti',
                'rating_label' => 'Notez cette image',
                'reaction_label' => 'Quelle émotion vous inspire-t-elle ?',
                'comment_label' => 'Laissez un commentaire (optionnel)',
                'name_label' => 'Nom (optionnel)',
                'email_label' => 'Email (optionnel)',
                'submit_label' => 'Envoyer',
                'success_message' => 'Merci pour votre contribution !',
                'error_message' => 'Impossible d’enregistrer votre avis. Réessayez.',
                'throttle_message' => 'Vous avez déjà envoyé un avis récemment. Réessayez plus tard.',
                'reaction_required' => 'Choisissez une réaction.',
                'rating_required' => 'Sélectionnez une note.',
                'reactions' => [
                    'like' => ['label' => 'J’aime', 'icon' => '👍'],
                    'love' => ['label' => 'Coup de cœur', 'icon' => '❤️'],
                    'dislike' => ['label' => 'Je n’aime pas', 'icon' => '👎'],
                ],
            ],
            'tabs' => [
                'deck' => [
                    'label' => 'Le deck',
                    'title' => '[FR] Titre de section temporaire',
                    'description' => '[FR] Description temporaire du deck Sunlight.'
                ],
                'concept' => [
                    'label' => 'Concept art',
                    'title' => '[FR] Coulisses créatives',
                    'description' => '[FR] Description temporaire pour le concept art.'
                ],
                'inspiration' => [
                    'label' => 'Inspiration',
                    'title' => '[FR] Sources mythiques',
                    'description' => '[FR] Description temporaire des inspirations.'
                ],
                'symbols' => [
                    'label' => 'Symboles',
                    'title' => '[FR] Langage visuel',
                    'description' => '[FR] Description temporaire des symboles.'
                ],
            ],
        ],
        'es' => [
            'intro' => [
                'label' => 'Recorrido visual',
                'title' => 'El universo en imágenes',
                'lead' => '[ES] Texto introductorio provisional para la galería.'
            ],
            'feedback' => [
                'button_label' => 'Comparte tu opinión',
                'modal_title' => 'Cuéntanos qué sientes',
                'rating_label' => 'Califica esta imagen',
                'reaction_label' => '¿Qué emoción te genera?',
                'comment_label' => 'Deja un comentario (opcional)',
                'name_label' => 'Nombre (opcional)',
                'email_label' => 'Correo (opcional)',
                'submit_label' => 'Enviar',
                'success_message' => '¡Gracias por tu aporte!',
                'error_message' => 'No pudimos guardar tu opinión. Intenta de nuevo.',
                'throttle_message' => 'Ya enviaste una opinión recientemente. Intenta más tarde.',
                'reaction_required' => 'Elige una reacción.',
                'rating_required' => 'Selecciona una calificación.',
                'reactions' => [
                    'like' => ['label' => 'Me gusta', 'icon' => '👍'],
                    'love' => ['label' => 'Me encanta', 'icon' => '❤️'],
                    'dislike' => ['label' => 'No me gusta', 'icon' => '👎'],
                ],
            ],
            'tabs' => [
                'deck' => [
                    'label' => 'La baraja',
                    'title' => '[ES] Título temporal del mazo',
                    'description' => '[ES] Descripción provisional del mazo Sunlight.'
                ],
                'concept' => [
                    'label' => 'Arte conceptual',
                    'title' => '[ES] Tras bambalinas',
                    'description' => '[ES] Descripción provisional del arte conceptual.'
                ],
                'inspiration' => [
                    'label' => 'Inspiración',
                    'title' => '[ES] Fuentes místicas',
                    'description' => '[ES] Descripción provisional de las inspiraciones.'
                ],
                'symbols' => [
                    'label' => 'Símbolos',
                    'title' => '[ES] Lenguaje visual',
                    'description' => '[ES] Descripción provisional de los símbolos.'
                ],
            ],
        ],
        'he' => [
            'intro' => [
                'label' => 'מסע חזותי',
                'title' => 'היקום בתמונות',
                'lead' => '[HE] טקסט הקדמה זמני לגלריה.'
            ],
            'feedback' => [
                'button_label' => 'שתפו את דעתכם',
                'modal_title' => 'איך זה מרגיש לכם?',
                'rating_label' => 'דרגו את התמונה',
                'reaction_label' => 'איזה רגש היא מעוררת?',
                'comment_label' => 'הוסיפו תגובה (לא חובה)',
                'name_label' => 'שם (לא חובה)',
                'email_label' => 'אימייל (לא חובה)',
                'submit_label' => 'שלחו משוב',
                'success_message' => 'תודה על המשוב!',
                'error_message' => 'לא הצלחנו לשמור את המשוב. נסו שוב.',
                'throttle_message' => 'כבר שלחתם משוב לאחרונה. נסו שוב מאוחר יותר.',
                'reaction_required' => 'בחרו תגובה.',
                'rating_required' => 'בחרו דירוג.',
                'reactions' => [
                    'like' => ['label' => 'אהבתי', 'icon' => '👍'],
                    'love' => ['label' => 'מת על זה', 'icon' => '❤️'],
                    'dislike' => ['label' => 'פחות', 'icon' => '👎'],
                ],
            ],
            'tabs' => [
                'deck' => [
                    'label' => 'החפיסה',
                    'title' => '[HE] כותרת זמנית לחפיסה',
                    'description' => '[HE] תיאור זמני לחפיסת Sunlight.'
                ],
                'concept' => [
                    'label' => 'קונספט ארט',
                    'title' => '[HE] מאחורי הקלעים',
                    'description' => '[HE] תיאור זמני לאמנות הקונספט.'
                ],
                'inspiration' => [
                    'label' => 'השראה',
                    'title' => '[HE] מקורות השראה',
                    'description' => '[HE] תיאור זמני של ההשראות.'
                ],
                'symbols' => [
                    'label' => 'סמלים',
                    'title' => '[HE] שפה חזותית',
                    'description' => '[HE] תיאור זמני של הסמלים.'
                ],
            ],
        ],
    ];

    public static function getFeedbackStrings(?string $language = null): array
    {
        $language = self::resolveLanguage($language);
        $defaults = self::defaultFeedbackStrings();
        $override = self::$translations[$language]['feedback'] ?? [];

        return array_replace_recursive($defaults, $override);
    }

    private static function defaultFeedbackStrings(): array
    {
        return [
            'button_label' => __('Share your thoughts', 'cta'),
            'modal_title' => __('Tell us what you think', 'cta'),
            'rating_label' => __('Rate this image', 'cta'),
            'reaction_label' => __('How does it make you feel?', 'cta'),
            'comment_label' => __('Leave a comment (optional)', 'cta'),
            'name_label' => __('Name (optional)', 'cta'),
            'email_label' => __('Email (optional)', 'cta'),
            'submit_label' => __('Send feedback', 'cta'),
            'success_message' => __('Thank you for your feedback!', 'cta'),
            'error_message' => __('Unable to save feedback. Please try again.', 'cta'),
            'throttle_message' => __('You recently submitted feedback for this image. Please try again later.', 'cta'),
            'reaction_required' => __('Please choose a reaction.', 'cta'),
            'rating_required' => __('Please choose a rating.', 'cta'),
            'average_label' => __('Average rating', 'cta'),
            'total_votes_label' => __('Votes', 'cta'),
            'reactions_label' => __('Reactions', 'cta'),
            'no_ratings_label' => __('No ratings yet', 'cta'),
            'rating_scale_label' => __('Select a rating', 'cta'),
            'recent_comments_label' => __('Recent comments', 'cta'),
            'no_comments_label' => __('No comments yet — be the first!', 'cta'),
            'anonymous_label' => __('Anonymous', 'cta'),
            'submit_loading_label' => __('Sending…', 'cta'),
            'reactions' => [
                'like' => ['label' => __('Like', 'cta'), 'icon' => '👍'],
                'love' => ['label' => __('Love', 'cta'), 'icon' => '❤️'],
                'dislike' => ['label' => __('Dislike', 'cta'), 'icon' => '👎'],
            ],
        ];
    }

    public static function getTabs(?string $language = null): array
    {
        $base = self::uploadsBase();

        $tabs = [
            [
                'id' => 'deck',
                'icon' => '🃏',
                'label' => 'The Deck',
                'count' => 12,
                'title' => 'The Core Cards',
                'description' => 'The foundation of Sunlight Tarot — each Major Arcana card represents a stage in the Dreamer\'s awakening journey.',
                'items' => self::getDeckItems($base),
            ],
            [
                'id' => 'concept',
                'icon' => '🎨',
                'label' => 'Concept Art',
                'count' => 8,
                'title' => 'Behind the Scenes',
                'description' => 'Early sketches, digital concepts, and the creative process that brings each card to life.',
                'items' => self::getConceptItems($base),
            ],
            [
                'id' => 'inspiration',
                'icon' => '💡',
                'label' => 'Inspiration',
                'count' => 6,
                'title' => 'Mystical Sources',
                'description' => 'The spiritual traditions, symbols, and philosophies that inspire our modern Tarot system.',
                'items' => self::getInspirationItems($base),
            ],
            [
                'id' => 'symbols',
                'icon' => '✨',
                'label' => 'Symbols',
                'count' => 15,
                'title' => 'The Visual Language',
                'description' => 'Sacred geometry, elemental symbols, and the iconography that connects all cards together.',
                'items' => self::getSymbolItems($base),
            ],
        ];

        $language = self::resolveLanguage($language);
        $overrides = self::$translations[$language]['tabs'] ?? [];

        foreach ($tabs as &$tab) {
            $tabId = $tab['id'] ?? null;
            if (!$tabId || empty($overrides[$tabId])) {
                continue;
            }

            $override = $overrides[$tabId];
            $itemOverrides = $override['items'] ?? [];
            unset($override['items']);

            $tab = array_merge($tab, $override);

            if (!empty($itemOverrides) && !empty($tab['items'])) {
                foreach ($tab['items'] as $index => $item) {
                    if (isset($itemOverrides[$index])) {
                        $tab['items'][$index] = array_merge($item, $itemOverrides[$index]);
                    }
                }
            }
        }
        unset($tab);

        return $tabs;
    }

    public static function getIntro(?string $language = null): array
    {
        $intro = [
            'label' => 'Visual Journey',
            'title' => 'The Vision in Images',
            'lead' => 'Every card, every color, every line is part of a larger symphony — the rebirth of Tarot. Explore concept art, elemental allies, and glimpses of the Sunlight world taking form.',
        ];

        $language = self::resolveLanguage($language);
        $override = self::$translations[$language]['intro'] ?? [];

        return array_merge($intro, $override);
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

        return array_key_exists($language, self::$translations) ? $language : 'en';
    }

    private static function uploadsBase(): string
    {
        return trailingslashit(content_url('uploads/cups'));
    }

    private static function getDeckItems(string $base): array
    {
        return [
            [
                'featured' => true,
                'icon' => '🌅',
                'title' => 'The Dreamer',
                'subtitle' => 'Major Arcana I',
                'headline' => 'The Dreamer Awakens',
                'description' => 'The beginning of consciousness, the spark of awareness that illuminates the path ahead.',
                'meta' => ['Major Arcana', 'Coming 2025'],
                'image' => $base . '1._Watercolor_tarot_card_boy_at_cliff_edge_in_muted_bedroom_t_744cad2c-7289-4e0e-9e96-75e608ae984d_0.png',
            ],
            ['icon' => '🌙', 'title' => 'The Moon', 'subtitle' => 'Major Arcana', 'image' => $base . '2._Soft_watercolor_card_moon_reflection_in_birdbath_on_yellow_64c104dd-67bb-4b1f-b165-19709fcfde76_2.png'],
            ['icon' => '⭐', 'title' => 'The Star', 'subtitle' => 'Major Arcana', 'image' => $base . '3._Watercolor_card_spinning_enneagram_wheel_on_notebook_page__0023f6eb-bf28-407c-b486-7e2ea1d129fb_3.png'],
            ['icon' => '☀️', 'title' => 'The Sun', 'subtitle' => 'Major Arcana', 'image' => $base . '9._Soft_watercolor_tarot_card_four_color-coded_angels_bluegre_dea97083-3fed-40f4-ba32-818e946dcc5c_2.png'],
            ['icon' => '🌊', 'title' => 'Cups Suite', 'subtitle' => 'Elemental', 'image' => $base . 'Soft_watercolor_card_Creamy_notebook_page_Birdbath_center__gl_72588265-b6ff-4e5c-b7df-3e9eba75e69c_1.png'],
            ['icon' => '🔥', 'title' => 'Wands Suite', 'subtitle' => 'Elemental', 'image' => $base . '3_of_Cups._Sepia_aquarelle_three_Atlantean-Viking_women_in_fl_295a1af1-bd69-49f8-aa6b-fa26b739af16_2.png'],
        ];
    }

    private static function getConceptItems(string $base): array
    {
        return [
            ['icon' => '✏️', 'title' => 'Initial Sketches', 'subtitle' => 'Hand-drawn concepts', 'image' => $base . '4_of_Cups._Watercolor_card_boy_sitting_on_bedroom_floor_noteb_e6845f3b-02cc-4db3-ad61-76a328db26ce_3.png'],
            ['icon' => '💻', 'title' => 'Digital Concepts', 'subtitle' => '3D renderings', 'image' => $base . '5_of_Cups._Sepia_aquarelle_boy_looking_at_three_spilled_cups__1b8b320d-6364-40ab-8202-6e4b5b5b60bd_3.png'],
            ['icon' => '🎨', 'title' => 'Color Studies', 'subtitle' => 'Palette exploration', 'image' => $base . '6._Soft_watercolor_card_flowing_starlight_from_Dads_postcard__5d04d9f6-0e30-4bd6-806a-5386e4b7279a_0.png'],
        ];
    }

    private static function getInspirationItems(string $base): array
    {
        return [
            ['icon' => '🕉️', 'title' => 'Osho Philosophy', 'subtitle' => 'Consciousness & Awareness', 'image' => $base . '8_of_Cups._Sepia_aquarelle_boy_walking_away_from_eight_cups_n_4060fdf9-8c78-4752-a13a-e8d76038f5d7_3.png'],
            ['icon' => '🔮', 'title' => 'Eileen Connolly', 'subtitle' => 'Modern Mysticism', 'image' => $base . '9._Soft_watercolor_tarot_card_four_color-coded_angels_bluegre_dea97083-3fed-40f4-ba32-818e946dcc5c_2.png'],
            ['icon' => '🧬', 'title' => 'Science & Spirit', 'subtitle' => 'Quantum Consciousness', 'image' => $base . '2_of_Cups._Watercolor_card_two_Viking_longships_made_of_noteb_901698f6-55e1-44ea-9b0a-3b0ce2acb25d_1.png'],
        ];
    }

    private static function getSymbolItems(string $base): array
    {
        return [
            ['icon' => '▴', 'title' => 'Sacred Geometry', 'image' => $base . 'Prince_of_Cups._Watercolor_card_young_Viking_explorer_in_pape_502701c2-1b0e-4882-b649-a3fd599037b0_1.png'],
            ['icon' => '☯️', 'title' => 'Duality', 'image' => $base . '4_of_Cups._Sepia_aquarelle_boy_on_bedroom_floor_three_cups_fl_5313206f-36ef-4fa2-b885-165ba059f9b1_2.png'],
            ['icon' => '✶', 'title' => 'Celestial Glyphs', 'image' => $base . '5_of_Cups._Sepia_aquarelle_boy_looking_at_three_spilled_cups__1b8b320d-6364-40ab-8202-6e4b5b5b60bd_0.png'],
            ['icon' => '🜃', 'title' => 'Elemental Seals', 'image' => $base . 'Soft_watercolor_card_Creamy_notebook_page_Birdbath_center__gl_72588265-b6ff-4e5c-b7df-3e9eba75e69c_1.png'],
            ['icon' => '🜂', 'title' => 'Fire Sigils', 'image' => $base . '3_of_Cups._Sepia_aquarelle_three_Atlantean-Viking_women_in_fl_295a1af1-bd69-49f8-aa6b-fa26b739af16_2.png'],
            ['icon' => '🜄', 'title' => 'Water Sigils', 'image' => $base . '2_of_Cups._Watercolor_card_two_Viking_longships_made_of_noteb_901698f6-55e1-44ea-9b0a-3b0ce2acb25d_1.png'],
        ];
    }
}
