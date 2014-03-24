<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 13/03/14
 * Time: 10:26 AM
 */

class EGMFormsShortcodes {
    public function __construct() {
        add_shortcode('custom_google_map', array($this, 'egm_display_map') );
    }

    function egm_display_map($atts) {
        $width = $height = $address = $address_url = $id = $class = $margin_bottom ='';

        extract( shortcode_atts( array(
            'id'            => 'egm-map',
            'class'         => 'egm-map',
            'address'       => get_option('egm-address'),
            'address_url'   => urlencode(get_option('egm-address')),
            'width'         => get_option( 'egm-map-width' ),
            'height'        => get_option( 'egm-map-height' ),
            'margin_bottom' => false
        ), $atts ) );

        if( $address && ! $address_url ) {
            $address_url = urlencode( $address );
        }
        $style = ' style="';

        if( $width )
            $style .= 'width:' . str_replace( 'px', '', $width ) . 'px;';
        if( $height )
            $style .= 'height:' . str_replace( 'px', '', $height ) . 'px;';
        if( $margin_bottom )
            $style .= 'margin-bottom:' . str_replace( 'px', '', $margin_bottom ) . 'px;';

        $style .= '"';

        $html = '';

        $html .= sprintf('<div id="%1$s" class="%2$s"%3$s>', $id, $class, $style)."\n";

        if( $address && $address_url && $width && $height ) {

//            $key = get_option('egm-google-maps-api-key');

            $image_url = 'http://maps.googleapis.com/maps/api/staticmap?center='.$address_url.'&zoom=14&size='.$width.'x'.$height.'&markers=color:red|'.$address_url.'&sensor=true';

            $html .= '<a href="https://www.google.com/maps/place/'.$address_url.'" target="_blank">'."\n";

            $html .= '<img src="'.$image_url.'" alt="Static fallback image showing the location of '.$address.'." width="'.$width.'" height="'.$height.'" />'."\n";

            $html .= '</a>'."\n";

        }

        $html .= '</div>'."\n";

        return $html;
    }
} 