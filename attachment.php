<?php
/**
 * Attachments Template
 *
 * Displays singular WordPress Media Library items.
 *
 * @package cleanyeti
 * @subpackage Templates
 *
 * @link http://codex.wordpress.org/Using_Image_and_File_Attachments Codex:Using Attachments
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


				// action hook for placing content above #post
				cleanyeti_abovepost();
				?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
					<div class="row">
						<div class="large-12 columns">
				<?php
				// creating the post header
				cleanyeti_postheader();
				?>
						</div>

					</div>
					<div class="entry-content">

						<div class="entry-attachment text-center panel radius"><?php the_attachment_link( $post->ID, true ) ?></div>

	                        <?php
				the_content( cleanyeti_more_text() );

				cleanyeti_numerical_link_pages(array('before' => sprintf('<div class="pagination-centered"><ul class="page-numbers">%s', __('<li class="unavailable">Pages:<li>', 'cleanyeti')),
													'after' => '</ul></div>' ));
	                        ?>

						<div class="row">
							<div class="large-12 columns">
								<ul id="image-nav-below" class="image-nav small-block-grid-2">
									<li><div class="image-previous left"><?php previous_image_link(); ?><p><?php previous_image_link( 'thumbnail', '&laquo; Previous' ); ?></p></div></li>
									<li><div class="image-next right"><?php next_image_link(); ?><p class="text-right"><?php next_image_link( 'thumbnaial', 'Next &raquo;' ); ?></p></div></li>
								</ul>
							</div>
						</div>

					</div><!-- .entry-content -->

				<?php cleanyeti_postfooter(); ?>

				</div><!-- #post -->


				<?php
				// action hook for placing contentbelow #post
				cleanyeti_belowpost();

       				// action hook for calling the comments_template
				cleanyeti_comments_template();

			// end loop
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