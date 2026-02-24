<?php
/**
 * ============================================
 * SINGLE PACKAGE TEMPLATE
 * ============================================
 * Displays single package page with all sections
 */

get_header();

while (have_posts()) : the_post();
    
    // ============================================
    // GET ALL META DATA
    // ============================================
    $hero_image = get_post_meta(get_the_ID(), '_package_hero_image', true);
    $subtitle = get_post_meta(get_the_ID(), '_package_subtitle', true);
    $location = get_post_meta(get_the_ID(), '_package_location', true);
    $price = get_post_meta(get_the_ID(), '_package_price', true);
    $discount_price = get_post_meta(get_the_ID(), '_package_discount_price', true);
    $price_note = get_post_meta(get_the_ID(), '_package_price_note', true);
    
    $duration = get_post_meta(get_the_ID(), '_package_duration', true);
    $group_size = get_post_meta(get_the_ID(), '_package_group_size', true);
    $difficulty = get_post_meta(get_the_ID(), '_package_difficulty', true);
    $best_time = get_post_meta(get_the_ID(), '_package_best_time', true);
    $accommodation = get_post_meta(get_the_ID(), '_package_accommodation', true);
    $meals = get_post_meta(get_the_ID(), '_package_meals', true);
    
    $stats = get_post_meta(get_the_ID(), '_package_stats', true);
    $gallery = get_post_meta(get_the_ID(), '_package_gallery', true);
    $overview_title = get_post_meta(get_the_ID(), '_package_overview_title', true);
    $overview_content = get_post_meta(get_the_ID(), '_package_overview_content', true);
    $itinerary = get_post_meta(get_the_ID(), '_package_itinerary', true);
    $highlights = get_post_meta(get_the_ID(), '_package_highlights', true);
    $whats_included = get_post_meta(get_the_ID(), '_package_whats_included', true);
    $whats_excluded = get_post_meta(get_the_ID(), '_package_whats_excluded', true);
    
    $cost_includes_title = get_post_meta(get_the_ID(), '_package_cost_includes_title', true);
    $cost_includes = get_post_meta(get_the_ID(), '_package_cost_includes', true);
    $cost_excludes_title = get_post_meta(get_the_ID(), '_package_cost_excludes_title', true);
    $cost_excludes = get_post_meta(get_the_ID(), '_package_cost_excludes', true);
    $cost_note = get_post_meta(get_the_ID(), '_package_cost_note', true);
    
    $faqs = get_post_meta(get_the_ID(), '_package_faqs', true);
    $terms_conditions = get_post_meta(get_the_ID(), '_package_terms_conditions', true);
    $map_embed = get_post_meta(get_the_ID(), '_package_map_embed', true);
    ?>

<!-- ============================================ -->
<!-- HERO SECTION WITH 4 IMAGES -->
<!-- ============================================ -->
<?php
// Get hero images
$hero_image = get_post_meta(get_the_ID(), '_package_hero_image', true);
$hero_image_2 = get_post_meta(get_the_ID(), '_package_hero_image_2', true);
$hero_image_3 = get_post_meta(get_the_ID(), '_package_hero_image_3', true);
$hero_image_4 = get_post_meta(get_the_ID(), '_package_hero_image_4', true);

