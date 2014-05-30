<?php
/**
 * Single Post Template
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

	// action hook for placing content above #content
	cleanyeti_abovecontent();

	// filter for manipulating the element that wraps the content
	echo apply_filters( 'cleanyeti_open_id_content', '<div id="content">' . "\n\n" );

	// start the loop
	while ( have_posts() ) : the_post();

		// create the navigation above the content
		cleanyeti_navigation_above();

		// action hook creating the single post
		cleanyeti_singlepost();

		// create the navigation below the content
		cleanyeti_navigation_below();

		// action hook for calling the comments_template
		cleanyeti_comments_template();

	// end the loop
	endwhile;

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