/**
 * ============================================
 * FRONTEND JAVASCRIPT
 * ============================================
 * Handles FAQ accordion and other frontend interactions
 */

jQuery(document).ready(function($) {
    
    // ============================================
    // FAQ ACCORDION
    // ============================================
    $('.faq-question').on('click', function() {
        var faqId = $(this).data('faq');
        var answer = $('#faq-' + faqId);
        
        // Toggle current FAQ
        $(this).toggleClass('active');
        answer.toggleClass('active').slideToggle(300);
        
        // Optional: Close other FAQs (comment out if you want multiple open)
        $('.faq-question').not(this).removeClass('active');
        $('.faq-answer').not(answer).removeClass('active').slideUp(300);
    });
    
    // ============================================
    // SMOOTH SCROLL TO SECTIONS
    // ============================================
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 600);
        }
    });
    
});

