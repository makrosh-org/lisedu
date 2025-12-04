<?php
/**
 * Archive Programs Template
 * 
 * Template for displaying the programs archive page
 * Requirements: 1.3 - Display all programs with filtering
 * 
 * @package Lumina_Child_Theme
 * @version 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main programs-archive">
    
    <!-- Page Header -->
    <header class="page-header programs-header">
        <?php lumina_breadcrumbs(); ?>
        
        <h1 class="page-title">Our Programs</h1>
        <p class="page-description">
            Explore our comprehensive educational programs designed for students from play group to grade 5. 
            Each program integrates academic excellence with Islamic values.
        </p>
    </header>
    
    <!-- Category Filter -->
    <?php
    $program_categories = get_terms(array(
        'taxonomy' => 'program_category',
        'hide_empty' => true,
    ));
    
    if ($program_categories && !is_wp_error($program_categories)) :
    ?>
        <div class="program-filters">
            <div class="filter-label">Filter by Category:</div>
            <div class="filter-buttons">
                <a href="<?php echo esc_url(get_post_type_archive_link('lis_program')); ?>" 
                   class="filter-button <?php echo !is_tax('program_category') ? 'active' : ''; ?>">
                    All Programs
                </a>
                <?php foreach ($program_categories as $category) : ?>
                    <a href="<?php echo esc_url(get_term_link($category)); ?>" 
                       class="filter-button <?php echo is_tax('program_category', $category->slug) ? 'active' : ''; ?>">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Programs Grid -->
    <?php if (have_posts()) : ?>
        
        <div class="programs-grid">
            <?php
            while (have_posts()) :
                the_post();
                
                // Get custom field values
                $age_range = get_post_meta(get_the_ID(), '_program_age_range', true);
                $curriculum_highlights = get_post_meta(get_the_ID(), '_program_curriculum_highlights', true);
                $program_categories = get_the_terms(get_the_ID(), 'program_category');
                ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('program-card'); ?>>
                    
                    <!-- Featured Image -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="program-card-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium_large', array('alt' => get_the_title())); ?>
                            </a>
                            
                            <?php if ($program_categories && !is_wp_error($program_categories)) : ?>
                                <div class="program-card-categories">
                                    <?php foreach ($program_categories as $category) : ?>
                                        <span class="category-badge"><?php echo esc_html($category->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Card Content -->
                    <div class="program-card-content">
                        <h2 class="program-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <?php if ($age_range) : ?>
                            <div class="program-card-age">
                                <span class="age-icon">👶</span>
                                <span class="age-text"><?php echo esc_html($age_range); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="program-card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                        </div>
                        
                        <?php if ($curriculum_highlights) : ?>
                            <div class="program-card-highlights">
                                <?php
                                // Show first 3 highlights
                                $highlights = explode("\n", $curriculum_highlights);
                                $highlights = array_filter(array_map('trim', $highlights));
                                $highlights = array_slice($highlights, 0, 3);
                                
                                if (!empty($highlights)) {
                                    echo '<ul class="highlights-preview">';
                                    foreach ($highlights as $highlight) {
                                        if (!empty($highlight)) {
                                            $highlight = preg_replace('/^[-•*]\s*/', '', $highlight);
                                            echo '<li>' . esc_html(wp_trim_words($highlight, 8, '...')) . '</li>';
                                        }
                                    }
                                    echo '</ul>';
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <a href="<?php the_permalink(); ?>" class="program-card-link">
                            Learn More →
                        </a>
                    </div>
                    
                </article>
                
            <?php endwhile; ?>
        </div>
        
        <!-- Pagination -->
        <div class="programs-pagination">
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('← Previous', 'lumina-child-theme'),
                'next_text' => __('Next →', 'lumina-child-theme'),
            ));
            ?>
        </div>
        
    <?php else : ?>
        
        <div class="no-programs-found">
            <p>No programs found. Please check back later or contact us for more information.</p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="contact-button">Contact Us</a>
        </div>
        
    <?php endif; ?>
    
</main>

<style>
/* Programs Archive Page Styles */
.programs-archive {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
}

