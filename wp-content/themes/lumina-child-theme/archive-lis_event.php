<?php
/**
 * Archive Events Template
 * 
 * Template for displaying events archive page
 * Requirements: 10.1 - Display events in chronological order
 * Requirements: 10.3 - Highlight events within next 7 days
 * Requirements: 10.5 - Filter events by category
 * Task 15: Create event archive template
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

<main id="main" class="site-main events-archive-page" role="main">
    
    <div class="events-archive-container">
        
        <!-- Page Header -->
        <header class="page-header">
            <?php lumina_breadcrumbs(); ?>
            <h1 class="page-title">School Events</h1>
            <p class="page-description">Stay informed about upcoming school activities, academic events, sports, cultural programs, and important dates.</p>
        </header>
        
        <!-- Event Category Filter -->
        <?php
        $event_categories = get_terms(array(
            'taxonomy' => 'event_category',
            'hide_empty' => true,
        ));
        
        if ($event_categories && !is_wp_error($event_categories)) :
        ?>
            <div class="event-filters">
                <div class="filter-label">Filter by Category:</div>
                <div class="filter-buttons">
                    <a href="<?php echo get_post_type_archive_link('lis_event'); ?>" 
                       class="filter-btn <?php echo !is_tax('event_category') ? 'active' : ''; ?>">
                        All Events
                    </a>
                    <?php foreach ($event_categories as $category) : ?>
                        <a href="<?php echo get_term_link($category); ?>" 
                           class="filter-btn <?php echo is_tax('event_category', $category->slug) ? 'active' : ''; ?>">
                            <?php echo esc_html($category->name); ?>
                            <span class="count">(<?php echo $category->count; ?>)</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Events List -->
        <?php if (have_posts()) : ?>
            
            <div class="events-list">
                
                <?php
                // Get today's date for comparison
                $today = strtotime(date('Y-m-d'));
                $seven_days = strtotime('+7 days', $today);
                
                while (have_posts()) : the_post();
                    
                    // Get event custom fields
                    $event_date = get_post_meta(get_the_ID(), 'event_date', true);
                    $event_time = get_post_meta(get_the_ID(), 'event_time', true);
                    $event_location = get_post_meta(get_the_ID(), 'event_location', true);
                    $event_end_date = get_post_meta(get_the_ID(), 'event_end_date', true);
                    
                    // Check if event is within next 7 days
                    $is_upcoming = false;
                    if ($event_date) {
                        $event_timestamp = strtotime($event_date);
                        if ($event_timestamp >= $today && $event_timestamp <= $seven_days) {
                            $is_upcoming = true;
                        }
                    }
                    
                    // Get event categories
                    $categories = get_the_terms(get_the_ID(), 'event_category');
                ?>
                
                <article id="event-<?php the_ID(); ?>" <?php post_class('event-item ' . ($is_upcoming ? 'upcoming-highlight' : '')); ?>>
                    
                    <div class="event-item-inner">
                        
                        <!-- Event Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="event-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                                </a>
                                <?php if ($is_upcoming) : ?>
                                    <span class="upcoming-badge">Upcoming!</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Event Content -->
                        <div class="event-content-wrapper">
                            
                            <!-- Event Categories -->
                            <?php if ($categories && !is_wp_error($categories)) : ?>
                                <div class="event-categories">
                                    <?php foreach ($categories as $category) : ?>
                                        <span class="event-category-badge"><?php echo esc_html($category->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Event Title -->
                            <h2 class="event-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <!-- Event Meta -->
                            <div class="event-meta">
                                <?php if ($event_date) : ?>
                                    <div class="event-meta-item">
                                        <span class="meta-icon">📅</span>
                                        <span class="meta-text">
                                            <?php 
                                            echo date('F j, Y', strtotime($event_date));
                                            if ($event_end_date && $event_end_date !== $event_date) {
                                                echo ' - ' . date('F j, Y', strtotime($event_end_date));
                                            }
                                            ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($event_time) : ?>
                                    <div class="event-meta-item">
                                        <span class="meta-icon">🕐</span>
                                        <span class="meta-text"><?php echo esc_html(date('g:i A', strtotime($event_time))); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($event_location) : ?>
                                    <div class="event-meta-item">
                                        <span class="meta-icon">📍</span>
                                        <span class="meta-text"><?php echo esc_html($event_location); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Event Excerpt -->
                            <div class="event-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <!-- Read More Link -->
                            <a href="<?php the_permalink(); ?>" class="event-read-more">
                                View Event Details →
                            </a>
                            
                        </div>
                        
                    </div>
                    
                </article>
                
                <?php endwhile; ?>
                
            </div>
            
            <!-- Pagination -->
            <div class="events-pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('← Previous', 'lumina-child-theme'),
                    'next_text' => __('Next →', 'lumina-child-theme'),
                ));
                ?>
            </div>
            
        <?php else : ?>
            
            <!-- No Events Found -->
            <div class="no-events-found">
                <div class="no-events-icon">📅</div>
                <h2>No Events Found</h2>
                <p>There are currently no events scheduled. Please check back later for updates!</p>
                <a href="<?php echo home_url('/'); ?>" class="back-home-btn">Return to Homepage</a>
            </div>
            
        <?php endif; ?>
        
    </div>
    
</main>

<style>
/* Events Archive Styles */
.events-archive-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
}

