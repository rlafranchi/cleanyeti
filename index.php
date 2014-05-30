<?php
/**
 * Index Template
 *
 * This file is required by WordPress to recoginze cleanyeti as a valid theme.
 * It is also the default template WordPress will use to display your web site,
 * when no other applicable templates are present in this theme's root directory
 * that apply to the query made to the site.
 *
 * WP Codex Reference: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package cleanyeti
 * @subpackage Templates
 */

	// calling the header.php
	get_header();

	// action hook for placing content above #container
    cleanyeti_abovecontainer();

		// action hook for placing content above #content
		cleanyeti_abovecontent();

		// filter for manipulating the element that wraps the content
		echo apply_filters( 'cleanyeti_open_id_content', '<div id="content">' . "\n\n" );

		// create the navigation above the content
            	cleanyeti_navigation_above();

            	// action hook for placing content above the index loop
            	cleanyeti_above_indexloop();

            	// action hook creating the index loop
            	cleanyeti_indexloop();

            	// action hook for placing content below the index loop
            	cleanyeti_below_indexloop();

            	// create the navigation below the content
            	cleanyeti_navigation_below();
            ?>

			</div><!-- #content -->

			<?php
				// action hook for placing content below #content
				cleanyeti_belowcontent();
			?>
		</div><!-- #container -->

<?php
	// action hook for placing content below #container
	cleanyeti_belowcontainer();

    // calling the standard sidebar
	cleanyeti_sidebar();

	// calling footer.php
	get_footer();
?>