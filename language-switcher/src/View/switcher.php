<?php
/**
 * Language switcher partial.
 *
 * @var array $languages
 * @var array|null $currentLanguage
 * @var string $viewContext
 */

if (empty($languages) || empty($currentLanguage)) {
    return;
}

if ($viewContext === 'menu') {
    // Render as menu item for wp_nav_menu_items filter
    ?>
    <li class="menu-item menu-item-language-switcher">
        <a href="#" class="menu-link lang-switcher-toggle" aria-haspopup="true" aria-expanded="false">
            <?php echo esc_html($currentLanguage['label']); ?>
        </a>
        <ul class="sub-menu lang-switcher-dropdown">
            <?php foreach ($languages as $language):
                $isActive = !empty($currentLanguage['code']) && $currentLanguage['code'] === ($language['code'] ?? '');
                $languageUrl = \LanguageSwitcher\Service\SwitcherRenderer::generateLanguageUrl($language);
                ?>
                <li class="menu-item<?php echo $isActive ? ' current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url($languageUrl); ?>"
                       lang="<?php echo esc_attr($language['code'] ?? ''); ?>"
                       hreflang="<?php echo esc_attr($language['code'] ?? ''); ?>"
                       class="menu-link"
                       data-lang="<?php echo esc_attr($language['code'] ?? ''); ?>">
                        <?php echo esc_html($language['label'] ?? ''); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </li>
    <?php
} else {
    // Render as standalone nav for header hooks
    ?>
    <div class="lang-switcher lang-switcher--header" data-language-switcher>
        <button class="lang-switcher__toggle" type="button" aria-haspopup="true" aria-expanded="false">
            <span class="lang-switcher__current"><?php echo esc_html($currentLanguage['label']); ?></span>
            <svg class="lang-switcher__icon" width="12" height="12" viewBox="0 0 12 12" aria-hidden="true">
                <path d="M2 4l4 4 4-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <ul class="lang-switcher__list">
            <?php foreach ($languages as $language):
                $isActive = !empty($currentLanguage['code']) && $currentLanguage['code'] === ($language['code'] ?? '');
                $languageUrl = \LanguageSwitcher\Service\SwitcherRenderer::generateLanguageUrl($language);
                ?>
                <li class="lang-switcher__item<?php echo $isActive ? ' is-active' : ''; ?>">
                    <a href="<?php echo esc_url($languageUrl); ?>"
                       lang="<?php echo esc_attr($language['code'] ?? ''); ?>"
                       hreflang="<?php echo esc_attr($language['code'] ?? ''); ?>"
                       class="lang-switcher__link"
                       data-lang="<?php echo esc_attr($language['code'] ?? ''); ?>">
                        <?php echo esc_html($language['label'] ?? ''); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
}
