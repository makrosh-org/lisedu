<?php
/**
 * The template for displaying archive pages (blog/news listing)
 * 
 * Task 17: Configure blog/news functionality
 * Requirements: 11.1, 11.2, 11.3, 11.5
 * 
 * This template displays news articles in reverse chronological order
 * with featured images, titles, dates, excerpts, and category filtering.
 * 
 * @package Lumina_Child_Theme
 * @version 1.0.0
 */

get_header(); ?>

<div class="lumina-archive-page">
    <div class="container">
        
        <!-- Page Header with Breadcrumbs -->
        <div class="archive-header">
            <?php lumina_breadcrumbs(); ?>
            
            <h1 class="archive-title">
                <?php
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title();
                } elseif (is_author()) {
                    echo 'Author: ' . get_the_author();
                } elseif (is_date()) {
                    echo 'Archives: ' . get_the_date('F Y');
                } else {
                    echo 'News & Announcements';
                }
                ?>
            </h1>
            
            <?php if (is_category() && category_description()) : ?>
                <div class="archive-description">
                    <?php echo category_description(); ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Category Filter -->
        <?php if (!is_category()) : ?>
        <div class="news-category-filter">
            <div class="filter-label">Filter by Category:</div>
            <div class="filter-buttons">
                <a href="<?php echo get_permalink(get_page_by_path('news')); ?>" class="filter-btn <?php echo !is_category() ? 'active' : ''; ?>">
                    All News
                </a>
                <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hide_empty' => true,
                ));
                
                foreach ($categories as $category) :
                    if ($category->slug !== 'uncategorized') :
                ?>
                    <a href="<?php echo get_category_link($category->term_id); ?>" class="filter-btn">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- News Articles Grid -->
        <div class="news-articles-grid">
            <?php if (have_posts()) : ?>
                
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('news-article-card'); ?>>
                        
                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="article-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('lumina-news', array('alt' => get_the_title())); ?>
                                </a>
                                
                                <!-- Category Badge on Image -->
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) :
                                    $primary_category = $categories[0];
                                ?>
                                    <span class="article-category-badge">
                                        <?php echo esc_html($primary_category->name); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php else : ?>
                            <!-- Placeholder if no featured image -->
                            <div class="article-image article-image-placeholder">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="placeholder-content">
                                        <span class="placeholder-icon">📰</span>
                                    </div>
                                </a>
                                
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) :
                                    $primary_category = $categories[0];
                                ?>
                                    <span class="article-category-badge">
                                        <?php echo esc_html($primary_category->name); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Article Content -->
                        <div class="article-content">
                            
                            <!-- Title -->
                            <h2 class="article-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <!-- Meta Information -->
                            <div class="article-meta">
                                <span class="article-date">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M11 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h1V1h2v1h4V1h2v1zm1 3H4v8h8V5z"/>
                                    </svg>
                                    <?php echo get_the_date('F j, Y'); ?>
                                </span>
                                
                                <span class="article-author">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                    By <?php the_author(); ?>
                                </span>
                            </div>
                            
                            <!-- Excerpt -->
                            <div class="article-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <!-- Read More Link -->
                            <a href="<?php the_permalink(); ?>" class="article-read-more">
                                Read Full Article
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M8 0l8 8-8 8V0z"/>
                                </svg>
                            </a>
                            
                        </div>
                        
                    </article>
                    
                <?php endwhile; ?>
                
                <!-- Pagination -->
                <div class="news-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                        'screen_reader_text' => 'News navigation',
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                
                <!-- No Posts Found -->
                <div class="no-posts-found">
                    <div class="no-posts-icon">📰</div>
                    <h2>No News Articles Found</h2>
                    <p>There are currently no news articles in this category. Please check back later or browse other categories.</p>
                    <a href="<?php echo get_permalink(get_page_by_path('news')); ?>" class="back-to-news-btn">
                        View All News
                    </a>
                </div>
                
            <?php endif; ?>
        </div>
        
    </div>
</div>

<style>
/* Archive Page Styles */
.lumina-archive-page {
    padding: 40px 0;
    background: #f7f7f7;
    min-height: 60vh;
}

