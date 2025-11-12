(function ($) {
    'use strict';

    function toggleSwitcher(event) {
        event.preventDefault();

        var $switcher = $(event.currentTarget).closest('.lang-switcher');
        var isOpen = $switcher.hasClass('is-open');

        closeAll();

        if (!isOpen) {
            $switcher.addClass('is-open');
            $switcher.find('.lang-switcher__toggle').attr('aria-expanded', 'true');
        }
    }

    function closeAll() {
        $('.lang-switcher.is-open')
            .removeClass('is-open')
            .find('.lang-switcher__toggle')
            .attr('aria-expanded', 'false');
    }

    function handleDocumentClick(event) {
        if (!$(event.target).closest('.lang-switcher').length) {
            closeAll();
        }
    }

    function handleKeydown(event) {
        if (event.key === 'Escape') {
            closeAll();
        }
    }

    // Header context toggle
    $(document).on('click', '.lang-switcher__toggle', toggleSwitcher);
    $(document).on('click', handleDocumentClick);
    $(document).on('keydown', handleKeydown);

    // Menu item context toggle
    $(document).on('click', '.menu-item-language-switcher > .lang-switcher-toggle', function(e) {
        e.preventDefault();
        var $toggle = $(this);
        var isExpanded = $toggle.attr('aria-expanded') === 'true';
        
        // Close all other menu dropdowns
        $('.menu-item-language-switcher .lang-switcher-toggle').attr('aria-expanded', 'false');
        
        // Toggle current
        $toggle.attr('aria-expanded', !isExpanded);
    });

    // Close menu dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.menu-item-language-switcher').length) {
            $('.menu-item-language-switcher .lang-switcher-toggle').attr('aria-expanded', 'false');
        }
    });
})(jQuery);
