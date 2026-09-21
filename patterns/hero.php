<?php
/**
 * Title: Hero Section
 * Slug: autoparts/hero
 * Categories: autoparts
 * Description: A hero section with a headline, supporting text, two call-to-action buttons and an image.
 *
 * @package Lime_Autoparts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!-- wp:group {"className":"la-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group la-hero"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?php echo esc_html_x( 'PRECISION ENGINEERED PERFORMANCE PARTS', 'Sample heading for hero pattern', 'autoparts' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"text-secondary","fontSize":"large","fontFamily":"body"} -->
<p class="has-text-secondary-color has-text-color has-body-font-family has-large-font-size"><?php echo esc_html_x( 'Unrivaled reliability for high-performance automotive systems. Discover a global network of premium parts designed for the most demanding engineering standards.', 'Sample paragraph for hero pattern', 'autoparts' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"fontFamily":"body"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-body-font-family wp-element-button"><?php echo esc_html_x( 'Shop All Components', 'Sample button label for hero pattern', 'autoparts' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button"><?php echo esc_html_x( 'View Catalog', 'Sample button label for hero pattern', 'autoparts' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"la-hero__image"} -->
<figure class="wp-block-image size-full la-hero__image"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero.png" alt="<?php echo esc_attr_x( 'Automotive engine components', 'Alt text for hero pattern image', 'autoparts' ); ?>"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
