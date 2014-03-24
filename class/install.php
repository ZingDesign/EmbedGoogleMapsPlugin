<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 13/03/14
 * Time: 9:22 AM
 */

class EGMFormsInstall {

    function __construct() {

        load_plugin_textdomain(EGM_TEXT_DOMAIN, false, basename( dirname( __FILE__ ) ) . '/languages' );

        add_action( 'admin_enqueue_scripts', array($this, 'egm_load_admin_assets') );

        add_action( 'wp_enqueue_scripts', array($this, 'egm_load_client_assets') );

    }

    function egm_load_admin_assets() {

        if ( isset($_GET['page']) && 'egm_main_menu_page' === $_GET['page'] ) {
        // Custom admin styles
            wp_enqueue_style( 'egm-admin', plugins_url( '/assets/css/egm-admin.css', dirname(__FILE__) ) );

            // Custom admin scripts
            wp_register_script(
                'egm-admin-script',
                plugins_url( '/assets/dist/js/egm-admin.min.js', dirname(__FILE__) ),
                array('jquery'),
                '1.0.0',
                true
            );

            wp_enqueue_media();
            wp_enqueue_script( 'egm-admin-script' );
//            wp_register_script('my-admin-js', WP_PLUGIN_URL.'/my-plugin/my-admin.js', array('jquery'));
//            wp_enqueue_script('my-admin-js');
        }
    }

    function egm_load_client_assets() {

        if( $api_key = get_option('egm-google-maps-api-key') ) {
            wp_enqueue_script(
                'google-maps-js-api',
                'https://maps.googleapis.com/maps/api/js?key='.$api_key.'&sensor=true',
                array(),
                '3.15'
            );

            wp_enqueue_script(
                'egm-client-script',
                plugins_url( '/assets/dist/js/egm-client.min.js', dirname(__FILE__) ),
                array('jquery', 'google-maps-js-api'),
                '1.0.0',
                true
            );

            wp_localize_script( 'egm-client-script', 'egmOptions', array(
                'address' => get_option('egm-address'),
                'style' => get_option('egm-map-style'),
                'infoWindowContent' => $this->get_info_window_image() . wpautop(get_option('egm-info-window-content'))
            ) );

            wp_enqueue_style( 'egm-client', plugins_url( '/assets/css/egm-client.css', dirname(__FILE__) ) );
        }
    }

    function get_info_window_image() {
        $html = '';
        if( $image_url = get_option('egm-info-window-image') ) {
            $html .= '<img class="egm-info-window-image" src="'.$image_url.'" alt="Info window image."/>'."\n";
        }

        return $html;
    }
}