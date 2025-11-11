<?php
namespace CTA\Model;

class SlideConfig {
    public static function getSlides() {
        return [
            new Slide(
                1, 
                '✨ Sunlight Tarot Deck', 
                'An open-source tarot deck in development. Leave your email to stay updated on progress and the upcoming Kickstarter launch. No spam, no sharing your info—just updates on this meaningful project.',
                'Keep Me Updated'
            ),
            new Slide(
                2, 
                '📜 Scroll Maze Novel', 
                'Diary of a Wimpy Kid meets Terry Pratchett meets The NeverEnding Story. A kid recreates the world through his rich imagination, exploring science and spirituality. First chapter: "Adam\'s Boring Guide to Practical Paradoxical Fantastical Parallel Dimensions." Hand-built, crowdfunded, and destined to become a game.',
                'Get Early Access'
            ),
            new Slide(
                3, 
                '🎮 Scroll Maze Game', 
                'Coming soon: the interactive game based on Scroll Maze. Where imagination becomes reality and every choice reshapes the world. Join the journey from novel to game.',
                'Join the Adventure'
            ),
        ];
    }
}
