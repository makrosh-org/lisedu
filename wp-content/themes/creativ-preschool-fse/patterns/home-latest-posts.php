<?php
/**
 * Title: Latest Posts
 * Slug: creativ-preschool-fse/home-latest-posts
 * Categories: theme
 *
 * @package creativ-preschool-fse
 * @since 1.0.0
 */

?>

<!-- wp:group {"metadata":{"categories":["theme"],"patternName":"creativ-preschool-fse/home-latest-posts","name":"Latest Posts"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|x-small","left":"var:preset|spacing|x-small","top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|x-large"},"blockGap":"var:preset|spacing|large","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--x-large);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--x-large);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"margin":{"bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group" style="margin-bottom:0"><!-- wp:heading {"level":6,"style":{"typography":{"textTransform":"uppercase","fontStyle":"normal","fontWeight":"400"},"color":{"text":"#fda00f"}},"fontSize":"x-small","fontFamily":"sniglet"} -->
<h6 class="wp-block-heading has-text-color has-sniglet-font-family has-x-small-font-size" style="color:#fda00f;font-style:normal;font-weight:400;text-transform:uppercase"><?php esc_html_e( 'Our Blog', 'creativ-preschool-fse' ); ?></h6>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"letterSpacing":"-1px","lineHeight":"1.1","fontStyle":"normal","fontWeight":"400"},"color":{"text":"#554e9f"},"elements":{"link":{"color":{"text":"#554e9f"}}}},"fontSize":"xxx-large","fontFamily":"sniglet"} -->
<h3 class="wp-block-heading has-text-align-center has-text-color has-link-color has-sniglet-font-family has-xxx-large-font-size" style="color:#554e9f;font-style:normal;font-weight:400;letter-spacing:-1px;line-height:1.1"><?php esc_html_e( 'Latest News & Articles', 'creativ-preschool-fse' ); ?></h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":18,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"metadata":{"categories":["posts","theme"],"patternName":"templaty-fse/query","name":"Query"},"layout":{"type":"constrained"}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"18rem"}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"left":"0","right":"0","top":"0","bottom":"0"},"blockGap":"0"},"border":{"radius":"15px","color":"#eeeeee","width":"1px"},"color":{"background":"#e86126"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group has-border-color has-background" style="border-color:#eeeeee;border-width:1px;border-radius:15px;background-color:#e86126;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"auto","sizeSlug":"full","style":{"border":{"radius":{"topLeft":"15px","topRight":"15px","bottomLeft":"0px","bottomRight":"0px"}}}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small","padding":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|small","right":"var:preset|spacing|small"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--small);padding-right:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--small)"><!-- wp:post-title {"level":5,"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"typography":{"lineHeight":"1.4","fontStyle":"normal","fontWeight":"400"},"spacing":{"margin":{"top":"var:preset|spacing|xx-small","bottom":"var:preset|spacing|xx-small"}}},"textColor":"base","fontFamily":"sniglet"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:post-author-name {"style":{"typography":{"fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"textColor":"base","fontSize":"x-small","fontFamily":"sniglet"} /-->

<!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"200"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"textColor":"base","fontSize":"x-small"} -->
<p class="has-base-color has-text-color has-link-color has-x-small-font-size" style="font-style:normal;font-weight:200">|</p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"style":{"typography":{"fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"textColor":"base","fontSize":"x-small","fontFamily":"sniglet"} /--></div>
<!-- /wp:group -->

<!-- wp:post-excerpt {"moreText":"Read More","excerptLength":15,"style":{"spacing":{"margin":{"top":"var:preset|spacing|x-small","bottom":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"textColor":"base","fontSize":"small","fontFamily":"sniglet"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"300"}}} -->
<p class="has-text-align-center" style="font-style:normal;font-weight:300"><?php esc_html_e( 'No results', 'creativ-preschool-fse' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->