<?php
/**
 * Archive Template for Resources
 * 
 * Displays a list of downloadable resources organized by categories
 * Requirements: 12.1, 12.2, 12.3, 12.4
 * Task 19: Create custom post type for Resources
 * 
 * @package Lumina_Child_Theme
 */

get_header();
?>

<div class="lumina-resources-archive">
    <div class="container">
        
        <!-- Page Header -->
        <header class="archive-header">
            <?php lumina_breadcrumbs(); ?>
            <h1 class="archive-title">
                <?php
                if (is_tax('resource_category')) {
                    single_term_title();
                } else {
                    echo 'Resources';
                }
                ?>
            </h1>
            <?php
            if (is_tax('resource_category')) {
                $term_description = term_description();
                if (!empty($term_description)) {
                    echo '<div class="archive-description">' . $term_description . '</div>';
                }
            } else {
                echo '<p class="archive-description">Access important documents, forms, and information for Lumina International School.</p>';
            }
            ?>
        </header>
        
        <!-- Category Filter -->
        <div class="resources-category-filter">
            <?php
            $current_term = get_queried_object();
            $current_term_id = isset($current_term->term_id) ? $current_term->term_id : 0;
            
            $categories = get_terms(array(
                'taxonomy' => 'resource_category',
                'hide_empty' => true,
            ));
            
            if (!empty($categories) && !is_wp_error($categories)) {
                echo '<div class="category-buttons">';
                
                // All Resources button
                $all_active = !is_tax('resource_category') ? 'active' : '';
                echo '<a href="' . get_post_type_archive_link('lis_resource') . '" class="category-btn ' . $all_active . '">All Resources</a>';
                
                // Category buttons
                foreach ($categories as $category) {
                    $is_active = ($current_term_id == $category->term_id) ? 'active' : '';
                    echo '<a href="' . get_term_link($category) . '" class="category-btn ' . $is_active . '">';
                    echo esc_html($category->name);
                    echo ' <span class="count">(' . $category->count . ')</span>';
                    echo '</a>';
                }
                
                echo '</div>';
            }
            ?>
        </div>
        
        <!-- Resources Grid -->
        <div class="resources-grid">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    
                    $resource_id = get_the_ID();
                    $file_url = get_post_meta($resource_id, '_resource_file_url', true);
                    $file_type = get_post_meta($resource_id, '_resource_file_type', true);
                    $file_size = get_post_meta($resource_id, '_resource_file_size', true);
                    $download_count = get_post_meta($resource_id, '_resource_download_count', true);
                    $access_level = get_post_meta($resource_id, '_resource_access_level', true);
                    $categories = get_the_terms($resource_id, 'resource_category');
                    
                    // Get file icon based on type
                    $file_icon = '📄';
                    if (!empty($file_type)) {
                        switch (strtoupper($file_type)) {
                            case 'PDF':
                                $file_icon = '📕';
                                break;
                            case 'DOC':
                            case 'DOCX':
                                $file_icon = '📘';
                                break;
                            case 'XLS':
                            case 'XLSX':
                                $file_icon = '📊';
                                break;
                        }
                    }
                    ?>
                    
                    <article id="resource-<?php echo $resource_id; ?>" class="resource-card">
                        <div class="resource-icon">
                            <?php echo $file_icon; ?>
                        </div>
                        
                        <div class="resource-content">
                            <h3 class="resource-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <?php if ($categories && !is_wp_error($categories)): ?>
                                <div class="resource-categories">
                                    <?php foreach ($categories as $category): ?>
                                        <span class="resource-category-badge"><?php echo esc_html($category->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="resource-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <div class="resource-meta">
                                <?php if (!empty($file_type)): ?>
                                    <span class="resource-type">
                                        <strong>Type:</strong> <?php echo esc_html($file_type); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if (!empty($file_size)): ?>
                                    <span class="resource-size">
                                        <strong>Size:</strong> <?php echo esc_html($file_size); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if (!empty($download_count)): ?>
                                    <span class="resource-downloads">
                                        <strong>Downloads:</strong> <?php echo number_format($download_count); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="resource-actions">
                                <?php if (!empty($file_url)): ?>
                                    <?php
                                    // Check if restricted and user is not logged in
                                    if ($access_level === 'restricted' && !is_user_logged_in()) {
                                        echo '<a href="' . wp_login_url(get_permalink()) . '" class="resource-download-btn restricted">';
                                        echo '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/></svg>';
                                        echo 'Login to Download';
                                        echo '</a>';
                                    } else {
                                        $download_url = add_query_arg('download_resource', $resource_id, home_url('/'));
                                        echo '<a href="' . esc_url($download_url) . '" class="resource-download-btn" target="_blank">';
                                        echo '<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>';
                                        echo 'Download';
                                        echo '</a>';
                                    }
                                    ?>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="resource-view-btn">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </article>
                    
                    <?php
                }
                
                // Pagination
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                ));
                
            } else {
                ?>
                <div class="no-resources-found">
                    <div class="no-resources-icon">📁</div>
                    <h3>No Resources Found</h3>
                    <p>There are currently no resources in this category. Please check back later or browse other categories.</p>
                    <a href="<?php echo get_post_type_archive_link('lis_resource'); ?>" class="back-to-all-btn">View All Resources</a>
                </div>
                <?php
            }
            ?>
        </div>
        
    </div>
