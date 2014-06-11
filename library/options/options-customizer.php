<?php
/**
 * Clean Yeti Options Theme Customizer Integration
 *
 * This file integrates the Theme Customizer
 * for the Clean Yeti Theme.
 * 
 * @package 	Clean Yeti
 * @copyright	Copyright (c) 2014, Serene Themes
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Clean Yeti 2.3.0
 */

/**
 * Clean Yeti Theme Settings Theme Customizer Implementation
 *
 * Implement the Theme Customizer for the 
 * Clean Yeti Theme Settings.
 * 
 * @param 	object	$wp_customize	Object that holds the customizer data
 * 
 * @link	http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/	Otto
 */
function cleanyeti_register_theme_customizer( $wp_customize ){

	// Failsafe is safe
	if ( ! isset( $wp_customize ) ) {
		return;
	}

	global $cleanyeti_options;
	$cleanyeti_options = cleanyeti_get_options();

	// Get the array of option parameters
	$option_parameters = cleanyeti_get_option_parameters();
	// Get list of tabs
	$tabs = cleanyeti_get_settings_page_tabs();

	// Add Sections
	foreach ( $tabs as $tab ) {
		// Add $tab section
		$wp_customize->add_section( 'cleanyeti_' . $tab['name'], array(
			'title'		=> $tab['title'],
		) );
	}

	// Add Settings
	foreach ( $option_parameters as $option_parameter ) {
		// sanitize callback based on type
		if ( 'text' == $option_parameter['type'] )
      $sanitize = 'cleanyeti_sanitize_text';
    else if ( 'checkbox' == $option_parameter['type'] )
      $sanitize = 'cleanyeti_sanitize_checkbox';
    else if ( 'radio' == $option_parameter['type'] || 'select' == $option_parameter['type'] )
      $sanitize = 'cleanyeti_sanitize_choices';
    else if ( 'color-picker' == $option_parameter['type'] )
      $sanitize = 'sanitize_hex_color';
    else if ( 'image' == $option_parameter['type'] )
      $sanitize = 'esc_url';
		
		$prio = ( isset( $option_parameter['priority'] ) ? $option_parameter['priority'] : 1 );
		// Add $option_parameter setting
		$wp_customize->add_setting( 'theme_cleanyeti_options[' . $option_parameter['name'] . ']', array(
			'default'        => $option_parameter['default'],
			'type'           => 'option',
			'sanitize'       => $sanitize
		) );

		// Add $option_parameter control
		if ( 'text' == $option_parameter['type'] ) {
			$wp_customize->add_control( 'cleanyeti_' . $option_parameter['name'], array(
				'label'   => $option_parameter['title'],
				'section' => 'cleanyeti_' . $option_parameter['tab'],
				'settings'   => 'theme_cleanyeti_options['. $option_parameter['name'] . ']',
				'type'    => 'text',
			) );

		} else if ( 'checkbox' == $option_parameter['type'] ) {
			$wp_customize->add_control( 'cleanyeti_' . $option_parameter['name'], array(
				'label'   => $option_parameter['title'],
				'section' => 'cleanyeti_' . $option_parameter['tab'],
				'settings'   => 'theme_cleanyeti_options['. $option_parameter['name'] . ']',
				'type'    => 'checkbox',
			) );

		} else if ( 'radio' == $option_parameter['type'] ) {
			$valid_options = array();
			foreach ( $option_parameter['valid_options'] as $valid_option ) {
				$valid_options[$valid_option['name']] = $valid_option['title'];
			}
			$wp_customize->add_control( 'cleanyeti_' . $option_parameter['name'], array(
				'label'   => $option_parameter['title'],
				'section' => 'cleanyeti_' . $option_parameter['tab'],
				'settings'   => 'theme_cleanyeti_options['. $option_parameter['name'] . ']',
				'type'    => 'radio',
				'choices'    => $valid_options,
			) );

		  } else if ( 'select' == $option_parameter['type'] ) {
			   $valid_options = array();
			  foreach ( $option_parameter['valid_options'] as $valid_option ) {
				  $valid_options[$valid_option['name']] = $valid_option['title'];
			  }
			$wp_customize->add_control( 'cleanyeti_' . $option_parameter['name'], array(
				'label'   => $option_parameter['title'],
				'section' => 'cleanyeti_' . $option_parameter['tab'],
				'settings'   => 'theme_cleanyeti_options['. $option_parameter['name'] . ']',
				'type'    => 'select',
				'choices'    => $valid_options,
				'priority' => $prio
			) );
		  } else if ( 'color-picker' == $option_parameter['type'] ) {
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cleanyeti_' . $option_parameter['name'], array(
		        'label'      => $option_parameter['title'],
		        'section'    => 'cleanyeti_' . $option_parameter['tab'],
                'settings'   => 'theme_cleanyeti_options['. $option_parameter['name'] . ']',
	        ) ) );
        } else if ( 'image' == $option_parameter['type'] ) {
            $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'cleanyeti_' . $option_parameter['name'], array(
                'label' => $option_parameter['title'],
                'section' => 'cleanyeti_' . $option_parameter['tab'],
                'settings' => 'theme_cleanyeti_options['. $option_parameter['name'] . ']',
                'priority' => $prio
            ) ) );
        } else if ( 'custom' == $option_parameter['type'] ) {
			$valid_options = array();
			foreach ( $option_parameter['valid_options'] as $valid_option ) {
				$valid_options[$valid_option['name']] = $valid_option['title'];
			}
			$wp_customize->add_control( 'cleanyeti_' . $option_parameter['name'], array(
				'label'   => $option_parameter['title'],
				'section' => 'cleanyeti_' . $option_parameter['tab'],
				'settings'   => 'theme_cleanyeti_options['. $option_parameter['name'] . ']',
				'type'    => 'select',
				'choices'    => $valid_options,
			) );
		}
	}
}
// Settings API options initilization and validation
add_action( 'customize_register', 'cleanyeti_register_theme_customizer' );

//Enqueue orbit customizer script
function cleanyeti_orbit_customizer_script() {
	global $wp_customize;
	if ( method_exists( $wp_customize,'is_preview' ) && $wp_customize->is_preview() )
		wp_enqueue_script( 'cleanyeti-orbit-customizer', get_template_directory_uri() . '/library/scripts/orbit-customizer.js', array( 'jquery' ) );
}
add_action( 'customize_controls_print_scripts', 'cleanyeti_orbit_customizer_script' );

/**
 * Theme customizer sanitize callback for text fields
 */

function cleanyeti_sanitize_text( $input ) {
    return wp_filter_nohtml_kses( $input );
}

/**
 * Theme customizer sanitize callback for checkbox fields
 */
function cleanyeti_sanitize_checkbox( $input ) {
    $input = ( ( isset( $input ) && true == $input ) ? true : false );
    return $input;
}

/**
 * Sanitize select and radio fields
 * @link http://cachingandburning.com/wordpress-theme-customizer-sanitizing-radio-buttons-and-select-lists/
 *
 */
function cleanyeti_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $name = preg_replace('/theme_cleanyeti_options\[(.*)\]/', '$1', $setting->id);
    $control = $wp_customize->get_control( 'cleanyeti_' . $name );
    $choices = $control->choices;

    if ( array_key_exists( $input, $choices ) ) {
        return $input;      
    } else {
        return $setting->default;
    }
}
?>