<?php
/**
 * Title: Featured Products
 * Slug: autoparts/featured-products
 * Categories: autoparts
 * Description: A section heading with a link, followed by a grid of featured products.
 *
 * @package Lime_Autoparts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$autoparts_shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
?>

<!-- wp:group {"className":"la-featured","layout":{"type":"constrained"}} -->
<div class="wp-block-group la-featured"><!-- wp:group {"className":"la-featured__header","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group la-featured__header"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html_x( 'Fast Selling Components', 'Sample heading for featured products pattern', 'autoparts' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"la-featured__link","textColor":"accent","fontSize":"small"} -->
<p class="la-featured__link has-accent-color has-text-color has-small-font-size"><a href="<?php echo esc_url( $autoparts_shop_url ); ?>"><?php echo esc_html_x( 'View All Products', 'Sample link text for featured products pattern', 'autoparts' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-collection {"queryId":0,"query":{"perPage":4,"pages":1,"offset":0,"postType":"product","order":"asc","orderBy":"title","search":"","exclude":[],"inherit":false,"taxQuery":[],"isProductCollectionBlock":true,"featured":true,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"flex","columns":4,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/featured","hideControls":["inherit","featured","filterable"],"queryContextIncludes":["collection"]} -->
<div class="wp-block-woocommerce-product-collection"><!-- wp:woocommerce/product-template -->
<!-- wp:woocommerce/product-image {"showSaleBadge":false,"isDescendentOfQueryLoop":true,"style":{"dimensions":{"aspectRatio":"1/1"}}} /-->

<!-- wp:post-title {"textAlign":"center","isLink":true,"fontSize":"medium","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"center","fontSize":"small"} /-->

<!-- wp:woocommerce/product-button {"textAlign":"center","isDescendentOfQueryLoop":true,"fontSize":"small"} /-->
<!-- /wp:woocommerce/product-template --></div>
<!-- /wp:woocommerce/product-collection --></div>
<!-- /wp:group -->