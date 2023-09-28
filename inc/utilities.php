<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'init_option_page');
function init_option_page(){
    Container::make( 'theme_options', __( 'Sticky socials' ) )
        ->set_icon( 'dashicons-ellipsis' )
        ->add_fields( array(
            Field::make( 'text', 'ss_instagram_url', __( 'Instagram URL' ) ),
            Field::make( 'text', 'ss_facebook_url', __( 'Facebook URL' ) ),
            Field::make( 'text', 'ss_x_url', __( 'X URL' ) ),
            Field::make( 'text', 'ss_whatsapp_url', __( 'WhatsApp URL' ) ),
        ));
}


add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    \Carbon_Fields\Carbon_Fields::boot();
}

function ss_get_field($item){
    return carbon_get_theme_option($item);
}