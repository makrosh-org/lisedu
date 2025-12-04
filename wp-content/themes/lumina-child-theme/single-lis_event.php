<?php
/**
 * Single Event Template
 * 
 * Template for displaying individual event details
 * Requirements: 10.2 - Display event title, date, time, location, and description
 * Task 15: Build single event template
 * 
 * @package Lumina_Child_Theme
 * @version 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="main" class="site-main single-event-page" role="main">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <article id="event-<?php the_ID(); ?>" <?php post_class('event-single'); ?>>
            
            <!-- Breadcrumbs -->
            <?php lumina_breadcrumbs(); ?>
            
            <!-- Event Header -->
            <header class="event-header">
                <h1 class="event-title"><?php the_title(); ?></h1>
                
                <?php
                // Get event categories
                $categories = get_the_terms(get_the_ID(), 'event_category');
                if ($categories && !is_wp_error($categories)) {
                    echo '<div class="event-categories">';
                    foreach ($categories as $category) {
                        echo '<span class="event-category-badge">' . esc_html($category->name) . '</span>';
                    }
                    echo '</div>';
                }
                ?>
            </header>
            
            <!-- Event Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="event-featured-image">
                    <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                </div>
            <?php endif; ?>
            
            <!-- Event Meta Information -->
            <div class="event-meta-info">
                <?php
                // Get custom field values
                $event_date = get_post_meta(get_the_ID(), 'event_date', true);
                $event_time = get_post_meta(get_the_ID(), 'event_time', true);
                $event_location = get_post_meta(get_the_ID(), 'event_location', true);
                $event_end_date = get_post_meta(get_the_ID(), 'event_end_date', true);
                
                // Check if event is within next 7 days (for highlighting)
                $is_upcoming = false;
                if ($event_date) {
                    $event_timestamp = strtotime($event_date);
                    $today = strtotime(date('Y-m-d'));
                    $seven_days = strtotime('+7 days', $today);
                    
                    if ($event_timestamp >= $today && $event_timestamp <= $seven_days) {
                        $is_upcoming = true;
                    }
                }
                ?>
                
                <div class="event-details-grid <?php echo $is_upcoming ? 'upcoming-event' : ''; ?>">
                    
                    <?php if ($event_date) : ?>
                        <div class="event-detail-item">
                            <span class="detail-icon">📅</span>
                            <div class="detail-content">
                                <strong class="detail-label">Date:</strong>
                                <span class="detail-value">
                                    <?php 
                                    echo date('l, F j, Y', strtotime($event_date));
                                    
                                    // Show end date if available
                                    if ($event_end_date && $event_end_date !== $event_date) {
                                        echo ' - ' . date('l, F j, Y', strtotime($event_end_date));
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($event_time) : ?>
                        <div class="event-detail-item">
                            <span class="detail-icon">🕐</span>
                            <div class="detail-content">
                                <strong class="detail-label">Time:</strong>
                                <span class="detail-value"><?php echo esc_html(date('g:i A', strtotime($event_time))); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($event_location) : ?>
                        <div class="event-detail-item">
                            <span class="detail-icon">📍</span>
                            <div class="detail-content">
                                <strong class="detail-label">Location:</strong>
                                <span class="detail-value"><?php echo esc_html($event_location); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
                <?php if ($is_upcoming) : ?>
                    <div class="upcoming-badge">
                        <span>🔔 Upcoming Event - Within 7 Days!</span>
                    </div>
                <?php endif; ?>
                
            </div>
            
            <!-- Event Content -->
            <div class="event-content">
                <?php the_content(); ?>
            </div>
            
            <!-- Event Navigation -->
            <nav class="event-navigation" aria-label="Event navigation">
                <div class="nav-links">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    
                    if ($prev_post) :
                        $prev_date = get_post_meta($prev_post->ID, 'event_date', true);
                    ?>
                        <div class="nav-previous">
                            <a href="<?php echo get_permalink($prev_post); ?>" rel="prev">
                                <span class="nav-subtitle">← Previous Event</span>
                                <span class="nav-title"><?php echo get_the_title($prev_post); ?></span>
                                <?php if ($prev_date) : ?>
                                    <span class="nav-date"><?php echo date('F j, Y', strtotime($prev_date)); ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($next_post) :
                        $next_date = get_post_meta($next_post->ID, 'event_date', true);
                    ?>
                        <div class="nav-next">
                            <a href="<?php echo get_permalink($next_post); ?>" rel="next">
                                <span class="nav-subtitle">Next Event →</span>
                                <span class="nav-title"><?php echo get_the_title($next_post); ?></span>
                                <?php if ($next_date) : ?>
                                    <span class="nav-date"><?php echo date('F j, Y', strtotime($next_date)); ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </nav>
            
            <!-- Back to Events Link -->
            <div class="back-to-events">
                <a href="<?php echo get_post_type_archive_link('lis_event'); ?>" class="back-link">
                    ← Back to All Events
                </a>
            </div>
            
        </article>
        
    <?php endwhile; ?>
    
</main>

<style>
/* Single Event Styles */
.single-event-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.event-single {
    background: #FFFFFF;
}

