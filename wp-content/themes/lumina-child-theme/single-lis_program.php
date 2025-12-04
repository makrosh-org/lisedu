<?php
/**
 * Single Program Template
 * 
 * Template for displaying individual program pages
 * Requirements: 1.3 - Display detailed information for each grade level
 * 
 * @package Lumina_Child_Theme
 * @version 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main program-single">
    <?php
    while (have_posts()) :
        the_post();
        
        // Get custom field values
        $age_range = get_post_meta(get_the_ID(), '_program_age_range', true);
        $curriculum_highlights = get_post_meta(get_the_ID(), '_program_curriculum_highlights', true);
        $program_categories = get_the_terms(get_the_ID(), 'program_category');
        ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('program-article'); ?>>
            
            <!-- Breadcrumbs -->
            <?php lumina_breadcrumbs(); ?>
            
            <!-- Program Header -->
            <header class="program-header">
                <h1 class="program-title"><?php the_title(); ?></h1>
                
                <?php if ($age_range) : ?>
                    <div class="program-age-range">
                        <span class="age-range-label">Age Range:</span>
                        <span class="age-range-value"><?php echo esc_html($age_range); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($program_categories && !is_wp_error($program_categories)) : ?>
                    <div class="program-categories">
                        <?php foreach ($program_categories as $category) : ?>
                            <span class="program-category-badge"><?php echo esc_html($category->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </header>
            
            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="program-featured-image">
                    <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                </div>
            <?php endif; ?>
            
            <!-- Program Content -->
            <div class="program-content">
                <?php the_content(); ?>
            </div>
            
            <!-- Curriculum Highlights -->
            <?php if ($curriculum_highlights) : ?>
                <div class="program-curriculum-highlights">
                    <h2 class="curriculum-title">Curriculum Highlights</h2>
                    <div class="curriculum-content">
                        <?php
                        // Convert line breaks to list items
                        $highlights = explode("\n", $curriculum_highlights);
                        $highlights = array_filter(array_map('trim', $highlights));
                        
                        if (!empty($highlights)) {
                            echo '<ul class="curriculum-list">';
                            foreach ($highlights as $highlight) {
                                if (!empty($highlight)) {
                                    // Remove bullet points if they exist
                                    $highlight = preg_replace('/^[-•*]\s*/', '', $highlight);
                                    echo '<li>' . esc_html($highlight) . '</li>';
                                }
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Call to Action -->
            <div class="program-cta">
                <h3>Interested in this program?</h3>
                <p>Contact us to learn more or schedule a visit.</p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="cta-button">Contact Us</a>
                <a href="<?php echo esc_url(home_url('/admissions')); ?>" class="cta-button secondary">Apply Now</a>
            </div>
            
            <!-- Navigation to other programs -->
            <nav class="program-navigation">
                <div class="nav-previous">
                    <?php
                    $prev_post = get_previous_post();
                    if ($prev_post) {
                        echo '<a href="' . get_permalink($prev_post->ID) . '" class="nav-link">';
                        echo '<span class="nav-label">← Previous Program</span>';
                        echo '<span class="nav-title">' . esc_html($prev_post->post_title) . '</span>';
                        echo '</a>';
                    }
                    ?>
                </div>
                <div class="nav-next">
                    <?php
                    $next_post = get_next_post();
                    if ($next_post) {
                        echo '<a href="' . get_permalink($next_post->ID) . '" class="nav-link">';
                        echo '<span class="nav-label">Next Program →</span>';
                        echo '<span class="nav-title">' . esc_html($next_post->post_title) . '</span>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </nav>
            
        </article>
        
    <?php endwhile; ?>
</main>

<style>
/* Program Single Page Styles */
.program-single {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.program-article {
    background: var(--base-white, #FFFFFF);
}

.program-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 3px solid var(--base-accent-teal, #7EBEC5);
}

.program-title {
    color: var(--base-darkblue, #003d70);
    font-size: 36px;
    margin-bottom: 15px;
    line-height: 1.2;
}

.program-age-range {
    margin: 15px 0;
    font-size: 18px;
}

.age-range-label {
    color: var(--base-darkblue, #003d70);
    font-weight: 600;
    margin-right: 10px;
}

.age-range-value {
    color: var(--base-accent-orange, #F39A3B);
    font-weight: 500;
}

.program-categories {
    margin-top: 15px;
}

.program-category-badge {
    display: inline-block;
    background: var(--base-accent-teal, #7EBEC5);
    color: var(--base-white, #FFFFFF);
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 14px;
    margin-right: 10px;
    margin-bottom: 5px;
}

.program-featured-image {
    margin: 30px 0;
    border-radius: 8px;
    overflow: hidden;
}

.program-featured-image img {
    width: 100%;
    height: auto;
    display: block;
}

.program-content {
    margin: 40px 0;
    line-height: 1.8;
    color: #333;
    font-size: 16px;
}

.program-content p {
    margin-bottom: 20px;
}

.program-curriculum-highlights {
    background: var(--base-lightgray, #f7f7f7);
    padding: 30px;
    border-radius: 8px;
    margin: 40px 0;
}

.curriculum-title {
    color: var(--base-darkblue, #003d70);
    font-size: 28px;
    margin-bottom: 20px;
}

.curriculum-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.curriculum-list li {
    padding: 12px 0 12px 30px;
    position: relative;
    color: #333;
    font-size: 16px;
    line-height: 1.6;
}

.curriculum-list li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: var(--base-accent-orange, #F39A3B);
    font-weight: bold;
    font-size: 18px;
}

.program-cta {
    background: linear-gradient(135deg, var(--base-darkblue, #003d70) 0%, var(--base-accent-teal, #7EBEC5) 100%);
    color: var(--base-white, #FFFFFF);
    padding: 40px;
    border-radius: 8px;
    text-align: center;
    margin: 40px 0;
}

.program-cta h3 {
    font-size: 28px;
    margin-bottom: 15px;
    color: var(--base-white, #FFFFFF);
}

.program-cta p {
    font-size: 18px;
    margin-bottom: 25px;
    opacity: 0.95;
}

.cta-button {
    display: inline-block;
    background: var(--base-accent-orange, #F39A3B);
    color: var(--base-white, #FFFFFF);
    padding: 15px 40px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    margin: 0 10px;
    transition: all 0.3s ease;
}

.cta-button:hover {
    background: var(--base-white, #FFFFFF);
    color: var(--base-darkblue, #003d70);
    transform: translateY(-2px);
}

.cta-button.secondary {
    background: transparent;
    border: 2px solid var(--base-white, #FFFFFF);
}

.cta-button.secondary:hover {
    background: var(--base-white, #FFFFFF);
    color: var(--base-darkblue, #003d70);
}

.program-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 50px;
    padding-top: 30px;
    border-top: 2px solid var(--base-lightgray, #f7f7f7);
}

.program-navigation .nav-previous,
.program-navigation .nav-next {
    flex: 0 0 48%;
}

.program-navigation .nav-next {
    text-align: right;
}

.nav-link {
    display: block;
    padding: 20px;
    background: var(--base-lightgray, #f7f7f7);
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.nav-link:hover {
    background: var(--base-accent-teal, #7EBEC5);
    transform: translateY(-3px);
}

.nav-label {
    display: block;
    color: var(--base-accent-orange, #F39A3B);
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
}

.nav-link:hover .nav-label {
    color: var(--base-white, #FFFFFF);
}

.nav-title {
    display: block;
    color: var(--base-darkblue, #003d70);
    font-size: 16px;
    font-weight: 500;
}

.nav-link:hover .nav-title {
    color: var(--base-white, #FFFFFF);
}

/* Responsive Design */
@media (max-width: 768px) {
    .program-single {
        padding: 20px 15px;
    }
    
    .program-title {
        font-size: 28px;
    }
    
    .curriculum-title {
        font-size: 24px;
    }
    
    .program-cta {
        padding: 30px 20px;
    }
    
    .program-cta h3 {
        font-size: 24px;
    }
    
    .cta-button {
        display: block;
        margin: 10px 0;
    }
    
    .program-navigation {
        flex-direction: column;
    }
    
    .program-navigation .nav-previous,
    .program-navigation .nav-next {
        flex: 1;
        margin-bottom: 15px;
        text-align: left;
    }
}
</style>

<?php
get_footer();
