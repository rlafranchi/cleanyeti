<?php

/**
 * Sidebars Extensions
 *
 * @package cleanyetiCoreLibrary
 * @subpackage SidebarExtensions
 */


/**
 * Get the standard sidebar
 *
 * This includes the primary and secondary widget areas. 
 * The sidebar can be switched on or off using cleanyeti_sidebar. <br>
 * Default: ON <br>
 * 
 * Filter: cleanyeti_sidebar
 */
function cleanyeti_sidebar() {
	$show = TRUE;
	$show = apply_filters('cleanyeti_sidebar', $show);
	
	if ($show)
      get_sidebar() . "\n\n";

	return;
} // end cleanyeti_sidebar

/**
 * Opening & closing element for sidebar
 *
 * Width may be changed by editing large-4 to large-*
 * If changed, filter for cleanyeti_container must be applied
 * Filters: cleanyeti_sidebar_open, cleanyeti_sidebar_close
 */
 
function cleanyeti_sidebar_open() {
    global $cleanyeti_options;
    $cleanyeti_options = cleanyeti_get_options();
    $sbpos = $cleanyeti_options['sidebar_position'];
    $sbwidth = $cleanyeti_options['sidebar_width'];
    $pullwidth = 12 - $sbwidth;
    if ( 'left' == $sbpos ) {
        $open = '<div class="medium-' . $sbwidth . ' medium-pull-' . $pullwidth . ' columns">';
    } else {
        $open = '<div class="medium-' . $sbwidth . ' columns">';
    }
    echo apply_filters('cleanyeti_sidebar_open', $open);
}
add_action( 'cleanyeti_abovemainasides', 'cleanyeti_sidebar_open', 1);

function cleanyeti_sidebar_close() {
    $close = '</div>';
    echo apply_filters('cleanyeti_sidebar_close', $close);
}
add_action( 'cleanyeti_belowmainasides', 'cleanyeti_sidebar_close', 99);

/* 
 * Main Aside Hooks
 */


/**
 * Register action hook: cleanyeti_abovemainasides 
 *
 * Located in sidebar.php
 * Just before the main asides (commonly used as sidebars)
 */
function cleanyeti_abovemainasides() {
    do_action('cleanyeti_abovemainasides');
}


/**
 * Register action hook: widget_area_primary_aside 
 *
 * Located in sidebar.php
 * Regular hook for primary widget area
 */
function cleanyeti_widget_area_primary_aside() {
    do_action('widget_area_primary_aside');
}


/**
 * Register action hook: cleanyeti_betweenmainasides 
 *
 * Located in sidebar.php
 * Between the main asides (commonly used as sidebars)
 */
function cleanyeti_betweenmainasides() {
    do_action('cleanyeti_betweenmainasides');
}


/**
 * Register action hook: widget_area_secondary_aside 
 *
 * Located in sidebar.php
 * Regular hook for secondary widget area
 */
function cleanyeti_widget_area_secondary_aside() {
    do_action('widget_area_secondary_aside');
}


/**
 * Register action hook: cleanyeti_belowmainasides 
 *
 * Located in sidebar.php
 * Just after the main asides (commonly used as sidebars)
 */
function cleanyeti_belowmainasides() {
    do_action('cleanyeti_belowmainasides');
}


/*
 * Index Aside Hooks
 */


/*	
 * Register action hook: cleanyeti_aboveindextop 
 *
 * Located in sidebar-index-top.php
 * Just above the 'index.top' widget area
 */
function cleanyeti_aboveindextop() {
	do_action('cleanyeti_aboveindextop');
}


/**
 * Register action hook: widget_area_index_top
 *
 * Located in sidebar.php
 * Regular hook for the 'index.top' widget area
 */
function cleanyeti_widget_area_index_top() {
    do_action('widget_area_index_top');
}

	
/**
 * Register action hook: cleanyeti_belowindextop 
 *
 * Located in sidebar-index-top.php
 * Just below the 'index.top' widget area
 */
function cleanyeti_belowindextop() {
    do_action('cleanyeti_belowindextop');
}


/**
 * Register action hook: cleanyeti_aboveindexinsert 
 *
 * Located in sidebar-index-insert.php
 * Just before the 'index-insert' widget area
 */
function cleanyeti_aboveindexinsert() {
    do_action('cleanyeti_aboveindexinsert');
}


/**
 * Register action hook: widget_area_index_insert
 * 
 * Located in sidebar-index-insert.php
 * Regular hook for the 'index-insert' widget area
 */
function cleanyeti_widget_area_index_insert() {
	do_action('widget_area_index_insert');
}
	
	
/**
 * Register action hook: cleanyeti_belowindexinsert 
 *
 * Located in sidebar-index-insert.php
 * Just after the 'index-insert' widget area
 */
function cleanyeti_belowindexinsert() {
    do_action('cleanyeti_belowindexinsert');
}	


/**
 * Register action hook: cleanyeti_aboveindexbottom 
 *
 * Located in sidebar-index-bottom.php
 * Just above the 'index-bottom' widget area
 */
function cleanyeti_aboveindexbottom() {
    do_action('cleanyeti_aboveindexbottom');
}
	