.event-header {
    margin-bottom: 30px;
}

.event-title {
    color: #003d70;
    font-size: 42px;
    font-weight: 700;
    margin: 0 0 20px 0;
    line-height: 1.2;
}

.event-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 15px;
}

.event-category-badge {
    background: #7EBEC5;
    color: #FFFFFF;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
}

.event-featured-image {
    margin: 30px 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 61, 112, 0.1);
}

.event-featured-image img {
    width: 100%;
    height: auto;
    display: block;
}

.event-meta-info {
    background: #f7f7f7;
    border-left: 5px solid #7EBEC5;
    padding: 30px;
    margin: 30px 0;
    border-radius: 8px;
}

.event-details-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.event-details-grid.upcoming-event {
    border: 3px solid #F39A3B;
    padding: 20px;
    border-radius: 8px;
    background: #FFF9F0;
}

.event-detail-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.detail-icon {
    font-size: 28px;
    line-height: 1;
}

.detail-content {
    flex: 1;
}

.detail-label {
    display: block;
    color: #003d70;
    font-size: 16px;
    margin-bottom: 5px;
}

.detail-value {
    display: block;
    color: #333;
    font-size: 18px;
}

.upcoming-badge {
    margin-top: 20px;
    padding: 15px;
    background: #F39A3B;
    color: #FFFFFF;
    text-align: center;
    border-radius: 8px;
    font-weight: 600;
    font-size: 16px;
}

.event-content {
    margin: 40px 0;
    color: #333;
    line-height: 1.8;
    font-size: 18px;
}

.event-content p {
    margin-bottom: 20px;
}

.event-content h2,
.event-content h3,
.event-content h4 {
    color: #003d70;
    margin-top: 30px;
    margin-bottom: 15px;
}

.event-content ul,
.event-content ol {
    margin: 20px 0;
    padding-left: 30px;
}

.event-content li {
    margin-bottom: 10px;
}

.event-navigation {
    margin: 50px 0 30px 0;
    padding: 30px 0;
    border-top: 2px solid #7EBEC5;
    border-bottom: 2px solid #7EBEC5;
}

.nav-links {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.nav-previous a,
.nav-next a {
    display: flex;
    flex-direction: column;
    padding: 20px;
    background: #f7f7f7;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.nav-previous a:hover,
.nav-next a:hover {
    background: #7EBEC5;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 61, 112, 0.15);
}

.nav-subtitle {
    color: #F39A3B;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
}

.nav-title {
    color: #003d70;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 5px;
}

.nav-previous a:hover .nav-title,
.nav-next a:hover .nav-title {
    color: #FFFFFF;
}

.nav-date {
    color: #666;
    font-size: 14px;
}

.nav-previous a:hover .nav-date,
.nav-next a:hover .nav-date {
    color: #FFFFFF;
}

.back-to-events {
    text-align: center;
    margin: 30px 0;
}

.back-link {
    display: inline-block;
    padding: 15px 30px;
    background: #003d70;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-link:hover {
    background: #F39A3B;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 61, 112, 0.2);
}

/* Responsive Design */
@media (min-width: 768px) {
    .event-details-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .nav-links {
        grid-template-columns: 1fr 1fr;
    }
    
    .nav-next {
        text-align: right;
    }
}

@media (min-width: 1024px) {
    .event-title {
        font-size: 48px;
    }
    
    .event-details-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 767px) {
    .event-title {
        font-size: 32px;
    }
    
    .event-content {
        font-size: 16px;
    }
}
</style>

<?php
get_footer();
