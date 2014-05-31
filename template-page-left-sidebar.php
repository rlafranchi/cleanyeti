<?php
/**
 * Template Name: Left Sidebar
 *
 * This is an option overide template to display the sidebar on the left for pages.
 *
 * @package cleanyeti
 * @subpackage Templates
 */

	// calling the header.php
	get_header();

	// action hook for placing content above #container
	cleanyeti_abovecontainer();
	
	  // call the left sidebar
	  cleanyeti_sidebar();

		// action hook for inserting content above #content
		cleanyeti_abovecontent();

		// filter for manipulating the element that wraps the content
		echo apply_filters( 'cleanyeti_open_id_content', '<div id="content">' . "\n\n" );


		// start the loop
		while ( have_posts() ) : the_post();

			// action hook for inserting content above #post
			cleanyeti_abovepost();
			?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

				<?php

			// creating the post header
			cleanyeti_postheader();
			?>

					<div class="entry-content">

			<?php

			cleanyeti_insert_featured_image();

			the_content( cleanyeti_more_text() );

			if ( function_exists( 'cleanyeti_numerical_link_pages' )) {
				    cleanyeti_numerical_link_pages( array (
                        'before' => sprintf('<div class="pagination-centered"><ul class="page-numbers">%s', __('<li class="unavailable">Pages:<li>', 'cleanyeti')),
						'after'  => '</ul></div>'
                    ));
                } else {
                    wp_link_pages();
                }
			echo cleanyeti_pageeditlink();
			?>

					</div>

				</div><!-- .post -->

				<?php
				// calls the do_action for inserting content below #post
				cleanyeti_belowpost();
				
				cleanyeti_comments_template();

		// end loop
		endwhile;

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

	// calling footer.php
	get_footer();
?>