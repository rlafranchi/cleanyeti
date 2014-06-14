<?php
/**
 * Clean Yeti Theme Options
 *
 * This file defines the Options for the Clean Yeti Theme.
 * 
 * Theme Options Functions
 * 
 *  - Define Default Theme Options
 *  - Register/Initialize Theme Options
 *  - Define Admin Settings Page
 *  - Register Contextual Help
 * 
 * @package 	Clean Yeti
 * @copyright	Copyright (c) 2014, Serene Themes
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Clean Yeti 2.3.0
 */

/**
 * Globalize the variable that holds the Theme Options
 * 
 * @global	array	$cleanyeti_options	holds Theme options
 */
global $cleanyeti_options;

/**
 * Clean Yeti Theme Settings API Implementation
 *
 * Implement the WordPress Settings API for the 
 * Clean Yeti Theme Settings.
 * 
 * @link	http://codex.wordpress.org/Settings_API	Codex Reference: Settings API
 * @link	http://ottopress.com/2009/wordpress-settings-api-tutorial/	Otto
 * @link	http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/	Ozh
 */
function cleanyeti_register_options(){
	require( get_template_directory() . '/library/options/options-register.php' );
}
// Settings API options initilization and validation
add_action( 'admin_init', 'cleanyeti_register_options' );

function cleanyeti_get_settings_page_cap() {
	return 'edit_theme_options';
}
// Hook into option_page_capability_{option_page}
add_action( 'option_page_capability_cleanyeti-settings', 'cleanyeti_get_settings_page_cap' );

/**
 * Get current settings page tab
 */
function cleanyeti_get_current_tab() {

	$page = 'cleanyeti-settings';
	if ( isset( $_GET['page'] ) && 'cleanyeti-reference' == $_GET['page'] ) {
		$page = 'cleanyeti-reference';
	}
    if ( isset( $_GET['tab'] ) ) {
        $current = $_GET['tab'];
    } else {
		$cleanyeti_options = cleanyeti_get_options();
		$current = 'general';
    }	
	return apply_filters( 'cleanyeti_get_current_tab', $current );
}

/**
 * Define Clean Yeti Admin Page Tab Markup
 * 
 * @uses	cleanyeti_get_current_tab()	defined in \functions\options.php
 * @uses	cleanyeti_get_settings_page_tabs()	defined in \functions\options.php
 * 
 * @link	http://www.onedesigns.com/tutorials/separate-multiple-theme-options-pages-using-tabs	Daniel Tara
 */
function cleanyeti_get_page_tab_markup() {

	$page = 'cleanyeti-settings';

    $current = cleanyeti_get_current_tab();
	
	$tabs = cleanyeti_get_settings_page_tabs();
    
    $links = array();
    
    foreach( $tabs as $tab ) {
		$tabname = $tab['name'];
		$tabtitle = $tab['title'];
        if ( $tabname == $current ) {
            $links[] = "<a class='nav-tab nav-tab-active' href='?page=$page&tab=$tabname'>$tabtitle</a>";
        } else {
            $links[] = "<a class='nav-tab' href='?page=$page&tab=$tabname'>$tabtitle</a>";
        }
    }
    
    echo '<div id="icon-themes" class="icon32"><br /></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach ( $links as $link )
        echo $link;
    echo '</h2>';
    
}

/**
 * Setup the Theme Admin Settings Page
 * 
 * Add "Clean Yeti Options" link to the "Appearance" menu
 * 
 * @uses	cleanyeti_get_settings_page_cap()	defined in \functions\wordpress-hooks.php
 */
function cleanyeti_add_theme_page() {
	// Globalize Theme options page
	global $cleanyeti_settings_page;
	// Add Theme options page
	$cleanyeti_settings_page = add_theme_page(
		// $page_title
		// Name displayed in HTML title tag
		__( 'Clean Yeti Options', 'cleanyeti' ), 
		// $menu_title
		// Name displayed in the Admin Menu
		__( 'Clean Yeti Options', 'cleanyeti' ), 
		// $capability
		// User capability required to access page
		'edit_theme_options', 
		// $menu_slug
		// String to append to URL after "themes.php"
		'cleanyeti-settings', 
		// $callback
		// Function to define settings page markup
		'cleanyeti_admin_options_page'
	);
	// load color picker script
	add_action( 'admin_enqueue_scripts', 'cleanyeti_enqueue_settings_scripts');
}
// Load the Admin Options page
add_action( 'admin_menu', 'cleanyeti_add_theme_page' );

/**
 *
 * Enqueues Color Picker Style and script
 *
 */

