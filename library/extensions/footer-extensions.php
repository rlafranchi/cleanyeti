<?php
/**
 * Footer Extensions
 *
 * @package cleanyetiCoreLibrary
 * @subpackage FooterExtensions
 */
 
/**
 * Register action hook: cleanyeti_abovemainclose
 * 
 * Located in footer.php, just before the closing of the main div
 */
function cleanyeti_abovemainclose() {
    do_action('cleanyeti_abovemainclose');
} // end cleanyeti_belowmainsidebar


/**
 * Register action hook: cleanyeti_abovefooter
 * 
 * Located in footer.php, just before the footer div
 */
function cleanyeti_abovefooter() {
    do_action('cleanyeti_abovefooter');
} // end cleanyeti_abovefooter


/**
 * Register action hook: cleanyeti_footer
 * 
 * Located in footer.php, inside the footer div
 */
function cleanyeti_footer() {
    do_action('cleanyeti_footer');
} // end cleanyeti_footer


/**
 * Register action hook: cleanyeti_belowfooter
 * 
 * Located in footer.php, just after the footer div
 */
function cleanyeti_belowfooter() {
    do_action('cleanyeti_belowfooter');
} // end cleanyeti_belowfooter


/**
 * Register action hook: cleanyeti_after
 * 
 * Located in footer.php, just before the closing body tag, after everything else.
 */
function cleanyeti_after() {
    do_action('cleanyeti_after');
} // end cleanyeti_after


if (function_exists('childtheme_override_subsidiaries'))  {
	/**
	 * @ignore
	 */
	function cleanyeti_subsidiaries() {
		childtheme_override_subsidiaries();
	}
} else {
	/**
	 * Create the subsidiary widgets areas in footer
	 * 
	 * Override: childtheme_override_subsidiaries
	 */
	function cleanyeti_subsidiaries() {
	      	
		// action hook for placing content above the subsidiary widget areas
		cleanyeti_abovesubasides();
		
		// action hook for creating the subsidiary widget areas
		cleanyeti_widget_area_subsidiaries();
		
		// action hook for placing content below subsidiary widget areas
		cleanyeti_belowsubasides();
   	}
}

add_action('cleanyeti_footer', 'cleanyeti_subsidiaries', 10);

/*
* Copyright code, courtesy of Chip Bennett
* http://wordpress.stackexchange.com/questions/14492/how-do-i-create-a-dynamically-updated-copyright-statement
*/
function cleanyeti_copyright() {
    global $wpdb;
    $copyright_dates = $wpdb->get_results("
        SELECT
            YEAR(min(post_date_gmt)) AS firstdate,
            YEAR(max(post_date_gmt)) AS lastdate
        FROM
            $wpdb->posts
        WHERE
            post_status = 'publish' AND
            post_date_gmt != '0000-00-00 00:00:00'
    ");
    $output = '';
    if($copyright_dates) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
            if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
                $copyright .= '-' . $copyright_dates[0]->lastdate;
            }
        $output = $copyright;
        $output .= ' ' . get_bloginfo( 'name' );
    }
    return apply_filters( 'cleanyeti_copyright', $output);
}

function cleanyeti_footer_menu_display() {
   ?>
<div class="row">
	<div class="large-4 columns">
    	<p class="copyright"><?php echo cleanyeti_copyright(); ?></p>
   </div>
	<div class="large-8 columns">
	<?php 
	wp_nav_menu( array(
	'theme_location'        => 'cleanyeti_footer_menu',
	'container'             => false,
	'menu_class'            => 'right inline-list footerlink',
	'fallback_cb'           => false,
	'depth'                 => 1
	 ) );
	 ?>
	 </div>
</div>
<?php
}
add_action( 'cleanyeti_footer', 'cleanyeti_footer_menu_display', 25);
?>