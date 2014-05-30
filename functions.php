<?php
/**
 * Theme Functions
 *
 * This file is used by WordPress to initialize the theme.
 * Clean Yeti is designed to be used as is and this file should not be modified.
 * You should use a Child Theme to make your customizations.
 *
 * Reference:  {@link http://codex.wordpress.org/Child_Themes Codex: Child Themes}
 *
 * @package cleanyeti
 * @subpackage ThemeInit
 */


/**
 * Registers action hook: cleanyeti_init
 *
 * @since cleanyeti 1.0
 */
function cleanyeti_init() {
	do_action('cleanyeti_init');
}


/**
 * cleanyeti_theme_setup
 *
 * @todo review for impact of deprecations on child themes & fix comment blocks?
 * @since cleanyeti 1.0
 */
function cleanyeti_theme_setup() {
	global $content_width;

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 *
	 * Used to set the width of images and content. Should be equal to the width the theme
	 * is designed for, generally via the style.css stylesheet.
	 *
	 * @since cleanyeti 1.0
	 */
	if ( !isset($content_width) )
		$content_width = 1170;

	// Check for MultiSite
	define( 'CLEANYETI_MB', is_multisite()  );

	// Create the feedlinks
	if ( ! current_theme_supports( 'cleanyeti_legacy_feedlinks' ) )
		add_theme_support( 'automatic-feed-links' );

	if ( apply_filters( 'cleanyeti_post_thumbs', true ) )
		add_theme_support( 'post-thumbnails' );

	add_theme_support( 'post-formats', array( 'aside', 'quote', 'video', 'image', 'gallery' ) );

	// Path constants
	define( 'CLEANYETI_LIB',  get_template_directory() .  '/library' );

	// Load widgets
	require_once ( CLEANYETI_LIB . '/extensions/widgets.php' );

	// Load custom header extensions
	require_once ( CLEANYETI_LIB . '/extensions/header-extensions.php' );

	// Load Shortcodes
	require_once ( CLEANYETI_LIB . '/extensions/shortcodes.php' );

	// Load custom content filters
	require_once ( CLEANYETI_LIB . '/extensions/content-extensions.php' );

	// Load custom Comments filters
	require_once ( CLEANYETI_LIB . '/extensions/comments-extensions.php' );

	// Load custom discussion filters
	require_once ( CLEANYETI_LIB . '/extensions/discussion-extensions.php' );

	// Load custom Widgets
	require_once ( CLEANYETI_LIB . '/extensions/widgets-extensions.php' );

	// Load the Comments Template functions and callbacks
	require_once ( CLEANYETI_LIB . '/extensions/discussion.php' );

	// Load custom sidebar hooks
	require_once ( CLEANYETI_LIB . '/extensions/sidebar-extensions.php' );

	// Load custom footer hooks
	require_once ( CLEANYETI_LIB . '/extensions/footer-extensions.php' );

	// Add Dynamic Contextual Semantic Classes
	require_once ( CLEANYETI_LIB . '/extensions/dynamic-classes.php' );

	// Need a little help from our helper functions
	require_once ( CLEANYETI_LIB . '/extensions/helpers.php' );

	// breadcrumbs
	require_once ( CLEANYETI_LIB . '/extensions/breadcrumbs.php' );

	// attachment extensions helps with displaying videos and images
	require_once ( CLEANYETI_LIB . '/extensions/attachment-extensions.php' );
	
    /**
     * Theme Options and Customizer API
     * Based on Oenology WordPress Theme, Copyright (C) 2010-2014 Chip Bennett
     * @link https://www.github.com/chipbennett/oenology
     */
	require_once ( CLEANYETI_LIB . '/options/options.php' );
	require_once ( CLEANYETI_LIB . '/options/options-customizer.php' );
    require_once ( CLEANYETI_LIB . '/options/options-filters.php' );

    /**
     * SCSS compiler written in PHP
     *
     * @copyright 2012-2013 Leaf Corcoran
     *
     * @license http://opensource.org/licenses/gpl-license GPL-3.0
     * @license http://opensource.org/licenses/MIT MIT
     *
     * @link http://leafo.net/scssphp
     */
	require_once ( CLEANYETI_LIB . '/Foundation/scss/scss.php' );
	require_once ( CLEANYETI_LIB . '/Foundation/scss/scss.inc.php' );

	// Adds filters for the description/meta content in archive templates
	add_filter( 'archive_meta', 'wptexturize' );
	add_filter( 'archive_meta', 'convert_smilies' );
	add_filter( 'archive_meta', 'convert_chars' );
	add_filter( 'archive_meta', 'wpautop' );

	// Translate, if applicable
	load_theme_textdomain( 'cleanyeti', CLEANYETI_LIB . '/languages' );

	$locale = get_locale();
	$locale_file = CLEANYETI_LIB . "/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once ($locale_file);

	// Register Menu Locations
	register_nav_menu( apply_filters('cleanyeti_primary_menu_id', 'primary-menu'), apply_filters('cleanyeti_primary_menu_name', __( 'Primary Menu', 'cleanyeti' ) ) );
	register_nav_menu( 'cleanyeti_footer_menu', __( 'Footer Menu', 'cleanyeti' ));

}

add_action('after_setup_theme', 'cleanyeti_theme_setup', 10);
?>