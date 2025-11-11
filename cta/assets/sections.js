(function ($) {
    'use strict';

    var tabSelectors = '.cta-gallery__tabs button';
    var triggerSelector = '.cta-gallery__trigger[data-trigger="gallery"]';
    var lightboxSelector = '.cta-gallery__lightbox';

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

    $(document).on('click', tabSelectors, handleTabClick);
    $(document).on('click', triggerSelector, openLightbox);
    $(document).on('click', '[data-lightbox-close]', handleClose);
    $(document).on('click', '[data-lightbox-prev]', handleNav);
    $(document).on('click', '[data-lightbox-next]', handleNav);
    $(document).on('keydown', handleKeydown);
})(jQuery);
