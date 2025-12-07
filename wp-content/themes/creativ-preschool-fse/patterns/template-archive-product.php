<?php
/**
 * Title: Template Archive Product
 * Slug: creativ-preschool-fse/template-archive-product
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

<!-- wp:woocommerce/breadcrumbs {"align":"","className":"bt-woo-breadcrumb bt-woo-breadcrumb-center","textColor":"accent-text","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-text"}}}}} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"18%"} -->
<div class="wp-block-column" style="flex-basis:18%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div></div>
<!-- /wp:cover -->

<!-- wp:group {"tagName":"main","style":{"spacing":{"blockGap":"var:preset|spacing|x-large","padding":{"bottom":"var:preset|spacing|x-large","top":"var:preset|spacing|x-large"}}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group" style="padding-top:var(--wp--preset--spacing--x-large);padding-bottom:var(--wp--preset--spacing--x-large)"><!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|70","right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"constrained","contentSize":"1180px"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--30)"><!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|large"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"70%"} -->
<div class="wp-block-column" style="flex-basis:70%"><!-- wp:woocommerce/store-notices /-->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:woocommerce/product-results-count /-->

<!-- wp:woocommerce/catalog-sorting /--></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":6,"query":{"perPage":10,"pages":0,"offset":0,"postType":"product","order":"asc","orderBy":"title","author":"","search":"","exclude":[],"sticky":"","inherit":true,"__woocommerceAttributes":[],"__woocommerceStockStatus":["instock","outofstock","onbackorder"]},"namespace":"woocommerce/product-query"} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"className":"products-block-post-template","layout":{"type":"grid","columnCount":2}} -->
<!-- wp:woocommerce/product-image {"imageSizing":"thumbnail","isDescendentOfQueryLoop":true} /-->

<!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"style":{"spacing":{"margin":{"bottom":"0.75rem","top":"15px"}}},"fontSize":"medium"} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"center"} /-->

<!-- wp:woocommerce/product-button {"textAlign":"center","isDescendentOfQueryLoop":true,"style":{"spacing":{"margin":{"top":"var:preset|spacing|small"}}}} /-->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"30%"} -->
<div class="wp-block-column" style="flex-basis:30%"><!-- wp:template-part {"slug":"sidebar-shop","theme":"creativ-preschool-fse"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->