// Fallback to featured image if hero image not set
if (empty($hero_image)) {
    $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
?>

<section class="package-hero-multi">
    <div class="hero-images-grid">
        <!-- Main Large Image (Left) -->
        <div class="hero-main-image">
            <?php if ($hero_image): ?>
                <img src="<?php echo esc_url($hero_image); ?>" alt="<?php the_title(); ?>" loading="eager">
            <?php endif; ?>
        </div>
        
        <!-- 3 Smaller Images (Right Column) -->
        <div class="hero-side-images">
            <?php if ($hero_image_2): ?>
                <div class="hero-side-image">
                    <img src="<?php echo esc_url($hero_image_2); ?>" alt="<?php the_title(); ?> - Image 2" loading="eager">
                </div>
            <?php endif; ?>
            
            <?php if ($hero_image_3): ?>
                <div class="hero-side-image">
                    <img src="<?php echo esc_url($hero_image_3); ?>" alt="<?php the_title(); ?> - Image 3" loading="eager">
                </div>
            <?php endif; ?>
            
            <?php if ($hero_image_4): ?>
                <div class="hero-side-image">
                    <img src="<?php echo esc_url($hero_image_4); ?>" alt="<?php the_title(); ?> - Image 4" loading="eager">
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Overlay Content -->
    <div class="hero-content-overlay">
        <div class="container">
            <?php if ($subtitle): ?>
                <p class="subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
            <h1><?php the_title(); ?></h1>

            <?php if ($price): ?>
                <div class="price-box">
                    <?php if ($discount_price): ?>
                        <span class="original-price"><?php echo esc_html($price); ?></span>
                        <span class="discount-price"><?php echo esc_html($discount_price); ?></span>
                    <?php else: ?>
                        <span class="price"><?php echo esc_html($price); ?></span>
                    <?php endif; ?>
                    <?php if ($price_note): ?>
                        <span class="price-note"><?php echo esc_html($price_note); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


    <!-- ============================================ -->
    <!-- PACKAGE STATS SECTION -->
    <!-- ============================================ -->
    <?php if (!empty($stats) && is_array($stats)): ?>
    <section class="package-stats">
        <div class="container">
            <div class="stats-grid">
                <?php foreach ($stats as $stat): 
                    if (empty($stat['label']) && empty($stat['value'])) continue;
                ?>
                <div class="stat-item">
                    <?php if (!empty($stat['icon'])): ?>
                        <?php if (strpos($stat['icon'], 'dashicons-') === 0): ?>
                            <span class="dashicons <?php echo esc_attr($stat['icon']); ?>" style="font-size: 40px; width: 40px; height: 40px;"></span>
                        <?php else: ?>
                            <span class="icon" style="font-size: 40px;"><?php echo esc_html($stat['icon']); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <p class="stat-label"><?php echo esc_html($stat['label']); ?></p>
                    <h3 class="stat-value"><?php echo esc_html($stat['value']); ?></h3>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================================ -->
    <!-- GALLERY SECTION -->
    <!-- ============================================ -->
    <?php if (!empty($gallery) && is_array($gallery)): ?>
    <section class="package-gallery">
        <div class="container">
            <h2>Gallery</h2>
            <div class="gallery-grid">
                <?php foreach ($gallery as $image): 
                    if (empty($image['url'])) continue;
                ?>
                <div class="gallery-item">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['caption'] ? $image['caption'] : get_the_title()); ?>" loading="lazy">
                    <?php if (!empty($image['caption'])): ?>
                        <p class="gallery-caption"><?php echo esc_html($image['caption']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================================ -->
    <!-- OVERVIEW SECTION -->
    <!-- ============================================ -->
    <?php if ($overview_content): ?>
    <section class="package-overview">
        <div class="container">
            <h2><?php echo $overview_title ? esc_html($overview_title) : 'Overview'; ?></h2>
            <div class="overview-content">
                <?php echo wpautop($overview_content); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================================ -->
    <!-- PACKAGE HIGHLIGHTS SECTION -->
    <!-- ============================================ -->
    <?php if ($highlights): 
        $highlights_array = explode("\n", $highlights);
        $highlights_array = array_filter(array_map('trim', $highlights_array));
    ?>
    <?php if (!empty($highlights_array)): ?>
    <section class="package-highlights">
        <div class="container">
            <h2>Package Highlights</h2>
            <ul class="highlights-list">
                <?php foreach ($highlights_array as $highlight): ?>
                    <li>⭐ <?php echo esc_html($highlight); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>

    <!-- ============================================ -->
    <!-- ITINERARY SECTION -->
    <!-- ============================================ -->
    <?php if (!empty($itinerary) && is_array($itinerary)): ?>
    <section class="package-itinerary">
        <div class="container">
            <h2>Itinerary</h2>
            <div class="itinerary-timeline">
                <?php foreach ($itinerary as $index => $day): 
                    if (empty($day['title']) && empty($day['description'])) continue;
                ?>
                <div class="itinerary-day">
                    <div class="day-marker"><?php echo $index + 1; ?></div>
                    <div class="day-content">
                        <h3>
                            <?php if (!empty($day['day'])): ?>
                                <span class="day-number"><?php echo esc_html($day['day']); ?>:</span> 
                            <?php endif; ?>
                            <?php echo esc_html($day['title']); ?>
                        </h3>
                        <?php if (!empty($day['description'])): ?>
                            <p><?php echo esc_html($day['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================================ -->
    <!-- WHAT'S INCLUDED/EXCLUDED SECTION -->
    <!-- ============================================ -->
    <?php if ($whats_included || $whats_excluded): ?>
    <section class="package-included-excluded">
        <div class="container">
            <h2>What to Expect</h2>
            <div class="included-excluded-grid">
                <?php if ($whats_included): 
                    $included_items = explode("\n", $whats_included);
                    $included_items = array_filter(array_map('trim', $included_items));
                ?>
                <div class="included-box">
                    <h3>✅ What's Included</h3>
                    <ul>
                        <?php foreach ($included_items as $item): ?>
                        <li><?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if ($whats_excluded): 
                    $excluded_items = explode("\n", $whats_excluded);
                    $excluded_items = array_filter(array_map('trim', $excluded_items));
                ?>
                <div class="excluded-box">
                    <h3>❌ What's Not Included</h3>
                    <ul>
                        <?php foreach ($excluded_items as $item): ?>
                        <li><?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================================ -->
    <!-- COST SECTION -->
    <!-- ============================================ -->
    <?php if ($cost_includes || $cost_excludes): ?>
    <section class="package-cost">
        <div class="container">
            <h2>Cost Details</h2>
            <div class="cost-grid">
                <?php if ($cost_includes): 
                    $includes_items = explode("\n", $cost_includes);
                    $includes_items = array_filter(array_map('trim', $includes_items));
                ?>
                <div class="cost-card">
                    <h3><?php echo $cost_includes_title ? esc_html($cost_includes_title) : 'Cost Includes'; ?></h3>
                    <ul>
                        <?php foreach ($includes_items as $item): ?>
                        <li>✓ <?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if ($cost_excludes): 
                    $excludes_items = explode("\n", $cost_excludes);
                    $excludes_items = array_filter(array_map('trim', $excludes_items));
                ?>
                <div class="cost-card">
                    <h3><?php echo $cost_excludes_title ? esc_html($cost_excludes_title) : 'Cost Excludes'; ?></h3>
                    <ul>
                        <?php foreach ($excludes_items as $item): ?>
                        <li>✗ <?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($cost_note): ?>
                <div class="cost-note">
                    <p><?php echo esc_html($cost_note); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================================ -->
    <!-- FAQ SECTION -->
    <!-- ============================================ -->
    <?php if (!empty($faqs) && is_array($faqs)): ?>
    <section class="package-faq">
        <div class="container">
            <h2>FAQs</h2>
            <div class="faq-accordion">
                <?php foreach ($faqs as $index => $faq): 
                    if (empty($faq['question'])) continue;
                ?>
                <div class="faq-item">
                    <button class="faq-question" data-faq="<?php echo $index; ?>">
                        <span><?php echo esc_html($faq['question']); ?></span>
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer" id="faq-<?php echo $index; ?>">
                        <?php echo wpautop($faq['answer']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================================ -->
    <!-- TERMS & CONDITIONS SECTION -->
    <!-- ============================================ -->
    <?php if ($terms_conditions): ?>
    <section class="package-terms">
        <div class="container">
            <h2>Terms & Conditions</h2>
            <div class="terms-content">
                <?php echo wpautop($terms_conditions); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================================ -->
    <!-- MAP SECTION -->
    <!-- ============================================ -->
    <?php if ($map_embed): ?>
    <section class="package-map">
        <div class="container">
            <h2>Location</h2>
            <div class="map-container">
                <?php echo wp_kses_post($map_embed); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

<?php endwhile;

get_footer();
?>
