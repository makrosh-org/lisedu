<?php
/**
 * Title: Template Blog Listing
 * Slug: creativ-preschool-fse/template-blog-listing
 * Categories: template
 * Inserter: false
 */
?>

<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/banner-img1.jpg' ) ); ?>","id":12,"dimRatio":70,"focalPoint":{"x":0.5,"y":0.1},"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull"><img class="wp-block-cover__image-background wp-image-12" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/banner-img1.jpg' ) ); ?>" style="object-position:50% 10%" data-object-fit="cover" data-object-position="50% 10%"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"className":"is-not-stacked-on-mobile"} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"width":"18%"} -->
<div class="wp-block-column" style="flex-basis:18%"></div>
<!-- /wp:column -->

<!-- wp:column {"width":"66.666%"} -->
<div class="wp-block-column" style="flex-basis:66.666%"><!-- wp:query-title {"type":"archive","textAlign":"center","showPrefix":false,"align":"wide"} /-->

<!-- wp:term-description {"textAlign":"center","align":"wide","textColor":"accent-text"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"18%"} -->
<div class="wp-block-column" style="flex-basis:18%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div></div>
<!-- /wp:cover -->

<!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|small","left":"var:preset|spacing|small","top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--small)"><!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|x-large"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"70%"} -->
<div class="wp-block-column" style="flex-basis:70%"><!-- wp:query {"queryId":42,"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"animated animated-fadeInUp"} -->
<div class="wp-block-query animated animated-fadeInUp"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"grid","columnCount":2}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small","padding":{"top":"0","bottom":"var:preset|spacing|medium","right":"0","left":"0"}},"border":{"radius":"30px"}},"className":"is-style-ct-box-shadow","layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-ct-box-shadow" style="border-radius:30px;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--medium);padding-left:0"><!-- wp:post-featured-image {"isLink":true,"width":"","height":"","style":{"border":{"radius":{"topLeft":"30px","topRight":"30px","bottomLeft":"0px","bottomRight":"0px"}},"layout":{"selfStretch":"fit","flexSize":null}}} /-->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"var:preset|spacing|medium","left":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-right:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small","margin":{"top":"var:preset|spacing|x-small"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--x-small)"><!-- wp:post-author {"textAlign":"left","avatarSize":24,"showAvatar":false,"style":{"color":{"text":"#656565"}},"fontSize":"x-small"} /-->

<!-- wp:paragraph {"fontSize":"x-small"} -->
<p class="has-x-small-font-size">·</p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"format":"M j, Y","style":{"color":{"text":"#656565"}},"fontSize":"x-small"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"textAlign":"left","level":5,"isLink":true,"style":{"spacing":{"margin":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}},"typography":{"letterSpacing":"-0.03em","lineHeight":"1.2"}}} /-->

<!-- wp:post-excerpt {"excerptLength":15,"fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"30%"} -->
<div class="wp-block-column" style="flex-basis:30%"><!-- wp:template-part {"slug":"sidebar","theme":"creativ-preschool-fse","area":"uncategorized"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->