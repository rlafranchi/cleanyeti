<?php
/**
 * Footer Template
 *
 * This template closes #main div and displays the #footer div.
 *
 * cleanyeti Action Hooks: cleanyeti_abovefooter cleanyeti_belowfooter cleanyeti_after
 * cleanyeti Filters: cleanyeti_close_wrapper can be used to remove the closing of the #wrapper div
 *
 * @package cleanyeti
 * @subpackage Templates
 */
			// action hook for placing content above the closing of the #main div
			cleanyeti_abovemainclose();
		?>

		</div><!-- #main -->

    	<?php
			// action hook for placing content above the footer
			cleanyeti_abovefooter();

			// Filter provided for altering output of the footer opening element
    		echo ( apply_filters( 'cleanyeti_open_footer', '<div id="footer">' ) );
    	?>

        	<?php
        		// action hook creating the footer
        		cleanyeti_footer();
        	?>

		<?php
			// Filter provided for altering output of the footer closing element
    		echo ( apply_filters( 'cleanyeti_close_footer', '</div><!-- #footer -->' . "\n" ) );

   			// action hook for placing content below the footer
			cleanyeti_belowfooter();

			// Filter provided for altering output of wrapping element follows the body tag
			if ( apply_filters( 'cleanyeti_close_wrapper', true ) )
				echo ( '</div><!-- #wrapper .hfeed -->' . "\n" );


			// action hook for placing content before closing the BODY tag
			cleanyeti_after();

        		if ( is_front_page() ) {
				cleanyeti_modal_data();
        		}

		// calling WordPress' footer action hook
		wp_footer();
		?>
	</body>
</html>