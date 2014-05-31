<?php
/**
 * Sidebar for two left and right sidebar page template
 *
 */
    
    // action hook for placing content above the main asides
    cleanyeti_aboveleftaside();

    // action hook creating the primary aside
    cleanyeti_widget_area_left_aside();	
	
    // action hook for placing content between primary and secondary aside
    cleanyeti_belowleftaside();
    
?>