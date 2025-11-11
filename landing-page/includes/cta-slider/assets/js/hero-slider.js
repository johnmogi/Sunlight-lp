/**
 * Hero Slider JavaScript
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        console.log('🎯 Hero Slider JS Loaded');
        
        // Carousel Variables
        var sliderSlides = $('.sunlight-hero-slider .carousel-slide');
        var sliderTotal = sliderSlides.length;
        var currentSlide = sliderSlides.index(sliderSlides.filter('.active'));
        currentSlide = currentSlide >= 0 ? currentSlide : 0;
        
        console.log('📊 Slider Stats:', {
            totalSlides: sliderTotal,
            currentSlide: currentSlide,
            slidesFound: sliderSlides.length
        });

        function normalizeIndex(index) {
            if (!sliderTotal) {
                return 0;
            }
            return (index + sliderTotal) % sliderTotal;
        }

        function goToSliderSlide(slideIndex) {
            if (!sliderTotal) {
                return;
            }

            currentSlide = normalizeIndex(slideIndex);

            sliderSlides.removeClass('active');

            var $targetSlide = sliderSlides.filter('.slide-' + currentSlide);
            if (!$targetSlide.length) {
                $targetSlide = sliderSlides.eq(currentSlide);
            }

            $targetSlide.addClass('active');

            var $slider = $('.sunlight-hero-slider');
            $slider.find('.hero-quick-signup').removeClass('show');
            $slider.find('.hero-cta-toggle').removeClass('active');
        }

        $('#slider-next').on('click', function(e) {
            e.preventDefault();
            goToSliderSlide(currentSlide + 1);
        });

        $('#slider-prev').on('click', function(e) {
            e.preventDefault();
            goToSliderSlide(currentSlide - 1);
        });

        var sliderAutoPlayInterval = null;
        if (sliderTotal > 1) {
            sliderAutoPlayInterval = setInterval(function() {
                goToSliderSlide(currentSlide + 1);
            }, 15000);
        }

        $('.carousel-nav').on('click', function() {
            if (sliderAutoPlayInterval) {
                clearInterval(sliderAutoPlayInterval);
                sliderAutoPlayInterval = null;
            }
        });

        // Debug: Check if CTA buttons exist
        var ctaButtons = $('.hero-cta-toggle');
        console.log('🔘 CTA Buttons found:', ctaButtons.length);
        
        $('.hero-cta-toggle').on('click', function(e) {
            e.preventDefault();
            console.log('🖱️ CTA Button clicked!');
            
            var $button = $(this);
            var formId = $button.data('form');
            var $form = $('#' + formId);
            
            console.log('📋 Form Debug:', {
                buttonClicked: true,
                formId: formId,
                formFound: $form.length,
                formElement: $form,
                hasShowClass: $form.hasClass('show')
            });
            
            // Close all other forms
            $('.hero-quick-signup').not($form).removeClass('show');
            $('.hero-cta-toggle').not($button).removeClass('active');
            
            // Toggle this form
            $form.toggleClass('show');
            $button.toggleClass('active');
            
            console.log('✅ After toggle - Form has show class:', $form.hasClass('show'));

            if (sliderAutoPlayInterval) {
                clearInterval(sliderAutoPlayInterval);
                sliderAutoPlayInterval = null;
            }
        });
        
        // Hero Signup Forms - Handle all forms dynamically
        $('.hero-signup-form').on('submit', function(e) {
            e.preventDefault();
            
            var $thisForm = $(this);
            var project = $thisForm.find('input[name=project]').val();
            var nonceName = project === 'sunlight-tarot' ? 'tarot_signup_nonce' : 
                            (project === 'maze-chronicles' ? 'novels_signup_nonce' : 'game_signup_nonce');
            
            var formData = {
                action: 'sunlight_hero_signup',
                nonce: $thisForm.find('#' + nonceName).val(),
                name: $thisForm.find('input[name=name]').val(),
                email: $thisForm.find('input[name=email]').val(),
                project: project,
                consent: $thisForm.find('input[name=consent]').is(':checked')
            };
            
            $.ajax({
                url: heroSliderData.ajaxUrl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        var projectName = project === 'sunlight-tarot' ? 'Sunlight Tarot' : 
                                        (project === 'maze-chronicles' ? 'Maze Chronicles' : 'The Maze Game');
                        var emoji = project === 'sunlight-tarot' ? '✨' : 
                                   (project === 'maze-chronicles' ? '📚' : '🎮');
                        
                        $thisForm.closest('.hero-quick-signup').html('<div class="signup-success-message" style="background:white;padding:2rem;border-radius:10px;text-align:center;border:2px solid #fdcb6e;"><h3>' + emoji + ' Welcome to ' + projectName + '!</h3><p>' + response.data.message + '</p><p style="margin-top:1rem;font-size:0.9rem;">Check your email for next steps.</p></div>');
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });

})(jQuery);
