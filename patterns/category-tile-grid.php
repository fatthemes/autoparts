<?php
/**
 * Title: Category Tile Grid
 * Slug: autoparts/category-tile-grid
 * Categories: autoparts
 * Description: A section heading with a link, followed by a grid of product categories.
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

<!-- wp:group {"className":"la-categories","backgroundColor":"surface","align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull la-categories has-surface-background-color has-background"><!-- wp:group {"className":"la-categories__header","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group la-categories__header"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php echo esc_html_x( 'Browse by Category', 'Sample heading for category grid pattern', 'autoparts' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"la-categories__link","textColor":"accent","fontSize":"small"} -->
<p class="la-categories__link has-accent-color has-text-color has-small-font-size"><a href="<?php echo esc_url( $autoparts_shop_url ); ?>"><?php echo esc_html_x( 'Explore Full Inventory', 'Sample link text for category grid pattern', 'autoparts' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php echo do_shortcode( '[product_categories number="3" columns="3" hide_empty="1" show_count="0"]' ); ?></div>
<!-- /wp:group -->