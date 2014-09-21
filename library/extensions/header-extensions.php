<?php
/**
 * Header Extensions
 *
 * @package cleanyetiCoreLibrary
 * @subpackage HeaderExtensions
 *
 *
 * Display the DOCTYPE
 * 
 * Filter: cleanyeti_create_doctype
 */

function cleanyeti_create_doctype() {
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" <?php language_attributes();?> > <![endif]-->
<html class="no-js" <?php language_attributes();?> >
<?php
}


/**
 * Display the HEAD profile
 * 
 * Filter: cleanyeti_head_profile
 */
function cleanyeti_head_profile() {
    $content = '<head>' . "\n";
    echo apply_filters('cleanyeti_head_profile', $content );
}


/**
 * Display the META content-type
 * 
 * Filter: cleanyeti_create_contenttype
 */
function cleanyeti_create_contenttype() {
    $content = "<meta http-equiv=\"Content-Type\" content=\"";
    $content .= get_bloginfo('html_type'); 
    $content .= "; charset=";
    $content .= get_bloginfo('charset');
    $content .= "\" />";
    $content .= "\n";
    $content .="<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />";
    $content .= "\n";
    echo apply_filters('cleanyeti_create_contenttype', $content);
}

if ( function_exists('childtheme_override_doctitle') )  {
	/**
	 * @ignore
	 */
	 function cleanyeti_doctitle() {
    	childtheme_override_doctitle();
    }
} else {
	/**
	 * Display the content of the title tag
	 * 
	 * Override: childtheme_override_doctitle
	 * Filter: thematic_doctitle_separator
	 *
	 */
	function cleanyeti_doctitle() {
        $separator = apply_filters('cleanyeti_doctitle_separator', '|');
        $doctitle = '<title>' . wp_title( $separator, false, 'right' ) . '</title>' . "\n";
        echo $doctitle;
	}
}

/**
 * Display links to RSS feed
 * 
 * This can be switched on or off using cleanyeti_show_rss. Default: ON
 * 
 * Filter: cleanyeti_show_rss
 * Filter: cleanyeti_rss
 */
function cleanyeti_show_rss() {
    $display = TRUE;
    $display = apply_filters('cleanyeti_show_rss', $display);
    if ($display) {
        $content = '<link rel="alternate" type="application/rss+xml" href="';
        $content .= get_feed_link( get_default_feed() );
        $content .= '" title="';
        $content .= esc_attr( get_bloginfo('name', 'display') );
        $content .= ' ' . __('Posts RSS feed', 'cleanyeti');
        $content .= '" />';
        $content .= "\n";
        echo apply_filters('cleanyeti_rss', $content);
    }
}

/**
 * Display pingback link
 * 
 * This can be switched on or off using cleanyeti_show_pingback. Default: ON
 * 
 * Filter: cleanyeti_show_pingback
 * Filter: cleanyeti_pingback_url
 */
function cleanyeti_show_pingback() {
    $display = TRUE;
    $display = apply_filters('cleanyeti_show_pingback', $display);
    if ($display) {
        $content = '<link rel="pingback" href="';
        $content .= get_bloginfo('pingback_url');
        $content .= '" />';
        $content .= "\n";
        echo apply_filters('cleanyeti_pingback_url',$content);
    }
}

/**
 * Add the default stylesheet to the head of the document.
 * 
 * Register and enqueue cleanyeti style.css
 * 
 *
 * Register Ubuntu font 
 * Ubuntu Font: http://font.ubuntu.com
 * Copyright: 2013 Canonical ltd.
 * License: http://font.ubuntu.com/ufl/ubuntu-font-licence-1.0.txt
 *
 * Register Foundation Style
 * Foundation Styles and Scripts bundle:
 * Foundation 5: http://foundation.zurb.com
 * Copyright: 2013 ZURB
 * License: MIT http://www.opensource.org/licenses/mit-license.php
 */



function cleanyeti_create_stylesheet() {
	global $wp_customize;
	if ( isset( $wp_customize ) && $wp_customize->is_preview() ) {
		$preview = 'preview';
		wp_enqueue_style( 'cleanyeti-foundation', get_template_directory_uri() . '/library/Foundation/css/cleanyetipreview.css', array(), date('Ymdhs') );
	} else {
        $preview = '';
        if ( file_exists( get_template_directory() . '/library/Foundation/css/cleanyeti.css' ) ) {
            wp_enqueue_style( 'cleanyeti-foundation', get_template_directory_uri() . '/library/Foundation/css/cleanyeti.css' );
        } else {
            wp_enqueue_style( 'cleanyeti-foundation', get_template_directory_uri() . '/library/Foundation/css/cleanyeti-default.css' );
        }
    }
	wp_register_style( 'cleanyeti-ubuntu', 'http://fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,700,700italic|Ubuntu+Mono' );
	wp_enqueue_style( 'cleanyeti-style', get_stylesheet_uri(), array( 'cleanyeti-ubuntu', 'cleanyeti-foundation' ) );

}

