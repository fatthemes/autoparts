<?php
/**
 * Autoparts — Theme Functions
 *
 * @package Lime_Autoparts
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
define( 'AUTOPARTS_VERSION', '1.0.0' );
define( 'AUTOPARTS_DIR', get_template_directory() );
define( 'AUTOPARTS_URI', get_template_directory_uri() );


/**
 * Registers all WordPress feature support and menus.
 */
function autoparts_setup() {

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
			'primary-menu'       => esc_html__( 'Primary Navigation', 'autoparts' ),
			'footer-quick-links' => esc_html__( 'Footer Quick Links', 'autoparts' ),
			'footer-categories'  => esc_html__( 'Footer Categories', 'autoparts' ),
		)
	);

	/*
	 * Make theme content translatable.
	 */
	load_theme_textdomain(
		'autoparts',
		AUTOPARTS_DIR . '/languages'
	);
}
add_action( 'after_setup_theme', 'autoparts_setup' );


/**
 * Declares WooCommerce theme compatibility.
 */
function autoparts_woocommerce_setup() {

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
add_action( 'after_setup_theme', 'autoparts_woocommerce_setup', 11 );


/**
 * Loads stylesheets and scripts on the frontend.
 */
function autoparts_enqueue_assets() {

	wp_enqueue_style(
		'autoparts-style',
		get_stylesheet_uri(),
		array(),
		AUTOPARTS_VERSION
	);

	wp_enqueue_style(
		'autoparts-theme',
		AUTOPARTS_URI . '/assets/css/theme.css',
		array( 'autoparts-style' ),
		AUTOPARTS_VERSION
	);

	wp_enqueue_script(
		'autoparts-navigation',
		AUTOPARTS_URI . '/assets/js/navigation.js',
		array(),
		AUTOPARTS_VERSION,
		true
	);

	$script_data = array(
		'ajaxUrl'           => admin_url( 'admin-ajax.php' ),
		'nonce'             => wp_create_nonce( 'autoparts_nonce' ),
		'homeUrl'           => home_url( '/' ),
		'searchPlaceholder' => __( 'Search by part number or model...', 'autoparts' ),
		'searchAriaLabel'   => __( 'Search', 'autoparts' ),
		'searchButtonText'  => __( 'Search', 'autoparts' ),
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$script_data['cartUrl']   = esc_url( wc_get_cart_url() );
		$script_data['shopUrl']   = esc_url( wc_get_page_permalink( 'shop' ) );
		$script_data['cartCount'] = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	}

	wp_localize_script(
		'autoparts-navigation',
		'autopartsData',
		$script_data
	);
}
add_action( 'wp_enqueue_scripts', 'autoparts_enqueue_assets' );


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
function autoparts_defer_navigation_script( $tag, $handle ) {
	if ( 'autoparts-navigation' === $handle ) {
		return str_replace( '<script ', '<script defer ', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'autoparts_defer_navigation_script', 10, 2 );


/**
 * Enables WooCommerce's persistent cart so items added by a
 * logged-in customer are restored on their next visit.
 */
function autoparts_enable_persistent_cart() {
	if ( class_exists( 'WooCommerce' ) ) {
		add_filter( 'woocommerce_persistent_cart_enabled', '__return_true' );
	}
}
add_action( 'wp_enqueue_scripts', 'autoparts_enable_persistent_cart' );


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
function autoparts_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = '&nbsp;&gt;&nbsp;';
	return $defaults;
}
if ( class_exists( 'WooCommerce' ) ) {
	add_filter( 'woocommerce_breadcrumb_defaults', 'autoparts_breadcrumb_delimiter' );
}


/**
 * Registers the custom pattern category that all
 * Autoparts patterns are filed under.
 * Site owners see this in the pattern inserter.
 */
function autoparts_register_pattern_category() {
	register_block_pattern_category(
		'autoparts',
		array(
			'label'       => esc_html__( 'Autoparts', 'autoparts' ),
			'description' => esc_html__( 'Patterns for the Autoparts theme.', 'autoparts' ),
		)
	);
}
add_action( 'init', 'autoparts_register_pattern_category' );


/**
 * Updates the cart count fragment via WooCommerce's AJAX
 * add-to-cart fragments so the header cart icon refreshes
 * without a full page reload.
 *
 * @param array $fragments Existing WooCommerce AJAX fragments.
 * @return array Filtered fragments.
 */
function autoparts_cart_count_fragment( $fragments ) {

	if ( ! class_exists( 'WooCommerce' ) ) {
		return $fragments;
	}

	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

	$fragments['span.cart-count'] = '<span class="cart-count" aria-live="polite">'
		. esc_html( $count )
		. '</span>';

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'autoparts_cart_count_fragment' );



/**
 * Adds useful body classes for CSS targeting.
 *
 * @param array $classes Existing body classes.
 * @return array Filtered body classes.
 */
function autoparts_body_classes( $classes ) {

	/* Add class when WooCommerce is active */
	if ( class_exists( 'WooCommerce' ) ) {
		$classes[] = 'woocommerce-active';
	}

	return $classes;
}
add_filter( 'body_class', 'autoparts_body_classes' );


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
function autoparts_shop_title( $title ) {
	if ( class_exists( 'WooCommerce' ) && is_shop() ) {
		$title = get_the_title( wc_get_page_id( 'shop' ) );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'autoparts_shop_title' );


/*
 * -------------------------------------------------------
 * DISABLE WOOCOMMERCE DEFAULT WRAPPERS
 * -------------------------------------------------------
 */

/**
 * Remove WooCommerce default wrappers on shop page.
 * These conflict with FSE block template layout.
 */
function autoparts_disable_wc_wrappers() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}
add_action( 'init', 'autoparts_disable_wc_wrappers' );


/**
 * Enqueues shop.css only on shop, product, cart, checkout,
 * account, and search pages — the templates where
 * WooCommerce markup actually appears.
 */
function autoparts_enqueue_shop_styles() {
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
			'autoparts-shop',
			AUTOPARTS_URI . '/assets/css/shop.css',
			array( 'autoparts-theme' ),
			AUTOPARTS_VERSION
		);
	}
}
add_action(
	'wp_enqueue_scripts',
	'autoparts_enqueue_shop_styles'
);


