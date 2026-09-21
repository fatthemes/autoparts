<?php
/**
 * Title: CTA Banner
 * Slug: autoparts/cta-banner
 * Categories: autoparts
 * Description: A call-to-action banner with a heading, supporting text and a button.
 *
 * @package Lime_Autoparts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!-- wp:group {"className":"la-cta","backgroundColor":"border","layout":{"type":"constrained"}} -->
<div class="wp-block-group la-cta has-border-background-color has-background"><!-- wp:columns {"verticalAlignment":"center","className":"la-cta__inner"} -->
<div class="wp-block-columns are-vertically-aligned-center la-cta__inner"><!-- wp:column {"verticalAlignment":"center","width":"70%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:70%"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php echo esc_html_x( 'Become a Dealer Partner', 'Sample heading for call to action pattern', 'autoparts' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small","fontFamily":"body"} -->
<p class="has-body-font-family has-small-font-size"><?php echo esc_html_x( 'Join our global network of authorized distributors. Access wholesale pricing, priority shipping, and dedicated technical support for your workshop.', 'Sample paragraph for call to action pattern', 'autoparts' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"30%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:30%"><!-- wp:buttons {"className":"la-cta__buttons"} -->
<div class="wp-block-buttons la-cta__buttons"><!-- wp:button {"className":"is-style-outline","fontSize":"small"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-small-font-size has-custom-font-size wp-element-button"><?php echo esc_html_x( 'Apply Now', 'Sample button label for call to action pattern', 'autoparts' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->