<?php
/**
 * SCSS compiler that uses $wp_filesystem to write scss settings to css file
 */

function cleanyeti_scss_compile() {
	global $wp_customize;
	if (empty($_POST)) return;
	if ( $_POST['action'] != 'update' ) return;
	$current = cleanyeti_get_current_tab();

    check_admin_referer('theme_cleanyeti_options-options');
    $preview = '';
    $url = wp_nonce_url('themes.php?page=cleanyeti-settings&tab=' . $current, 'theme_cleanyeti_options-options');
    $form_fields = ( isset( $_POST['theme_cleanyeti_options'] ) ? $_POST['theme_cleanyeti_options'] : array() );

	$method = '';
	$valid_fields = cleanyeti_options_validate( $form_fields );

    if (false === ($creds = request_filesystem_credentials($url, $method, false, false, $valid_fields) ) ) {
        return true;
    }

    if ( ! WP_Filesystem($creds) ) {
        request_filesystem_credentials($url, $method, true, false, $valid_fields);
        return true;
    }
    update_option( 'theme_cleanyeti_options', $valid_fields );

    $scsspath = get_stylesheet_directory() . '/library/Foundation/scss/';
    $scssname = $scsspath . '_cleanyeti.scss';
    $csspath = get_stylesheet_directory() . '/library/Foundation/css/';
    $cssname = $csspath . 'cleanyeti.css';

    ob_start();
    require( $scsspath . 'settings.php');
    $scss = ob_get_clean();

    global $wp_filesystem;
    if ( ! $wp_filesystem->put_contents( $scssname, $scss, FS_CHMOD_FILE) ) {
        echo "error saving scss file!";
    }

    $scss = new Cyb_Scssc();
    $scss->setImportPaths( $scsspath );
    $scss->setFormatter("Cyb_Scss_Formatter");

    $css = $scss->compile('
        @import "cleanyeti-app.scss"
    ');
    if ( ! $wp_filesystem->put_contents( $cssname, $css, FS_CHMOD_FILE) ) {
        echo "error saving css file!";
    }
}

function cleanyeti_preview_ajax_script() {
    global $wp_customize;
    if ( ! isset( $wp_customize ) ) return;
    
    $nonce = $_POST['nonce'];
    $customizers = json_decode( wp_unslash( $_POST['customized'] ), true );
    $max_width = $customizers['theme_cleanyeti_options[max_width]'];
    $header_color = $customizers['theme_cleanyeti_options[header_color]'];
    $footer_color = $customizers['theme_cleanyeti_options[footer_color]'];
    $primary = $customizers['theme_cleanyeti_options[primary]'];
    $secondary = $customizers['theme_cleanyeti_options[secondary]'];
    $topbar_bg = $customizers['theme_cleanyeti_options[topbar_bg]'];
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
            var data = {
                action: 'cyb_ajax',
                nonce: '<?php echo $nonce; ?>',
                max_width: '<?php echo $max_width; ?>',
                header_color: '<?php echo $header_color; ?>',
                footer_color: '<?php echo $footer_color; ?>',
                primary: '<?php echo $primary; ?>',
                secondary: '<?php echo $secondary; ?>',
                topbar_bg: '<?php echo $topbar_bg; ?>'
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            $.post(ajaxurl, data, function(response) {
                console.log(response);
            });
        });
    </script>
    
    <?php
}
add_action( 'wp_footer', 'cleanyeti_preview_ajax_script', 10, 2 );

