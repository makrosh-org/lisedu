<?php
/**
 * The template for displaying single posts (individual news articles)
 * 
 * Task 17: Configure blog/news functionality
 * Requirements: 11.1, 11.2, 11.3, 11.5
 * 
 * This template displays individual news articles with full content,
 * featured image, title, date, author, and category information.
 * 
 * @package Lumina_Child_Theme
 * @version 1.0.0
 */

get_header(); ?>

<div class="lumina-single-post">
    <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>
            
            <!-- Article Header -->
            <div class="article-header-section">
                <div class="container">
                    
                    <!-- Breadcrumbs -->
                    <?php lumina_breadcrumbs(); ?>
                    
                    <!-- Categories -->
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) :
                    ?>
                        <div class="article-categories">
                            <?php foreach ($categories as $category) : ?>
                                <a href="<?php echo get_category_link($category->term_id); ?>" class="category-badge">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Title -->
                    <h1 class="article-main-title"><?php the_title(); ?></h1>
                    
                    <!-- Meta Information -->
                    <div class="article-main-meta">
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M11 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h1V1h2v1h4V1h2v1zm1 3H4v8h8V5z"/>
                            </svg>
                            <span><?php echo get_the_date('F j, Y'); ?></span>
                        </div>
                        
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span>By <?php the_author(); ?></span>
                        </div>
                        
                        <?php if (comments_open() || get_comments_number()) : ?>
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6l-4 4V4a2 2 0 0 1 2-2z"/>
                            </svg>
                            <span><?php comments_number('0 Comments', '1 Comment', '% Comments'); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
            
            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="article-featured-image">
                    <div class="container">
                        <?php the_post_thumbnail('full', array('alt' => get_the_title())); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Article Content -->
            <div class="article-main-content">
                <div class="container">
                    <div class="content-wrapper">
                        
                        <!-- Main Content -->
                        <div class="article-body">
                            <?php the_content(); ?>
                            
                            <?php
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'lumina-child-theme'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>
                        
                        <!-- Sidebar -->
                        <aside class="article-sidebar">
                            
                            <!-- Share Section -->
                            <div class="sidebar-widget share-widget">
                                <h3 class="widget-title">Share This Article</h3>
                                <div class="share-buttons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer" 
                                       class="share-btn facebook-btn"
                                       aria-label="Share on Facebook">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                        Facebook
                                    </a>
                                    
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer" 
                                       class="share-btn twitter-btn"
                                       aria-label="Share on Twitter">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                        Twitter
                                    </a>
                                    
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer" 
                                       class="share-btn linkedin-btn"
                                       aria-label="Share on LinkedIn">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                        LinkedIn
                                    </a>
                                    
                                    <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>" 
                                       class="share-btn email-btn"
                                       aria-label="Share via Email">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                        </svg>
                                        Email
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Related Articles -->
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) :
                                $category_ids = array();
                                foreach ($categories as $category) {
                                    $category_ids[] = $category->term_id;
                                }
                                
                                $related_args = array(
                                    'category__in' => $category_ids,
                                    'post__not_in' => array(get_the_ID()),
                                    'posts_per_page' => 3,
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                );
                                
                                $related_query = new WP_Query($related_args);
                                
                                if ($related_query->have_posts()) :
                            ?>
                                <div class="sidebar-widget related-articles-widget">
                                    <h3 class="widget-title">Related Articles</h3>
                                    <div class="related-articles-list">
                                        <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                                            <article class="related-article-item">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <a href="<?php the_permalink(); ?>" class="related-article-image">
                                                        <?php the_post_thumbnail('thumbnail', array('alt' => get_the_title())); ?>
                                                    </a>
                                                <?php endif; ?>
                                                <div class="related-article-content">
                                                    <h4 class="related-article-title">
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </h4>
                                                    <span class="related-article-date"><?php echo get_the_date('M j, Y'); ?></span>
                                                </div>
                                            </article>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            <?php
                                    wp_reset_postdata();
                                endif;
                            endif;
                            ?>
                            
                            <!-- Back to News -->
                            <div class="sidebar-widget back-to-news-widget">
                                <a href="<?php echo get_permalink(get_page_by_path('news')); ?>" class="back-to-news-link">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M8 0l-8 8 8 8V0z"/>
                                    </svg>
                                    Back to All News
                                </a>
                            </div>
                            
                        </aside>
                        
                    </div>
                </div>
            </div>
            
            <!-- Post Navigation -->
            <div class="post-navigation-section">
                <div class="container">
                    <div class="post-navigation">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        
                        <?php if ($prev_post) : ?>
                            <div class="nav-item nav-previous">
                                <span class="nav-label">← Previous Article</span>
                                <a href="<?php echo get_permalink($prev_post); ?>" class="nav-title">
                                    <?php echo get_the_title($prev_post); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($next_post) : ?>
                            <div class="nav-item nav-next">
                                <span class="nav-label">Next Article →</span>
                                <a href="<?php echo get_permalink($next_post); ?>" class="nav-title">
                                    <?php echo get_the_title($next_post); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Comments Section -->
            <?php if (comments_open() || get_comments_number()) : ?>
                <div class="comments-section">
                    <div class="container">
                        <?php comments_template(); ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </article>
        
    <?php endwhile; ?>
