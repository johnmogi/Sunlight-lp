<?php
/**
 * Video shortcode template
 * @var array $content
 * @var array $ajax
 */

$intro = $content['intro'] ?? [];
$hero = $content['hero'] ?? [];
$playlist = $content['playlist']['items'] ?? [];
$playlistHeading = $content['playlist']['heading'] ?? '';
$playlistDescription = $content['playlist']['description'] ?? '';
$media = $content['media']['items'] ?? [];
$mediaHeading = $content['media']['heading'] ?? '';
$mediaDescription = $content['media']['description'] ?? '';

$heroUrl = $hero['url'] ?? '';
$heroMeta = $hero['meta'] ?? '';
$heroTitle = $hero['title'] ?? '';
$heroDescription = $hero['description'] ?? '';
$heroId = $hero['id'] ?? 'cta-hero-video';
$isRtl = class_exists('LanguageSwitcher\\Support\\Context') && \LanguageSwitcher\Support\Context::isRtl();
$direction = $isRtl ? 'rtl' : 'ltr';
?>
<section class="cta-video<?php echo $isRtl ? ' is-rtl' : ''; ?>" id="cta-video" dir="<?php echo esc_attr($direction); ?>"
    data-ajax-url="<?php echo esc_url($ajax['ajaxUrl']); ?>"
    data-ajax-nonce="<?php echo esc_attr($ajax['nonce']); ?>">
    <div class="cta-container">
        <?php if (!empty($intro)): ?>
            <div class="cta-video__intro">
                <?php if (!empty($intro['label'])): ?>
                    <span class="cta-section-label"><?php echo esc_html($intro['label']); ?></span>
                <?php endif; ?>
                <?php if (!empty($intro['title'])): ?>
                    <h2 class="cta-section-title"><?php echo esc_html($intro['title']); ?></h2>
                <?php endif; ?>
                <?php if (!empty($intro['lead'])): ?>
                    <p class="cta-section-lead"><?php echo esc_html($intro['lead']); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="cta-video__layout" data-video-player>
            <div class="cta-video__player" data-video-active>
                <div class="cta-video__embed" data-video-embed>
                    <?php if (!empty($heroUrl)): ?>
                        <?php echo wp_oembed_get($heroUrl); ?>
                    <?php endif; ?>
                </div>
                <div class="cta-video__player-details">
                    <?php if (!empty($heroMeta)): ?>
                        <div class="cta-video__player-meta" data-video-meta><?php echo esc_html($heroMeta); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($heroTitle)): ?>
                        <h3 class="cta-video__player-title" data-video-title><?php echo esc_html($heroTitle); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($heroDescription)): ?>
                        <p class="cta-video__player-description" data-video-description><?php echo esc_html($heroDescription); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <aside class="cta-video__playlist">
                <?php if (!empty($playlistHeading)): ?>
                    <h4 class="cta-video__playlist-heading"><?php echo esc_html($playlistHeading); ?></h4>
                <?php endif; ?>
                <?php if (!empty($playlistDescription)): ?>
                    <p class="cta-video__playlist-description"><?php echo esc_html($playlistDescription); ?></p>
                <?php endif; ?>

                <?php if (!empty($playlist)): ?>
                    <div class="cta-video__playlist-items" data-video-playlist>
                        <?php foreach ($playlist as $index => $item):
                            $itemId = $item['id'] ?? ('cta-video-' . $index);
                            $thumbnail = $item['thumbnail'] ?? '';
                            $meta = $item['meta'] ?? '';
                            $title = $item['title'] ?? '';
                            $description = $item['description'] ?? '';
                            $url = $item['url'] ?? '';
                            $isActive = ($url === $heroUrl) || ($index === 0 && empty($heroUrl));
                            ?>
                            <button type="button"
                                    class="cta-video__playlist-button <?php echo $isActive ? 'is-active' : ''; ?>"
                                    data-video-trigger
                                    data-video-url="<?php echo esc_url($url); ?>"
                                    data-video-meta="<?php echo esc_attr($meta); ?>"
                                    data-video-title="<?php echo esc_attr($title); ?>"
                                    data-video-description="<?php echo esc_attr($description); ?>"
                                    data-video-id="<?php echo esc_attr($itemId); ?>">
                                <div class="cta-video__thumb">
                                    <?php if (!empty($thumbnail)): ?>
                                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>">
                                    <?php else: ?>
                                        <span>▶</span>
                                    <?php endif; ?>
                                </div>
                                <div class="cta-video__playlist-body">
                                    <?php if (!empty($meta)): ?>
                                        <span class="cta-video__playlist-meta"><?php echo esc_html($meta); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($title)): ?>
                                        <span class="cta-video__playlist-title"><?php echo esc_html($title); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($description)): ?>
                                        <span class="cta-video__playlist-text"><?php echo esc_html($description); ?></span>
                                    <?php endif; ?>
                                </div>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </aside>
        </div>

        <?php if (!empty($media)): ?>
            <div class="cta-media">
                <div class="cta-media__header">
                    <?php if (!empty($mediaHeading)): ?>
                        <h3 class="cta-section-title"><?php echo esc_html($mediaHeading); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($mediaDescription)): ?>
                        <p class="cta-section-lead"><?php echo esc_html($mediaDescription); ?></p>
                    <?php endif; ?>
                </div>

                <div class="cta-media__grid">
                    <?php foreach ($media as $item):
                        $meta = $item['meta'] ?? '';
                        $title = $item['title'] ?? '';
                        $description = $item['description'] ?? '';
                        $embed = $item['embed'] ?? '';
                        $actions = $item['actions'] ?? [];
                        $listen = $actions['listen'] ?? '';
                        $details = $actions['details'] ?? '';
                        ?>
                        <article class="cta-media__card">
                            <?php if (!empty($embed)): ?>
                                <div class="cta-media__embed">
                                    <?php echo $embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </div>
                            <?php endif; ?>
                            <div class="cta-media__body">
                                <?php if (!empty($meta)): ?>
                                    <span class="cta-media__meta"><?php echo esc_html($meta); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($title)): ?>
                                    <h4 class="cta-media__title"><?php echo esc_html($title); ?></h4>
                                <?php endif; ?>
                                <?php if (!empty($description)): ?>
                                    <p class="cta-media__description"><?php echo esc_html($description); ?></p>
                                <?php endif; ?>
                                <div class="cta-media__actions">
                                    <?php if (!empty($listen)): ?>
                                        <a class="cta-media__link" href="<?php echo esc_url($listen); ?>" target="_blank" rel="noopener noreferrer">Listen</a>
                                    <?php endif; ?>
                                    <?php if (!empty($details)): ?>
                                        <a class="cta-media__link" href="<?php echo esc_url($details); ?>" target="_blank" rel="noopener noreferrer">Details</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
