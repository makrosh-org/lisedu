<?php
/**
 * Single Resource Template
 * 
 * Displays a single resource with download functionality
 * Requirements: 12.2, 12.3, 12.4, 12.5
 * Task 19: Create custom post type for Resources
 * 
 * @package Lumina_Child_Theme
 */

get_header();
?>

<div class="lumina-single-resource">
    <div class="container">
        
        <?php
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
            
            <article id="resource-<?php echo $resource_id; ?>" class="single-resource-content">
                
                <!-- Breadcrumbs -->
                <?php lumina_breadcrumbs(); ?>
                
                <!-- Resource Header -->
                <header class="resource-header">
                    <div class="resource-header-icon">
                        <?php echo $file_icon; ?>
                    </div>
                    <div class="resource-header-content">
                        <h1 class="resource-title"><?php the_title(); ?></h1>
                        
                        <?php if ($categories && !is_wp_error($categories)): ?>
                            <div class="resource-categories">
                                <?php foreach ($categories as $category): ?>
                                    <a href="<?php echo get_term_link($category); ?>" class="resource-category-badge">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </header>
                
                <!-- Resource Meta Information -->
                <div class="resource-meta-box">
                    <div class="meta-grid">
                        <?php if (!empty($file_type)): ?>
                            <div class="meta-item">
                                <div class="meta-icon">📋</div>
                                <div class="meta-content">
                                    <div class="meta-label">File Type</div>
                                    <div class="meta-value"><?php echo esc_html($file_type); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($file_size)): ?>
                            <div class="meta-item">
                                <div class="meta-icon">💾</div>
                                <div class="meta-content">
                                    <div class="meta-label">File Size</div>
                                    <div class="meta-value"><?php echo esc_html($file_size); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($download_count)): ?>
                            <div class="meta-item">
                                <div class="meta-icon">📊</div>
                                <div class="meta-content">
                                    <div class="meta-label">Downloads</div>
                                    <div class="meta-value"><?php echo number_format($download_count); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="meta-item">
                            <div class="meta-icon">🔒</div>
                            <div class="meta-content">
                                <div class="meta-label">Access Level</div>
                                <div class="meta-value"><?php echo ($access_level === 'restricted') ? 'Restricted' : 'Public'; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Resource Description -->
                <div class="resource-description">
                    <h2>About This Resource</h2>
                    <div class="resource-content">
                        <?php the_content(); ?>
                    </div>
                </div>
                
                <!-- Download Section -->
                <?php if (!empty($file_url)): ?>
                    <div class="resource-download-section">
                        <?php
                        // Check if restricted and user is not logged in
                        if ($access_level === 'restricted' && !is_user_logged_in()) {
                            ?>
                            <div class="download-restricted">
                                <div class="restricted-icon">🔒</div>
                                <h3>Login Required</h3>
                                <p>This resource is restricted to logged-in users only. Please log in to download this file.</p>
                                <a href="<?php echo wp_login_url(get_permalink()); ?>" class="login-btn">
                                    Login to Download
                                </a>
                            </div>
                            <?php
                        } else {
                            $download_url = add_query_arg('download_resource', $resource_id, home_url('/'));
                            ?>
                            <div class="download-ready">
                                <h3>Ready to Download</h3>
                                <p>Click the button below to download this resource. The download will begin immediately.</p>
                                <a href="<?php echo esc_url($download_url); ?>" class="download-btn" target="_blank">
                                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                    </svg>
                                    Download <?php echo esc_html($file_type); ?> File
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                <?php endif; ?>
                
                <!-- Related Resources -->
                <?php
                if ($categories && !is_wp_error($categories)) {
                    $category_ids = wp_list_pluck($categories, 'term_id');
                    
                    $related_args = array(
                        'post_type' => 'lis_resource',
                        'posts_per_page' => 3,
                        'post__not_in' => array($resource_id),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'resource_category',
                                'field' => 'term_id',
                                'terms' => $category_ids,
                            ),
                        ),
                    );
                    
                    $related_query = new WP_Query($related_args);
                    
                    if ($related_query->have_posts()) {
                        ?>
                        <div class="related-resources">
                            <h2>Related Resources</h2>
                            <div class="related-resources-grid">
                                <?php
                                while ($related_query->have_posts()) {
                                    $related_query->the_post();
                                    $related_id = get_the_ID();
                                    $related_file_type = get_post_meta($related_id, '_resource_file_type', true);
                                    $related_file_size = get_post_meta($related_id, '_resource_file_size', true);
                                    
                                    $related_icon = '📄';
                                    if (!empty($related_file_type)) {
                                        switch (strtoupper($related_file_type)) {
                                            case 'PDF':
                                                $related_icon = '📕';
                                                break;
                                            case 'DOC':
                                            case 'DOCX':
                                                $related_icon = '📘';
                                                break;
                                            case 'XLS':
                                            case 'XLSX':
                                                $related_icon = '📊';
                                                break;
                                        }
                                    }
                                    ?>
                                    <div class="related-resource-card">
                                        <div class="related-icon"><?php echo $related_icon; ?></div>
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="related-meta">
                                            <?php if (!empty($related_file_type)): ?>
                                                <span><?php echo esc_html($related_file_type); ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($related_file_size)): ?>
                                                <span><?php echo esc_html($related_file_size); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                
                <!-- Back to Resources -->
                <div class="back-to-resources">
                    <a href="<?php echo get_post_type_archive_link('lis_resource'); ?>" class="back-btn">
                        ← Back to All Resources
                    </a>
                </div>
                
            </article>
            
            <?php
        }
        ?>
        
    </div>
