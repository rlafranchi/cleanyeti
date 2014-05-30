<?php
/**
 * Archive Template
 *
 * Displays an Archive index of post-type items. Other more specific archive templates
 * may override the display of this template for example the category.php.
 *
 * @package cleanyeti
 * @subpackage Templates
 *
 * @link http://codex.wordpress.org/Template_Hierarchy Codex: Template Hierarchy
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

			// action hook for placing content above the archive loop
			cleanyeti_above_archiveloop();

			// action hook creating the archive loop
			cleanyeti_archiveloop();

			// action hook for placing content below the archive loop
			cleanyeti_below_archiveloop();

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