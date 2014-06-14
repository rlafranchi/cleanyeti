<?php
/**
 *
 * Filters to render content based on options
 *
 */

// filter copyright option
function cleanyeti_copyright_filter( $output ) {
    global $cleanyeti_options;
    $cleanyeti_options = cleanyeti_get_options();
    if ( 'true' == $cleanyeti_options['display_custom_copyright'] ) {
        $output = $cleanyeti_options['copyright_text'];
        return $output;
    } elseif ( 'default' == $cleanyeti_options['display_custom_copyright'] ) {
        return $output;
    } else {
        $output = '';
        return $output;
    }
}
add_filter('cleanyeti_copyright', 'cleanyeti_copyright_filter' );

// credit action
function cleanyeti_credits() {
    global $cleanyeti_options;
    $cleanyeti_options = cleanyeti_get_options();
    if ( 'true' == $cleanyeti_options['display_footer_credit'] ) :
    ?>
    <div class="row">
        <div class="medium-12 columns text-center" id="footer-credits">
            <p><?php _e( 'Powered by', 'cleanyeti' ); ?>: <a href="http://wordpress.org" rel="generator" title="WordPress">WordPress</a> <?php _e( 'Themed by', 'cleanyeti' ); ?>: <a href="http://www.serenethemes.com" title="Serene Themes"><?php _e( 'Serene Themes', 'cleanyeti' ); ?></a></p>
        </div>
    </div>
    <?php
    endif;
}
add_action( 'cleanyeti_footer', 'cleanyeti_credits', 999 );

function cleanyeti_orbit_slider_content() {

    $orbitoptions = cleanyeti_get_options();
    $orbitselect = $orbitoptions['no_slides'];
    $orbitdisplay = $orbitoptions['display_orbit'];
    $orbit_lib  = $orbitoptions['orbit'];                       
    if ( ( 'true' == $orbitdisplay ) && is_front_page() && ( 1 == $orbit_lib ) ) : ?>
        <div class="row show-for-medium-up">
            <div class="medium-12 columns">
                <ul data-orbit>
<?php 

        $orbitmin=1;
        while ( $orbitmin <= $orbitselect ) :
            $orbitimage     = $orbitoptions['orbit_image_' . $orbitmin];
            $orbitpage      = $orbitoptions['orbit_page_link_' . $orbitmin];
            $orbitpage_data = get_page( $orbitpage );

            if ($orbitpage != 0 ) : ?>
                    <li>
                        <a href="#" data-reveal-id="orbit_page<?php echo $orbitmin;?>"><img src=<?php if ($orbitimage == true){echo $orbitimage;}else{echo get_template_directory_uri() . '/library/Images/foundation4-z-1440x900.png';}?> /></a>
                        <div class="orbit-caption"><h5><?php echo $orbitpage_data->post_title;?></h5></div>
                    </li>
            <?php else : ?>
                    <li>
                        <a href="#" data-reveal-id="orbit_page_nopage"><img src="<?php if ($orbitimage == true){echo $orbitimage;}else{echo get_template_directory_uri() . '/library/Images/foundation4-z-1440x900.png';}?>" /></a>
                        <div class="orbit-caption"><h5><?php _e( 'Choose a Page to Link to.', 'cleanyeti' ); ?></h5></div>
                    </li>
<?php
                endif;
            $orbitmin++;
        endwhile;
?>
                </ul><!--Orbit-Slider-->
            </div>   
        </div>  
<?php
    endif;
}
add_action('cleanyeti_belowheader', 'cleanyeti_orbit_slider_content');

function cleanyeti_get_excerpt_by_id($post_id) {
    $the_post       = get_page($post_id); //Gets post ID
    $the_excerpt    = ( isset( $the_post->post_content ) ? $the_post->post_content : __( 'No Post Content', 'cleanyeti' ) ); //Gets post_content to be used as a basis for the excerpt
    $excerpt_length = 50; //Sets excerpt length by word count
    $the_excerpt    = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words          = explode(' ', $the_excerpt, $excerpt_length + 1);

    if ( count( $words ) > $excerpt_length ) :
        array_pop( $words );
        array_push( $words, '&hellip;');
        $the_excerpt = implode(' ', $words );
    endif;

    $the_excerpt = '<p>' . $the_excerpt . '</p>';

    return $the_excerpt;
}

function cleanyeti_modal_data() {

    $orbitoptions    = cleanyeti_get_options();
    $orbitnoslides = $orbitoptions['no_slides'];
    $orbitpagemin    = 1;
    while ( $orbitpagemin <= $orbitnoslides ) {
        $orbitpage      = $orbitoptions['orbit_page_link_' . $orbitpagemin ];
        $orbitpage_data = get_page( $orbitpage );
        $modalexcerpt   = cleanyeti_get_excerpt_by_id( $orbitpage );
        if ( $orbitpage != 0 ) : ?>
<div id="orbit_page<?php echo $orbitpagemin; ?>" class="reveal-modal" data-reveal>
    <h2><?php echo $orbitpage_data->post_title; ?></h2>
    <div class="panel radius"><p><?php echo $modalexcerpt; ?></p></div>
    <a class="secondary button radius" href="<?php echo get_permalink( $orbitpage_data ); ?>"><?php _e( 'Read More', 'cleanyeti' ); ?></a>
    <a class="close-reveal-modal">&#215;</a>
</div>
<?php
        endif;
        $orbitpagemin++;
    }
?>    
<div id="orbit_page_nopage" class="reveal-modal" data-reveal>
    <h2><?php _e( 'Page Title will show here', 'cleanyeti' ); ?></h2>
    <p><?php _e( 'Choose a page to link to on the theme customizer page.  The first few lines of the page\'s content will show here.  This element is called a modal which is just one of the great Foundation features devoloped by Zurb.  For more info feel free to visit ', 'cleanyeti' ); ?><a href="http://foundation.zurb.com" target="blank">foundation.zurb.com.</a></p>
    <a class="secondary button radius" href="<?php echo esc_url(home_url()) . '/wp-admin/customize.php'; ?>"><?php _e( 'Customize', 'cleanyeti' ); ?></a>
    <a class="close-reveal-modal">&#215;</a>
</div>
<?php
}

/**
 * render flexible_menu
 */
function cleanyeti_flexible_menu( $menu_args = array() ) {
    $options = cleanyeti_get_options();
    $flexpos = $options['flex_menu_position'];
    $menu_args = array(
      'theme_location'        => 'cleanyeti_flex_menu',
      'container'             => false,
      'menu_class'            => 'inline-list ' . $flexpos,
      'fallback_cb'           => false,
      'echo'                  => false,
      'depth'                 => 1
	  );
    $output = '<div class="row" id="cleanyeti-flexible-menu">';
    $output .= '<div class="medium-12 columns">';
    $output .= wp_nav_menu( $menu_args );
    $output .= '</div>';
    $output .= '</div>';
    echo apply_filters( 'cleanyeti_flexible_menu', $output, $menu_args );
}
$cy_options = cleanyeti_get_options();
$flex_hook = $cy_options['flex_menu_location'];
if ( $flex_hook == 'belowwidgets' ) {
    add_action( 'cleanyeti_footer', 'cleanyeti_flexible_menu', 15 );
} else {
    add_action( 'cleanyeti_' . $flex_hook, 'cleanyeti_flexible_menu' );
}
?>