.programs-header {
    text-align: center;
    margin-bottom: 50px;
    padding-bottom: 30px;
    border-bottom: 3px solid var(--base-accent-teal, #7EBEC5);
}

.page-title {
    color: var(--base-darkblue, #003d70);
    font-size: 42px;
    margin-bottom: 15px;
}

.page-description {
    color: #666;
    font-size: 18px;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto;
}

/* Program Filters */
.program-filters {
    background: var(--base-lightgray, #f7f7f7);
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 40px;
    text-align: center;
}

.filter-label {
    color: var(--base-darkblue, #003d70);
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 15px;
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
}

.filter-button {
    display: inline-block;
    padding: 10px 25px;
    background: var(--base-white, #FFFFFF);
    color: var(--base-darkblue, #003d70);
    border: 2px solid var(--base-accent-teal, #7EBEC5);
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.filter-button:hover {
    background: var(--base-accent-teal, #7EBEC5);
    color: var(--base-white, #FFFFFF);
    transform: translateY(-2px);
}

.filter-button.active {
    background: var(--base-darkblue, #003d70);
    color: var(--base-white, #FFFFFF);
    border-color: var(--base-darkblue, #003d70);
}

/* Programs Grid */
.programs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.program-card {
    background: var(--base-white, #FFFFFF);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 61, 112, 0.1);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.program-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 25px rgba(0, 61, 112, 0.2);
}

.program-card-image {
    position: relative;
    width: 100%;
    height: 250px;
    overflow: hidden;
}

.program-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.program-card:hover .program-card-image img {
    transform: scale(1.1);
}

.program-card-categories {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.category-badge {
    display: inline-block;
    background: var(--base-accent-orange, #F39A3B);
    color: var(--base-white, #FFFFFF);
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.program-card-content {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.program-card-title {
    font-size: 24px;
    margin-bottom: 15px;
}

.program-card-title a {
    color: var(--base-darkblue, #003d70);
    text-decoration: none;
    transition: color 0.3s ease;
}

.program-card-title a:hover {
    color: var(--base-accent-teal, #7EBEC5);
}

.program-card-age {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
    padding: 8px 12px;
    background: var(--base-lightgray, #f7f7f7);
    border-radius: 20px;
    width: fit-content;
}

.age-icon {
    font-size: 18px;
}

.age-text {
    color: var(--base-darkblue, #003d70);
    font-weight: 600;
    font-size: 14px;
}

.program-card-excerpt {
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
    flex: 1;
}

.program-card-highlights {
    margin-bottom: 20px;
}

.highlights-preview {
    list-style: none;
    padding: 0;
    margin: 0;
}

.highlights-preview li {
    padding: 5px 0 5px 20px;
    position: relative;
    color: #555;
    font-size: 14px;
}

.highlights-preview li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: var(--base-accent-orange, #F39A3B);
    font-weight: bold;
}

.program-card-link {
    display: inline-block;
    color: var(--base-accent-teal, #7EBEC5);
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    margin-top: auto;
}

.program-card-link:hover {
    color: var(--base-accent-orange, #F39A3B);
    transform: translateX(5px);
}

/* Pagination */
.programs-pagination {
    text-align: center;
    margin-top: 50px;
}

.programs-pagination .nav-links {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.programs-pagination .page-numbers {
    display: inline-block;
    padding: 10px 18px;
    background: var(--base-white, #FFFFFF);
    color: var(--base-darkblue, #003d70);
    border: 2px solid var(--base-accent-teal, #7EBEC5);
    border-radius: 5px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.programs-pagination .page-numbers:hover,
.programs-pagination .page-numbers.current {
    background: var(--base-accent-teal, #7EBEC5);
    color: var(--base-white, #FFFFFF);
}

/* No Programs Found */
.no-programs-found {
    text-align: center;
    padding: 80px 20px;
    background: var(--base-lightgray, #f7f7f7);
    border-radius: 8px;
}

.no-programs-found p {
    font-size: 18px;
    color: #666;
    margin-bottom: 25px;
}

.contact-button {
    display: inline-block;
    padding: 15px 40px;
    background: var(--base-accent-orange, #F39A3B);
    color: var(--base-white, #FFFFFF);
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.contact-button:hover {
    background: var(--base-darkblue, #003d70);
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .programs-archive {
        padding: 20px 15px;
    }
    
    .page-title {
        font-size: 32px;
    }
    
    .page-description {
        font-size: 16px;
    }
    
    .programs-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .filter-buttons {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-button {
        width: 100%;
        text-align: center;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .programs-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<?php
get_footer();
