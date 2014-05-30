<?php
/**
 * Category Template
 *
 * Displays an archive index of posts assigned to a Category.
 *
 * @package cleanyeti
 * @subpackage Templates
 *
 * @link http://codex.wordpress.org/Category_Templates Codex: Category Templates
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

			// action hook for placing content above the category loop
			cleanyeti_above_categoryloop();

			// action hook creating the category loop
			cleanyeti_categoryloop();

			// action hook for placing content below the category loop
			cleanyeti_below_categoryloop();

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