add_action('wp_enqueue_scripts','cleanyeti_create_stylesheet');

if ( function_exists('childtheme_override_head_scripts') )  {
    /**
     * @ignore
     */
    function cleanyeti_head_scripts() {
    	childtheme_override_head_scripts();
    }
} else {
    /**
     *
     * Child themes should use wp_dequeue_scripts to remove individual scripts.
     * Larger changes can be made using the override.
     *
     * Override: childtheme_override_head_scripts <br>
     *
     * @since 1.0
     */
    function cleanyeti_head_scripts() {
        global $cleanyeti_options;
        $cleanyeti_options = cleanyeti_get_options();
        $option_parameters = cleanyeti_get_option_parameters();

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			has_filter( 'cleanyeti_show_commentreply' ) ? cleanyeti_show_commentreply() : wp_enqueue_script( 'comment-reply' );

		wp_register_style( 'foundation-icons-social', get_template_directory_uri() . '/library/Foundation/fonts/foundation_icons_all/foundation_icons_social/stylesheets/social_foundicons.css');
		wp_enqueue_style( 'foundation-icons-social' );
		wp_register_style( 'foundation-icons-general', get_template_directory_uri() . '/library/Foundation/fonts/foundation_icons_all/foundation_icons_general/stylesheets/general_foundicons.css');
		wp_enqueue_style( 'foundation-icons-general' );
		wp_register_style( 'foundation-icons-general-enclosed', get_template_directory_uri() . '/library/Foundation/fonts/foundation_icons_all/foundation_icons_general_enclosed/stylesheets/general_enclosed_foundicons.css');
		wp_enqueue_style( 'foundation-icons-general-enclosed' );
		wp_register_style( 'foundation-icons-accessibility', get_template_directory_uri() . '/library/Foundation/fonts/foundation_icons_all/foundation_icons_accessibility/stylesheets/accessibility_foundicons.css');
		wp_enqueue_style( 'foundation-icons-accessibility' );

		wp_enqueue_script( 'cleanyeti-modernizr-js', get_template_directory_uri() . '/library/Foundation/js/modernizr.js', array( 'jquery' ), '2.8.3' );
		wp_enqueue_script( 'cleanyeti-foundation-js', get_template_directory_uri() . '/library/Foundation/js/foundation/foundation.js', array(), '5.4.1', true );
        wp_enqueue_script( 'cleanyeti-foundation-accordion-js', get_template_directory_uri() . '/library/Foundation/js/foundation/foundation.accordion.js', array(), '5.4.1', true );
        wp_enqueue_script( 'cleanyeti-foundation-tabs-js', get_template_directory_uri() . '/library/Foundation/js/foundation/foundation.tab.js', array(), '5.4.1', true );
        wp_enqueue_script( 'cleanyeti-foundation-topbar-js', get_template_directory_uri() . '/library/Foundation/js/foundation/foundation.topbar.js', array(), '5.4.1', true );
        foreach ( $option_parameters as $option_parameter ) {
            $section = $option_parameter['section'];
            $name = $option_parameter['name'];
            if ( 'javascript' == $section && isset( $cleanyeti_options[$name] ) && 1 == $cleanyeti_options[$name] ) {
                wp_enqueue_script( 'cleanyeti-foundation-' . $name . '-js', get_template_directory_uri() . '/library/Foundation/js/foundation/foundation.' . $name . '.js', array(), '5.4.1', true );
            }
        }
        wp_enqueue_script( 'cleanyeti-document-js', get_template_directory_uri() . '/library/Foundation/js/document.js', array () , '5.4.1', true );
	}
}

add_action('wp_enqueue_scripts','cleanyeti_head_scripts');


/**
 * Return the default arguments for wp_page_menu()
 *
 * This is used as fallback when the user has not created a custom nav menu in wordpress admin
 *
 * Filter: cleanyeti_page_menu_args
 *
 * @return array
 */
function cleanyeti_page_menu_args() {
	$args = array (
		'sort_column' => 'menu_order',
		'menu_class'  => 'menu',
		'include'     => '',
		'exclude'     => '',
		'echo'        => FALSE,
		'show_home'   => FALSE,
		'link_before' => '',
		'link_after'  => ''
	);
	return apply_filters('cleanyeti_page_menu_args', $args);
}


