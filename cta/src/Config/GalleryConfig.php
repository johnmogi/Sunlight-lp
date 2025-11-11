<?php
namespace CTA\Config;

class GalleryConfig
{
    public static function getTabs(): array
    {
        $base = self::uploadsBase();

        return [
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
    }

    public static function getIntro(): array
    {
        return [
            'label' => 'Visual Journey',
            'title' => 'The Vision in Images',
            'lead' => 'Every card, every color, every line is part of a larger symphony — the rebirth of Tarot. Explore concept art, elemental allies, and glimpses of the Sunlight world taking form.',
        ];
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
