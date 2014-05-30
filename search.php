<?php
/**
 * Search Template
 *
 * …
 *
 * @package cleanyeti
 * @subpackage Templates
 */

    // calling the header.php
    get_header();

    // action hook for placing content above #container
    cleanyeti_abovecontainer();


		// action hook for inserting contentabove #content
		cleanyeti_abovecontent();

		// filter for manipulating the element that wraps the content
		echo apply_filters( 'cleanyeti_open_id_content', '<div id="content">' . "\n\n" );

		if (have_posts()) {

	                // create the navigation above the content
	                cleanyeti_navigation_above();

	                // action hook for placing content above the search loop
	                cleanyeti_above_searchloop();

	                // action hook creating the search loop
	                cleanyeti_searchloop();

	                // action hook for placing content below the search loop
	                cleanyeti_below_searchloop();

	                // create the navigation below the content
	                cleanyeti_navigation_below();

		} else {

			// action hook for inserting content above #post
			cleanyeti_abovepost();
			?>

				<div id="post-0" class="post noresults">

					<h1 class="entry-title"><?php _e( 'Nothing Found', 'cleanyeti' ) ?></h1>

					<div class="entry-content">

						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'cleanyeti' ) ?></p>

					</div><!-- .entry-content -->
					<?php get_search_form(); ?>

				</div><!-- #post -->

		<?php
		// action hook for inserting content below #post
		cleanyeti_belowpost();
		}
		?>

			</div><!-- #content -->

		<?php
		// action hook for inserting content below #content
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