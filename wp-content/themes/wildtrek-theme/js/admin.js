/**
 * ============================================
 * WILDTREK ADMIN JAVASCRIPT
 * ============================================
 * Handles all admin panel functionality for package management
 */

jQuery(document).ready(function($) {
    
    // ============================================
    // MEDIA UPLOADER: HERO IMAGE
    // ============================================
    $('.upload-hero-image').on('click', function(e) {
        e.preventDefault();
        var button = $(this);
        var input = $('#package_hero_image');
        
        var mediaUploader = wp.media({
            title: 'Select Hero/Banner Image',
            button: { text: 'Use this image' },
            multiple: false
        });
        
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            input.val(attachment.url);
            
            // Show preview
            var preview = '<div style="margin-top: 10px;"><img src="' + attachment.url + '" style="max-width: 300px; height: auto; border: 1px solid #ddd; padding: 5px;" /></div>';
            button.parent().find('img').parent().remove();
            button.parent().append(preview);
        });
        
        mediaUploader.open();
    });
    
    // ============================================
    // MEDIA UPLOADER: GALLERY IMAGES
    // ============================================
    var galleryIndex = $('.gallery-item-row').length;
    
    $(document).on('click', '.upload-gallery-image', function(e) {
        e.preventDefault();
        var button = $(this);
        var row = button.closest('.gallery-item-row');
        var input = row.find('.gallery-url');
        
        var mediaUploader = wp.media({
            title: 'Select Gallery Image',
            button: { text: 'Use this image' },
            multiple: false
        });
        
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            input.val(attachment.url);
            
            // Update preview
            var img = row.find('img');
            if (img.length) {
                img.attr('src', attachment.url);
            } else {
                row.find('div').first().prepend('<img src="' + attachment.url + '" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ccc;" />');
            }
        });
        
        mediaUploader.open();
    });
    
    // ============================================
    // ADD GALLERY IMAGE
    // ============================================
    $('#add-gallery-image').on('click', function() {
        var html = `
        <div class="gallery-item-row" style="margin-bottom: 15px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="flex: 1;">
                    <input type="text" name="package_gallery[${galleryIndex}][url]" value="" class="large-text gallery-url" placeholder="Image URL" readonly />
                    <input type="text" name="package_gallery[${galleryIndex}][caption]" value="" class="large-text" placeholder="Image Caption (optional)" style="margin-top: 5px;" />
                </div>
                <div>
                    <button type="button" class="button upload-gallery-image">📁 Upload</button>
                    <button type="button" class="button remove-gallery" style="background: #dc3232; color: white;">🗑️ Remove</button>
                </div>
            </div>
        </div>
        `;
        $('#gallery-repeater').append(html);
        galleryIndex++;
    });
    
    // ============================================
    // REMOVE GALLERY IMAGE
    // ============================================
    $(document).on('click', '.remove-gallery', function() {
        if (confirm('Are you sure you want to remove this image?')) {
            $(this).closest('.gallery-item-row').slideUp(300, function() {
                $(this).remove();
            });
        }
    });
    
    // ============================================
    // ADD NEW STAT
    // ============================================
    var statIndex = $('.stat-item-row').length;
    $('#add-stat').on('click', function() {
        var html = `
        <div class="stat-item-row" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <table class="form-table">
                <tr>
                    <td style="width: 33%;">
                        <label>Icon/Emoji:</label><br>
                        <input type="text" name="package_stats[${statIndex}][icon]" value="" class="regular-text" placeholder="📅 or dashicons-calendar" />
                        <p class="description">Use emoji or dashicons class</p>
                    </td>
                    <td style="width: 33%;">
                        <label>Label:</label><br>
                        <input type="text" name="package_stats[${statIndex}][label]" value="" class="regular-text" placeholder="Tour Duration" />
                    </td>
                    <td style="width: 33%;">
                        <label>Value:</label><br>
                        <input type="text" name="package_stats[${statIndex}][value]" value="" class="regular-text" placeholder="8 Days" />
                    </td>
                </tr>
            </table>
            <button type="button" class="button remove-stat" style="background: #dc3232; color: white;">🗑️ Remove</button>
        </div>
        `;
        $('#stats-repeater').append(html);
        statIndex++;
    });
    
    // ============================================
    // REMOVE STAT
    // ============================================
    $(document).on('click', '.remove-stat', function() {
        if (confirm('Are you sure you want to remove this stat?')) {
            $(this).closest('.stat-item-row').slideUp(300, function() {
                $(this).remove();
            });
        }
    });
    
    // ============================================
    // ADD ITINERARY DAY
    // ============================================
    var dayIndex = $('.itinerary-day-row').length;
    $('#add-itinerary-day').on('click', function() {
        dayIndex++;
        var html = `
        <div class="itinerary-day-row" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3 style="margin-top: 0;">Day ${dayIndex}</h3>
            <table class="form-table">
                <tr>
                    <th style="width: 200px;"><label>Day Label:</label></th>
                    <td>
                        <input type="text" name="package_itinerary[${dayIndex - 1}][day]" value="Day ${dayIndex}" class="regular-text" placeholder="Day ${dayIndex}" />
                    </td>
                </tr>
                <tr>
                    <th><label>Activity/Title:</label></th>
                    <td>
                        <input type="text" name="package_itinerary[${dayIndex - 1}][title]" value="" class="large-text" placeholder="Arrival & Orientation" />
                    </td>
                </tr>
                <tr>
                    <th><label>Description:</label></th>
                    <td>
                        <textarea name="package_itinerary[${dayIndex - 1}][description]" rows="5" class="large-text"></textarea>
                        <p class="description">Describe what happens on this day</p>
                    </td>
                </tr>
            </table>
            <button type="button" class="button remove-itinerary" style="background: #dc3232; color: white;">🗑️ Remove Day</button>
        </div>
        `;
        $('#itinerary-repeater').append(html);
    });
    
    // ============================================
    // REMOVE ITINERARY DAY
    // ============================================
    $(document).on('click', '.remove-itinerary', function() {
        if (confirm('Are you sure you want to remove this day?')) {
            $(this).closest('.itinerary-day-row').slideUp(300, function() {
                $(this).remove();
                // Renumber remaining days
                $('.itinerary-day-row').each(function(index) {
                    $(this).find('h3').text('Day ' + (index + 1));
                });
                dayIndex = $('.itinerary-day-row').length;
            });
        }
    });
    
    // ============================================
    // ADD FAQ
    // ============================================
    var faqIndex = $('.faq-item-row').length;
    $('#add-faq').on('click', function() {
        var editorId = 'package_faqs_' + faqIndex + '_answer';
        var html = `
        <div class="faq-item-row" style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; background: #f9f9f9;">
            <h3 style="margin-top: 0;">FAQ #${faqIndex + 1}</h3>
            <table class="form-table">
                <tr>
                    <th style="width: 150px;"><label>Question:</label></th>
                    <td>
                        <input type="text" name="package_faqs[${faqIndex}][question]" value="" class="large-text" placeholder="e.g., How long is the trek?" />
                    </td>
                </tr>
                <tr>
                    <th><label>Answer:</label></th>
                    <td>
                        <textarea name="package_faqs[${faqIndex}][answer]" id="${editorId}" class="large-text faq-answer-textarea" rows="6"></textarea>
                        <p class="description">Write a detailed answer (you can add formatting after saving)</p>
                    </td>
                </tr>
            </table>
            <button type="button" class="button remove-faq" style="background: #dc3232; color: white;">🗑️ Remove FAQ</button>
        </div>
        `;
        $('#faq-repeater').append(html);
        faqIndex++;
    });
    
    // ============================================
    // REMOVE FAQ
    // ============================================
    $(document).on('click', '.remove-faq', function() {
        if (confirm('Are you sure you want to remove this FAQ?')) {
            $(this).closest('.faq-item-row').slideUp(300, function() {
                $(this).remove();
                // Renumber remaining FAQs
                $('.faq-item-row').each(function(index) {
                    $(this).find('h3').text('FAQ #' + (index + 1));
                });
                faqIndex = $('.faq-item-row').length;
            });
        }
    });
    
    // ============================================
    // FORM VALIDATION
    // ============================================
    $('form#post').on('submit', function() {
        var title = $('#title').val();
        if (!title || title.trim() === '') {
            alert('Please enter a package title!');
            $('#title').focus();
            return false;
        }
    });
    
    // ============================================
    // AUTO-SAVE NOTIFICATION
    // ============================================
    $(document).on('heartbeat-tick.autosave', function() {
        console.log('Package data auto-saved');
    });
    
});