</div>

<style>
/* Single Resource Styles */
.lumina-single-resource {
    padding: 40px 20px;
    background: #f7f7f7;
    min-height: 70vh;
}

.lumina-single-resource .container {
    max-width: 900px;
    margin: 0 auto;
}

.single-resource-content {
    background: #FFFFFF;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
}

/* Resource Header */
.resource-header {
    display: flex;
    gap: 25px;
    align-items: flex-start;
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 3px solid #7EBEC5;
}

.resource-header-icon {
    font-size: 80px;
    flex-shrink: 0;
}

.resource-header-content {
    flex: 1;
}

.resource-title {
    color: #003d70;
    font-size: 32px;
    margin: 0 0 15px 0;
    line-height: 1.3;
}

.resource-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.resource-category-badge {
    background: #7EBEC5;
    color: #FFFFFF;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.resource-category-badge:hover {
    background: #003d70;
}

/* Resource Meta Box */
.resource-meta-box {
    background: #f7f7f7;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
}

.meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
}

.meta-item {
    display: flex;
    gap: 15px;
    align-items: center;
}

.meta-icon {
    font-size: 32px;
    flex-shrink: 0;
}

.meta-content {
    flex: 1;
}

.meta-label {
    font-size: 12px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}

.meta-value {
    font-size: 16px;
    color: #003d70;
    font-weight: 600;
}

/* Resource Description */
.resource-description {
    margin-bottom: 30px;
}

.resource-description h2 {
    color: #003d70;
    font-size: 24px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f7f7f7;
}

.resource-content {
    color: #666;
    line-height: 1.8;
    font-size: 16px;
}

.resource-content p {
    margin-bottom: 15px;
}

.resource-content ul,
.resource-content ol {
    margin: 15px 0;
    padding-left: 30px;
}

.resource-content li {
    margin-bottom: 10px;
}

/* Download Section */
.resource-download-section {
    background: linear-gradient(135deg, #7EBEC5 0%, #003d70 100%);
    border-radius: 12px;
    padding: 40px;
    text-align: center;
    margin-bottom: 30px;
    color: #FFFFFF;
}

.download-ready h3,
.download-restricted h3 {
    color: #FFFFFF;
    font-size: 24px;
    margin: 0 0 15px 0;
}

.download-ready p,
.download-restricted p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 16px;
    margin-bottom: 25px;
}

.download-btn,
.login-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 40px;
    background: #F39A3B;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 700;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.download-btn:hover,
.login-btn:hover {
    background: #FFFFFF;
    color: #003d70;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.restricted-icon {
    font-size: 60px;
    margin-bottom: 20px;
}

/* Related Resources */
.related-resources {
    margin-bottom: 30px;
}

.related-resources h2 {
    color: #003d70;
    font-size: 24px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f7f7f7;
}

.related-resources-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.related-resource-card {
    background: #f7f7f7;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
}

.related-resource-card:hover {
    background: #7EBEC5;
    transform: translateY(-3px);
}

.related-icon {
    font-size: 40px;
    margin-bottom: 10px;
}

.related-resource-card h4 {
    margin: 0 0 10px 0;
    font-size: 16px;
}

.related-resource-card h4 a {
    color: #003d70;
    text-decoration: none;
}

.related-resource-card:hover h4 a {
    color: #FFFFFF;
}

.related-meta {
    display: flex;
    justify-content: center;
    gap: 10px;
    font-size: 12px;
    color: #666;
}

.related-resource-card:hover .related-meta {
    color: rgba(255, 255, 255, 0.9);
}

/* Back to Resources */
.back-to-resources {
    text-align: center;
    padding-top: 30px;
    border-top: 2px solid #f7f7f7;
}

.back-btn {
    display: inline-block;
    padding: 12px 30px;
    background: #003d70;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: #7EBEC5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .single-resource-content {
        padding: 30px 20px;
    }
    
    .resource-header {
        flex-direction: column;
        text-align: center;
    }
    
    .resource-header-icon {
        font-size: 60px;
    }
    
    .resource-title {
        font-size: 24px;
    }
    
    .meta-grid {
        grid-template-columns: 1fr;
    }
    
    .resource-download-section {
        padding: 30px 20px;
    }
    
    .related-resources-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