function cleanyeti_ajax_callback() {
    global $wpdb;
    if ( ! wp_verify_nonce( $_POST['nonce'], 'preview-customize_cleanyeti' ) ) return;
    $url = wp_nonce_url('customize.php', 'preview-customize_cleanyeti');
    $method = '';
    $creds = unserialize(get_theme_mod('cyb_creds'));
    
    if ( ! WP_Filesystem($creds) ) {
        request_filesystem_credentials($url, $method, true, false, null);
        print_r( $creds );
    }

    $scsspath = get_stylesheet_directory() . '/library/Foundation/scss/';
    $scssname = $scsspath . '_cleanyetipreview.scss';
    $csspath = get_stylesheet_directory() . '/library/Foundation/css/';
    $cssname = $csspath . 'cleanyetipreview.css';

    ob_start();
    require( $scsspath . 'preview-settings.php');
    $scss = ob_get_clean();


    // by this point, the $wp_filesystem global should be working, so let's use it to create a file
    global $wp_filesystem;
    if ( ! $wp_filesystem->put_contents( $scssname, $scss, FS_CHMOD_FILE) ) {
       return;
    }

    $scss = new Cyb_Scssc();
    $scss->setImportPaths( $scsspath );
    $scss->setFormatter("Cyb_Scss_Formatter");

    $css = $scss->compile('
        @import "cleanyeti-app-preview.scss"
    ');
    if ( ! $wp_filesystem->put_contents( $cssname, $css, FS_CHMOD_FILE) ) {
        return;
    }
	exit;
}
add_action( 'wp_ajax_cyb_ajax', 'cleanyeti_ajax_callback' );
//add_action( 'wp_ajax_nopriv_ajax', 'cleanyeti_ajax_callback' );


function cleanyeti_scss_compile_save() {
	global $wp_customize;

	$current = cleanyeti_get_current_tab();
    $url = wp_nonce_url('customize.php', 'save-customize_'. $wp_customize->get_stylesheet() );
	$method = '';

    if (false === ($creds = request_filesystem_credentials($url, $method, false, false, null) ) ) {
        return true; // stop the normal page form from displaying
    }

    if ( ! WP_Filesystem($creds) ) {
        request_filesystem_credentials($url, $method, true, false, null);
        return true;
    }

    $scsspath = get_stylesheet_directory() . '/library/Foundation/scss/';
    $scssname = $scsspath . '_cleanyeti.scss';
    $csspath = get_stylesheet_directory() . '/library/Foundation/css/';
    $cssname = $csspath . 'cleanyeti.css';

    ob_start();
    require( $scsspath . 'settings.php');
    $scss = ob_get_clean();


    // by this point, the $wp_filesystem global should be working, so let's use it to create a file
    global $wp_filesystem;
    if ( ! $wp_filesystem->put_contents( $scssname, $scss, FS_CHMOD_FILE) ) {
        echo "error saving scss file!";
    }

    $scss = new Cyb_Scssc();
    $scss->setImportPaths( $scsspath );
    $scss->setFormatter("Cyb_Scss_Formatter");

    $css = $scss->compile('
        @import "cleanyeti-app.scss"
    ');
    if ( ! $wp_filesystem->put_contents( $cssname, $css, FS_CHMOD_FILE) ) {
        echo "error saving css file!";
    }
}
add_action('customize_save_after','cleanyeti_scss_compile_save');

function cyb_controls_init() {
    global $wp_customize;
    if ( !isset( $wp_customize ) ) return;
    $url = wp_nonce_url('customize.php', 'preview-customize_'. $wp_customize->get_stylesheet() );
	$method = '';
    
    if (false === ($creds = request_filesystem_credentials($url, $method, false, false, null) ) ) {
        return; // stop the normal page form from displaying
    }

    if ( ! WP_Filesystem($creds) ) {
        request_filesystem_credentials($url, $method, true, false, null);
        return;
    }
    set_theme_mod( 'cyb_creds', serialize($creds) );
}
add_action( 'customize_controls_init', 'cyb_controls_init' );

function cleanyeti_clear_creds() {
    global $wp_customize;
    $creds = unserialize( get_theme_mod( 'cyb_creds' ) );
    if ( ! isset( $wp_customize) && isset( $creds ) ) {
        remove_theme_mod( 'cyb_creds' );
    }
}
add_action( 'init', 'cleanyeti_clear_creds' );
?>