<?php
/**
 * Discussion Extensions
 *
 * @package cleanyetiCoreLibrary
 * @subpackage DiscussionExtensions
 */
 
if (function_exists('childtheme_override_commentmeta'))  {
	/**
	 * @ignore
	 */
	function cleanyeti_commentmeta() {
		childtheme_override_commentmeta();
	}
} else {
	/**
	 * Create comment meta
	 * 
	 * Located in discussion.php
	 * 
	 * Override: childtheme_override_commentmeta <br>
	 * Filter: cleanyeti_commentmeta
	 */
	function cleanyeti_commentmeta($print = TRUE) {
		$content = '<div class="comment-meta">' . 
					sprintf( _x('Posted %s at %s', 'Posted {$date} at {$time}', 'cleanyeti') , 
						get_comment_date(),
						get_comment_time() );

		$content .= ' <span class="meta-sep">|</span> ' . sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', '#comment-' . get_comment_ID() , __( 'Permalink to this comment', 'cleanyeti' ), __( 'Permalink', 'cleanyeti' ) );
							
		if ( get_edit_comment_link() ) {
			$content .=	sprintf(' <span class="meta-sep">|</span><span class="edit-link"> <a class="comment-edit-link" href="%1$s" title="%2$s">%3$s</a></span>',
						get_edit_comment_link(),
						__( 'Edit comment' , 'cleanyeti' ),
						__( 'Edit', 'cleanyeti' ) );
			}
		
		$content .= '</div>' . "\n";
			
		return $print ? print(apply_filters('cleanyeti_commentmeta', $content)) : apply_filters('cleanyeti_commentmeta', $content);

	} // end cleanyeti_commentmeta
}

/**
 * Register action hook: cleanyeti_abovecomment
 * 
 * Located in discussion.php, at the beginning of the li#comment-[id] element.
 * Note that this is *per comment*
 */
function cleanyeti_abovecomment() {
	do_action('cleanyeti_abovecomment');
}

/**
 * Register action hook: cleanyeti_belowcomment
 * 
 * Located discussion.php, just after the comment reply link.
 * Note that this is *per comment*:
 */
function cleanyeti_belowcomment() {
	do_action('cleanyeti_belowcomment');
}

?>