</div>

<style>
/* Single Post Styles */
.lumina-single-post {
    background: #f7f7f7;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Article Header */
.article-header-section {
    background: #FFFFFF;
    padding: 40px 0 30px;
    border-bottom: 3px solid #7EBEC5;
}

.article-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 20px 0;
}

.category-badge {
    background: #7EBEC5;
    color: #FFFFFF;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.category-badge:hover {
    background: #F39A3B;
}

.article-main-title {
    color: #003d70;
    font-size: 42px;
    line-height: 1.3;
    margin: 20px 0;
    font-weight: 700;
}

.article-main-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    margin-top: 20px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    font-size: 15px;
}

.meta-item svg {
    color: #7EBEC5;
}

/* Featured Image */
.article-featured-image {
    background: #FFFFFF;
    padding: 0 0 40px;
}

.article-featured-image img {
    width: 100%;
    height: auto;
    max-height: 600px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

/* Article Content */
.article-main-content {
    padding: 40px 0;
}

.content-wrapper {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 40px;
}

.article-body {
    background: #FFFFFF;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
}

.article-body p {
    color: #333;
    font-size: 17px;
    line-height: 1.8;
    margin-bottom: 20px;
}

.article-body h2,
.article-body h3,
.article-body h4 {
    color: #003d70;
    margin-top: 30px;
    margin-bottom: 15px;
    font-weight: 700;
}

.article-body h2 {
    font-size: 32px;
}

.article-body h3 {
    font-size: 26px;
}

.article-body h4 {
    font-size: 22px;
}

.article-body ul,
.article-body ol {
    margin: 20px 0;
    padding-left: 30px;
}

.article-body li {
    color: #333;
    font-size: 17px;
    line-height: 1.8;
    margin-bottom: 10px;
}

.article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 25px 0;
}

.article-body blockquote {
    border-left: 4px solid #7EBEC5;
    padding-left: 25px;
    margin: 30px 0;
    font-style: italic;
    color: #666;
    font-size: 18px;
}

/* Sidebar */
.article-sidebar {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.sidebar-widget {
    background: #FFFFFF;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
}

.widget-title {
    color: #003d70;
    font-size: 20px;
    margin: 0 0 20px 0;
    font-weight: 700;
    padding-bottom: 15px;
    border-bottom: 2px solid #7EBEC5;
}

/* Share Buttons */
.share-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.share-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    color: #FFFFFF;
}

.facebook-btn {
    background: #1877F2;
}

.facebook-btn:hover {
    background: #145dbf;
}

.twitter-btn {
    background: #1DA1F2;
}

.twitter-btn:hover {
    background: #1a8cd8;
}

.linkedin-btn {
    background: #0A66C2;
}

.linkedin-btn:hover {
    background: #004182;
}

.email-btn {
    background: #666;
}

.email-btn:hover {
    background: #003d70;
}

/* Related Articles */
.related-articles-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.related-article-item {
    display: flex;
    gap: 15px;
}

.related-article-image {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
}

.related-article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-article-item:hover .related-article-image img {
    transform: scale(1.1);
}

.related-article-content {
    flex: 1;
}

.related-article-title {
    margin: 0 0 8px 0;
    font-size: 15px;
    line-height: 1.4;
}

.related-article-title a {
    color: #003d70;
    text-decoration: none;
    transition: color 0.3s ease;
}

.related-article-title a:hover {
    color: #7EBEC5;
}

.related-article-date {
    color: #999;
    font-size: 12px;
}

/* Back to News */
.back-to-news-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px;
    background: #F39A3B;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-to-news-link:hover {
    background: #003d70;
}

/* Post Navigation */
.post-navigation-section {
    background: #FFFFFF;
    padding: 30px 0;
    border-top: 1px solid #f7f7f7;
}

.post-navigation {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

.nav-item {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.nav-next {
    text-align: right;
}

.nav-label {
    color: #999;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.nav-title {
    color: #003d70;
    font-size: 18px;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
}

.nav-title:hover {
    color: #7EBEC5;
}

/* Comments Section */
.comments-section {
    background: #FFFFFF;
    padding: 40px 0;
    border-top: 1px solid #f7f7f7;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .content-wrapper {
        grid-template-columns: 1fr;
    }
    
    .article-sidebar {
        order: 2;
    }
}

@media (max-width: 768px) {
    .article-main-title {
        font-size: 32px;
    }
    
    .article-body {
        padding: 25px;
    }
    
    .article-body p,
    .article-body li {
        font-size: 16px;
    }
    
    .post-navigation {
        grid-template-columns: 1fr;
    }
    
    .nav-next {
        text-align: left;
    }
}

@media (max-width: 480px) {
    .article-header-section {
        padding: 25px 0 20px;
    }
    
    .article-main-title {
        font-size: 26px;
    }
    
    .article-main-meta {
        flex-direction: column;
        gap: 12px;
    }
    
    .article-body {
        padding: 20px;
    }
    
    .sidebar-widget {
        padding: 20px;
    }
}
</style>

<?php get_footer(); ?>
