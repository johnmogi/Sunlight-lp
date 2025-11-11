jQuery(document).ready(function($) {
    console.log('CTA Slider loaded');

    let currentSlide = 0;
    const slides = $('.cta-slide');
    const totalSlides = slides.length;

    // Navigation
    $('.cta-prev').on('click', function() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    });

    $('.cta-next').on('click', function() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    });

    function showSlide(index) {
        slides.removeClass('active');
        slides.eq(index).addClass('active');
        // Hide all forms when changing slides
        $('.cta-form').removeClass('show');
        $('.cta-toggle').removeClass('active');
    }

    // Toggle form
    $('.cta-toggle').on('click', function() {
        const formId = $(this).data('form');
        const $form = $('#' + formId);
        const $button = $(this);

        console.log('Toggle clicked:', formId);

        // Close other forms
        $('.cta-form').not($form).removeClass('show');
        $('.cta-toggle').not($button).removeClass('active');

        // Toggle this form
        $form.toggleClass('show');
        $button.toggleClass('active');
    });

    // Form submission
    $('.cta-submit-form').on('submit', function(e) {
        e.preventDefault();
        console.log('Form submitted');

        const $form = $(this);
        const $message = $form.siblings('.cta-message');
        const name = $form.find('input[name="name"]').val();
        const email = $form.find('input[name="email"]').val();
        const website = $form.find('input[name="website"]').val(); // Honeypot

        $.ajax({
            url: ctaData.ajaxUrl,
            type: 'POST',
            data: {
                action: 'cta_submit',
                nonce: ctaData.nonce,
                name: name,
                email: email,
                website: website
            },
            success: function(response) {
                console.log('Response:', response);
                if (response.success) {
                    $message.removeClass('error').addClass('success').text(response.data.message);
                    $form[0].reset();
                } else {
                    $message.removeClass('success').addClass('error').text(response.data.message);
                }
            },
            error: function() {
                $message.removeClass('success').addClass('error').text('An error occurred. Please try again.');
            }
        });
    });
});
