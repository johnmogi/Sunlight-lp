<?php
namespace CTA\Config;

class SignupConfig
{
    public static function getContent(): array
    {
        return [
            'label' => 'Join the Circle',
            'title' => 'Be Part of the Creation',
            'lead' => 'Leave your details to receive art reveals, story chapters, and invitations to early play sessions. No noise — only light.',
            'bullet_points' => [
                'First look at new Tarot artwork and symbolism reveals',
                'Invitations to closed Scroll Maze playtests and salons',
                'Opportunities to contribute to music, story, and game design',
            ],
            'privacy' => 'We respect your time and your inbox. Expect only meaningful updates, never spam.'
        ];
    }
}