</div>

<style>
/* Resources Archive Styles */
.lumina-resources-archive {
    padding: 40px 20px;
    background: #f7f7f7;
    min-height: 70vh;
}

.lumina-resources-archive .container {
    max-width: 1200px;
    margin: 0 auto;
}

.archive-header {
    background: #FFFFFF;
    padding: 40px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.archive-title {
    color: #003d70;
    font-size: 36px;
    margin: 0 0 15px 0;
    font-weight: 700;
}

.archive-description {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    margin: 0;
}

/* Category Filter */
.resources-category-filter {
    background: #FFFFFF;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.category-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
}

.category-btn {
    padding: 12px 24px;
    background: #f7f7f7;
    color: #003d70;
    text-decoration: none;
    border-radius: 25px;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.category-btn:hover {
    background: #7EBEC5;
    color: #FFFFFF;
    transform: translateY(-2px);
}

.category-btn.active {
    background: #003d70;
    color: #FFFFFF;
    border-color: #003d70;
}

.category-btn .count {
    font-size: 13px;
    opacity: 0.8;
}

/* Resources Grid */
.resources-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 25px;
}

.resource-card {
    background: #FFFFFF;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    gap: 20px;
}

.resource-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 61, 112, 0.15);
}

.resource-icon {
    font-size: 50px;
    flex-shrink: 0;
}

.resource-content {
    flex: 1;
}

.resource-title {
    margin: 0 0 12px 0;
    font-size: 20px;
    line-height: 1.4;
}

.resource-title a {
    color: #003d70;
    text-decoration: none;
    transition: color 0.3s ease;
}

.resource-title a:hover {
    color: #7EBEC5;
}

.resource-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}

.resource-category-badge {
    background: #7EBEC5;
    color: #FFFFFF;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
}

.resource-excerpt {
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
    font-size: 14px;
}

.resource-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
    padding: 15px;
    background: #f7f7f7;
    border-radius: 8px;
    font-size: 13px;
}

.resource-meta span {
    color: #666;
}

.resource-meta strong {
    color: #003d70;
}

.resource-actions {
    display: flex;
    gap: 10px;
}

.resource-download-btn,
.resource-view-btn {
    flex: 1;
    text-align: center;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.resource-download-btn {
    background: #F39A3B;
    color: #FFFFFF;
}

.resource-download-btn:hover {
    background: #003d70;
}

.resource-download-btn.restricted {
    background: #999;
}

.resource-download-btn.restricted:hover {
    background: #666;
}

.resource-view-btn {
    background: #FFFFFF;
    color: #003d70;
    border: 2px solid #003d70;
}

.resource-view-btn:hover {
    background: #003d70;
    color: #FFFFFF;
}

/* No Resources Found */
.no-resources-found {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    background: #FFFFFF;
    border-radius: 12px;
}

.no-resources-icon {
    font-size: 80px;
    margin-bottom: 20px;
    opacity: 0.3;
}

.no-resources-found h3 {
    color: #003d70;
    font-size: 28px;
    margin-bottom: 15px;
}

.no-resources-found p {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 30px;
}

.back-to-all-btn {
    display: inline-block;
    padding: 12px 30px;
    background: #F39A3B;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-to-all-btn:hover {
    background: #003d70;
}

/* Pagination */
.pagination {
    margin-top: 40px;
    text-align: center;
}

.pagination .nav-links {
    display: inline-flex;
    gap: 10px;
}

.pagination a,
.pagination span {
    display: inline-block;
    padding: 10px 18px;
    background: #FFFFFF;
    color: #003d70;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid #f7f7f7;
}

.pagination a:hover,
.pagination .current {
    background: #003d70;
    color: #FFFFFF;
    border-color: #003d70;
}

/* Responsive Design */
@media (max-width: 768px) {
    .resources-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .resource-card {
        flex-direction: column;
        text-align: center;
    }
    
    .resource-icon {
        font-size: 60px;
    }
    
    .resource-actions {
        flex-direction: column;
    }
    
    .category-buttons {
        flex-direction: column;
    }
    
    .archive-header {
        padding: 30px 20px;
    }
    
    .archive-title {
        font-size: 28px;
    }
}
</style>

<?php
get_footer();
