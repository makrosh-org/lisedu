<?php
/**
 * Title: Template Single Product
 * Slug: creativ-preschool-fse/template-single-product
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
<div class="wp-block-column" style="flex-basis:66.666%"></div>
<!-- /wp:column -->

<!-- wp:column {"width":"18%"} -->
<div class="wp-block-column" style="flex-basis:18%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div></div>
<!-- /wp:cover -->
<!-- wp:group {"tagName":"main","style":{"spacing":{"blockGap":"var:preset|spacing|x-large","padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|x-large"}}},"layout":{"inherit":true,"type":"constrained"}} -->
<main class="wp-block-group" style="padding-top:var(--wp--preset--spacing--x-large);padding-bottom:var(--wp--preset--spacing--x-large)"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:woocommerce/breadcrumbs /-->

<!-- wp:woocommerce/store-notices /-->

<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|large"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"512px"} -->
<div class="wp-block-column" style="flex-basis:512px"><!-- wp:woocommerce/product-image-gallery /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:post-title {"level":1,"__woocommerceNamespace":"woocommerce/product-query/product-title"} /-->

<!-- wp:woocommerce/product-rating {"isDescendentOfSingleProductTemplate":true} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfSingleProductTemplate":true} /-->

<!-- wp:post-excerpt {"__woocommerceNamespace":"woocommerce/product-query/product-summary"} /-->

<!-- wp:woocommerce/add-to-cart-form /-->

<!-- wp:woocommerce/product-meta -->
<div class="wp-block-woocommerce-product-meta"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:woocommerce/product-sku {"isDescendentOfSingleProductTemplate":true} /-->

<!-- wp:post-terms {"term":"product_cat","prefix":"Category: "} /-->

<!-- wp:post-terms {"term":"product_tag","prefix":"Tags: "} /--></div>
<!-- /wp:group --></div>
<!-- /wp:woocommerce/product-meta --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:woocommerce/product-details {"align":"wide"} /-->

<!-- wp:woocommerce/related-products {"align":"wide"} -->
<div class="wp-block-woocommerce-related-products alignwide"><!-- wp:query {"queryId":4,"query":{"perPage":3,"pages":0,"offset":0,"postType":"product","order":"asc","orderBy":"title","author":"","search":"","exclude":[],"sticky":"","inherit":false},"namespace":"woocommerce/related-products","lock":{"remove":true,"move":true}} -->
<div class="wp-block-query"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Related products', 'creativ-preschool-fse' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:post-template {"layout":{"type":"grid","columnCount":3},"__woocommerceNamespace":"woocommerce/product-query/product-template"} -->
<!-- wp:woocommerce/product-image {"imageSizing":"cropped","isDescendentOfQueryLoop":true} /-->

<!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"fontSize":"medium","__woocommerceNamespace":"woocommerce/product-query/product-title"} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"center","style":{"spacing":{"margin":{"bottom":"1rem"}}}} /-->

<!-- wp:woocommerce/product-button {"textAlign":"center","isDescendentOfQueryLoop":true,"fontSize":"small","style":{"spacing":{"margin":{"bottom":"1rem"}}}} /-->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:woocommerce/related-products --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->