/**
 * Return the default arguments for wp_nav_menu
 * 
 * Filter: cleanyeti_primary_menu_id <br>
 * Filter: cleanyeti_nav_menu_args
 *
 * @return array
 */
class Topbar_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_lvl(&$output, $depth=0, $args=array() ) {
    $indent = str_repeat("\t", $depth);
    $output = preg_replace( "/(.*)(\<li.*?class\=\")([^\"]*)(\".*?)$/", "$1$2$3 has-dropdown$4", $output );
    $output .= "\n$indent<ul class=\"dropdown\">\n";
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a '. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

function cleanyeti_nav_menu_args() {
    global $cleanyeti_options;
    $cleanyeti_options = cleanyeti_get_options();
    $menuclass = $cleanyeti_options['header_top_bar_menu_position'];
	$args = array (
		'theme_location'	=> apply_filters('cleanyeti_primary_menu_id', 'primary-menu'),
		'menu'				=> '',
		'container'			=> '',
		'container_class'	=> '',
		'menu_class'		=> $menuclass,
		'fallback_cb'		=> false,
		'before'			=> '',
		'after'				=> '',
		'link_before'		=> '',
		'link_after'		=> '',
		'depth'				=> 0,
		'walker'			=> new Topbar_Walker_Nav_Menu(),
		'echo'				=> false
	);

	return apply_filters('cleanyeti_nav_menu_args', $args);
}



if ( function_exists( 'childtheme_override_body' ) )  {
	/**
	 * @ignore
	 */
	 function cleanyeti_body() {
		childtheme_override_body();
	}
} else {
	/**
	 * Creates the body tag
	 */
	 function cleanyeti_body() {
    	if ( apply_filters( 'cleanyeti_show_bodyclass',TRUE ) ) { 
        	// Creating the body class
    		echo '<body ';
    		body_class();
    		echo '>' . "\n\n";
    	} else {
    		echo '<body>' . "\n\n";
    	}
	}
}


/**
 * Register action hook: cleanyeti_before
 * 
 * Located in header.php, just after the body tag, before anything else.
 */
function cleanyeti_before() {
    do_action( 'cleanyeti_before' );
}


/**
 * Register action hook: cleanyeti_abovefooter
 * 
 * Located in header.php, inside the header div
 */
function cleanyeti_aboveheader() {
    do_action( 'cleanyeti_aboveheader' );
}


/**
 * Register action hook: cleanyeti_abovefooter
 * 
 * Located in header.php, inside the header div
 */
function cleanyeti_header() {
    do_action( 'cleanyeti_header' );
}


if ( function_exists( 'childtheme_override_brandingopen' ) )  {
	/**
	 * @ignore
	 */
	function cleanyeti_brandingopen() {
		childtheme_override_brandingopen();
		}
	} else {
	/**
	 * Display the opening of the #branding div
	 * 
	 * Override: childtheme_override_brandingopen
	 */
    function cleanyeti_brandingopen() {
        global $cleanyeti_options;
        $cleanyeti_options = cleanyeti_get_options();
        $align = 'text-' . $cleanyeti_options['title_position'];
        if ( 'true' == $cleanyeti_options['display_main_title'] ) {
            echo '<div class="row ' . $align . '">' . "\n";
            echo "\t<div id=\"branding\" class=\"medium-10 columns\">\n";
        }
    }
}

add_action( 'cleanyeti_header','cleanyeti_brandingopen',2 );


if ( function_exists( 'childtheme_override_blogtitle' ) )  {
	/**
	 * @ignore
	 */
    function cleanyeti_blogtitle() {
    	childtheme_override_blogtitle();
    }
} else {
    /**
     * Display the blog title within the #branding div
     * 
     * Override: childtheme_override_blogtitle
     */    
    function cleanyeti_blogtitle() {
        $cleanyeti_options = cleanyeti_get_options();
        if ( 'true' == $cleanyeti_options['display_main_title'] ) :
        ?>

          <div id="blog-title"><a href="<?php echo esc_url(home_url()); ?>/" title="<?php bloginfo('name'); ?>" rel="home"><h1><?php bloginfo('name'); ?></h1></a></div>

        <?php
        endif;
    }
}

add_action('cleanyeti_header','cleanyeti_blogtitle',3);


if ( function_exists('childtheme_override_blogdescription') )  {
	/**
	 * @ignore
	 */
    function cleanyeti_blogdescription() {
    	childtheme_override_blogdescription();
    }
} else {
    /**
     * Display the blog description within the #branding div
     * 
     * Override: childtheme_override_blogdescription
     */
    function cleanyeti_blogdescription() {
        $blogdescclass = '"subheader"';
    	$blogdesc = '"blog-description">' . get_bloginfo('description', 'display');
        $cleanyeti_options = cleanyeti_get_options();
        if ( 'true' == $cleanyeti_options['display_main_title'] ) {
            echo "\t<h3 class=$blogdescclass id=$blogdesc</h3>\n\n";
            echo '</div>';
        }
    }
}

add_action('cleanyeti_header','cleanyeti_blogdescription',4);

if ( function_exists('childtheme_override_logo_display') )  {
	/**
	 * @ignore
	 */
    function cleanyeti_logo_display() {
    	childtheme_override_logo_display();
    }
} else {
    /**
     * Display the logo 
     * 
     * Override: childtheme_override_logo_display
     */   
    function cleanyeti_logo_display() {
        global $wp_customize, $cleanyeti_options;
        $cleanyetioptions = cleanyeti_get_options();
        $cleanyetilogo = $cleanyetioptions['logo'];
        $logo_position = $cleanyetioptions['logo_position'];
        if ( 'below_menu' == $logo_position ) {
            ?>
            <div class="medium-2 columns"><a href="<?php echo esc_url(home_url()); ?>" rel="home"><img class="th" src='<?php echo $cleanyetilogo; ?>' alt="<?php echo get_bloginfo('name'); ?>"></a></div>
            <?php
        }
    }
}
add_action('cleanyeti_header','cleanyeti_logo_display',5);


if ( function_exists('childtheme_override_brandingclose') )  {
	/**
	 * @ignore
	 */
	 function cleanyeti_brandingclose() {
    	childtheme_override_brandingclose();
    }
} else {
    /**
     * Display the closing of the #branding div
     * 
     * Override: childtheme_override_brandingclose
     */    
    function cleanyeti_brandingclose() {
        $cleanyeti_options = cleanyeti_get_options();
        if ( 'true' == $cleanyeti_options['display_main_title'] )
            echo "\t\t</div><!--  #branding -->\n";
    }
}

add_action('cleanyeti_header','cleanyeti_brandingclose',6);


if ( function_exists('childtheme_override_access') )  {
    /**
	 * @ignore
	 */
	 function cleanyeti_access() {
    	childtheme_override_access();
    }
} else {
    /**
     * Display the #access div
     * 
     * Override: childtheme_override_access
     */    
    function cleanyeti_access() {
    global $cleanyeti_options, $wp_customize;
    $cleanyeti_options = cleanyeti_get_options();
    $sticky = ( ( 'sticky' == $cleanyeti_options['header_top_bar_position'] ) ? ' class="found-sticky"' : '' );
    $menuclass = $cleanyeti_options['header_top_bar_menu_position'];
    $cleanyetilogo = $cleanyeti_options['logo'];
    ?> 
        <div id="access"<?php echo $sticky; ?>>
            <nav class="top-bar" data-topbar>
                <ul class="title-area">
                <!-- Title Area -->
                    <li class="name">
                        <?php if  ( 'with_menu' == $cleanyeti_options['logo_position'] ) : ?><img class="menu-logo" src='<?php echo $cleanyetilogo; ?>' alt="<?php echo get_bloginfo('name'); ?>"><?php endif; ?>
                        <?php if ( 'true' == $cleanyeti_options['display_top_bar_title'] ) : ?><h1><a href="<?php echo esc_url(home_url()); ?>/" title="<?php bloginfo('name'); ?>" rel="home"><?php bloginfo('name'); ?></a></h1><?php endif; ?>
                    </li>
                    <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                    <li class="toggle-topbar menu-icon"><a href="#"><?php _e( 'Menu', 'cleanyeti'); ?></a></li>
                </ul>
                
                <section class="top-bar-section">
<?php 
    	if ( ( function_exists("has_nav_menu") ) && ( has_nav_menu( apply_filters('cleanyeti_primary_menu_id', 'primary-menu') ) ) ) {
    	    echo  wp_nav_menu(cleanyeti_nav_menu_args());
    	}
?>
                </section>             
            </nav>
        </div><!-- #access -->          

<?php
   }
}

add_action('cleanyeti_header','cleanyeti_access',1);

/**
 * Register action hook: cleanyeti_belowheader
 * 
 * Located in header.php, just after the header div
 */
function cleanyeti_belowheader() {
    
    do_action('cleanyeti_belowheader');
} // end cleanyeti_belowheader
?>
