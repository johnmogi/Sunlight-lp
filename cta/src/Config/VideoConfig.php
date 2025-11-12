<?php
namespace CTA\Config;

class VideoConfig
{
    private static array $content = [
        'en' => [
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
        ],
        'fr' => [
            'intro' => [
                'label' => 'Vivez la lumière',
                'title' => 'Histoires en mouvement',
                'lead' => 'Film, jeu et son racontent l’histoire de Sunlight. Découvrez l’univers à travers des bandes-annonces, des sessions live et des paysages sonores immersifs.',
            ],
            'hero' => [
                'meta' => 'Film principal',
                'title' => 'L’histoire commence ici',
                'description' => 'Découvrez le premier aperçu de Sunlight Tarot — un voyage entre art, esprit et imagination. Ce court métrage présente la lumière des cartes, la musique qui les anime et la vision qui relie tout.',
            ],
            'playlist' => [
                'heading' => 'Choisissez une autre expérience',
                'description' => 'Sélectionnez une vidéo ou un parcours sonore pour remplacer le lecteur principal. Chaque entrée révèle une facette de l’univers Sunlight — coulisses, musique et avant-premières de gameplay.',
                'items' => [
                    [
                        'meta' => 'Première YouTube',
                        'title' => 'Le rêveur s’éveille — bande-annonce officielle',
                        'description' => 'Un regard cinématographique sur l’arc de l’éveil et la renaissance du Tarot.',
                    ],
                    [
                        'meta' => 'Aperçu de gameplay',
                        'title' => 'Session prototype Scroll Maze',
                        'description' => 'Explorez la conscience stratégique à travers les premières mécaniques et choix narratifs.',
                    ],
                    [
                        'meta' => 'Musique live',
                        'title' => 'Session studio : Fréquences de lumière',
                        'description' => 'Une exploration guidée des motifs élémentaires du Tarot.',
                    ],
                ],
            ],
            'media' => [
                'heading' => 'Albums & paysages sonores',
                'description' => 'Plongez dans des playlists évolutives, des boucles méditatives et des compagnons audio narratifs.',
                'items' => [
                    [
                        'meta' => 'Album musical',
                        'title' => 'Suite ambiante pour l’éveil',
                        'description' => 'Un mélange doux de synthés, de carillons et de drones sacrés enregistré pour la méditation longue.',
                    ],
                    [
                        'meta' => 'Chapitre narré',
                        'title' => 'Scroll Maze Chapitre Un — édition audio',
                        'description' => 'Écoutez le premier chapitre du Scroll Maze dans un format narré exclusif.',
                    ],
                    [
                        'meta' => 'Boucle de concentration',
                        'title' => 'Boucle des quatre éléments',
                        'description' => 'Une boucle répétitive conçue pour l’écriture, le codage et la contemplation.',
                    ],
                ],
            ],
        ],
        'es' => [
            'intro' => [
                'label' => 'Vive la luz',
                'title' => 'Historias en movimiento',
                'lead' => 'Cine, jugabilidad y sonido se unen para contar la historia de Sunlight. Explora el universo mediante tráilers, sesiones en vivo y paisajes sonoros inmersivos.',
            ],
            'hero' => [
                'meta' => 'Película destacada',
                'title' => 'La historia comienza aquí',
                'description' => 'Mira el primer vistazo de Sunlight Tarot — un viaje de arte, espíritu e imaginación. Este cortometraje presenta la luz detrás de las cartas, la música que las impulsa y la visión que lo conecta todo.',
            ],
            'playlist' => [
                'heading' => 'Elige otra experiencia',
                'description' => 'Selecciona un viaje de video o audio para cambiar el reproductor principal. Cada entrada muestra una faceta del universo Sunlight — detrás de cámaras, sesiones musicales y avances de juego.',
                'items' => [
                    [
                        'meta' => 'Estreno en YouTube',
                        'title' => 'El soñador despierta — tráiler oficial',
                        'description' => 'Una mirada cinematográfica al arco del despertar y al Tarot renacido.',
                    ],
                    [
                        'meta' => 'Avance de jugabilidad',
                        'title' => 'Sesión prototipo de Scroll Maze',
                        'description' => 'Explora la conciencia estratégica mediante mecánicas tempranas y decisiones narrativas.',
                    ],
                    [
                        'meta' => 'Música en vivo',
                        'title' => 'Sesión de estudio: Frecuencias de luz',
                        'description' => 'Un recorrido guiado por los motivos elementales del Tarot.',
                    ],
                ],
            ],
            'media' => [
                'heading' => 'Álbumes y paisajes sonoros',
                'description' => 'Sumérgete en playlists en evolución, bucles meditativos y acompañantes narrativos de audio.',
                'items' => [
                    [
                        'meta' => 'Álbum musical',
                        'title' => 'Suite ambiente para el despertar',
                        'description' => 'Una mezcla suave de sintetizadores, campanas y drones sagrados para meditación prolongada.',
                    ],
                    [
                        'meta' => 'Capítulo narrado',
                        'title' => 'Scroll Maze Capítulo Uno — edición en audio',
                        'description' => 'Escucha el primer capítulo de Scroll Maze en un formato narrado exclusivo.',
                    ],
                    [
                        'meta' => 'Bucle de enfoque',
                        'title' => 'Bucle de los cuatro elementos',
                        'description' => 'Un loop repetitivo diseñado para escribir, programar y contemplar en profundidad.',
                    ],
                ],
            ],
        ],
        'he' => [
            'intro' => [
                'label' => 'חוו את האור',
                'title' => 'סיפורים בתנועה',
                'lead' => 'קולנוע, משחק וסOUND מתאחדים כדי לספר את סיפור Sunlight. חקרו טריילרים, סשנים חיים ונופי צליל סוחפים.',
            ],
            'hero' => [
                'meta' => 'סרט מרכזי',
                'title' => 'הסיפור מתחיל כאן',
                'description' => 'צפו בהצצה הראשונה ל-Sunlight Tarot — מסע של אמנות, רוח ודמיון. הסרטון מציג את האור שמאחורי הקלפים, את המוזיקה שמניעה אותם ואת החזון שמחבר הכול.',
            ],
            'playlist' => [
                'heading' => 'בחרו חוויה אחרת',
                'description' => 'בחרו וידאו או מסע שמע כדי להחליף את הנגן הראשי. כל פריט מאיר היבט אחר של יקום Sunlight — מאחורי הקלעים, סשנים מוזיקליים ותצוגות משחק מוקדמות.',
                'items' => [
                    [
                        'meta' => 'בכורת YouTube',
                        'title' => 'התעוררות החולם — טריילר רשמי',
                        'description' => 'מבט קולנועי על מסע ההתעוררות ועל הטארוט שנולד מחדש.',
                    ],
                    [
                        'meta' => 'תצוגת משחק',
                        'title' => 'סשן אב-טיפוס של Scroll Maze',
                        'description' => 'גלו תודעה אסטרטגית דרך מכניקות מוקדמות והחלטות סיפוריות.',
                    ],
                    [
                        'meta' => 'מוזיקה חיה',
                        'title' => 'סשן אולפן: תדרי אור',
                        'description' => 'סיור מודרך במוטיבים היסודיים של הטארוט.',
                    ],
                ],
            ],
            'media' => [
                'heading' => 'אלבומים ונופי צליל',
                'description' => 'העמיקו בפלייליסטים מתפתחים, בלופים מדיטטיביים ומלווים נרטיביים.',
                'items' => [
                    [
                        'meta' => 'אלבום מוזיקה',
                        'title' => 'סוויטה אמביינטית להתעוררות',
                        'description' => 'תערובת רכה של סינתים, פעמונים וצילצולים קדושים להאזנה ממושכת.',
                    ],
                    [
                        'meta' => 'פרק מוקלט',
                        'title' => 'Scroll Maze פרק ראשון — גרסת שמע',
                        'description' => 'האזינו לפרק הראשון של Scroll Maze בגרסה מוקלטת בלעדית.',
                    ],
                    [
                        'meta' => 'לולאת מיקוד',
                        'title' => 'לולאת ארבעת האלמנטים',
                        'description' => 'לולאה חוזרת שנועדה לכתיבה, תכנות והתבוננות עמוקה.',
                    ],
                ],
            ],
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
