jQuery(document).ready(function($) {
    'use strict';

    let currentSlide = 0;
    const $slides = $('.cta-slider__slide');
    const $dots = $('.cta-slider__dot');
    const totalSlides = $slides.length;

    if (totalSlides === 0) {
        return;
    }

    // Navigation - Previous
    $('.cta-slider__nav-btn--prev').on('click', function() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    });

    // Navigation - Next
    $('.cta-slider__nav-btn--next').on('click', function() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    });

    // Navigation - Dots
    $dots.on('click', function() {
        const index = parseInt($(this).data('index'), 10);
        if (!isNaN(index) && index !== currentSlide) {
            currentSlide = index;
            showSlide(currentSlide);
        }
    });

    function showSlide(index) {
        // Update slides
        $slides.removeClass('is-active');
        $slides.eq(index).addClass('is-active');

        // Update dots
        $dots.removeClass('is-active').attr('aria-selected', 'false');
        $dots.eq(index).addClass('is-active').attr('aria-selected', 'true');

        // Hide all forms when changing slides
        $('.cta-slider__form-wrapper').removeClass('is-visible');
        $('.cta-slider__cta').removeClass('is-active');
    }

    // Toggle form
    $('.cta-slider__cta').on('click', function() {
        const formId = $(this).data('form');
        const $formWrapper = $('#' + formId);
        const $button = $(this);

        // Close other forms
        $('.cta-slider__form-wrapper').not($formWrapper).removeClass('is-visible');
        $('.cta-slider__cta').not($button).removeClass('is-active');

        // Toggle this form
        $formWrapper.toggleClass('is-visible');
        $button.toggleClass('is-active');
    });

    // Form submission with security
    $('.cta-slider__form').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $message = $form.closest('.cta-slider__form-wrapper').find('.cta-slider__message');
        const $submitBtn = $form.find('.cta-slider__form-submit');
        
        // Get form data
        const name = $form.find('input[name="name"]').val().trim();
        const email = $form.find('input[name="email"]').val().trim();
        const website = $form.find('input[name="website"]').val(); // Honeypot - should be empty

        // Basic client-side validation
        if (!name || !email) {
            $message.removeClass('success').addClass('error').text('Please fill in all fields.');
            return;
        }

        // Disable submit button
        const originalText = $submitBtn.find('.cta-slider__form-submit-text').text();
        $submitBtn.prop('disabled', true).find('.cta-slider__form-submit-text').text('Sending...');

        // AJAX submission with nonce and honeypot
        $.ajax({
            url: ctaData.ajaxUrl,
            type: 'POST',
            data: {
                action: 'cta_submit',
                nonce: ctaData.nonce,
                name: name,
                email: email,
                website: website // Honeypot field
            },
            success: function(response) {
                if (response && response.success) {
                    $message.removeClass('error').addClass('success').text(response.data.message || 'Thank you for subscribing!');
                    $form[0].reset();
                } else {
                    const errorMsg = (response && response.data && response.data.message) 
                        ? response.data.message 
                        : 'Something went wrong. Please try again.';
                    $message.removeClass('success').addClass('error').text(errorMsg);
                }
            },
            error: function() {
                $message.removeClass('success').addClass('error').text('Network error. Please try again.');
            },
            complete: function() {
                // Re-enable submit button
                $submitBtn.prop('disabled', false).find('.cta-slider__form-submit-text').text(originalText);
            }
        });
    });

    // Keyboard navigation
    $(document).on('keydown', function(e) {
        if (!$('.cta-slider').length) {
            return;
        }

        if (e.key === 'ArrowLeft') {
            $('.cta-slider__nav-btn--prev').trigger('click');
        } else if (e.key === 'ArrowRight') {
            $('.cta-slider__nav-btn--next').trigger('click');
        }
    });
});
