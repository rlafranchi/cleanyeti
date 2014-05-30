<?php
/**
 * Error 404 Page Template
 *
 * Displays a "Not Found" message and a search form when a 404 Error is encountered.
 *
 * @package cleanyeti
 * @subpackage Templates
 *
 * @link http://codex.wordpress.org/Creating_an_Error_404_Page Codex: Create a 404 Page
 */

	// calling the header.php
	get_header();

	// action hook for placing content above #container
	cleanyeti_abovecontainer();

				// action hook for placing content above #content includes #container
				cleanyeti_abovecontent();

				// filter for manipulating the element that wraps the content
				echo apply_filters( 'cleanyeti_open_id_content', '<div id="content">' . "\n\n" );

				// action hook for placing content above #post
				cleanyeti_abovepost();
				?>

				<div id="post-0" class="post error404">

				<?php
				// action hook for placing the 404 content
				cleanyeti_404()
				?>

				</div><!-- .post -->

				<?php
					// action hook for placing content below #post
					cleanyeti_belowpost();
				?>

			</div><!-- #content -->

			<?php
				// action hook for placing content below #content
				cleanyeti_belowcontent();
			?>

		</div><!-- #container -->

			<?php
			//calling the standard sidebar
			cleanyeti_sidebar();
			?>
    </div>

<?php
	// action hook for placing content below #container
	cleanyeti_belowcontainer();
	// calling footer.php
	get_footer();
?>