function cleanyeti_enqueue_settings_scripts($hook_suffix) {
    global $cleanyeti_settings_page;
    $current = cleanyeti_get_current_tab();
    if ( isset( $_GET['page'] ) && 'cleanyeti-settings' == $_GET['page'] ) {
        if ( 'orbit' == $current ) {
            wp_enqueue_script( 'cleanyeti-orbit-options', get_template_directory_uri() . '/library/scripts/orbit-options.js', array( 'jquery' ) );
            wp_enqueue_script( 'cleanyeti-upload', get_template_directory_uri() .'/library/scripts/upload.js', array('jquery') );
        }
        if ( 'general' == $current )
            wp_enqueue_script( 'cleanyeti-logo-upload', get_template_directory_uri() . '/library/scripts/upload-logo.js', array( 'jquery' ) );
        if ( 'orbit' == $current || 'general' == $current ) {
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
            wp_enqueue_script('media-upload');
        }
        if ( 'colors' == $current ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'cleanyeti-color-picker', get_template_directory_uri() . '/library/Foundation/js/color-picker.js', array( 'wp-color-picker' ), false, true );
        }
    }
}

function cleanyeti_options_thickbox() {
    global $pagenow;
 
    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
        // Now we'll replace the 'Insert into Post Button' inside Thickbox
        add_filter( 'gettext', 'cleanyeti_replace_thickbox_text'  , 1, 3 );
    }
}
//add_action( 'admin_init', 'cleanyeti_options_thickbox' );
 
function cleanyeti_replace_thickbox_text($translated_text, $text, $domain) {
    if ('Insert into Post' == $text) {
        $referer = strpos( wp_get_referer(), 'cleanyeti-settings' );
        if ( $referer != '' ) {
            return __('I want this to be my Image!', 'cleanyeti' );
        }
    }
    return $translated_text;
}

/**
 * Clean Yeti Theme Settings Page Markup
 * 
 * @uses	cleanyeti_get_current_tab()	defined in \functions\custom.php
 * @uses	cleanyeti_get_page_tab_markup()	defined in \functions\custom.php
 */
function cleanyeti_admin_options_page() { 
	// Determine the current page tab
	$currenttab = cleanyeti_get_current_tab();
	// Define the page section accordingly
	$settings_section = 'cleanyeti_' . $currenttab . '_tab';
	?>

	<div class="wrap">
		<?php cleanyeti_get_page_tab_markup(); ?>
		<?php if ( isset( $_POST['action'] ) ) {
				if ( $_POST['action'] == 'update' ) {
    				echo '<div class="updated"><p>';
					echo __( 'Theme settings updated successfully.', 'cleanyeti' );
					echo '</p></div>';
					cleanyeti_scss_compile();
				}
		} ?>
		<form action="" method="post">
		<?php 
			// Implement settings field security, nonces, etc.
			settings_fields('theme_cleanyeti_options');
			// Output each settings section, and each
			// Settings field in each section
			do_settings_sections( $settings_section );
		?>
			<?php submit_button( __( 'Save Settings', 'cleanyeti' ), 'primary', 'theme_cleanyeti_options[submit-' . $currenttab . ']', false ); ?>
			<?php submit_button( __( 'Reset Defaults', 'cleanyeti' ), 'secondary', 'theme_cleanyeti_options[reset-' . $currenttab . ']', false ); ?>
		</form>
	</div>
<?php 
}

/**
 * Clean Yeti Theme Option Defaults
 * 
 * Returns an associative array that holds 
 * all of the default values for all Theme 
 * options.
 * 
 * @uses	cleanyeti_get_option_parameters()	defined in \functions\options.php
 * 
 * @return	array	$defaults	associative array of option defaults
 */
function cleanyeti_get_option_defaults() {
	// Get the array that holds all
	// Theme option parameters
	$option_parameters = cleanyeti_get_option_parameters();
	// Initialize the array to hold
	// the default values for all
	// Theme options
	$option_defaults = array();
	// Loop through the option
	// parameters array
	foreach ( $option_parameters as $option_parameter ) {
		$name = $option_parameter['name'];
		// Add an associative array key
		// to the defaults array for each
		// option in the parameters array
		$option_defaults[$name] = $option_parameter['default'];
	}
	// Return the defaults array
	return apply_filters( 'cleanyeti_option_defaults', $option_defaults );
}

/**
 * Define default options tab
 */
function cleanyeti_define_default_options_tab( $options ) {
	$options['default_options_tab'] = 'general';
	return $options;
}
add_filter( 'cleanyeti_option_defaults', 'cleanyeti_define_default_options_tab' );

/**
 * Clean Yeti Theme Option Parameters
 * 
 * Array that holds parameters for all options for
 * Clean Yeti. The 'type' key is used to generate
 * the proper form field markup and to sanitize
 * the user-input data properly. The 'tab' key
 * determines the Settings Page on which the
 * option appears, and the 'section' tab determines
 * the section of the Settings Page tab in which
 * the option appears.
 * 
 * @return	array	$options	array of arrays of option parameters
 */
