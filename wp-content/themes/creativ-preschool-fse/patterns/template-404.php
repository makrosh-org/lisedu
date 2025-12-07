<?php
 /**
  * Title: Template 404
  * Slug: creativ-preschool-fse/template-404
  * Categories: template
  * Inserter: false
  */
?>

<!-- wp:group {"tagName":"main","style":{"spacing":{"padding":{"bottom":"0"},"blockGap":"var:preset|spacing|x-large"}},"UAGDay":[]} -->
<main class="wp-block-group" style="padding-bottom:0">
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/banner-img1.jpg' ) ); ?>","id":12,"dimRatio":70,"focalPoint":{"x":0.5,"y":0.1},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull" style="padding-top:var(--wp--preset--spacing--xx-large);padding-bottom:var(--wp--preset--spacing--xx-large)"><img class="wp-block-cover__image-background wp-image-12" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/banner-img1.jpg' ) ); ?>" style="object-position:50% 10%" data-object-fit="cover" data-object-position="50% 10%"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:query-title {"type":"archive","textAlign":"center"} /-->

<!-- wp:heading {"className":"has-text-align-center","style":{"typography":{"fontSize":"clamp(4rem, 30vw, 15rem)","fontWeight":"400","lineHeight":"1","fontStyle":"normal"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-size:clamp(4rem, 30vw, 15rem);font-style:normal;font-weight:400;line-height:1">
404</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><?php esc_html_e( 'This page could not be found. Maybe try a search?', 'creativ-preschool-fse' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"Search","showLabel":false,"width":75,"widthUnit":"%","buttonText":"Search","buttonUseIcon":true,"align":"center"} /-->

<!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div></div>
<!-- /wp:cover -->
</main>
<!-- /wp:group -->