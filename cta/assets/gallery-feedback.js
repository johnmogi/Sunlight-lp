(function ($) {
    'use strict';

    var selectors = {
        openButton: '[data-feedback-open]',
        modal: '[data-feedback-modal]',
        closeButton: '[data-feedback-close]',
        backdrop: '.cta-gallery__feedback-backdrop',
        form: '.cta-gallery__feedback-form',
        ratingInput: '[data-feedback-rating-input]',
        reactionList: '[data-feedback-reactions]',
        reactionOption: '.cta-gallery__feedback-reaction',
        reactionRadio: '.cta-gallery__feedback-reaction input[type="radio"]',
        response: '[data-feedback-response]',
        submit: '[data-feedback-submit]',
        nameField: '[data-feedback-name]',
        emailField: '[data-feedback-email]',
        commentField: '[data-feedback-comment]',
        imageField: '[data-feedback-image]',
        titleField: '[data-feedback-title]',
        captionField: '[data-feedback-caption]',
        subtitleField: '[data-feedback-subtitle]',
        preview: '[data-feedback-preview]'
    };

    var state = {
        dataset: (window.ctaGalleryFeedback && window.ctaGalleryFeedback.initial && window.ctaGalleryFeedback.initial.items) || {},
        strings: (window.ctaGalleryFeedback && window.ctaGalleryFeedback.initial && window.ctaGalleryFeedback.initial.strings) || {},
        ajax: {
            url: (window.ctaGalleryFeedback && window.ctaGalleryFeedback.ajaxUrl) || (window.ctaGalleryFeedback && window.ctaGalleryFeedback.messages && window.ctaGalleryFeedback.messages.ajaxUrl) || '',
            nonce: (window.ctaGalleryFeedback && window.ctaGalleryFeedback.nonce) || ''
        },
        messages: (window.ctaGalleryFeedback && window.ctaGalleryFeedback.messages) || {},
        modal: null,
        previouslyFocused: null,
        currentTarget: null
    };

    function init() {
        state.modal = $(selectors.modal);
        if (!state.modal.length) {
            return;
        }

        bindOpenEvents();
        bindCloseEvents();
        bindReactionEvents();
        bindSubmit();
        updateAllPreviews();
    }

    function bindOpenEvents() {
        $(document).on('click', selectors.openButton, function (event) {
            event.preventDefault();
            var targetId = $(event.currentTarget).data('feedback-target');
            openModal(targetId, event.currentTarget);
        });
    }

    function bindCloseEvents() {
        $(document).on('click', selectors.closeButton + ',' + selectors.backdrop, function (event) {
            event.preventDefault();
            closeModal();
        });

        $(document).on('keydown', function (event) {
            if (event.key === 'Escape' && state.modal.hasClass('is-open')) {
                closeModal();
            }
        });
    }

    function bindReactionEvents() {
        state.modal.on('change', selectors.reactionRadio, function (event) {
            var $input = $(event.currentTarget);
            selectReaction($input);
        });

        state.modal.on('click', selectors.reactionOption, function (event) {
            var $label = $(event.currentTarget);
            var $input = $label.find('input[type="radio"]');
            if ($input.length) {
                $input.prop('checked', true).trigger('change');
            }
        });
    }

    function bindSubmit() {
        state.modal.on('submit', selectors.form, function (event) {
            event.preventDefault();

            var $form = $(event.currentTarget);
            var $response = $form.find(selectors.response);
            var $submit = $form.find(selectors.submit);
            var reaction = $form.find(selectors.reactionRadio + ':checked').val() || '';
            var rating = $form.find(selectors.ratingInput).val();

            if (!reaction) {
                $response.text(state.messages.reactionRequired || 'Please choose a reaction.');
                return;
            }

            if (!rating) {
                $response.text(state.messages.ratingRequired || 'Please choose a rating.');
                return;
            }

            $submit.prop('disabled', true);
            $response.text('');

            var formData = {
                action: 'cta_gallery_feedback',
                nonce: state.ajax.nonce,
                image_id: $form.find('input[name="image_id"]').val(),
                reaction: reaction,
                rating: rating,
                comment: $form.find('textarea[name="comment"]').val(),
                name: $form.find('input[name="name"]').val(),
                email: $form.find('input[name="email"]').val(),
                cta_feedback_url: $form.find('input[name="cta_feedback_url"]').val()
            };

            $.ajax({
                url: state.ajax.url || (typeof ctaSectionsData !== 'undefined' ? ctaSectionsData.ajaxUrl : ''),
                type: 'POST',
                data: formData
            }).done(function (response) {
                if (response && response.success) {
                    var messageKey = response.data && response.data.comment_pending ? 'commentPending' : 'commentApproved';
                    var message = (state.messages && state.messages[messageKey]) || (response.data && response.data.message) || state.messages.success || '';
                    $response.text(message);
                    if (response.data && response.data.aggregates && state.currentTarget) {
                        updateDataset(formData.image_id, response.data);
                    }
                    resetForm($form, true);
                    setTimeout(closeModal, 1200);
                } else {
                    var failMessage = (response && response.data && response.data.message) || state.messages.error || 'Unable to save feedback. Please try again.';
                    $response.text(failMessage);
                }
            }).fail(function () {
                $response.text(state.messages.error || 'Unable to save feedback. Please try again.');
            }).always(function () {
                $submit.prop('disabled', false);
            });
        });
    }

    function openModal(id, triggerEl) {
        var datasetEntry = ensureDatasetEntry(id);
        state.previouslyFocused = triggerEl || document.activeElement;
        state.currentTarget = id;

        var $form = state.modal.find(selectors.form);
        $form[0].reset();
        $form.find(selectors.ratingInput).val('');
        $form.find(selectors.reactionOption).removeClass('is-selected');
        $form.find(selectors.reactionRadio).prop('checked', false);
        $form.find(selectors.response).text('');
        $form.find('input[name="image_id"]').val(id || '');

        populateMeta(datasetEntry.meta || {});
        updateModalSubtitle(datasetEntry.meta || {});

        state.modal.addClass('is-open').attr('aria-hidden', 'false');
        $('body').addClass('cta-feedback-open');

        var firstField = state.modal.find(selectors.nameField);
        if (firstField.length) {
            firstField.trigger('focus');
        }
    }

    function closeModal() {
        if (!state.modal) {
            return;
        }
        state.modal.removeClass('is-open').attr('aria-hidden', 'true');
        $('body').removeClass('cta-feedback-open');
        if (state.previouslyFocused && typeof state.previouslyFocused.focus === 'function') {
            state.previouslyFocused.focus();
        }
    }

    function selectReaction($input) {
        var $list = $input.closest(selectors.reactionList);
        $list.find(selectors.reactionOption).removeClass('is-selected');
        $input.closest(selectors.reactionOption).addClass('is-selected');

        var rating = $input.data('rating');
        var $form = $input.closest(selectors.form);
        $form.find(selectors.ratingInput).val(rating || '');
    }

    function resetForm($form, keepMessage) {
        $form.find(selectors.commentField).val('');
        if (!keepMessage) {
            $form.find(selectors.response).text('');
        }
        $form.find(selectors.reactionOption).removeClass('is-selected');
        $form.find(selectors.reactionRadio).prop('checked', false);
        $form.find(selectors.ratingInput).val('');
    }

    function populateMeta(meta) {
        var $image = state.modal.find(selectors.imageField);
        var $title = state.modal.find(selectors.titleField);
        var $caption = state.modal.find(selectors.captionField);

        if ($image.length) {
            if (meta.image) {
                $image.attr('src', meta.image).attr('alt', meta.title || meta.subtitle || '');
                $image.show();
            } else {
                $image.hide();
            }
        }

        $title.text(meta.title || meta.headline || '');
        $caption.text(meta.description || meta.subtitle || meta.headline || '');
    }

    function updateModalSubtitle(meta) {
        var $subtitle = state.modal.find(selectors.subtitleField);
        if (!$subtitle.length) {
            return;
        }

        var template = state.strings.modal_subtitle || '';
        var title = meta.title || meta.headline || '';

        if (template && title) {
            $subtitle.text(template.replace('%s', title));
        } else {
            $subtitle.text('');
        }
    }

    function updateDataset(id, payload) {
        if (!id) {
            return;
        }

        if (!state.dataset[id]) {
            state.dataset[id] = {};
        }

        if (payload.aggregates) {
            state.dataset[id].aggregates = payload.aggregates;
        }

        if (payload.comments) {
            state.dataset[id].comments = payload.comments;
        }

        renderPreview(id);
    }

    function updateAllPreviews() {
        $('[data-feedback-id]').each(function () {
            var $card = $(this);
            var id = $card.data('feedbackId');

            if (!id) {
                return;
            }

            ensureDatasetEntry(id);
            renderPreview(id);
        });
    }

    function ensureDatasetEntry(id) {
        if (!id) {
            return {};
        }

        if (!state.dataset[id]) {
            state.dataset[id] = {
                aggregates: null,
                comments: [],
                meta: getMetaFromCard(id)
            };
        } else if (!state.dataset[id].meta || $.isEmptyObject(state.dataset[id].meta)) {
            state.dataset[id].meta = getMetaFromCard(id);
        }

        return state.dataset[id];
    }

    function getMetaFromCard(id) {
        var $card = getCard(id);
        if (!$card.length) {
            return {};
        }

        var meta = $card.data('feedbackMeta');

        if (typeof meta === 'string') {
            try {
                meta = JSON.parse(meta);
            } catch (e) {
                meta = {};
            }
        }

        return meta || {};
    }

    function getCard(id) {
        return $('[data-feedback-id="' + id + '"]');
    }

    function renderPreview(id) {
        if (!id) {
            return;
        }

        var $card = getCard(id);
        if (!$card.length) {
            return;
        }

        var $preview = $card.find(selectors.preview);
        if (!$preview.length) {
            return;
        }

        var entry = ensureDatasetEntry(id);
        var aggregates = entry.aggregates || {};
        var total = parseInt(aggregates.total, 10) || 0;

        $preview.empty();

        if (!total) {
            $preview.addClass('is-empty').text(state.strings.no_ratings_label || 'No ratings yet');
            return;
        }

        $preview.removeClass('is-empty');

        var chips = [];

        if (aggregates.avg_rating) {
            var $ratingChip = $('<span>').addClass('cta-gallery-card__metric');
            $('<span>').addClass('cta-gallery-card__metric-icon').text('⭐').attr('aria-hidden', 'true').appendTo($ratingChip);
            $('<span>').addClass('cta-gallery-card__metric-label').text((state.strings.average_label || 'Average rating') + ':').appendTo($ratingChip);
            $('<strong>').text(aggregates.avg_rating).appendTo($ratingChip);
            chips.push($ratingChip);
        }

        var votesLabel = state.strings.total_votes_label || 'Votes';
        var $votesChip = $('<span>').addClass('cta-gallery-card__metric');
        $('<span>').addClass('cta-gallery-card__metric-icon').text('🗳️').attr('aria-hidden', 'true').appendTo($votesChip);
        $('<span>').addClass('cta-gallery-card__metric-label').text(votesLabel + ':').appendTo($votesChip);
        $('<strong>').text(total).appendTo($votesChip);
        chips.push($votesChip);

        var reactionStrings = state.strings.reactions || {};
        var reactionMap = {
            like: { key: 'likes', fallbackIcon: '👍' },
            love: { key: 'loves', fallbackIcon: '❤️' },
            dislike: { key: 'dislikes', fallbackIcon: '👎' }
        };

        Object.keys(reactionMap).forEach(function (reaction) {
            var map = reactionMap[reaction];
            var count = parseInt(aggregates[map.key], 10) || 0;

            if (!count) {
                return;
            }

            var reactionConfig = reactionStrings[reaction] || {};
            var icon = reactionConfig.icon || map.fallbackIcon;
            var label = reactionConfig.label || reaction.charAt(0).toUpperCase() + reaction.slice(1);

            var $chip = $('<span>').addClass('cta-gallery-card__reaction');
            $('<span>').addClass('cta-gallery-card__reaction-icon').attr('aria-hidden', 'true').text(icon).appendTo($chip);
            $('<span>').addClass('cta-gallery-card__reaction-label').text(label).appendTo($chip);
            $('<strong>').text(count).appendTo($chip);
            chips.push($chip);
        });

        if (!chips.length) {
            $preview.addClass('is-empty').text(state.strings.no_ratings_label || 'No ratings yet');
            return;
        }

        chips.forEach(function ($chip) {
            $preview.append($chip);
        });
    }

    $(document).ready(init);
})(jQuery);