function cleanyeti_get_option_parameters() {
    $width_array = array();
    $i = 800;
    while ( $i <= 1400 ) {
        $width_array[$i]['name'] = $i;
        $width_array[$i]['title'] = $i;
        $i = $i + 50;
    }
    
    $sbwidth_array = array();
    $i = 2;
    while ( $i <= 6 ) {
        $sbwidth_array[$i]['name'] = $i;
        $sbwidth_array[$i]['title'] = $i;
        $i++;
    }
    
    $left_sbwidth_array = array();
    $i = 2;
    while ( $i <= 4 ) {
        $left_sbwidth_array[$i]['name'] = $i;
        $left_sbwidth_array[$i]['title'] = $i;
        $i++;
    }
    
    $noslides = array();
    $i = 3;
    while ( $i <= 10 ) {
        $noslides[$i]['name'] = $i;
        $noslides[$i]['title'] = $i;
        $i++;
    }
    
    $orbit_pages = array();
    $orbit_pages['select']['name'] = 'select';
    $orbit_pages['select']['title'] = '--Select--';
    $pages = get_pages();
    foreach ( $pages as $page ) {
        $orbit_pages[$page->ID]['name'] = $page->ID;
        $orbit_pages[$page->ID]['title'] = $page->post_title;
    }
    
    $options = array(
        'logo' => array( 
            'name' => 'logo',
            'title' => __( 'Upload Logo', 'cleanyeti' ),
            'type' => 'image',
            'description' => __( 'Upload a logo to display in the header.', 'cleanyeti'),
            'section' => 'header',
            'tab' => 'general',
            'since' => '2.3.0',
            'default' => 'http://placehold.it/100x100'
        ),
        'display_admin_notice' => array(
            'name' => 'display_admin_notice',
            'title' => __( 'Display Admin Notice', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => __( 'Display Admin Notice about theme settings?', 'cleanyeti' ),
            'section' => 'info',
            'tab' => 'general',
            'since' => '2.3.0',
            'default' => 1
        ),
        'title_position' => array(
            'name' => 'title_position',
            'title' => __( 'Main Title Position', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'left' => array(
                  'name' => 'left',
                  'title' => __( 'Left', 'cleanyeti' )
                ),
                'center' => array(
                  'name' => 'center',
                  'title' => __( 'Center', 'cleanyeti' )
                ),
                'right' => array(
                  'name' => 'right',
                  'title' => __( 'Right', 'cleanyeti' )
                )
            ),
            'description' => __( 'Position to dispaly main title below navigation', 'cleanyeti' ),
            'section' => 'header',
            'tab' => 'general',
            'since' => '2.3.0',
            'default' => 'left'
        ),
        'header_color' => array(
            'name' => 'header_color',
            'title' => __( 'Header Color', 'cleanyeti' ),
            'type' => 'color-picker',
            'description' => __( 'Choose a color to display in the background of the header.', 'cleanyeti' ),
            'section' => 'color',
            'tab' => 'colors',
            'since' => '2.3.0',
            'default' => '#FFFFFF'
        ),
        'header_top_bar_position' => array(
            'name' => 'header_top_bar_position',
            'title' => __( 'Header Top Bar Position', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'sticky' => array(
                  'name' => 'sticky',
                  'title' => __( 'Sticky', 'cleanyeti' )
                ),
                'not_sticky' => array(
                  'name' => 'not_sticky',
                  'title' => __( 'Not Sticky', 'cleanyeti' )
                )
            ),
            'description' => __( 'Should Header Top Bar stick to the top of the browser or the top of the page?', 'cleanyeti' ),
            'section' => 'header',
            'tab' => 'general',
            'since' => '2.3.0',
            'default' => 'not_sticky'
        ),
        'header_top_bar_menu_position' => array(
            'name' => 'header_top_bar_menu_position',
            'title' => __( 'Header Top Bar Menu Position', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'left' => array(
                    'name' => 'left',
                    'title' => __( 'left', 'cleanyeti' )
                ),
                'right' => array(
                    'name' => 'right',
                    'title' => __( 'Right', 'cleanyeti' )
                )
            ),
            'description' => __( 'Choose whether to display menu items on the left or the right in the Top Bar.', 'cleanyeti' ),
            'section' => 'header',
            'tab' => 'general',
            'since' => '2.3.0',
            'default' => 'right'
        ),
        'display_top_bar_title' => array(
            'name' => 'display_top_bar_title',
            'title' => __( 'Display Top Bar Title', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'false' => array(
                    'name' => 'false',
                    'title' => __( 'Do Not Display', 'cleanyeti' )
                ),
                'true' => array(
                    'name' => 'true',
                    'title' => __( 'Display', 'cleanyeti' )
                )
            ),
            'description' => __( 'Choose whether or not the site title will display in the Top Bar.', 'cleanyeti' ),
            'section' => 'header',
            'tab' => 'general',
            'since' => '2.3.0',
            'default' => 'true'
        ),
        'display_footer_credit' => array(
            'name' => 'display_footer_credit',
            'title' => __( 'Display Footer Credit', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
            'false' => array(
              'name' => 'false',
              'title' => __( 'Do Not Display', 'cleanyeti' )
            ),
            'true' => array(
              'name' => 'true',
              'title' => __( 'Display', 'cleanyeti' )
            )
            ),
            'description' => __( 'Display a credit link in the footer? This option is disabled by default, and you are under no obligation whatsoever to enable it.', 'cleanyeti' ),
            'section' => 'footer',
            'tab' => 'general',
            'since' => '2.3.0',
            'default' => 'false'
        ),
        'display_custom_copyright' => array(
            'name' => 'display_custom_copyright',
            'title' => __( 'Display Custom Copyright Text', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
            'default' => array(
                'name' => 'default',
                'title' => __( 'Display Default Copyright Text', 'cleanyeti' )
                    ),
            'false' => array(
              'name' => 'false',
              'title' => __( 'Do Not Display', 'cleanyeti' )
            ),
            'true' => array(
              'name' => 'true',
              'title' => __( 'Display', 'cleanyeti' )
            )
            ),
            'description' => __( 'Display custom copyright text? This option is disabled by default.  The default copyright text will display the range of your published post dates and blog title.', 'cleanyeti' ),
            'section' => 'footer',
            'tab' => 'general',
            'since' => '2.3.0',
            'default' => 'default'
        ),
        'copyright_text' => array(
            'name' => 'copyright_text',
            'title' => __( 'Custom Copyright Text', 'cleanyeti' ),
            'type' => 'text',
            'sanitize' => 'nohtml',
            'description' => __( 'Enter your custom copyright text to display in the footer.', 'cleanyeti' ),
            'section' => 'footer',
            'tab' => 'general',
            'since' => '2.3.0',
            'default' => '&copy; ' . get_bloginfo('name')
        ),
        'footer_color' => array(
            'name' => 'footer_color',
            'title' => __( 'Footer Color', 'cleanyeti' ),
            'type' => 'color-picker',
            'description' => __( 'Choose a color to display in the background of the footer.', 'cleanyeti' ),
            'section' => 'color',
            'tab' => 'colors',
            'since' => '2.3.0',
            'default' => '#FFFFFF'
        ),
        'primary' => array(
            'name' => 'primary',
            'title' => __( 'Primary Color', 'cleanyeti' ),
            'type' => 'color-picker',
            'description' => __( 'The primary color is the most prevalent.  It will show as links, most buttons, and in pagination.', 'cleanyeti' ),
            'section' => 'color',
            'tab' => 'colors',
            'since' => '2.3.0',
            'default' => '#2ba6cb'
        ),
        'secondary' => array(
            'name' => 'secondary',
            'title' => __( 'Secondary Color', 'cleanyeti' ),
            'type' => 'color-picker',
            'description' => __( 'The secondary color is a compliment to the primary color.', 'cleanyeti' ),
            'section' => 'color',
            'tab' => 'colors',
            'since' => '2.3.0',
            'default' => '#e9e9e9'
        ),
        'topbar_bg' => array(
            'name' => 'topbar_bg',
            'title' => __( 'Top Bar Background Color', 'cleanyeti' ),
            'type' => 'color-picker',
            'description' => __( 'The background color of the main navigation menu.', 'cleanyeti' ),
            'section' => 'color',
            'tab' => 'colors',
            'since' => '2.3.0',
            'default' => '#333333'
        ),
        'abide' => array(
            'name' => 'abide',
            'title' => __( 'Abide', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/abide.html">%s</a>', __( 'Abide', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'alert' => array(
            'name' => 'alert',
            'title' => __( 'Alert', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/alert_boxes.html">%s</a>', __( 'Alert', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'clearing' => array(
            'name' => 'clearing',
            'title' => __( 'Clearing Lightbox', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/clearing.html">%s</a>', __( 'Clearing', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'dropdown' => array(
            'name' => 'dropdown',
            'title' => __( 'Dropdown', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/dropdown.html">%s</a>', __( 'Dropdown', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'equalizer' => array(
            'name' => 'equalizer',
            'title' => __( 'Equalizer', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/equalizer.html">%s</a>', __( 'Equalizer', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'interchange' => array(
            'name' => 'interchange',
            'title' => __( 'Interchange', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/interchange.html">%s</a>', __( 'Interchange', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'joyride' => array(
            'name' => 'joyride',
            'title' => __( 'Joyride', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/joyride.html">%s</a>', __( 'Joyride', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'magellan' => array(
            'name' => 'magellan',
            'title' => __( 'Magellan', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/magellan.html">%s</a>', __( 'Magellan', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'offcanvas' => array(
            'name' => 'offcanvas',
            'title' => __( 'Off Canvas', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/offcanvas.html">%s</a>', __( 'Off Canvas', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'orbit' => array(
            'name' => 'orbit',
            'title' => __( 'Orbit Slider', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/orbit.html">%s</a>', __( 'Orbit', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => true
        ),
        'reveal' => array(
            'name' => 'reveal',
            'title' => __( 'Reveal Modals', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/reveal.html">%s</a>', __( 'Reveal', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => true
        ),
        'slider' => array(
            'name' => 'slider',
            'title' => __( 'Range Slider', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/range_slider.html">%s</a>', __( 'Slider', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'tooltip' => array(
            'name' => 'tooltip',
            'title' => __( 'Tooltips', 'cleanyeti' ),
            'type' => 'checkbox',
            'description' => sprintf( __( 'Docs: %s', 'cleanyeti' ), sprintf( '<a href="http://foundation.zurb.com/docs/components/tooltips.html">%s</a>', __( 'Tooltips', 'cleanyeti' ) ) ),
            'section' => 'javascript',
            'tab' => 'foundation_settings',
            'since' => '2.3.0',
            'default' => false
        ),
        'sidebar_position' => array(
            'name' => 'sidebar_position',
            'title' => __( 'Sidebar Position', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'left' => array(
                    'name' => 'left',
                    'title' => __( 'Left', 'cleanyeti' )
                ),
                'right' => array(
                    'name' => 'right',
                    'title' => __( 'Right', 'cleanyeti' )
                )
            ),
            'description' => __( 'Choose the positiong in which you would like to display the sidebar.', 'cleanyeti' ),
            'section' => 'layouts',
            'tab' => 'layout',
            'since' => '2.3.0',
            'default' => 'right',
            'post_meta' => true
		    ),
        'sidebar_post_layout' => array(
            'name' => 'sidebar_post_layout',
            'title' => __( 'Sidebar Post Layout', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'single' => array(
                    'name' => 'single',
                    'title' => __( 'Single Sidebar', 'cleanyeti' )
                ),
                'double' => array(
                    'name' => 'double',
                    'title' => __( 'Left and Right Sidebar', 'cleanyeti' )
                )
            ),
            'description' => __( 'Choose whether or not to have a single sidebar or a left and right sidebar on posts.', 'cleanyeti' ),
            'section' => 'main',
            'tab' => 'layout',
            'since' => '2.3.4',
            'default' => 'single',
            'post_meta' => true
		    ),
        'sidebar_index_layout' => array(
            'name' => 'sidebar_index_layout',
            'title' => __( 'Sidebar Index Layout', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'single' => array(
                    'name' => 'single',
                    'title' => __( 'Single Sidebar', 'cleanyeti' )
                ),
                'double' => array(
                    'name' => 'double',
                    'title' => __( 'Left and Right Sidebar', 'cleanyeti' )
                )
            ),
            'description' => __( 'Choose whether or not to have a single sidebar or a left and right sidebar on the Blog index page.', 'cleanyeti' ),
            'section' => 'main',
            'tab' => 'layout',
            'since' => '2.3.4',
            'default' => 'single',
		    ),
        'sidebar_archive_layout' => array(
            'name' => 'sidebar_archive_layout',
            'title' => __( 'Sidebar Archive Layout', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'single' => array(
                    'name' => 'single',
                    'title' => __( 'Single Sidebar', 'cleanyeti' )
                ),
                'double' => array(
                    'name' => 'double',
                    'title' => __( 'Left and Right Sidebar', 'cleanyeti' )
                )
            ),
            'description' => __( 'Choose whether or not to have a single sidebar or a left and right sidebar on archive pages.', 'cleanyeti' ),
            'section' => 'main',
            'tab' => 'layout',
            'since' => '2.3.4',
            'default' => 'single',
		    ),
        'max_width' => array(
            'name' => 'max_width',
            'title' => __( 'Maximum Content Width', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => $width_array,
            'description' => __( 'Choose the maximum content width.  This value is the maximum width of the main content and the sidebar combined.', 'cleanyeti'),
            'section' => 'main',
            'tab' => 'layout',
            'since' => '2.3.0',
            'default' => '1200'
        ),
        'sidebar_width' => array(
            'name' => 'sidebar_width',
            'title' => __( 'Sidebar Column Width', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => $sbwidth_array,
            'description' => __( 'Choose the sidebar column width.  Width is based on a 12 column grid so a width of 6 columns will split the main content and sidebar down the middle.', 'cleanyeti' ),
            'section' => 'layouts',
            'tab' => 'layout',
            'since' => '2.3.0',
            'default' => '4'
        ),
        'left_sidebar_width' => array(
            'name' => 'left_sidebar_width',
            'title' => __( 'Left Sidebar Column Width', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => $left_sbwidth_array,
            'description' => __( 'Choose the left sidebar column width for the two sidebar template.  Width is based on a 12 column grid.', 'cleanyeti' ),
            'section' => 'layout_two',
            'tab' => 'layout',
            'since' => '2.3.4',
            'default' => '3',
            'post_meta' => true
        ),
        'right_sidebar_width' => array(
            'name' => 'right_sidebar_width',
            'title' => __( 'Right Sidebar Column Width', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => $left_sbwidth_array,
            'description' => __( 'Choose the right sidebar column width for the two sidebar template.  Width is based on a 12 column grid.', 'cleanyeti' ),
            'section' => 'layout_two',
            'tab' => 'layout',
            'since' => '2.3.4',
            'default' => '3',
            'post_meta' => true
        ),
        'no_slides' => array(
            'name' => 'no_slides',
            'title' => __( 'Number or Slides', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => $noslides,
            'description' => __( 'Choose the number of slides you would like to appear in the slider.', 'cleanyeti' ),
            'section' => 'slides',
            'tab' => 'orbit',
            'since' => '2.3.0',
            'default' => '3'
        ),
        'display_orbit' => array(
            'name' => 'display_orbit',
            'title' => __( 'Display Orbit Slider', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'false' => array(
                  'name' => 'false',
                  'title' => __( 'Do Not Display', 'cleanyeti' )
                ),
                'true' => array(
                  'name' => 'true',
                  'title' => __( 'Display', 'cleanyeti' )
                )
            ),
            'description' => __( 'Choose whether or not to display the Orbit Slider.  If enabled, the slider will only appear on the front page.', 'cleanyeti' ),
            'section' => 'slides',
            'tab' => 'orbit',
            'since' => '2.4.1',
            'default' => 'false'
        ),
        'flex_menu_location' => array(
            'name' => 'flex_menu_location',
            'title' => __( 'Flexible Menu Location', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'aboveheader' => array(
                    'name' => 'aboveheader',
                    'title' => __( 'Above Header', 'cleanyeti' )
                ),
                'belowheader' => array(
                    'name' => 'belowheader',
                    'title' => __( 'Below Header', 'cleanyeti' )
                ),
                'abovefooter' => array(
                    'name' => 'abovefooter',
                    'title' => __( 'Above Footer', 'cleanyeti' )
                ),
                'belowwidgets' => array(
                    'name' => 'belowwidgets',
                    'title' => __( 'Below Footer Widgets', 'cleanyeti' )
                ),
                'belowfooter' => array(
                    'name' => 'belowfooter',
                    'title' => __( 'Below Footer', 'cleanyeti' )
                ),
            ),
            'description' => __( 'Choose where to display flexible menu.', 'cleanyeti' ),
            'section' => 'flex_menu',
            'tab' => 'menus',
            'since' => '2.4.2',
            'default' => 'belowheader'   
        ),
        'flex_menu_position' => array(
            'name' => 'flex_menu_position',
            'title' => __( 'Flexible Menu Position', 'cleanyeti' ),
            'type' => 'select',
            'valid_options' => array(
                'left' => array(
                  'name' => 'left',
                  'title' => __( 'Left', 'cleanyeti' )
                ),
                'right' => array(
                  'name' => 'right',
                  'title' => __( 'Right', 'cleanyeti' )
                )
            ),
            'description' => __( 'Position to dispaly flexible menu', 'cleanyeti' ),
            'section' => 'flex_menu',
            'tab' => 'menus',
            'since' => '2.4.2',
            'default' => 'left'
        ),
    );

    $i = 1;
    $q = 2;
    $o_page_link = array();
    $o_image = array();
    while ( $i <= 10 ) {
        $o_page_link = array(
            'name' => 'orbit_page_link_' . $i,
            'title' => __( 'Page Link', 'cleanyeti' ) . ' ' . $i,
            'type' => 'select',
            'valid_options' => $orbit_pages,
            'description' => sprintf( __( 'Choose which page to link the image in slide %d to.', 'cleanyeti' ), $i ),
            'section' => 'slides',
            'tab' => 'orbit',
            'since' => '2.3.0',
            'default' => '--Select--',
            'priority' => $q
        );
        $options['orbit_page_link_' . $i] = $o_page_link;
        $q++;
        $o_image = array(
            'name' => 'orbit_image_' . $i,
            'title' => __( 'Upload Image', 'cleanyeti' ) . ' ' . $i,
            'type' => 'image',
            'description' => sprintf( __( 'Upload an image to display in slide %d.', 'cleanyeti'), $i ),
            'section' => 'slides',
            'tab' => 'orbit',
            'since' => '2.3.0',
            'default' => 'http://placehold.it/1200x400',
            'priority' => $q
        );
        $options['orbit_image_' . $i] = $o_image;
        $i++;
        $q++;
    }
    return apply_filters( 'cleanyeti_get_option_parameters', $options );
}

/**
 * Get Clean Yeti Theme Options
 * 
 * Array that holds all of the defined values
 * for Clean Yeti Theme options. If the user 
 * has not specified a value for a given Theme 
 * option, then the option's default value is
 * used instead.
 *
 * @uses	cleanyeti_get_option_defaults()	defined in \functions\options.php
 * 
 * @uses	get_option()
 * @uses	wp_parse_args()
 * 
 * @return	array	$cleanyeti_options	current values for all Theme options
 */
function cleanyeti_get_options() {
	// Get the option defaults
	$option_defaults = cleanyeti_get_option_defaults();
	// Globalize the variable that holds the Theme options
	global $cleanyeti_options;
	// Parse the stored options with the defaults
	$cleanyeti_options = wp_parse_args( get_option( 'theme_cleanyeti_options', array() ), $option_defaults );
	// Return the parsed array
	return $cleanyeti_options;
}

/**
 * Separate settings by tab
 * 
 * Returns an array of tabs, each of
 * which is an indexed array of settings
 * included with the specified tab.
 *
 * @uses	cleanyeti_get_option_parameters()	defined in \functions\options.php
 * @uses	cleanyeti_get_settings_page_tabs()	defined in \functions\options.php
 * 
 * @return	array	$settingsbytab	array of arrays of settings by tab
 */
function cleanyeti_get_settings_by_tab() {
	// Get the list of settings page tabs
	$tabs = cleanyeti_get_settings_page_tabs();
	// Initialize an array to hold
	// an indexed array of tabnames
	$settingsbytab = array();
	// Loop through the array of tabs
	foreach ( $tabs as $tab ) {
		$tabname = $tab['name'];
		// Add an indexed array key
		// to the settings-by-tab 
		// array for each tab name
		$settingsbytab[] = $tabname;
	}
	// Get the array of option parameters
	$option_parameters = cleanyeti_get_option_parameters();
	// Loop through the option parameters
	// array
	foreach ( $option_parameters as $option_parameter ) {
		$optiontab = $option_parameter['tab'];
		$optionname = $option_parameter['name'];
		// Add an indexed array key to the 
		// settings-by-tab array for each
		// setting associated with each tab
		$settingsbytab[$optiontab][] = $optionname;
		$settingsbytab['all'][] = $optionname;
	}
	// Return the settings-by-tab
	// array
	return $settingsbytab;
}
 
/**
 * Clean Yeti Theme Admin Settings Page Tabs
 * 
 * Array that holds all of the tabs for the
 * Clean Yeti Theme Settings Page. Each tab
 * key holds an array that defines the 
 * sections for each tab, including the
 * description text.
 * 
 * @uses	cleanyeti_get_color_text()	defined in \functions\options-register.php
 * 
 * @return	array	$tabs	array of arrays of tab parameters
 */
function cleanyeti_get_settings_page_tabs() {
	
$tabs = array(
    'general' => array(
        'name' => 'general',
        'title' => __( 'General', 'cleanyeti' ),
        'sections' => array(
            'info' => array(
                'name' => 'info',
                'title' => __( 'Thank You for using the Clean Yeti Theme', 'cleanyeti' ),
                'description' => cleanyeti_theme_info()
                    ),
            'header' => array(
                'name' => 'header',
                'title' => __( 'Header Options', 'cleanyeti' ),
                'description' => __( 'Manage Header options for the Clean Yeti Theme. Refer to the contextual help screen for descriptions and help regarding each theme option.', 'cleanyeti' )
            ),
            'footer' => array(
                'name' => 'footer',
                'title' => __( 'Footer Options', 'cleanyeti' ),
                'description' => __( 'Manage Footer options for the Clean Yeti Theme. Refer to the contextual help screen for descriptions and help regarding each theme option.', 'cleanyeti' )
            )
        ),
    ),
    'colors' => array(
        'name' => 'colors',
        'title' => __( 'Colors', 'cleanyeti' ),
        'sections' => array(
            'color' => array(
                'name' => 'color',
                'title' => __( 'Color Options', 'cleanyeti' ),
                'description' => __( 'Choose from a variety of color options to customize your site.', 'cleanyeti' )
            ),
        ),
    ), 
    'foundation_settings' => array(
        'name' => 'foundation_settings',
        'title' => __( 'Foundation Settings', 'cleanyeti' ),
        'sections' => array(
            'javascript' => array(
                'name' => 'javascript',
                'title' => __( 'Javascript Libraries', 'cleanyeti' ),
                'description' => __( 'Choose which Foundation javascript libraries you would like to load.  If you decided to load all libraries, then it is recommended to use a plugin such as W3 total cache to increase page load speed.  Clean Yeti loads the Orbit Slider, Reveal, Accordion, Tabs, and Top Bar libraries by default, since these features are integrated into the theme.', 'cleanyeti' ),
            ),
        ),
    ),
    'layout' => array(
        'name' => 'layout',
        'title' => __( 'Layout', 'cleanyeti' ),
        'sections' => array(
            'main' => array(
                'name' => 'main',
                'title' => __( 'Layout', 'cleanyeti' ),
                'description' => __( 'Adjust row width and other content widths for single and two sidebar layouts.', 'cleanyeti' )
            ),
            'layouts' => array(
                'name' => 'layouts',
                'title' => __( 'Content Arrangement for Single Sidebar', 'cleanyeti' ),
                'description' => __( 'Manage the layout and sizes of the main content and sidebar.', 'cleanyeti' ),
                'post_meta' => true
            ),
            'layout_two' => array(
                'name' => 'layout_two',
                'title' => __( 'Content Arrangement for Two Sidebars', 'cleanyeti' ),
                'description' => __( 'Manage the layout and sizes of the main content and both sidebars for the two sidebar page template.', 'cleanyeti' ),
                'post_meta' => true
            ),
        ),
        'post_meta' => true
    ),
    'orbit' => array(
        'name' => 'orbit',
        'title' => __( 'Orbit Slider', 'cleanyeti' ),
        'sections' => array(
            'slides' => array(
                'name' => 'slides',
                'title' => __( 'Front Page Orbit Slider', 'cleanyeti' ),
                'description' => __( 'Choose your images and pages to link to for the front page slider.  In order for this to work, the orbit slider library must be loaded under the Foundation Settings.  1200 x 400 is the recommended image resolutions for the slides.', 'cleanyeti' )
            ),
        ),
    ),
    'menus' => array(
        'name' => 'menus',
        'title' => __( 'Menus', 'cleanyeti' ),
        'sections' => array(
            //'locations' => array(
            //    'name' => 'locations',
            //    'title' => __( 'Menu Locations', 'cleanyeti' ),
            //    'description' => __( 'Manage menu locations.  Layout Options for the flexible menu are shown below.', 'cleanyeti' )
            //),
            'flex_menu' => array(
                'name' => 'flex_menu',
                'title' => __( 'Flexible Menu', 'cleanyeti' ),
                'description' => __( 'Choose where to display the flexible menu.  The style used for this menu is the foundation inline-list class.', 'cleanyeti' )
            ),
        ),
    ),
);
return apply_filters( 'cleanyeti_get_settings_page_tabs', $tabs );
}

function cleanyeti_theme_info() {
    $text = sprintf( __('Support for this theme is included with your purchase.  Access our support forum here: %s  Need help getting started? Serene Themes also offers Web Development services to help you get started with your website or provide improvements to your current site.  Find out more at %s.', 'cleanyeti' ), ': <a href="http://serenethemes.com/forums/" title="Serene Themes Support Forum">serenethemes.com/forums</a>', '<a href="http://serenethemes.com" title="Serene Themes">serenethemes.com</a>' );
    return $text;
}

/**
 * Theme settings page notice
 */
function cleanyeti_admin_notices($hook_suffix) {
    global $cleanyeti_options;
    $cleanyeti_options = cleanyeti_get_options();
    $set_url = esc_url( admin_url( 'themes.php?page=cleanyeti-settings' ) );
    $page = ( isset( $_GET['page'] ) ? $_GET['page'] : '' );
    if( $page == 'cleanyeti-settings' || $cleanyeti_options['display_admin_notice'] == 0 ) {
    return;
    } else { ?>
    
    <div class="updated">
        <p><?php echo sprintf( __( 'Clean Yeti has added more theme settings. <a href="%s">Customize Here</a>', 'cleanyeti'), $set_url ); ?></p>
    </div> <?php
    }
}
add_action( 'admin_notices', 'cleanyeti_admin_notices' );

/**
 * @todo Menu Locations
 */
 
 
?>