/**
 * Register action hook: widget_area_index_bottom 
 *
 * Located in sidebar-index-bottom.php
 * Regular hook for the 'index-bottom' widget area
 */	
function cleanyeti_widget_area_index_bottom() {
    do_action('widget_area_index_bottom');
}
	
	
/**
 * Register action hook: cleanyeti_belowindexbottom 
 *
 * Located in sidebar-index-bottom.php
 * Just below the 'index-bottom' widget area
 */	function cleanyeti_belowindexbottom() {
    do_action('cleanyeti_belowindexbottom');
}
	
	
/*
 * Single Post Asides
 */


/**
 * Register action hook: cleanyeti_abovesingletop 
 *
 * Located in sidebar-single-top.php
 * Just above the 'single-top' widget area
 */
function cleanyeti_abovesingletop() {
    do_action('cleanyeti_abovesingletop');
}


/**
 * Register action hook: widget_area_single_top 
 *
 * Located in sidebar-single-top.php
 * Regular hook for the 'single-top' widget area
 */
function cleanyeti_widget_area_single_top() {
    do_action('widget_area_single_top');
}


/**
 * Register action hook: cleanyeti_belowsingletop 
 *
 * Located in sidebar-single-top.php
 * Just below the 'single-top' widget area
 */
function cleanyeti_belowsingletop() {
    do_action('cleanyeti_belowsingletop');
}
	
	
/**
 * Register action hook: cleanyeti_abovesingleinsert 
 *
 * Located in sidebar-single-insert.php
 * Just above the 'single-insert' widget area
 */
function cleanyeti_abovesingleinsert() {
    do_action('cleanyeti_abovesingleinsert');
}


/**
 * Register action hook: widget_area_single_insert 
 *
 * Located in sidebar-single-insert.php
 * Regular hook for the 'single-insert' widget area
 */
function cleanyeti_widget_area_single_insert() {
    do_action('widget_area_single_insert');
}


/**
 * Register action hook: cleanyeti_belowsingleinsert 
 *
 * Located in sidebar-single-insert.php
 * Just below the 'single-insert' widget area
 */
function cleanyeti_belowsingleinsert() {
    do_action('cleanyeti_belowsingleinsert');
}


/**
 * Register action hook: cleanyeti_abovesinglebottom 
 *
 * Located in sidebar-single-bottom.php
 * Just above the 'single-bottom' widget area
 */
function cleanyeti_abovesinglebottom() {
    do_action('cleanyeti_abovesinglebottom');
}


/**
 * Register action hook: widget_area_single_bottom 
 *
 * Located in sidebar-single-bottom.php
 * Regular hook for the 'single-bottom' widget area
 */
function cleanyeti_widget_area_single_bottom() {
    do_action('widget_area_single_bottom');
}


/**
 * Register action hook: cleanyeti_belowsinglebottom 
 *
 * Located in sidebar-single-bottom.php
 * Just below the 'single-bottom' widget area
 */
function cleanyeti_belowsinglebottom() {
    do_action('cleanyeti_belowsinglebottom');
}


/*
 * Page Aside Hooks
 */


/**
 * Register action hook: cleanyeti_abovepagetop 
 *
 * Located in sidebar-page-top.php
 * Just above the 'page-top' widget area
 */
function cleanyeti_abovepagetop() {
    do_action('cleanyeti_abovepagetop');
}


/**
 * Register action hook: widget_area_page_top 
 *
 * Located in sidebar-page-top.php
 * Regular hook for the 'page-top' widget area
 */
function cleanyeti_widget_area_page_top() {
    do_action('widget_area_page_top');
}


/**
 * Register action hook: cleanyeti_belowpagetop 
 *
 * Located in sidebar-page-top.php
 * Just below the 'page-top' widget area
 */
function cleanyeti_belowpagetop() {
    do_action('cleanyeti_belowpagetop');
} // end cleanyeti_belowpagetop


/**
 * Register action hook: cleanyeti_abovepagebottom 
 *
 * Located in sidebar-page-bottom.php
 * Just above the 'page-bottom' widget area
 */
function cleanyeti_abovepagebottom() {
    do_action('cleanyeti_abovepagebottom');
} // end cleanyeti_abovepagebottom


/**
 * Register action hook: widget_area_page_bottom 
 *
 * Located in sidebar-page-bottom.php
 * Regular hook for the 'page-bottom' widget area
 */
function cleanyeti_widget_area_page_bottom() {
    do_action('widget_area_page_bottom');
} // end widget_area_page_bottom


/**
 * Register action hook: cleanyeti_belowpagebottom 
 *
 * Located in sidebar-page-bottom.php
 * Just below the 'page-bottom' widget area
 */
function cleanyeti_belowpagebottom() {
    do_action('cleanyeti_belowpagebottom');
} // end cleanyeti_belowpagebottom	


/*
 * Subsidiary Aside Hooks
 */


/**
 * Register action hook: cleanyeti_abovesubasides 
 *
 * Located in sidebar-subsidiary.php
 * Just above the subsidiary widget areas
 */
function cleanyeti_abovesubasides() {
    do_action('cleanyeti_abovesubasides');
}


