<?php
/**
 * PartsStop — Theme Functions
 *
 * @package PartsStop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * -------------------------------------------------------
 * CONSTANTS
 * For easy referencing of paths and version
 * throughout the theme without repeating strings.
 * -------------------------------------------------------
 */
define( 'PARTSSTOP_VERSION', '1.0.0' );
define( 'PARTSSTOP_DIR', get_template_directory() );
define( 'PARTSSTOP_URI', get_template_directory_uri() );

/*
 * -------------------------------------------------------
 * INCLUDES
 * Recommended-plugin notice (WooCommerce, Contact Form 7)
 * via TGM Plugin Activation. Loaded after the constants
 * above because inc/tgmpa.php uses PARTSSTOP_DIR.
 * -------------------------------------------------------
 */
require_once PARTSSTOP_DIR . '/inc/tgmpa.php';


/**
 * Registers all WordPress feature support and menus.
 */
function partsstop_setup() {

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support(
		'custom-logo',
		array(
			'width'       => 200,
			'height'      => 60,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support( 'responsive-embeds' );

	add_theme_support( 'align-wide' );

	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	/*
	 * Register navigation menu locations.
	 */
	register_nav_menus(
		array(
			'primary-menu'       => esc_html__( 'Primary Navigation', 'partsstop' ),
			'footer-quick-links' => esc_html__( 'Footer Quick Links', 'partsstop' ),
			'footer-categories'  => esc_html__( 'Footer Categories', 'partsstop' ),
		)
	);

	/*
	 * Make theme content translatable.
	 */
	load_theme_textdomain(
		'partsstop',
		PARTSSTOP_DIR . '/languages'
	);
}
add_action( 'after_setup_theme', 'partsstop_setup' );


/**
 * Declares WooCommerce theme compatibility.
 */
function partsstop_woocommerce_setup() {

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	/*
	 * Declare WooCommerce support with image dimensions
	 * matching our registered image sizes above.
	 */
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 300,
			'single_image_width'    => 600,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);

	/* Enable product gallery features */
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'partsstop_woocommerce_setup', 11 );


/**
 * Loads stylesheets and scripts on the frontend.
 */
function partsstop_enqueue_assets() {

	wp_enqueue_style(
		'partsstop-style',
		get_stylesheet_uri(),
		array(),
		PARTSSTOP_VERSION
	);

	wp_enqueue_style(
		'partsstop-theme',
		PARTSSTOP_URI . '/assets/css/theme.css',
		array( 'partsstop-style' ),
		PARTSSTOP_VERSION
	);

	wp_enqueue_script(
		'partsstop-navigation',
		PARTSSTOP_URI . '/assets/js/navigation.js',
		array(),
		PARTSSTOP_VERSION,
		true
	);

	$script_data = array(
		'ajaxUrl'           => admin_url( 'admin-ajax.php' ),
		'nonce'             => wp_create_nonce( 'partsstop_nonce' ),
		'homeUrl'           => home_url( '/' ),
		'searchPlaceholder' => __( 'Search by part number or model...', 'partsstop' ),
		'searchAriaLabel'   => __( 'Search', 'partsstop' ),
		'searchButtonText'  => __( 'Search', 'partsstop' ),
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$script_data['cartUrl']   = esc_url( wc_get_cart_url() );
		$script_data['shopUrl']   = esc_url( wc_get_page_permalink( 'shop' ) );
		$script_data['cartCount'] = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	}

	wp_localize_script(
		'partsstop-navigation',
		'partsstopData',
		$script_data
	);
}
add_action( 'wp_enqueue_scripts', 'partsstop_enqueue_assets' );


/**
 * Adds the `defer` attribute to the navigation script's tag.
 *
 * Registered once at top level instead of inside the enqueue
 * callback, since it previously re-registered the same filter
 * on every `wp_enqueue_scripts` run.
 *
 * @param string $tag    The `<script>` tag for the enqueued script.
 * @param string $handle The script's registered handle.
 * @return string The filtered script tag.
 */
function partsstop_defer_navigation_script( $tag, $handle ) {
	if ( 'partsstop-navigation' === $handle ) {
		return str_replace( '<script ', '<script defer ', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'partsstop_defer_navigation_script', 10, 2 );


/**
 * Enables WooCommerce's persistent cart so items added by a
 * logged-in customer are restored on their next visit.
 */
function partsstop_enable_persistent_cart() {
	if ( class_exists( 'WooCommerce' ) ) {
		add_filter( 'woocommerce_persistent_cart_enabled', '__return_true' );
	}
}
add_action( 'wp_enqueue_scripts', 'partsstop_enable_persistent_cart' );


/**
 * Switches WooCommerce's classic breadcrumb delimiter from the
 * default slash to a chevron, so the shop archive / product search
 * breadcrumbs (rendered via woocommerce_breadcrumb()) match the
 * separator used by the single-product page's core wp:breadcrumbs
 * block. This is the native WooCommerce hook for this — do not
 * replace it with a CSS content-swap on the delimiter text, since
 * the delimiter is plain text baked into the template output, not a
 * CSS-generated character.
 *
 * @param array $defaults Default woocommerce_breadcrumb() args.
 * @return array Filtered args.
 */
function partsstop_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = '&nbsp;&gt;&nbsp;';
	return $defaults;
}
if ( class_exists( 'WooCommerce' ) ) {
	add_filter( 'woocommerce_breadcrumb_defaults', 'partsstop_breadcrumb_delimiter' );
}


/**
 * Registers the custom pattern category that all
 * PartsStop patterns are filed under.
 * Site owners see this in the pattern inserter.
 */
function partsstop_register_pattern_category() {
	register_block_pattern_category(
		'partsstop',
		array(
			'label'       => esc_html__( 'PartsStop', 'partsstop' ),
			'description' => esc_html__( 'Patterns for the PartsStop theme.', 'partsstop' ),
		)
	);
}
add_action( 'init', 'partsstop_register_pattern_category' );


/**
 * Updates the cart count fragment via WooCommerce's AJAX
 * add-to-cart fragments so the header cart icon refreshes
 * without a full page reload.
 *
 * @param array $fragments Existing WooCommerce AJAX fragments.
 * @return array Filtered fragments.
 */
function partsstop_cart_count_fragment( $fragments ) {

	if ( ! class_exists( 'WooCommerce' ) ) {
		return $fragments;
	}

	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

	$fragments['span.cart-count'] = '<span class="cart-count" aria-live="polite">'
		. esc_html( $count )
		. '</span>';

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'partsstop_cart_count_fragment' );



/**
 * Adds useful body classes for CSS targeting.
 *
 * @param array $classes Existing body classes.
 * @return array Filtered body classes.
 */
function partsstop_body_classes( $classes ) {

	/* Add class when WooCommerce is active */
	if ( class_exists( 'WooCommerce' ) ) {
		$classes[] = 'woocommerce-active';
	}

	return $classes;
}
add_filter( 'body_class', 'partsstop_body_classes' );


/*
 * -------------------------------------------------------
 * SHOP ARCHIVE TITLE
 * -------------------------------------------------------
 */

/**
 * Fix WooCommerce shop page archive title.
 * Removes "Archives:" prefix and returns
 * clean title for the shop page.
 *
 * @param string $title The archive title generated by WordPress.
 * @return string The filtered title.
 */
function partsstop_shop_title( $title ) {
	if ( class_exists( 'WooCommerce' ) && is_shop() ) {
		$title = get_the_title( wc_get_page_id( 'shop' ) );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'partsstop_shop_title' );


/*
 * -------------------------------------------------------
 * DISABLE WOOCOMMERCE DEFAULT WRAPPERS
 * -------------------------------------------------------
 */

/**
 * Remove WooCommerce default wrappers on shop page.
 * These conflict with FSE block template layout.
 */
function partsstop_disable_wc_wrappers() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}
add_action( 'init', 'partsstop_disable_wc_wrappers' );


/**
 * Enqueues shop.css only on shop, product, cart, checkout,
 * account, and search pages — the templates where
 * WooCommerce markup actually appears.
 */
function partsstop_enqueue_shop_styles() {
	if ( class_exists( 'WooCommerce' ) && (
		is_shop()
		|| is_product_taxonomy()
		|| is_product()
		|| is_cart()
		|| is_checkout()
		|| is_account_page()
		|| is_search()
	) ) {
		wp_enqueue_style(
			'partsstop-shop',
			PARTSSTOP_URI . '/assets/css/shop.css',
			array( 'partsstop-theme' ),
			PARTSSTOP_VERSION
		);
	}
}
add_action(
	'wp_enqueue_scripts',
	'partsstop_enqueue_shop_styles'
);


/**
 * Adds "New here? Create an account" under the login form
 * on the logged-out My Account page. assets/js/navigation.js
 * listens for clicks on this link (data-account-toggle) to
 * swap which form is visible. Paired with
 * partsstop_account_toggle_to_login() below, which adds
 * the reverse link under the register form.
 */
function partsstop_account_toggle_to_register() {
	if ( ! class_exists( 'WooCommerce' ) || 'yes' !== get_option( 'woocommerce_enable_myaccount_registration' ) ) {
		return;
	}
	?>
	<p class="partsstop-account-toggle">
		<?php esc_html_e( 'New here?', 'partsstop' ); ?>
		<a href="#" class="partsstop-account-toggle__link" data-account-toggle="register"><?php esc_html_e( 'Create an account', 'partsstop' ); ?></a>
	</p>
	<?php
}
add_action( 'woocommerce_login_form_end', 'partsstop_account_toggle_to_register' );

/**
 * Adds "Already have an account? Log in" under the register
 * form on the logged-out My Account page. Counterpart to
 * partsstop_account_toggle_to_register() above.
 */
function partsstop_account_toggle_to_login() {
	if ( ! class_exists( 'WooCommerce' ) || 'yes' !== get_option( 'woocommerce_enable_myaccount_registration' ) ) {
		return;
	}
	?>
	<p class="partsstop-account-toggle">
		<?php esc_html_e( 'Already have an account?', 'partsstop' ); ?>
		<a href="#" class="partsstop-account-toggle__link" data-account-toggle="login"><?php esc_html_e( 'Log in', 'partsstop' ); ?></a>
	</p>
	<?php
}
add_action( 'woocommerce_register_form_end', 'partsstop_account_toggle_to_login' );

/**
 * Registers the dynamic copyright text block binding used by
 * the footer template part, so the copyright year and site
 * name never need to be hardcoded.
 */
function partsstop_register_copyright_binding() {
	register_block_bindings_source(
		'partsstop/copyright',
		array(
			'label'              => __( 'Copyright Text', 'partsstop' ),
			'get_value_callback' => function () {
				return sprintf(
					/* translators: 1: Current year, 2: Site name. */
					esc_html__( '© %1$s %2$s. All rights reserved.', 'partsstop' ),
					date_i18n( 'Y' ),
					get_bloginfo( 'name' )
				);
			},
		)
	);
}
add_action( 'init', 'partsstop_register_copyright_binding' );