/**
 * Adds "New here? Create an account" under the login form
 * on the logged-out My Account page. assets/js/navigation.js
 * listens for clicks on this link (data-account-toggle) to
 * swap which form is visible. Paired with
 * autoparts_account_toggle_to_login() below, which adds
 * the reverse link under the register form.
 */
function autoparts_account_toggle_to_register() {
	if ( ! class_exists( 'WooCommerce' ) || 'yes' !== get_option( 'woocommerce_enable_myaccount_registration' ) ) {
		return;
	}
	?>
	<p class="lime-account-toggle">
		<?php esc_html_e( 'New here?', 'autoparts' ); ?>
		<a href="#" class="lime-account-toggle__link" data-account-toggle="register"><?php esc_html_e( 'Create an account', 'autoparts' ); ?></a>
	</p>
	<?php
}
add_action( 'woocommerce_login_form_end', 'autoparts_account_toggle_to_register' );

/**
 * Adds "Already have an account? Log in" under the register
 * form on the logged-out My Account page. Counterpart to
 * autoparts_account_toggle_to_register() above.
 */
function autoparts_account_toggle_to_login() {
	if ( ! class_exists( 'WooCommerce' ) || 'yes' !== get_option( 'woocommerce_enable_myaccount_registration' ) ) {
		return;
	}
	?>
	<p class="lime-account-toggle">
		<?php esc_html_e( 'Already have an account?', 'autoparts' ); ?>
		<a href="#" class="lime-account-toggle__link" data-account-toggle="login"><?php esc_html_e( 'Log in', 'autoparts' ); ?></a>
	</p>
	<?php
}
add_action( 'woocommerce_register_form_end', 'autoparts_account_toggle_to_login' );

/**
 * Registers the dynamic copyright text block binding used by
 * the footer template part, so the copyright year and site
 * name never need to be hardcoded.
 */
function autoparts_register_copyright_binding() {
	register_block_bindings_source(
		'autoparts/copyright',
		array(
			'label'              => __( 'Copyright Text', 'autoparts' ),
			'get_value_callback' => function () {
				return sprintf(
					/* translators: 1: Current year, 2: Site name. */
					esc_html__( '© %1$s %2$s. All rights reserved.', 'autoparts' ),
					date_i18n( 'Y' ),
					get_bloginfo( 'name' )
				);
			},
		)
	);
}
add_action( 'init', 'autoparts_register_copyright_binding' );