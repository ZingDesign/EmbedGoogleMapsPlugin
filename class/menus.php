<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 13/03/14
 * Time: 9:53 AM
 */
//
//include_once( trailingslashit(plugin_dir_path( __FILE__ )) . 'FormHelper.php');

class EGMFormsMenus {

    private $form;

    function __construct() {


        if( is_admin() ) {
            add_action( 'admin_init', array( $this, 'egm_init_settings' ) );

            add_action( 'admin_menu', array( $this, 'egm_init_menu' ));

        }

//        $this->form = new FormHelper(array(
//            'form_name' => 'egm_options',
//            'action' => 'options.php',
//            'is_ajax' => false
//        ));

    }

    //The menu page
    function egm_init_menu() {
        //        add_options_page($page_title, $menu_title, $capability, $menu_slug, $callback);
        add_options_page(
            'Embed Google maps',                // Page title
            'Embed Google maps',                // Menu title
            'manage_options',                   // Capability
            'egm_main_menu_page',               // menu slug
            array($this, 'egm_menu_options')    // callback
        );
    }

    function egm_init_settings() {

        add_settings_section(
            'egm-main-section',                 // id
            'Google map settings',                     // title
            array( $this, 'egm_section_main' ), // callback
            'egm_main_menu_page'                // page
        );

        add_settings_field(
            'egm-google-maps-api-key',              // id
            'Google Maps API key',              // title
            array( $this, 'egm_input_api_key' ),// callback
            'egm_main_menu_page',               // page
            'egm-main-section'                  // section
        );

        add_settings_field(
            'egm-address',              // id
            'Your address',              // title
            array( $this, 'egm_input_address' ),// callback
            'egm_main_menu_page',               // page
            'egm-main-section'                  // section
        );

        add_settings_field(
            'egm-map-width',                        // id
            'Map width (pixels)',                        // title
            array( $this, 'egm_input_map_width' ),// callback
            'egm_main_menu_page',               // page
            'egm-main-section'                  // section
        );

        add_settings_field(
            'egm-map-height',                        // id
            'Map height (pixels)',               // title
            array( $this, 'egm_input_map_height' ),// callback
            'egm_main_menu_page',               // page
            'egm-main-section'                  // section
        );

        add_settings_field(
            'egm-info-window-content',
            'Info window content',
            array( $this, 'egm_input_info_window_content' ),
            'egm_main_menu_page',
            'egm-main-section'
        );

        add_settings_field(
            'egm-map-style',
            'Map style<br/>(Paste Javascript style array from <a href="http://snazzymaps.com/" target="_blank">Snazzy Maps</a>)',
            array( $this, 'egm_input_style' ),
            'egm_main_menu_page',
            'egm-main-section'
        );

        register_setting(
            'egm_main_menu_page',   // option group
            'egm-google-maps-api-key',  // option name
            'esc_html'              // sanitize callback
        );

        register_setting(
            'egm_main_menu_page',   // option group
            'egm-address',  // option name
            'esc_html'              // sanitize callback
        );

        register_setting(
            'egm_main_menu_page',   // option group
            'egm-map-width',  // option name
            'esc_html'              // sanitize callback
        );

        register_setting(
            'egm_main_menu_page',   // option group
            'egm-map-height',  // option name
            'esc_html'              // sanitize callback
        );

        register_setting(
            'egm_main_menu_page',   // option group
            'egm-info-window-content',  // option name
            'esc_attr'              // sanitize callback
        );


        register_setting(
            'egm_main_menu_page',   // option group
            'egm-map-style',  // option name
            'sanitize_text_field'              // sanitize callback
        );

    }

    function egm_section_main() {
//        echo "<h2>Main options</h2>\n";
    }

    function egm_input_api_key() {
        echo '<input class="egm-text" type="text" id="egm-google-maps-api-key" name="egm-google-maps-api-key" value="'.get_option('egm-google-maps-api-key').'"/>';
    }

    function egm_input_address() {
        echo '<textarea class="egm-text" id="egm-address" name="egm-address">'.get_option('egm-address').'</textarea>';
    }

    function egm_input_map_width() {
        echo '<input class="egm-text" type="number" id="egm-map-width" name="egm-map-width" value="'.get_option('egm-map-width').'"/>';
    }

    function egm_input_map_height() {
        echo '<input class="egm-text" type="number" id="egm-map-height" name="egm-map-height" value="'.get_option('egm-map-height').'"/>';
    }

    function egm_input_info_window_content() {
        echo '<input class="egm-text" type="text" id="egm-info-window-content" name="egm-info-window-content" value="'.get_option('egm-info-window-content').'"/>';
    }

    function egm_input_style() {
        echo '<textarea class="egm-text" id="egm-map-style" name="egm-map-style" rows="15" cols="60">'.get_option('egm-map-style').'</textarea>';
    }

    function egm_menu_options() {
//        $html = '';

        echo '<form method="POST" action="options.php">';

        settings_fields( 'egm_main_menu_page' );

        do_settings_sections( 'egm_main_menu_page' ); 	//pass slug name of page

        submit_button();

        echo '</form>';

        echo "<h3>Shortcode:</h3>\n";

        echo "<p>Paste this shortcode into your post:</p>\n";

        echo "<pre>[custom_google_map]</pre>\n";


//        echo $html;
    }


} 