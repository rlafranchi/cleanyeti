<?php $data = array(); $data = $_POST; ?>
/* <?php echo rand( 1, 999999999 ); ?> */
@import "foundation/functions";
$rem-base: 16px;
$row-width: rem-calc(<?php echo $data['max_width']; ?>);

/* Top Bar */
$topbar-sticky-class: ".found-sticky";


$topbar-bg-color: <?php echo $data['topbar_bg']; ?>;
$topbar-dropdown-bg: $topbar-bg-color;
$topbar-dropdown-link-bg: $topbar-bg-color;

// $topbar-link-color: #fff;
// $topbar-link-color-hover: #fff;
// $topbar-link-color-active: #fff;
// $topbar-link-color-active-hover: #fff;

$topbar-link-bg-hover: scale-color($topbar-bg-color, $lightness: -14%);
$topbar-dropdown-label-bg: $topbar-bg-color;


/* Colors */
$primary-color: <?php echo $data['primary']; ?>;
$secondary-color: <?php echo $data['secondary']; ?>;
$cyb-header-bg-color: <?php echo $data['header_color']; ?>;
$cyb-footer-bg-color: <?php echo $data['footer_color']; ?>;