.lumina-archive-page .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Archive Header */
.archive-header {
    background: #FFFFFF;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.archive-title {
    color: #003d70;
    font-size: 36px;
    margin: 15px 0;
    font-weight: 700;
}

.archive-description {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    margin-top: 15px;
}

/* Category Filter */
.news-category-filter {
    background: #FFFFFF;
    padding: 20px 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.filter-label {
    color: #003d70;
    font-weight: 600;
    margin-bottom: 15px;
    font-size: 16px;
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.filter-btn {
    padding: 10px 20px;
    background: #f7f7f7;
    color: #003d70;
    text-decoration: none;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.filter-btn:hover {
    background: #7EBEC5;
    color: #FFFFFF;
}

.filter-btn.active {
    background: #003d70;
    color: #FFFFFF;
    border-color: #003d70;
}

/* News Articles Grid */
.news-articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.news-article-card {
    background: #FFFFFF;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.news-article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 61, 112, 0.15);
}

/* Article Image */
.article-image {
    position: relative;
    width: 100%;
    height: 250px;
    overflow: hidden;
    background: #f7f7f7;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.news-article-card:hover .article-image img {
    transform: scale(1.05);
}

.article-image-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #7EBEC5 0%, #003d70 100%);
}

.placeholder-content {
    text-align: center;
}

.placeholder-icon {
    font-size: 80px;
    opacity: 0.3;
}

.article-category-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #F39A3B;
    color: #FFFFFF;
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

/* Article Content */
.article-content {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.article-title {
    margin: 0 0 15px 0;
    font-size: 22px;
    line-height: 1.4;
}

.article-title a {
    color: #003d70;
    text-decoration: none;
    transition: color 0.3s ease;
}

.article-title a:hover {
    color: #7EBEC5;
}

/* Article Meta */
.article-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f7f7f7;
}

.article-date,
.article-author {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #999;
    font-size: 13px;
}

.article-date svg,
.article-author svg {
    color: #7EBEC5;
}

/* Article Excerpt */
.article-excerpt {
    color: #666;
    line-height: 1.7;
    margin-bottom: 20px;
    flex: 1;
}

.article-excerpt p {
    margin: 0;
}

/* Read More Link */
.article-read-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #F39A3B;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    align-self: flex-start;
}

.article-read-more:hover {
    color: #003d70;
    gap: 12px;
}

.article-read-more svg {
    transition: transform 0.3s ease;
}

.article-read-more:hover svg {
    transform: translateX(3px);
}

/* Pagination */
.news-pagination {
    grid-column: 1 / -1;
    margin-top: 20px;
}

.news-pagination .pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.news-pagination .page-numbers {
    padding: 10px 18px;
    background: #FFFFFF;
    color: #003d70;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid #f7f7f7;
}

.news-pagination .page-numbers:hover,
.news-pagination .page-numbers.current {
    background: #003d70;
    color: #FFFFFF;
    border-color: #003d70;
}

.news-pagination .page-numbers.dots {
    background: transparent;
    border: none;
    cursor: default;
}

/* No Posts Found */
.no-posts-found {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    background: #FFFFFF;
    border-radius: 12px;
}

.no-posts-icon {
    font-size: 80px;
    margin-bottom: 20px;
    opacity: 0.3;
}

.no-posts-found h2 {
    color: #003d70;
    font-size: 28px;
    margin-bottom: 15px;
}

.no-posts-found p {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 30px;
}

.back-to-news-btn {
    display: inline-block;
    padding: 12px 30px;
    background: #F39A3B;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-to-news-btn:hover {
    background: #003d70;
}

/* Responsive Design */
@media (max-width: 768px) {
    .archive-title {
        font-size: 28px;
    }
    
    .news-articles-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .filter-buttons {
        flex-direction: column;
    }
    
    .filter-btn {
        text-align: center;
    }
    
    .article-meta {
        flex-direction: column;
        gap: 10px;
    }
}

@media (max-width: 480px) {
    .lumina-archive-page .container {
        padding: 0 15px;
    }
    
    .archive-header,
    .news-category-filter {
        padding: 20px;
    }
    
    .article-content {
        padding: 20px;
    }
}
</style>

<?php get_footer(); ?>
