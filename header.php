<?php
/**
 * Header Template
 *
 * This template calls a series of functions that output the head tag of the document.
 * The body and div #main elements are opened at the end of this file.
 *
 * @package cleanyeti
 * @subpackage Templates
 */

	// Create doctype
	cleanyeti_create_doctype();

	// Opens the head tag
	cleanyeti_head_profile();

	// Create the meta content type
	cleanyeti_create_contenttype();

	// Create the title tag
	cleanyeti_doctitle();

	// Legacy feedlink handling
	if ( current_theme_supports( 'cleanyeti_legacy_feedlinks' ) ) {
		// Creating the internal RSS links
		cleanyeti_show_rss();
	}

	// Create pingback adress
	cleanyeti_show_pingback();

	/* The function wp_head() loads cleanyeti's stylesheet and scripts.
	 * Calling wp_head() is required to provide plugins and child themes
	 * the ability to insert markup within the <head> tag.
	 */
	wp_head();
?>
</head>

<?php
	// Create the body element and dynamic body classes
	cleanyeti_body();

	// Action hook to place content before opening #wrapper
	cleanyeti_before();
?>
	<?php
		// Filter provided for removing output of wrapping element follows the body tag
		echo ( apply_filters( 'cleanyeti_open_wrapper', '<div id="wrapper" class="hfeed site-wrapper">' ) );

		// Action hook for placing content above the theme header
		cleanyeti_aboveheader();
	?>


		<?php
			// Filter provided for altering output of the header opening element
			echo ( apply_filters( 'cleanyeti_open_header',  '<div id="header">' ) );
    	?>


        	<?php
				// Action hook creating the theme header
				cleanyeti_header();
       		?>

    	<?php
    		// Filter provided for altering output of the header closing element
			echo ( apply_filters( 'cleanyeti_close_header', '</div><!-- #header-->' ) );
		?>

    	<?php
			// Action hook for placing content below the theme header
			cleanyeti_belowheader();
    	?>

	<div id="main" class="row">
