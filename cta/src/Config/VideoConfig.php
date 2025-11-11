<?php
namespace CTA\Config;

class VideoConfig
{
    public static function getContent(): array
    {
        return [
            'title' => 'The Story Begins Here',
            'intro' => 'Watch the first glimpse of Sunlight Tarot — a journey through art, spirit, and imagination. This short film introduces the light behind the cards, the music that moves them, and the vision that connects everything together.',
            'placeholder' => [
                'icon' => '🎬',
                'title' => 'Video Coming Soon',
                'hint' => 'Use: [cta_video url="https://youtube.com/your-video"]'
            ]
        ];
    }
}
