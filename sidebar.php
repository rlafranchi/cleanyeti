<?php 
/**
 * Main Sidebar Template
 *
 * …
 * 
 * @package cleanyeti
 * @subpackage Templates
 */

    // action hook for placing content above the main asides
    cleanyeti_abovemainasides();

    // action hook creating the primary aside
    cleanyeti_widget_area_primary_aside();	
	
    // action hook for placing content between primary and secondary aside
    cleanyeti_betweenmainasides();

    // action hook creating the secondary aside
    cleanyeti_widget_area_secondary_aside();	
	
    // action hook for placing content below the main asides
    cleanyeti_belowmainasides(); 
?>