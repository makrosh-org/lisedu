/**
 * Lumina International School Custom Scripts
 * 
 * @package Lumina_Child_Theme
 * @version 1.0.0
 */

(function($) {
    'use strict';
    
    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        
        // Mobile menu toggle
        initMobileMenu();
        
        // Smooth scroll for anchor links
        initSmoothScroll();
        
        // Form validation enhancements
        initFormValidation();
        
        // Lazy loading fallback for older browsers
        initLazyLoadFallback();
    });
    
    /**
     * Initialize mobile menu functionality
     */
    function initMobileMenu() {
        // Add mobile menu toggle if not already present
        if ($('.mobile-menu-toggle').length === 0 && $('.main-navigation').length > 0) {
            $('.main-navigation').prepend('<button class="mobile-menu-toggle" aria-label="Toggle Menu"><span></span><span></span><span></span></button>');
        }
        
        // Toggle menu on click
        $(document).on('click', '.mobile-menu-toggle', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            $('.main-navigation ul').toggleClass('mobile-active');
            $('body').toggleClass('menu-open');
        });
        
        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation').length && $('.main-navigation ul').hasClass('mobile-active')) {
                $('.mobile-menu-toggle').removeClass('active');
                $('.main-navigation ul').removeClass('mobile-active');
                $('body').removeClass('menu-open');
            }
        });
    }
    
    /**
     * Initialize smooth scrolling for anchor links
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            }
        });
    }
    
    /**
     * Initialize form validation enhancements
     */
    function initFormValidation() {
        // Add real-time validation feedback
        $('input[required], textarea[required], select[required]').on('blur', function() {
            validateField($(this));
        });
        
        // Email validation
        $('input[type="email"]').on('blur', function() {
            validateEmail($(this));
        });
        
        // Phone validation
        $('input[type="tel"]').on('blur', function() {
            validatePhone($(this));
        });
    }
    
    /**
     * Validate a required field
     */
    function validateField($field) {
        var value = $field.val().trim();
        
        if (value === '') {
            showFieldError($field, 'This field is required');
            return false;
        } else {
            clearFieldError($field);
            return true;
        }
    }
    
    /**
     * Validate email format
     */
    function validateEmail($field) {
        var email = $field.val().trim();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email !== '' && !emailRegex.test(email)) {
            showFieldError($field, 'Please enter a valid email address');
            return false;
        } else if (email !== '') {
            clearFieldError($field);
            return true;
        }
        return true;
    }
    
    /**
     * Validate phone format
     */
    function validatePhone($field) {
        var phone = $field.val().trim();
        var phoneRegex = /^[\d\s\-\+\(\)]+$/;
        
        if (phone !== '' && !phoneRegex.test(phone)) {
            showFieldError($field, 'Please enter a valid phone number');
            return false;
        } else if (phone !== '') {
            clearFieldError($field);
            return true;
        }
        return true;
    }
    
    /**
     * Show field error message
     */
    function showFieldError($field, message) {
        $field.addClass('error');
        
        // Remove existing error message
        $field.siblings('.field-error').remove();
        
        // Add new error message
        $field.after('<span class="field-error" style="color: #d32f2f; font-size: 0.875rem; display: block; margin-top: 4px;">' + message + '</span>');
    }
    
    /**
     * Clear field error
     */
    function clearFieldError($field) {
        $field.removeClass('error');
        $field.siblings('.field-error').remove();
    }
    
    /**
     * Initialize lazy loading fallback for older browsers
     */
    function initLazyLoadFallback() {
        // Check if browser supports native lazy loading
        if ('loading' in HTMLImageElement.prototype) {
            return; // Native lazy loading is supported
        }
        
        // Fallback for older browsers
        var lazyImages = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            var imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var image = entry.target;
                        if (image.dataset.src) {
                            image.src = image.dataset.src;
                        }
                        image.classList.add('loaded');
                        imageObserver.unobserve(image);
                    }
                });
            });
            
            lazyImages.forEach(function(image) {
                imageObserver.observe(image);
            });
        } else {
            // Fallback for browsers without IntersectionObserver
            lazyImages.forEach(function(image) {
                if (image.dataset.src) {
                    image.src = image.dataset.src;
                }
            });
        }
    }
    
})(jQuery);
