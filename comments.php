<?php
/**
 * Comments Template
 *
 * Lists the comments and displays the comments form.
 *
 * @package cleanyeti
 * @subpackage Templates
 *
 * @todo chase the invalid counts & pagination for comments/trackbacks
 * @todo remove the cleanyeti_COMPATIBLE_COMMENT_FORM condition to a legacy function for template berevity
 */
?>
				<?php
					// action hook for inserting content above #comments
					cleanyeti_abovecomments()
				?>

				<div id="comments">

				<?php
					// Disable direct access to the comments script
					if ( 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
					    die ( __('Please do not load this page directly.', 'cleanyeti')  );

					// Set required varible from options
					$req = get_option('require_name_email');

					// Check post password and cookies
					if ( post_password_required() ) :
				?>

					<div class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'cleanyeti') ?></div>

				</div><!-- #comments -->

				<?php
						return;
					endif;

				?>

				<?php if ( have_comments() ) : ?>

					<?php
						// Collect the comments and pings
						$cleanyeti_comments = $wp_query->comments_by_type['comment'];
						$cleanyeti_pings = $wp_query->comments_by_type['pings'];

						// Calculate the total number of each
						$cleanyeti_comment_count = count( $cleanyeti_comments );
						$cleanyeti_ping_count = count( $cleanyeti_pings );

						// Get the page count for each
						$cleanyeti_comment_pages = get_comment_pages_count( $cleanyeti_comments );
						$cleanyeti_ping_pages = get_comment_pages_count( $cleanyeti_pings );

						// Determine which is the greater pagination number between the two (comment,ping) paginations
						$cleanyeti_max_response_pages = ( $cleanyeti_ping_pages > $cleanyeti_comment_pages ) ? $cleanyeti_ping_pages : $cleanyeti_comment_pages;

						// Reset the query var to use our calculation for the maximum page (newest/oldest)
						if ( $overridden_cpage )
							set_query_var( 'cpage', 'newest' == get_option('default_comments_page') ? $cleanyeti_comment_pages : 1 );
					?>

					<?php if ( ! empty( $comments_by_type['comment'] ) ) : ?>

					<?php
						// action hook for inserting content above #comments-list
						cleanyeti_abovecommentslist() ;
					?>

						<?php if ( get_query_var('cpage') <= $cleanyeti_comment_pages )  : ?>

					<div id="comments-list-wrapper" class="comments">

						<h3><?php printf( $cleanyeti_comment_count > 1 ? __( cleanyeti_multiplecomments_text(), 'cleanyeti' ) : __( cleanyeti_singlecomment_text(), 'cleanyeti' ), $cleanyeti_comment_count ) ?></h3>

						<ol id="comments-list" >
							<?php wp_list_comments( cleanyeti_list_comments_arg() ); ?>
						</ol>

					</div><!-- #comments-list-wrapper .comments -->

						<?php endif; ?>

					<?php
						// action hook for inserting content below #comments-list
						cleanyeti_belowcommentslist()
					?>

					<?php endif; ?>

					<div id="comments-nav-below" class="comment-navigation">

	        			<div class="pagination-centered"><?php paginate_comments_links( array('total=' . $cleanyeti_max_response_pages, 'type' => 'list', 'prev_text' => '&laquo;', 'next_text' => '&raquo;' ) ); ?></div>

	                </div>

					<?php if ( ! empty( $comments_by_type['pings'] ) ) : ?>

					<?php
						// action hook for inserting content above #trackbacks-list-wrapper
						cleanyeti_abovetrackbackslist();
					?>

						<?php if ( get_query_var('cpage') <= $cleanyeti_ping_pages ) : ?>

					<div id="pings-list-wrapper" class="pings">

						<h3><?php printf( $cleanyeti_ping_count > 1 ? '<span>%d</span> ' . __( 'Trackbacks', 'cleanyeti' ) : sprintf( _x( '%1$sOne%2$s Trackback', '%1$ and %2$s are <span> tags', 'cleanyeti' ), '<span>', '</span>' ), $cleanyeti_ping_count ) ?></h3>

						<ul id="trackbacks-list">
							<?php wp_list_comments( 'type=pings&callback=cleanyeti_pings' ); ?>
						</ul>

					</div><!-- #pings-list-wrapper .pings -->

						<?php endif; ?>

					<?php
						// action hook for inserting content below #trackbacks-list
						cleanyeti_belowtrackbackslist();
					?>

					<?php endif; ?>

				<?php endif; ?>

			<?php
				if ( 'open' == $post->comment_status ) :
					if ( current_theme_supports( 'cleanyeti_legacy_comment_form' ) ) {

						cleanyeti_legacy_comment_form();

					} else {

						// action hook for inserting content above #commentform
						cleanyeti_abovecommentsform();

						comment_form( cleanyeti_comment_form_args() );

						// action hook for inserting content below #commentform
						cleanyeti_belowcommentsform();

					}
				endif /* if ( 'open' == $post->comment_status ) */
						?>

				</div><!-- #comments -->

				<?php
					// action hook for inserting content below #comments
					cleanyeti_belowcomments()
				?>