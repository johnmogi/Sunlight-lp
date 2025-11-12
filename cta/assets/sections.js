(function ($) {
    'use strict';

    var tabSelectors = '.cta-gallery__tabs button';
    var triggerSelector = '.cta-gallery__trigger[data-trigger="gallery"]';
    var lightboxSelector = '.cta-gallery__lightbox';
    var playlistSelector = '.cta-video__playlist-button[data-video-trigger]';
    var playerSelector = '[data-video-player]';
    var signupFormSelector = '.cta-signup-form';

    function handleTabClick(event) {
        event.preventDefault();

        var $button = $(event.currentTarget);
        var target = $button.attr('data-target');

        if (!target) {
            return;
        }

        var $wrapper = $button.closest('.cta-gallery');
        if (!$wrapper.length) {
            return;
        }

        $wrapper.find(tabSelectors).removeClass('is-active');
        $button.addClass('is-active');

        $wrapper.find('.cta-gallery__pane').removeClass('is-active');
        $wrapper.find('#' + target).addClass('is-active');
    }

    function openLightbox(event) {
        event.preventDefault();

        var $button = $(event.currentTarget);
        var group = $button.data('group');
        var $lightbox = $('#' + group);

        if (!$lightbox.length) {
            return;
        }

        var entry = {
            image: $button.data('image') || '',
            title: $button.data('title') || '',
            headline: $button.data('headline') || '',
            caption: $button.data('caption') || '',
            alt: $button.data('alt') || ''
        };

        attachItemsToLightbox($lightbox, group);
        updateLightboxContent($lightbox, entry, group, $button.data('index'));
        $lightbox.addClass('is-open');
        $('body').addClass('cta-lightbox-open');
    }

    function attachItemsToLightbox($lightbox, group) {
        if ($lightbox.data('initialized')) {
            return;
        }

        var items = [];

        $('[data-group="' + group + '"][data-trigger="gallery"]').each(function () {
            items.push({
                index: $(this).data('index'),
                image: $(this).data('image') || '',
                title: $(this).data('title') || '',
                headline: $(this).data('headline') || '',
                caption: $(this).data('caption') || '',
                alt: $(this).data('alt') || ''
            });
        });

        $lightbox.data('items', items);
        $lightbox.data('initialized', true);
    }

    function updateLightboxContent($lightbox, entry, group, index) {
        var items = $lightbox.data('items') || [];
        var currentIndex = findIndex(items, index);

        $lightbox.data('currentIndex', currentIndex);

        $lightbox.find('.cta-gallery__lightbox-image')
            .attr('src', entry.image)
            .attr('alt', entry.alt);

        $lightbox.find('.cta-gallery__lightbox-title').text(entry.title || entry.headline || '');
        $lightbox.find('.cta-gallery__lightbox-text').text(entry.caption || entry.subtitle || '');

        toggleNavState($lightbox, currentIndex, items.length);
    }

    function toggleNavState($lightbox, currentIndex, total) {
        $lightbox.find('[data-lightbox-prev]').prop('disabled', currentIndex <= 0);
        $lightbox.find('[data-lightbox-next]').prop('disabled', currentIndex >= total - 1);
    }

    function findIndex(items, index) {
        var currentIndex = 0;
        items.forEach(function (item, idx) {
            if (String(item.index) === String(index)) {
                currentIndex = idx;
            }
        });
        return currentIndex;
    }

    function closeLightbox($lightbox) {
        $lightbox.removeClass('is-open');
        $('body').removeClass('cta-lightbox-open');
    }

    function handleClose(event) {
        event.preventDefault();
        var $lightbox = $(event.currentTarget).closest(lightboxSelector);
        closeLightbox($lightbox);
    }

    function handleNav(event) {
        event.preventDefault();
        var $button = $(event.currentTarget);
        var direction = $button.is('[data-lightbox-next]') ? 1 : -1;
        var $lightbox = $button.closest(lightboxSelector);
        var items = $lightbox.data('items') || [];
        var currentIndex = $lightbox.data('currentIndex') || 0;
        var targetIndex = currentIndex + direction;

        if (targetIndex < 0 || targetIndex >= items.length) {
            return;
        }

        var entry = items[targetIndex];
        updateLightboxContent($lightbox, entry, $lightbox.data('group'), entry.index);
    }

    function handleKeydown(event) {
        var $openLightbox = $(lightboxSelector + '.is-open');
        if (!$openLightbox.length) {
            return;
        }

        if (event.key === 'Escape') {
            closeLightbox($openLightbox);
        } else if (event.key === 'ArrowLeft') {
            $openLightbox.find('[data-lightbox-prev]').trigger('click');
        } else if (event.key === 'ArrowRight') {
            $openLightbox.find('[data-lightbox-next]').trigger('click');
        }
    }

    function handlePlaylistClick(event) {
        event.preventDefault();

        var $button = $(event.currentTarget);
        var $layout = $button.closest(playerSelector);

        if (!$layout.length) {
            return;
        }

        var ajaxUrl = $layout.closest('.cta-video').data('ajax-url');
        var nonce = $layout.closest('.cta-video').data('ajax-nonce');

        if (!ajaxUrl || !nonce) {
            return;
        }

        $layout.find(playlistSelector).removeClass('is-active');
        $button.addClass('is-active');

        var request = {
            action: 'cta_oembed',
            nonce: nonce,
            url: $button.data('video-url') || ''
        };

        var $playerMeta = $layout.find('[data-video-meta]');
        var $playerTitle = $layout.find('[data-video-title]');
        var $playerDescription = $layout.find('[data-video-description]');
        var $embed = $layout.find('[data-video-embed]');

        $playerMeta.text($button.data('video-meta') || '');
        $playerTitle.text($button.data('video-title') || '');
        $playerDescription.text($button.data('video-description') || '');

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: request,
            success: function (response) {
                if (response && response.success && response.data && response.data.embed) {
                    $embed.html(response.data.embed);
                }
            },
            error: function () {
                if (typeof ctaSectionsData !== 'undefined' && ctaSectionsData.messages && ctaSectionsData.messages.error) {
                    $playerDescription.text(ctaSectionsData.messages.error);
                }
            }
        });
    }

    function handleSignupSubmit(event) {
        event.preventDefault();

        if (typeof ctaSectionsData === 'undefined') {
            return;
        }

        var $form = $(event.currentTarget);
        var $section = $form.closest('.cta-signup');
        var $message = $section.find('[data-signup-message]');
        var $button = $form.find('button[type="submit"]');

        var data = {
            action: 'cta_submit',
            nonce: ctaSectionsData.nonce,
            name: $form.find('input[name="name"]').val(),
            email: $form.find('input[name="email"]').val(),
            website: $form.find('input[name="website"]').val()
        };

        $message.removeClass('is-success is-error').hide();

        var originalText = $button.data('original-text');
        if (!originalText) {
            originalText = $button.text();
            $button.data('original-text', originalText);
        }
        $button.prop('disabled', true).text($button.data('loading-text') || 'Sending…');

        $.ajax({
            url: ctaSectionsData.ajaxUrl,
            type: 'POST',
            data: data,
            success: function (response) {
                if (response && response.success) {
                    $message.text(response.data && response.data.message ? response.data.message : ctaSectionsData.messages.success)
                        .addClass('is-success')
                        .show();
                    $form[0].reset();
                } else {
                    var message = (response && response.data && response.data.message) ? response.data.message : ctaSectionsData.messages.validation;
                    $message.text(message)
                        .addClass('is-error')
                        .show();
                }
            },
            error: function () {
                $message.text(ctaSectionsData.messages.error)
                    .addClass('is-error')
                    .show();
            },
            complete: function () {
                $button.prop('disabled', false).text(originalText);
            }
        });
    }

    $(document).on('click', tabSelectors, handleTabClick);
    $(document).on('click', triggerSelector, openLightbox);
    $(document).on('click', '[data-lightbox-close]', handleClose);
    $(document).on('click', '[data-lightbox-prev]', handleNav);
    $(document).on('click', '[data-lightbox-next]', handleNav);
    $(document).on('keydown', handleKeydown);
    $(document).on('click', playlistSelector, handlePlaylistClick);
    $(document).on('submit', signupFormSelector, handleSignupSubmit);
})(jQuery);