/**
 * Register action hook: cleanyeti_belowsubasides 
 *
 * Located in sidebar-subsidiary.php
 * Just below the subsidiary widget areas
 */
function cleanyeti_belowsubasides() {
    do_action('cleanyeti_belowsubasides');
}


/**
 * Open the #subsidiary div
 * 
 * Will only display if there is a widget in one of the subsidiary asides
 */
function cleanyeti_subsidiaryopen() {
    if ( is_active_sidebar('1st-subsidiary-aside') || is_active_sidebar('2nd-subsidiary-aside') || is_active_sidebar('3rd-subsidiary-aside') ) { // one of the subsidiary asides has a widget ?>
        
        <div id="subsidiary" class="row">
        
    <?php
    }
}
add_action('widget_area_subsidiaries', 'cleanyeti_subsidiaryopen', 10);


/**
 * Register action hook: cleanyeti_before_first_sub 
 *
 * Is only available if there is a widget in one of the subsidiary asides
 */
function cleanyeti_before_first_sub() {
    do_action('cleanyeti_before_first_sub');
}


/**
 * Add the cleanyeti_before_first_sub hook within the #subsidiary div
 *
 * Will only add the hook if there is a widget in one of the subsidiary asides
 */
function cleanyeti_add_before_first_sub() {
    if ( is_active_sidebar('1st-subsidiary-aside') || is_active_sidebar('2nd-subsidiary-aside') || is_active_sidebar('3rd-subsidiary-aside') ) { // one of the subsidiary asides has a widget
        cleanyeti_before_first_sub();
    }
}
add_action('widget_area_subsidiaries', 'cleanyeti_add_before_first_sub',20);

	
/**
 * Register action hook: widget_area_subsidiaries 
 *
 * Located in sidebar-subsidiary.php
 * Regular hook for the subsidiary widget areas
 */
function cleanyeti_widget_area_subsidiaries() {
    do_action('widget_area_subsidiaries');
}


/**
 * Register action hook: cleanyeti_between_firstsecond_sub 
 *
 * Is only available if there is a widget in one of the subsidiary asides
 */
function cleanyeti_between_firstsecond_sub() {
    do_action('cleanyeti_between_firstsecond_sub');
}


/**
 * Add the cleanyeti_between_firstsecond_sub hook within the #subsidiary div
 *
 * Will only add the hook if there is a widget in one of the subsidiary asides
 */
function cleanyeti_add_between_firstsecond_sub() {
    if ( is_active_sidebar('1st-subsidiary-aside') || is_active_sidebar('2nd-subsidiary-aside') || is_active_sidebar('3rd-subsidiary-aside') ) { // one of the subsidiary asides has a widget
        cleanyeti_between_firstsecond_sub();
    }
}
add_action('widget_area_subsidiaries', 'cleanyeti_add_between_firstsecond_sub',40);


/**
 * Register action hook: cleanyeti_between_secondthird_sub 
 *
 * Is only available if there is a widget in one of the subsidiary asides
 */
function cleanyeti_between_secondthird_sub() {
    do_action('cleanyeti_between_secondthird_sub');
}


/**
 * Add the cleanyeti_between_secondthird_sub hook within the #subsidiary div
 *
 * Will only add the hook if there is a widget in one of the subsidiary asides
 */
function cleanyeti_add_between_secondthird_sub() {
    if ( is_active_sidebar('1st-subsidiary-aside') || is_active_sidebar('2nd-subsidiary-aside') || is_active_sidebar('3rd-subsidiary-aside') ) { // one of the subsidiary asides has a widget
        cleanyeti_between_secondthird_sub();
    }
}
add_action('widget_area_subsidiaries', 'cleanyeti_add_between_secondthird_sub',60);


/**
 * Register action hook: cleanyeti_after_third_sub 
 *
 * Is only available if there is a widget in one of the subsidiary asides
 */
function cleanyeti_after_third_sub() {
    do_action('cleanyeti_after_third_sub');
}	


/**
 * Add the cleanyeti_after_third_sub hook within the #subsidiary div
 *
 * Will only add the hook if there is a widget in one of the subsidiary asides
 */
function cleanyeti_add_after_third_sub() {
    if ( is_active_sidebar('1st-subsidiary-aside') || is_active_sidebar('2nd-subsidiary-aside') || is_active_sidebar('3rd-subsidiary-aside') ) { // one of the subsidiary asides has a widget
        cleanyeti_after_third_sub();
    }
}
add_action('widget_area_subsidiaries', 'cleanyeti_add_after_third_sub',80);


/**
 * Close the #subsidiary div
 * 
 * Will only display if there is a widget in one of the subsidiary asides
 */
function cleanyeti_subsidiaryclose() {
    if ( is_active_sidebar('1st-subsidiary-aside') || is_active_sidebar('2nd-subsidiary-aside') || is_active_sidebar('3rd-subsidiary-aside') ) { // one of the subsidiary asides has a widget ?>
        
        </div><!-- #subsidiary -->
        
    <?php
    }
}
add_action('widget_area_subsidiaries', 'cleanyeti_subsidiaryclose', 200);