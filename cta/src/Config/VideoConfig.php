<?php
namespace CTA\Config;

class VideoConfig
{
    public static function getContent(): array
    {
        return [
            'intro' => [
                'label' => 'Experience the Light',
                'title' => 'Stories in Motion',
                'lead' => 'Film, gameplay, and sound unite to tell the Sunlight story. Explore the universe through trailers, live sessions, and immersive soundscapes.',
            ],
            'hero' => [
                'id' => 'sunlight-feature',
                'meta' => 'Feature Film',
                'title' => 'The Story Begins Here',
                'description' => 'Watch the first glimpse of Sunlight Tarot — a journey through art, spirit, and imagination. This short film introduces the light behind the cards, the music that moves them, and the vision that connects everything together.',
                'url' => 'https://www.youtube.com/watch?v=Z1BCujX3pw8'
            ],
            'playlist' => [
                'heading' => 'Choose Another Experience',
                'description' => 'Select a video or audio journey to swap the main player. Each entry spotlights a facet of the Sunlight universe — behind-the-scenes moments, music sessions, and gameplay previews.',
                'items' => [
                    [
                        'id' => 'dreamer-trailer',
                        'meta' => 'YouTube Premiere',
                        'title' => 'Dreamer Awakens — Official Trailer',
                        'description' => 'A cinematic look at the awakening arc and the Tarot reborn.',
                        'url' => 'https://www.youtube.com/watch?v=QCMjlZ3G1AE',
                        'thumbnail' => 'https://img.youtube.com/vi/QCMjlZ3G1AE/hqdefault.jpg'
                    ],
                    [
                        'id' => 'scroll-maze-session',
                        'meta' => 'Gameplay Preview',
                        'title' => 'Scroll Maze Prototype Session',
                        'description' => 'Explore strategic consciousness through early mechanics and narrative choices.',
                        'url' => 'https://www.youtube.com/watch?v=E7wJTI-1dvQ',
                        'thumbnail' => 'https://img.youtube.com/vi/E7wJTI-1dvQ/hqdefault.jpg'
                    ],
                    [
                        'id' => 'studio-session',
                        'meta' => 'Live Music',
                        'title' => 'Studio Session: Frequencies of Light',
                        'description' => 'Composer-led walkthrough of the Tarot’s elemental motifs.',
                        'url' => 'https://www.youtube.com/watch?v=kXYiU_JCYtU',
                        'thumbnail' => 'https://img.youtube.com/vi/kXYiU_JCYtU/hqdefault.jpg'
                    ],
                ],
            ],
            'media' => [
                'heading' => 'Albums & Soundscapes',
                'description' => 'Immerse yourself in evolving playlists, meditative loops, and narrative audio companions.',
                'items' => [
                    [
                        'id' => 'ambient-suite',
                        'meta' => 'Music Album',
                        'title' => 'Ambient Suite for Awakening',
                        'description' => 'A soft-focus blend of synth, chimes, and sacred drones recorded for long-form meditation.',
                        'embed' => '<iframe src="https://open.spotify.com/embed/album/1DFixLWuPkv3KT3TnV35m3" width="100%" height="232" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>',
                        'actions' => [
                            'listen' => 'https://open.spotify.com/album/1DFixLWuPkv3KT3TnV35m3',
                            'details' => 'https://sunlight-project.local/music/ambient-suite'
                        ]
                    ],
                    [
                        'id' => 'chapter-one-audio',
                        'meta' => 'Narrated Chapter',
                        'title' => 'Scroll Maze Chapter One — Audio Edition',
                        'description' => 'Listen to the first chapter of the Scroll Maze in an exclusive narrated format.',
                        'embed' => '<iframe width="100%" height="210" src="https://www.youtube.com/embed/6Dh-RL__uN4" title="Narrated Chapter" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                        'actions' => [
                            'listen' => 'https://www.youtube.com/watch?v=6Dh-RL__uN4',
                            'details' => 'https://sunlight-project.local/stories/chapter-one'
                        ]
                    ],
                    [
                        'id' => 'focus-loop',
                        'meta' => 'Focus Loop',
                        'title' => 'Four Elements Focus Loop',
                        'description' => 'A repeating loop designed for writing, coding, and deep contemplation sessions.',
                        'embed' => '<iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/308204625&color=%23ff5500&auto_play=false&hide_related=false&show_comments=false&show_user=false&show_reposts=false&show_teaser=false"></iframe>',
                        'actions' => [
                            'listen' => 'https://soundcloud.com/monstercat/pegboard-nerds-hero-feat-elizaveta',
                            'details' => null
                        ]
                    ],
                ],
            ],
        ];
    }
}