.events-archive-container {
    background: #FFFFFF;
}

.page-header {
    text-align: center;
    margin-bottom: 50px;
}

.page-title {
    color: #003d70;
    font-size: 48px;
    font-weight: 700;
    margin: 20px 0;
}

.page-description {
    color: #666;
    font-size: 18px;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Event Filters */
.event-filters {
    background: #f7f7f7;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 40px;
}

.filter-label {
    color: #003d70;
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 15px;
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 10px 20px;
    background: #FFFFFF;
    color: #003d70;
    text-decoration: none;
    border: 2px solid #7EBEC5;
    border-radius: 25px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    background: #7EBEC5;
    color: #FFFFFF;
    transform: translateY(-2px);
}

.filter-btn.active {
    background: #003d70;
    color: #FFFFFF;
    border-color: #003d70;
}

.filter-btn .count {
    font-size: 12px;
    opacity: 0.8;
}

/* Events List */
.events-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 30px;
    margin-bottom: 50px;
}

.event-item {
    background: #FFFFFF;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.event-item:hover {
    border-color: #7EBEC5;
    box-shadow: 0 8px 25px rgba(0, 61, 112, 0.15);
    transform: translateY(-5px);
}

.event-item.upcoming-highlight {
    border: 3px solid #F39A3B;
    background: #FFF9F0;
}

.event-item-inner {
    display: flex;
    flex-direction: column;
}

.event-thumbnail {
    position: relative;
    width: 100%;
    height: 250px;
    overflow: hidden;
}

.event-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.event-item:hover .event-thumbnail img {
    transform: scale(1.05);
}

.upcoming-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #F39A3B;
    color: #FFFFFF;
    padding: 8px 20px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 14px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
}

.event-content-wrapper {
    padding: 25px;
}

.event-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 15px;
}

.event-category-badge {
    background: #7EBEC5;
    color: #FFFFFF;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.event-title {
    margin: 0 0 15px 0;
    font-size: 28px;
    line-height: 1.3;
}

.event-title a {
    color: #003d70;
    text-decoration: none;
    transition: color 0.3s ease;
}

.event-title a:hover {
    color: #7EBEC5;
}

.event-meta {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin: 20px 0;
    padding: 15px;
    background: #f7f7f7;
    border-radius: 8px;
}

.event-meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.meta-icon {
    font-size: 20px;
}

.meta-text {
    color: #333;
    font-size: 15px;
}

.event-excerpt {
    color: #666;
    line-height: 1.7;
    margin: 20px 0;
}

.event-read-more {
    display: inline-block;
    padding: 12px 25px;
    background: #F39A3B;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.event-read-more:hover {
    background: #003d70;
    transform: translateX(5px);
}

/* No Events Found */
.no-events-found {
    text-align: center;
    padding: 80px 20px;
    background: #f7f7f7;
    border-radius: 12px;
}

.no-events-icon {
    font-size: 80px;
    margin-bottom: 20px;
}

.no-events-found h2 {
    color: #003d70;
    font-size: 32px;
    margin-bottom: 15px;
}

.no-events-found p {
    color: #666;
    font-size: 18px;
    margin-bottom: 30px;
}

.back-home-btn {
    display: inline-block;
    padding: 15px 30px;
    background: #003d70;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-home-btn:hover {
    background: #F39A3B;
    transform: translateY(-2px);
}

/* Pagination */
.events-pagination {
    margin-top: 50px;
    text-align: center;
}

.events-pagination .nav-links {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.events-pagination .page-numbers {
    display: inline-block;
    padding: 10px 15px;
    background: #FFFFFF;
    color: #003d70;
    text-decoration: none;
    border: 2px solid #7EBEC5;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.events-pagination .page-numbers:hover,
.events-pagination .page-numbers.current {
    background: #003d70;
    color: #FFFFFF;
    border-color: #003d70;
}

/* Responsive Design */
@media (min-width: 768px) {
    .event-item-inner {
        flex-direction: row;
    }
    
    .event-thumbnail {
        width: 350px;
        height: auto;
        min-height: 300px;
    }
    
    .event-content-wrapper {
        flex: 1;
    }
    
    .event-meta {
        flex-direction: row;
        flex-wrap: wrap;
    }
    
    .event-meta-item {
        flex: 0 0 auto;
    }
}

@media (min-width: 1024px) {
    .events-list {
        gap: 40px;
    }
    
    .event-thumbnail {
        width: 400px;
    }
}

@media (max-width: 767px) {
    .page-title {
        font-size: 36px;
    }
    
    .page-description {
        font-size: 16px;
    }
    
    .event-title {
        font-size: 24px;
    }
    
    .filter-buttons {
        flex-direction: column;
    }
    
    .filter-btn {
        justify-content: center;
    }
}
</style>

<?php
get_footer();
