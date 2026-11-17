<?php
/**
 * Recommended plugins (TGM Plugin Activation).
 *
 * Shows a dismissible admin notice and an Appearance → Install Plugins
 * screen recommending the plugins this theme is designed around. Both
 * are optional: the theme works without them, they only unlock the shop
 * and contact-form features. Nothing is installed or activated
 * automatically — the site owner decides.
 *
 * The TGMPA library itself lives in inc/class-tgm-plugin-activation.php
 * (generated for WordPress.org distribution with the partsstop text
 * domain) and must not be edited — update it by regenerating it at
 * http://tgmpluginactivation.com/download/ instead.
 *
 * @package PartsStop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once PARTSSTOP_DIR . '/inc/class-tgm-plugin-activation.php';

/**
 * Registers the recommended plugins with TGMPA.
 *
 * Plugins are pulled from the WordPress.org plugin directory only (no
 * bundled zips or external URLs), and none are required or
 * force-activated, per the theme review requirements.
 */
function partsstop_register_recommended_plugins() {

	/*
	 * Plugin list. Only name, slug and required are set, so TGMPA
	 * installs the latest version straight from WordPress.org.
	 */
	$plugins = array(
		// Powers the shop, product, cart, checkout and account templates.
		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
		// Contact forms for the Contact / Dealer Application pages.
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false,
		),
	);

	/*
	 * TGMPA settings. The install screen sits under Appearance and is
	 * only available to users who can edit theme options. Notices can be
	 * dismissed, and plugins are never activated automatically.
	 */
	$config = array(
		'id'           => 'partsstop',
		'default_path' => '',
		'menu'         => 'partsstop-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',

		// User-facing strings, translatable with the theme's text domain.
		'strings'      => array(
			'page_title'                      => __( 'Install Recommended Plugins', 'partsstop' ),
			'menu_title'                      => __( 'Install Plugins', 'partsstop' ),
			/* translators: %s: Plugin name. */
			'installing'                      => __( 'Installing Plugin: %s', 'partsstop' ),
			/* translators: %s: Plugin name. */
			'updating'                        => __( 'Updating Plugin: %s', 'partsstop' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'partsstop' ),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: Plugin name(s). */
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'partsstop'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: Plugin name(s). */
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'partsstop'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: Plugin name(s). */
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'partsstop'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'partsstop'
			),
			'update_link'                     => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'partsstop'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'partsstop'
			),
			'return'                          => __( 'Return to Recommended Plugins Installer', 'partsstop' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'partsstop' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'partsstop' ),
			/* translators: 1: Plugin name. */
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'partsstop' ),
			/* translators: 1: Dashboard link. */
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'partsstop' ),
			'dismiss'                         => __( 'Dismiss this notice', 'partsstop' ),
			'notice_cannot_install_activate'  => __( 'There are one or more recommended plugins to install, update or activate.', 'partsstop' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'partsstop' ),
		),
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'partsstop_register_recommended_plugins' );
