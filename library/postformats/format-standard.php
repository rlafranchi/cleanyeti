<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * For displaying content in the standard post format
 *
 */
 ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >                                   

	                        <?php cleanyeti_postheader();?>

					<div class="row">

						<div class="entry-content large-12 columns">
					
						<?php cleanyeti_content(); ?>

						</div><!-- .entry-content -->
    					
					</div>


					<?php  cleanyeti_postfooter(); ?>

				</div><!-- #post -->