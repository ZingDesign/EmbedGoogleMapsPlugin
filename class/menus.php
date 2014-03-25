<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 13/03/14
 * Time: 9:53 AM
 */

class EGMFormsMenus {

    function __construct() {

        if( is_admin() ) {
            add_action( 'admin_init', array( $this, 'egm_init_settings' ) );

            add_action( 'admin_menu', array( $this, 'egm_init_menu' ));
        }

    }

    //The menu page
    function egm_init_menu() {
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
            'egm-main-section',
            __('Custom Google map settings', 'egm'),
            array( $this, 'egm_section_main' ),
            'egm_main_menu_page'
        );

        add_settings_field(
            'egm-google-maps-api-key',
            __('Google Maps API key', 'egm'),
            array( $this, 'egm_input_api_key' ),
            'egm_main_menu_page',
            'egm-main-section'
        );

        add_settings_field(
            'egm-address',
            __('Your address', 'egm'),
            array( $this, 'egm_input_address' ),
            'egm_main_menu_page',
            'egm-main-section'
        );

        add_settings_field(
            'egm-map-width',
            __('Map width (pixels)', 'egm'),
            array( $this, 'egm_input_map_width' ),
            'egm_main_menu_page',
            'egm-main-section'
        );

        add_settings_field(
            'egm-map-height',
            __('Map height (pixels)', 'egm'),
            array( $this, 'egm_input_map_height' ),
            'egm_main_menu_page',
            'egm-main-section'
        );

        add_settings_field(
            'egm-info-window-image',
            __('Info window image', 'egm'),
            array( $this, 'egm_input_info_window_image' ),
            'egm_main_menu_page',
            'egm-main-section'
        );

        add_settings_field(
            'egm-info-window-content',
            __('Info window content', 'egm'),
            array( $this, 'egm_input_info_window_content' ),
            'egm_main_menu_page',
            'egm-main-section'
        );

        add_settings_field(
            'egm-map-style',
            sprintf(__('Map style%1$sPaste Javascript style array from %2$sSnazzy Maps%3$s', 'egm'), '<br/><em>', '<a href="http://snazzymaps.com/" target="_blank">', '</a></em>'),
            array( $this, 'egm_input_style' ),
            'egm_main_menu_page',
            'egm-main-section'
        );

        register_setting(
            'egm_main_menu_page',       // option group
            'egm-google-maps-api-key',  // option name
            'esc_html'                  // sanitize callback
        );

        register_setting(
            'egm_main_menu_page',
            'egm-address',
            'esc_html'
        );

        register_setting(
            'egm_main_menu_page',
            'egm-map-width',
            'esc_html'
        );

        register_setting(
            'egm_main_menu_page',
            'egm-map-height',
            'esc_html'
        );

        register_setting(
            'egm_main_menu_page',
            'egm-info-window-image',
            'esc_url'
        );

        register_setting(
            'egm_main_menu_page',
            'egm-info-window-content',
            'esc_attr'
        );


        register_setting(
            'egm_main_menu_page',
            'egm-map-style',
            'sanitize_text_field'
        );

    }

    function egm_section_main() {
//        echo "<h1>" . __('Zing Design - Embed custom Google maps', 'egm') . "</h1>\n";

    }

    function egm_input_api_key() {
        echo '<input class="egm-text" type="text" id="egm-google-maps-api-key" name="egm-google-maps-api-key" value="'.get_option('egm-google-maps-api-key').'"/>';
        echo '<br/><a href="http://www.zingdesign.com/how-to-build-a-custom-google-map-for-your-website/" target="_blank">' . __('How do I get an API key?', 'egm') . '</a>';
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

    function egm_input_info_window_image() {
        echo '<input id="upload_image" type="text" size="36" name="egm-info-window-image" value="'.get_option('egm-info-window-image').'" />'."\n";
        echo '<input id="upload_image_button" class="button" type="button" value="Insert Image" />'."\n";
        echo '<br /><em><small>';
        echo __('Enter a URL or insert an image', 'egm')."\n";
        echo '</small></em>'."\n";
    }

    function egm_input_info_window_content() {
        echo '<textarea class="egm-text" type="text" id="egm-info-window-content" name="egm-info-window-content" rows="5">'.get_option('egm-info-window-content').'</textarea>';
    }

    function egm_input_style() {
        echo '<textarea class="egm-text" id="egm-map-style" name="egm-map-style" rows="15" cols="60">'.get_option('egm-map-style').'</textarea>';
    }

    function egm_menu_options() {

        echo '<form id="egm-form" method="POST" action="options.php">';

        settings_fields( 'egm_main_menu_page' );

        do_settings_sections( 'egm_main_menu_page' ); 	//pass slug name of page

        submit_button();

        echo '</form>';

        echo "<h3>" . __('Shortcode:', 'egm') . "</h3>\n";

        echo "<p>" . __('Paste this shortcode into your post:', 'egm') . "</p>\n";

        echo "<pre class=\"egm-shortcode-output\">[custom_google_map]</pre>\n";

        echo "<p><strong>". __('Allowed attributes:', 'egm') . "</strong></p>\n";
        echo "<ul class=\"bullet-list\">\n";
        echo "<li>class</li>\n";
        echo "<li>address</li>\n";
        echo "<li>width</li>\n";
        echo "<li>height</li>\n";
        echo "<li>margin_bottom</li>\n";
        echo "</ul>\n";

        echo '<a href="http://zingdesign.com" target="_blank"><img src="'.plugins_url('assets/images/zing-design-logo.png', dirname(__FILE__)).'" alt="Zing Design" width="200" height="64" /></a>'."\n";
    }


} 