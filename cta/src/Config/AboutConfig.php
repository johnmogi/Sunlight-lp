<?php
namespace CTA\Config;

class AboutConfig
{
    public static function getIntro(): array
    {
        return [
            'label' => 'Three Journeys, One Vision',
            'title' => 'The Sunlight Universe',
            'lead' => 'Where consciousness meets creativity through three interconnected experiences.'
        ];
    }

    public static function getCards(): array
    {
        return [
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
        ];
    }

    public static function getUniverse(): array
    {
        return [
            'label' => 'One Connected Universe',
            'description' => 'Cards, stories, and games are facets of the same light. Inspired by innovators like Osho and Eileen Connolly, we continue their legacy—breaking conventions, opening hearts, and bringing light to shadow.'
        ];
    }

    public static function getQuote(): array
    {
        return [
            'text' => 'The Tarot is not about knowing the future. It\'s about understanding the now — through cards, stories, and play.'
        ];
    }
}
