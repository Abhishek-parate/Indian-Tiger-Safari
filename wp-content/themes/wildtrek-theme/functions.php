<?php
/**
 * ============================================
 * WILDTREK THEME FUNCTIONS - COMPLETE VERSION
 * ============================================
 * Custom WordPress theme for dynamic package pages
 * No plugins required - Pure WordPress functionality
 */

// ============================================
// THEME SETUP
// ============================================
function wildtrek_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'wildtrek'),
    ));
}
add_action('after_setup_theme', 'wildtrek_theme_setup');

// ============================================
// ENQUEUE FRONTEND STYLES & SCRIPTS
// ============================================
function wildtrek_enqueue_styles() {
    // Main theme stylesheet
    wp_enqueue_style('wildtrek-style', get_stylesheet_uri(), array(), '2.0');
    
    // Dashicons for frontend (for stat icons)
    wp_enqueue_style('dashicons');
    
    // Google Fonts (optional but recommended)
    wp_enqueue_style('wildtrek-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap', array(), null);
}
add_action('wp_enqueue_scripts', 'wildtrek_enqueue_styles');

function wildtrek_enqueue_scripts() {
    // jQuery (already included in WordPress)
    wp_enqueue_script('jquery');
    
    // Custom frontend script for FAQ accordion
    wp_enqueue_script('wildtrek-frontend', get_template_directory_uri() . '/js/frontend.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'wildtrek_enqueue_scripts');


// ============================================
// REGISTER CUSTOM POST TYPE - PACKAGES
// ============================================
function wildtrek_register_package_post_type() {
    $labels = array(
        'name'                  => 'Packages',
        'singular_name'         => 'Package',
        'menu_name'             => 'Packages',
        'name_admin_bar'        => 'Package',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Package',
        'new_item'              => 'New Package',
        'edit_item'             => 'Edit Package',
        'view_item'             => 'View Package',
        'all_items'             => 'All Packages',
        'search_items'          => 'Search Packages',
        'not_found'             => 'No packages found.',
        'not_found_in_trash'    => 'No packages found in Trash.'
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-palmtree',
        'query_var'             => true,
        'rewrite'               => array('slug' => 'package'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'show_in_rest'          => true,
    );

    register_post_type('package', $args);
}
add_action('init', 'wildtrek_register_package_post_type');

// ============================================
// ADD META BOXES FOR ALL PACKAGE SECTIONS
// ============================================
function wildtrek_add_package_meta_boxes() {
    
    // PACKAGE DETAILS SECTION
    add_meta_box(
        'package_details',
        '📋 Package Details',
        'wildtrek_package_details_callback',
        'package',
        'normal',
        'high'
    );
    
    // HERO/BANNER SECTION
    add_meta_box(
        'package_hero_section',
        '🎯 Hero/Banner Section',
        'wildtrek_hero_section_callback',
        'package',
        'normal',
        'high'
    );
    
    // GALLERY SECTION
    add_meta_box(
        'package_gallery',
        '🖼️ Package Gallery',
        'wildtrek_gallery_callback',
        'package',
        'normal',
        'default'
    );
    
    // PACKAGE STATS/FEATURES SECTION
    add_meta_box(
        'package_stats',
        '📊 Package Statistics/Features',
        'wildtrek_stats_callback',
        'package',
        'normal',
        'default'
    );
    
    // OVERVIEW SECTION
    add_meta_box(
        'package_overview',
        '📝 Overview Section',
        'wildtrek_overview_callback',
        'package',
        'normal',
        'default'
    );
    
    // ITINERARY SECTION
    add_meta_box(
        'package_itinerary',
        '🗓️ Itinerary (Day by Day)',
        'wildtrek_itinerary_callback',
        'package',
        'normal',
        'default'
    );
    
    // PACKAGE HIGHLIGHTS SECTION
    add_meta_box(
        'package_highlights',
        '⭐ Package Highlights',
        'wildtrek_highlights_callback',
        'package',
        'normal',
        'default'
    );
    
    // WHAT'S INCLUDED SECTION
    add_meta_box(
        'package_whats_included',
        '✅ What\'s Included',
        'wildtrek_whats_included_callback',
        'package',
        'normal',
        'default'
    );
    
    // WHAT'S EXCLUDED SECTION
    add_meta_box(
        'package_whats_excluded',
        '❌ What\'s Excluded',
        'wildtrek_whats_excluded_callback',
        'package',
        'normal',
        'default'
    );
    
    // COST SECTION
    add_meta_box(
        'package_cost',
        '💰 Cost & Pricing Details',
        'wildtrek_cost_callback',
        'package',
        'normal',
        'default'
    );
    
    // FAQ SECTION
    add_meta_box(
        'package_faq',
        '❓ FAQs (Frequently Asked Questions)',
        'wildtrek_faq_callback',
        'package',
        'normal',
        'default'
    );
    
    // TERMS & CONDITIONS SECTION
    add_meta_box(
        'package_terms',
        '📜 Terms & Conditions',
        'wildtrek_terms_callback',
        'package',
        'normal',
        'default'
    );
    
    // LOCATION/MAP SECTION
    add_meta_box(
        'package_location',
        '📍 Location & Map',
        'wildtrek_location_callback',
        'package',
        'normal',
        'default'
    );
    
    // SEO SETTINGS (SIDEBAR)
    add_meta_box(
        'package_seo',
        '🔍 SEO Settings',
        'wildtrek_seo_callback',
        'package',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'wildtrek_add_package_meta_boxes');

// ============================================
// META BOX CALLBACK: PACKAGE DETAILS
// ============================================
function wildtrek_package_details_callback($post) {
    wp_nonce_field('wildtrek_save_package_data', 'wildtrek_package_nonce');
    
    $package_subtitle = get_post_meta($post->ID, '_package_subtitle', true);
    $package_days = get_post_meta($post->ID, '_package_days', true);
    ?>
    
    <table class="form-table">
        <tr>
            <th><label for="package_subtitle">Package Subtitle/Tagline:</label></th>
            <td>
                <input type="text" id="package_subtitle" name="package_subtitle" 
                       value="<?php echo esc_attr($package_subtitle); ?>" 
                       class="large-text" 
                       placeholder="e.g., Adventure of a Lifetime">
                <p class="description">A catchy subtitle or tagline for the package</p>
            </td>
        </tr>
        
        <tr>
            <th><label for="package_days">Days:</label></th>
            <td>
                <input type="number" id="package_days" name="package_days" 
                       value="<?php echo esc_attr($package_days); ?>" 
                       min="1" 
                       placeholder="e.g., 5">
                <p class="description">Number of days for this package</p>
            </td>
        </tr>
    </table>
    
    <?php
}


// ============================================
// META BOX CALLBACK: HERO/BANNER SECTION (4 IMAGES)
// ============================================
function wildtrek_hero_section_callback($post) {
    $hero_image = get_post_meta($post->ID, '_package_hero_image', true);
    $hero_image_2 = get_post_meta($post->ID, '_package_hero_image_2', true);
    $hero_image_3 = get_post_meta($post->ID, '_package_hero_image_3', true);
    $hero_image_4 = get_post_meta($post->ID, '_package_hero_image_4', true);
    
    $price = get_post_meta($post->ID, '_package_price', true);
    $discount_price = get_post_meta($post->ID, '_package_discount_price', true);
    $price_note = get_post_meta($post->ID, '_package_price_note', true);
    ?>
    
    <p style="background: #e7f3ff; padding: 15px; border-left: 4px solid #2196F3; margin-bottom: 20px;">
        <strong>📸 Hero Banner with 4 Images:</strong> Upload 4 images for the banner section. 
        Image 1 will be large (left side), Images 2-4 will be smaller (right side in a column).
    </p>
    
    <table class="form-table">
        <!-- HERO IMAGE 1 (Main Large) -->
        <tr>
            <th style="width: 200px;"><label>Hero Image 1 (Main):</label></th>
            <td>
                <input type="text" id="package_hero_image" name="package_hero_image" value="<?php echo esc_attr($hero_image); ?>" class="large-text" readonly />
                <button type="button" class="button upload-hero-image" data-target="package_hero_image">📁 Upload Image 1</button>
                <p class="description">This will be the main large image on the left (Recommended: 800x600px)</p>
                <?php if ($hero_image): ?>
                    <div style="margin-top: 10px;">
                        <img src="<?php echo esc_url($hero_image); ?>" style="max-width: 300px; height: auto; border: 1px solid #ddd; padding: 5px;" />
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        
        <!-- HERO IMAGE 2 -->
        <tr>
            <th><label>Hero Image 2 (Top Right):</label></th>
            <td>
                <input type="text" id="package_hero_image_2" name="package_hero_image_2" value="<?php echo esc_attr($hero_image_2); ?>" class="large-text" readonly />
                <button type="button" class="button upload-hero-image" data-target="package_hero_image_2">📁 Upload Image 2</button>
                <p class="description">Smaller image - top right position (Recommended: 400x300px)</p>
                <?php if ($hero_image_2): ?>
                    <div style="margin-top: 10px;">
                        <img src="<?php echo esc_url($hero_image_2); ?>" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;" />
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        
        <!-- HERO IMAGE 3 -->
        <tr>
            <th><label>Hero Image 3 (Middle Right):</label></th>
            <td>
                <input type="text" id="package_hero_image_3" name="package_hero_image_3" value="<?php echo esc_attr($hero_image_3); ?>" class="large-text" readonly />
                <button type="button" class="button upload-hero-image" data-target="package_hero_image_3">📁 Upload Image 3</button>
                <p class="description">Smaller image - middle right position (Recommended: 400x300px)</p>
                <?php if ($hero_image_3): ?>
                    <div style="margin-top: 10px;">
                        <img src="<?php echo esc_url($hero_image_3); ?>" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;" />
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        
        <!-- HERO IMAGE 4 -->
        <tr>
            <th><label>Hero Image 4 (Bottom Right):</label></th>
            <td>
                <input type="text" id="package_hero_image_4" name="package_hero_image_4" value="<?php echo esc_attr($hero_image_4); ?>" class="large-text" readonly />
                <button type="button" class="button upload-hero-image" data-target="package_hero_image_4">📁 Upload Image 4</button>
                <p class="description">Smaller image - bottom right position (Recommended: 400x300px)</p>
                <?php if ($hero_image_4): ?>
                    <div style="margin-top: 10px;">
                        <img src="<?php echo esc_url($hero_image_4); ?>" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;" />
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        
        <tr>
            <td colspan="2"><hr style="margin: 20px 0;"></td>
        </tr>
        
        <!-- PRICE FIELDS -->
        <tr>
            <th><label>Package Price:</label></th>
            <td>
                <input type="text" name="package_price" value="<?php echo esc_attr($price); ?>" class="regular-text" placeholder="₹15,999" />
                <p class="description">Main display price (e.g., ₹15,999 or $299)</p>
            </td>
        </tr>
        
        <tr>
            <th><label>Discount Price:</label></th>
            <td>
                <input type="text" name="package_discount_price" value="<?php echo esc_attr($discount_price); ?>" class="regular-text" placeholder="₹12,999" />
                <p class="description">If there's a special offer/discount (leave empty if no discount)</p>
            </td>
        </tr>
        
        <tr>
            <th><label>Price Note:</label></th>
            <td>
                <input type="text" name="package_price_note" value="<?php echo esc_attr($price_note); ?>" class="large-text" placeholder="per person" />
                <p class="description">Additional price information (e.g., "per person", "all inclusive")</p>
            </td>
        </tr>
    </table>
    <?php
}


// ============================================
// META BOX CALLBACK: GALLERY SECTION
// ============================================
function wildtrek_gallery_callback($post) {
    $gallery_images = get_post_meta($post->ID, '_package_gallery', true);
    if (!is_array($gallery_images)) {
        $gallery_images = array();
    }
    ?>
    <p><strong>Add multiple images to showcase your package</strong></p>
    <div id="gallery-repeater">
        <?php if (count($gallery_images) > 0):
            foreach ($gallery_images as $index => $image): ?>
        <div class="gallery-item-row" style="margin-bottom: 15px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <?php if ($image['url']): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ccc;" />
                <?php endif; ?>
                <div style="flex: 1;">
                    <input type="text" name="package_gallery[<?php echo $index; ?>][url]" value="<?php echo esc_attr($image['url']); ?>" class="large-text gallery-url" placeholder="Image URL" readonly />
                    <input type="text" name="package_gallery[<?php echo $index; ?>][caption]" value="<?php echo esc_attr($image['caption']); ?>" class="large-text" placeholder="Image Caption (optional)" style="margin-top: 5px;" />
                </div>
                <div>
                    <button type="button" class="button upload-gallery-image">📁 Upload</button>
                    <button type="button" class="button remove-gallery" style="background: #dc3232; color: white;">🗑️ Remove</button>
                </div>
            </div>
        </div>
        <?php endforeach;
        endif; ?>
    </div>
    <button type="button" class="button button-primary" id="add-gallery-image">➕ Add Gallery Image</button>
    <?php
}

// ============================================
// META BOX CALLBACK: PACKAGE STATS/FEATURES
// ============================================
function wildtrek_stats_callback($post) {
    $stats = get_post_meta($post->ID, '_package_stats', true);
    if (!is_array($stats) || empty($stats)) {
        $stats = array(
            array('icon' => 'dashicons-calendar-alt', 'label' => 'Tour Duration', 'value' => ''),
            array('icon' => 'dashicons-groups', 'label' => 'Group Size', 'value' => ''),
            array('icon' => 'dashicons-location', 'label' => 'Destination', 'value' => ''),
            array('icon' => 'dashicons-star-filled', 'label' => 'Best Time', 'value' => '')
        );
    }
    ?>
    <p><strong>Add key statistics/features that will be displayed prominently</strong></p>
    <div id="stats-repeater">
        <?php foreach ($stats as $index => $stat): ?>
        <div class="stat-item-row" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <table class="form-table">
                <tr>
                    <td style="width: 33%;">
                        <label>Icon/Emoji:</label><br>
                        <input type="text" name="package_stats[<?php echo $index; ?>][icon]" value="<?php echo esc_attr($stat['icon']); ?>" class="regular-text" placeholder="📅 or dashicons-calendar" />
                        <p class="description">Use emoji or dashicons class</p>
                    </td>
                    <td style="width: 33%;">
                        <label>Label:</label><br>
                        <input type="text" name="package_stats[<?php echo $index; ?>][label]" value="<?php echo esc_attr($stat['label']); ?>" class="regular-text" placeholder="Tour Duration" />
                    </td>
                    <td style="width: 33%;">
                        <label>Value:</label><br>
                        <input type="text" name="package_stats[<?php echo $index; ?>][value]" value="<?php echo esc_attr($stat['value']); ?>" class="regular-text" placeholder="8 Days" />
                    </td>
                </tr>
            </table>
            <button type="button" class="button remove-stat" style="background: #dc3232; color: white;">🗑️ Remove</button>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button button-primary" id="add-stat">➕ Add Stat</button>
    <?php
}

// ============================================
// META BOX CALLBACK: OVERVIEW SECTION
// ============================================
function wildtrek_overview_callback($post) {
    $overview_title = get_post_meta($post->ID, '_package_overview_title', true);
    $overview_content = get_post_meta($post->ID, '_package_overview_content', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="package_overview_title">Section Title</label></th>
            <td>
                <input type="text" id="package_overview_title" name="package_overview_title" value="<?php echo esc_attr($overview_title); ?>" class="large-text" placeholder="Overview" />
            </td>
        </tr>
        <tr>
            <th><label for="package_overview_content">Overview Content</label></th>
            <td>
                <?php 
                wp_editor($overview_content, 'package_overview_content', array(
                    'textarea_name' => 'package_overview_content',
                    'textarea_rows' => 12,
                    'media_buttons' => true,
                    'teeny' => false,
                    'tinymce' => true
                ));
                ?>
                <p class="description">Describe the package in detail - what makes it special, what guests can expect, etc.</p>
            </td>
        </tr>
    </table>
    <?php
}

// ============================================
// META BOX CALLBACK: ITINERARY SECTION
// ============================================
function wildtrek_itinerary_callback($post) {
    $itinerary = get_post_meta($post->ID, '_package_itinerary', true);
    if (!is_array($itinerary) || empty($itinerary)) {
        $itinerary = array(
            array('day' => 'Day 1', 'title' => '', 'description' => '')
        );
    }
    ?>
    <p><strong>Add day-by-day itinerary for the package</strong></p>
    <div id="itinerary-repeater">
        <?php foreach ($itinerary as $index => $day): ?>
        <div class="itinerary-day-row" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3 style="margin-top: 0;">Day <?php echo $index + 1; ?></h3>
            <table class="form-table">
                <tr>
                    <th style="width: 200px;"><label>Day Label:</label></th>
                    <td>
                        <input type="text" name="package_itinerary[<?php echo $index; ?>][day]" value="<?php echo esc_attr($day['day']); ?>" class="regular-text" placeholder="Day 1" />
                    </td>
                </tr>
                <tr>
                    <th><label>Activity/Title:</label></th>
                    <td>
                        <input type="text" name="package_itinerary[<?php echo $index; ?>][title]" value="<?php echo esc_attr($day['title']); ?>" class="large-text" placeholder="Arrival & Orientation" />
                    </td>
                </tr>
                <tr>
                    <th><label>Description:</label></th>
                    <td>
                        <textarea name="package_itinerary[<?php echo $index; ?>][description]" rows="5" class="large-text"><?php echo esc_textarea($day['description']); ?></textarea>
                        <p class="description">Describe what happens on this day</p>
                    </td>
                </tr>
            </table>
            <button type="button" class="button remove-itinerary" style="background: #dc3232; color: white;">🗑️ Remove Day</button>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button button-primary" id="add-itinerary-day">➕ Add Another Day</button>
    <?php
}

// ============================================
// META BOX CALLBACK: PACKAGE HIGHLIGHTS
// ============================================
function wildtrek_highlights_callback($post) {
    $highlights = get_post_meta($post->ID, '_package_highlights', true);
    if (!is_array($highlights)) {
        $highlights = explode("\n", $highlights);
    }
    ?>
    <p><strong>List the key highlights/features of this package (one per line)</strong></p>
    <textarea name="package_highlights" rows="10" class="large-text" placeholder="Visit the Royal Palace&#10;Jeep Safari in Chitwan National Park&#10;Traditional Cultural Dance Performance&#10;Bird Watching Tour"><?php echo esc_textarea(is_array($highlights) ? implode("\n", $highlights) : $highlights); ?></textarea>
    <p class="description">Each line will be displayed as a bullet point with a star icon</p>
    <?php
}

// ============================================
// META BOX CALLBACK: WHAT'S INCLUDED
// ============================================
function wildtrek_whats_included_callback($post) {
    $included = get_post_meta($post->ID, '_package_whats_included', true);
    ?>
    <p><strong>List everything that's included in the package price (one per line)</strong></p>
    <textarea name="package_whats_included" rows="12" class="large-text" placeholder="Airport pick-up and drop-off&#10;All accommodation&#10;Daily breakfast and dinner&#10;English-speaking guide&#10;All entrance fees&#10;Transportation"><?php echo esc_textarea($included); ?></textarea>
    <p class="description">Each line will be displayed with a green checkmark (✅)</p>
    <?php
}

// ============================================
// META BOX CALLBACK: WHAT'S EXCLUDED
// ============================================
function wildtrek_whats_excluded_callback($post) {
    $excluded = get_post_meta($post->ID, '_package_whats_excluded', true);
    ?>
    <p><strong>List what's NOT included in the package (one per line)</strong></p>
    <textarea name="package_whats_excluded" rows="12" class="large-text" placeholder="International airfare&#10;Travel insurance&#10;Personal expenses&#10;Tips and gratuities&#10;Alcoholic beverages&#10;Lunch during tours"><?php echo esc_textarea($excluded); ?></textarea>
    <p class="description">Each line will be displayed with a red X mark (❌)</p>
    <?php
}

// ============================================
// META BOX CALLBACK: COST SECTION
// ============================================
function wildtrek_cost_callback($post) {
    $cost_includes_title = get_post_meta($post->ID, '_package_cost_includes_title', true);
    $cost_includes = get_post_meta($post->ID, '_package_cost_includes', true);
    $cost_excludes_title = get_post_meta($post->ID, '_package_cost_excludes_title', true);
    $cost_excludes = get_post_meta($post->ID, '_package_cost_excludes', true);
    $cost_note = get_post_meta($post->ID, '_package_cost_note', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="package_cost_includes_title">Cost Includes Section Title</label></th>
            <td>
                <input type="text" id="package_cost_includes_title" name="package_cost_includes_title" value="<?php echo esc_attr($cost_includes_title); ?>" class="large-text" placeholder="Cost Includes" />
            </td>
        </tr>
        <tr>
            <th><label for="package_cost_includes">Cost Includes Details</label></th>
            <td>
                <textarea name="package_cost_includes" rows="8" class="large-text" placeholder="Price per adult sharing twin accommodation&#10;All meals as per itinerary&#10;Experienced tour guide"><?php echo esc_textarea($cost_includes); ?></textarea>
                <p class="description">One item per line</p>
            </td>
        </tr>
        <tr>
            <th><label for="package_cost_excludes_title">Cost Excludes Section Title</label></th>
            <td>
                <input type="text" id="package_cost_excludes_title" name="package_cost_excludes_title" value="<?php echo esc_attr($cost_excludes_title); ?>" class="large-text" placeholder="Cost Excludes" />
            </td>
        </tr>
        <tr>
            <th><label for="package_cost_excludes">Cost Excludes Details</label></th>
            <td>
                <textarea name="package_cost_excludes" rows="8" class="large-text" placeholder="Single room supplement&#10;Optional activities&#10;Personal insurance"><?php echo esc_textarea($cost_excludes); ?></textarea>
                <p class="description">One item per line</p>
            </td>
        </tr>
        <tr>
            <th><label for="package_cost_note">Additional Cost Notes</label></th>
            <td>
                <textarea name="package_cost_note" rows="4" class="large-text" placeholder="Prices are subject to change. Contact us for group discounts."><?php echo esc_textarea($cost_note); ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}

// ============================================
// META BOX CALLBACK: FAQ SECTION (WITH WYSIWYG)
// ============================================
function wildtrek_faq_callback($post) {
    $faqs = get_post_meta($post->ID, '_package_faqs', true);
    if (!is_array($faqs) || empty($faqs)) {
        $faqs = array(
            array('question' => '', 'answer' => '')
        );
    }
    ?>
    <p><strong>Add Frequently Asked Questions with detailed answers</strong></p>
    <div id="faq-repeater">
        <?php foreach ($faqs as $index => $faq): ?>
        <div class="faq-item-row" style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; background: #f9f9f9;">
            <h3 style="margin-top: 0;">FAQ #<?php echo $index + 1; ?></h3>
            <table class="form-table">
                <tr>
                    <th style="width: 150px;"><label>Question:</label></th>
                    <td>
                        <input type="text" name="package_faqs[<?php echo $index; ?>][question]" value="<?php echo esc_attr($faq['question']); ?>" class="large-text" placeholder="e.g., How long is the trek?" />
                    </td>
                </tr>
                <tr>
                    <th><label>Answer:</label></th>
                    <td>
                        <?php 
                        wp_editor($faq['answer'], 'package_faqs_' . $index . '_answer', array(
                            'textarea_name' => 'package_faqs[' . $index . '][answer]',
                            'textarea_rows' => 8,
                            'media_buttons' => false,
                            'teeny' => true,
                            'tinymce' => true,
                            'quicktags' => true
                        ));
                        ?>
                        <p class="description">Write a detailed answer with formatting options</p>
                    </td>
                </tr>
            </table>
            <button type="button" class="button remove-faq" style="background: #dc3232; color: white;">🗑️ Remove FAQ</button>
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button button-primary" id="add-faq">➕ Add Another FAQ</button>
    <?php
}

// ============================================
// META BOX CALLBACK: TERMS & CONDITIONS
// ============================================
function wildtrek_terms_callback($post) {
    $terms_conditions = get_post_meta($post->ID, '_package_terms_conditions', true);
    ?>
    <p><strong>Add terms, conditions, and policies for this package</strong></p>
    <?php 
    wp_editor($terms_conditions, 'package_terms_conditions', array(
        'textarea_name' => 'package_terms_conditions',
        'textarea_rows' => 15,
        'media_buttons' => false,
        'teeny' => false,
        'tinymce' => true
    ));
    ?>
    <p class="description">Include cancellation policy, payment terms, requirements, etc.</p>
    <?php
}

// ============================================
// META BOX CALLBACK: LOCATION/MAP
// ============================================
function wildtrek_location_callback($post) {
    $map_embed = get_post_meta($post->ID, '_package_map_embed', true);
    $map_latitude = get_post_meta($post->ID, '_package_map_latitude', true);
    $map_longitude = get_post_meta($post->ID, '_package_map_longitude', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="package_map_embed">Google Map Embed Code</label></th>
            <td>
                <textarea id="package_map_embed" name="package_map_embed" rows="4" class="large-text" placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450"></iframe>'><?php echo esc_textarea($map_embed); ?></textarea>
                <p class="description">Paste the iframe embed code from Google Maps. Go to Google Maps → Share → Embed a map</p>
            </td>
        </tr>
        <tr>
            <th><label for="package_map_latitude">Latitude (Optional)</label></th>
            <td>
                <input type="text" id="package_map_latitude" name="package_map_latitude" value="<?php echo esc_attr($map_latitude); ?>" class="regular-text" placeholder="27.7172" />
            </td>
        </tr>
        <tr>
            <th><label for="package_map_longitude">Longitude (Optional)</label></th>
            <td>
                <input type="text" id="package_map_longitude" name="package_map_longitude" value="<?php echo esc_attr($map_longitude); ?>" class="regular-text" placeholder="85.3240" />
            </td>
        </tr>
    </table>
    <?php
}

// ============================================
// META BOX CALLBACK: SEO SETTINGS
// ============================================
function wildtrek_seo_callback($post) {
    $meta_title = get_post_meta($post->ID, '_package_meta_title', true);
    $meta_description = get_post_meta($post->ID, '_package_meta_description', true);
    $meta_keywords = get_post_meta($post->ID, '_package_meta_keywords', true);
    ?>
    <table class="form-table">
        <tr>
            <td>
                <label for="package_meta_title"><strong>Meta Title:</strong></label><br>
                <input type="text" id="package_meta_title" name="package_meta_title" value="<?php echo esc_attr($meta_title); ?>" class="large-text" placeholder="SEO Title" />
                <p class="description">Leave empty to use page title</p>
            </td>
        </tr>
        <tr>
            <td>
                <label for="package_meta_description"><strong>Meta Description:</strong></label><br>
                <textarea id="package_meta_description" name="package_meta_description" rows="3" class="large-text" placeholder="Brief description for search engines"><?php echo esc_textarea($meta_description); ?></textarea>
                <p class="description">150-160 characters recommended</p>
            </td>
        </tr>
        <tr>
            <td>
                <label for="package_meta_keywords"><strong>Meta Keywords:</strong></label><br>
                <input type="text" id="package_meta_keywords" name="package_meta_keywords" value="<?php echo esc_attr($meta_keywords); ?>" class="large-text" placeholder="keyword1, keyword2, keyword3" />
            </td>
        </tr>
    </table>
    <?php
}

// ============================================
// SAVE ALL META BOX DATA
// ============================================
function wildtrek_save_package_data($post_id) {
    // Security checks
    if (!isset($_POST['wildtrek_package_nonce']) || !wp_verify_nonce($_POST['wildtrek_package_nonce'], 'wildtrek_save_package_data')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // SAVE Package Details
    $simple_fields = array(
        'package_subtitle', 'package_location', 'package_duration',
        'package_group_size', 'package_difficulty', 'package_best_time',
        'package_accommodation', 'package_meals'
    );
    
    foreach ($simple_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    
    // SAVE Hero Section (All 4 Images + Pricing) - FIXED
    if (isset($_POST['package_hero_image'])) {
        update_post_meta($post_id, '_package_hero_image', sanitize_text_field($_POST['package_hero_image']));
    }
    if (isset($_POST['package_hero_image_2'])) {
        update_post_meta($post_id, '_package_hero_image_2', sanitize_text_field($_POST['package_hero_image_2']));
    }
    if (isset($_POST['package_hero_image_3'])) {
        update_post_meta($post_id, '_package_hero_image_3', sanitize_text_field($_POST['package_hero_image_3']));
    }
    if (isset($_POST['package_hero_image_4'])) {
        update_post_meta($post_id, '_package_hero_image_4', sanitize_text_field($_POST['package_hero_image_4']));
    }
    
    // Save pricing info
    if (isset($_POST['package_price'])) {
        update_post_meta($post_id, '_package_price', sanitize_text_field($_POST['package_price']));
    }
    if (isset($_POST['package_discount_price'])) {
        update_post_meta($post_id, '_package_discount_price', sanitize_text_field($_POST['package_discount_price']));
    }
    if (isset($_POST['package_price_note'])) {
        update_post_meta($post_id, '_package_price_note', sanitize_text_field($_POST['package_price_note']));
    }
    
    // SAVE Gallery
    if (isset($_POST['package_gallery']) && is_array($_POST['package_gallery'])) {
        $gallery = array();
        foreach ($_POST['package_gallery'] as $image) {
            if (!empty($image['url'])) {
                $gallery[] = array(
                    'url' => sanitize_text_field($image['url']),
                    'caption' => sanitize_text_field($image['caption'])
                );
            }
        }
        update_post_meta($post_id, '_package_gallery', $gallery);
    }
    
    // SAVE Stats
    if (isset($_POST['package_stats']) && is_array($_POST['package_stats'])) {
        $stats = array();
        foreach ($_POST['package_stats'] as $stat) {
            if (!empty($stat['label']) || !empty($stat['value'])) {
                $stats[] = array(
                    'icon' => sanitize_text_field($stat['icon']),
                    'label' => sanitize_text_field($stat['label']),
                    'value' => sanitize_text_field($stat['value'])
                );
            }
        }
        update_post_meta($post_id, '_package_stats', $stats);
    }
    
    // SAVE Overview
    if (isset($_POST['package_overview_title'])) {
        update_post_meta($post_id, '_package_overview_title', sanitize_text_field($_POST['package_overview_title']));
    }
    if (isset($_POST['package_overview_content'])) {
        update_post_meta($post_id, '_package_overview_content', wp_kses_post($_POST['package_overview_content']));
    }
    
    // SAVE Itinerary
    if (isset($_POST['package_itinerary']) && is_array($_POST['package_itinerary'])) {
        $itinerary = array();
        foreach ($_POST['package_itinerary'] as $day) {
            if (!empty($day['title']) || !empty($day['description'])) {
                $itinerary[] = array(
                    'day' => sanitize_text_field($day['day']),
                    'title' => sanitize_text_field($day['title']),
                    'description' => sanitize_textarea_field($day['description'])
                );
            }
        }
        update_post_meta($post_id, '_package_itinerary', $itinerary);
    }
    
    // SAVE Highlights
    if (isset($_POST['package_highlights'])) {
        update_post_meta($post_id, '_package_highlights', sanitize_textarea_field($_POST['package_highlights']));
    }
    
    // SAVE What's Included/Excluded
    if (isset($_POST['package_whats_included'])) {
        update_post_meta($post_id, '_package_whats_included', sanitize_textarea_field($_POST['package_whats_included']));
    }
    if (isset($_POST['package_whats_excluded'])) {
        update_post_meta($post_id, '_package_whats_excluded', sanitize_textarea_field($_POST['package_whats_excluded']));
    }
    
    // SAVE Cost
    $cost_fields = array('package_cost_includes_title', 'package_cost_includes', 
                        'package_cost_excludes_title', 'package_cost_excludes', 'package_cost_note');
    foreach ($cost_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_textarea_field($_POST[$field]));
        }
    }
    
    // SAVE FAQs
    if (isset($_POST['package_faqs']) && is_array($_POST['package_faqs'])) {
        $faqs = array();
        foreach ($_POST['package_faqs'] as $faq) {
            if (!empty($faq['question'])) {
                $faqs[] = array(
                    'question' => sanitize_text_field($faq['question']),
                    'answer' => wp_kses_post($faq['answer'])
                );
            }
        }
        update_post_meta($post_id, '_package_faqs', $faqs);
    }
    
    // SAVE Terms
    if (isset($_POST['package_terms_conditions'])) {
        update_post_meta($post_id, '_package_terms_conditions', wp_kses_post($_POST['package_terms_conditions']));
    }
    
    // SAVE Location
    if (isset($_POST['package_map_embed'])) {
        update_post_meta($post_id, '_package_map_embed', wp_kses_post($_POST['package_map_embed']));
    }
    if (isset($_POST['package_map_latitude'])) {
        update_post_meta($post_id, '_package_map_latitude', sanitize_text_field($_POST['package_map_latitude']));
    }
    if (isset($_POST['package_map_longitude'])) {
        update_post_meta($post_id, '_package_map_longitude', sanitize_text_field($_POST['package_map_longitude']));
    }
    
    // SAVE SEO
    if (isset($_POST['package_meta_title'])) {
        update_post_meta($post_id, '_package_meta_title', sanitize_text_field($_POST['package_meta_title']));
    }
    if (isset($_POST['package_meta_description'])) {
        update_post_meta($post_id, '_package_meta_description', sanitize_textarea_field($_POST['package_meta_description']));
    }
    if (isset($_POST['package_meta_keywords'])) {
        update_post_meta($post_id, '_package_meta_keywords', sanitize_text_field($_POST['package_meta_keywords']));
    }
}
add_action('save_post_package', 'wildtrek_save_package_data');


// ============================================
// ENQUEUE ADMIN SCRIPTS & STYLES
// ============================================
function wildtrek_admin_scripts($hook) {
    global $post_type;
    if ('package' !== $post_type || ('post.php' !== $hook && 'post-new.php' !== $hook)) {
        return;
    }
    
    wp_enqueue_media();
    wp_enqueue_style('dashicons');
    wp_enqueue_script('wildtrek-admin', get_template_directory_uri() . '/js/admin.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'wildtrek_admin_scripts');

// ============================================
// ADD SEO META TAGS TO HEAD
// ============================================
function wildtrek_add_seo_meta_tags() {
    if (is_singular('package')) {
        global $post;
        $meta_title = get_post_meta($post->ID, '_package_meta_title', true);
        $meta_description = get_post_meta($post->ID, '_package_meta_description', true);
        $meta_keywords = get_post_meta($post->ID, '_package_meta_keywords', true);
        
        if ($meta_title) {
            echo '<meta property="og:title" content="' . esc_attr($meta_title) . '" />' . "\n";
        }
        if ($meta_description) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '" />' . "\n";
            echo '<meta property="og:description" content="' . esc_attr($meta_description) . '" />' . "\n";
        }
        if ($meta_keywords) {
            echo '<meta name="keywords" content="' . esc_attr($meta_keywords) . '" />' . "\n";
        }
    }
}
add_action('wp_head', 'wildtrek_add_seo_meta_tags');

// ============================================
// FLUSH REWRITE RULES ON THEME ACTIVATION
// ============================================
function wildtrek_rewrite_flush() {
    wildtrek_register_package_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'wildtrek_rewrite_flush');
