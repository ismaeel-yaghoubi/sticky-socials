<?php
/*
 * Plugin Name:       Sticky socials
 * Description:       This plugins add sticky social buttons
 * Version:           1.0
 * Author:            Ismaeel Yaghoubi
 * Author URI:        https://ismaeel-yaghoubi.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sticky-socials
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class is_sticky_socials{

    public $plugin;

    function __construct(){
        $this->plugin = plugin_basename( __FILE__ );
        define('PLUGIN_PATH', plugin_dir_path( __FILE__ ));
        require_once( PLUGIN_PATH .'/vendor/autoload.php');
    }


    function init(){
        require_once( PLUGIN_PATH .'/inc/utilities.php');
    }

    function register_template(){
        require_once( PLUGIN_PATH .'/inc/templates/ss-template.php');
    }

    function load_template(){
        add_action('wp',array($this, 'register_template') );
    }

    function register(){
        // add_action( 'admin_menu', array($this , 'add_admin_pages') );
        add_filter( "plugin_action_links_$this->plugin", array($this, 'settings_link'));
    }

    function settings_link($link){
        $settings_link = '<a href="admin.php?page=is_sticky_socials">Settings</a>';
        array_push($link, $settings_link);
        return $link;
    }

    // function add_admin_pages(){
    //     add_menu_page( 'Post slider', 'Slider', 'manage_options', 'is_sticky_socials',array($this, 'admin_page') ,'dashicons-slides', 110);
    // }

    function admin_page(){
        require_once(plugin_dir_path( __FILE__ ).'/templates/index.html');
    }

    function register_styles(){
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_style'));
        add_action( 'wp_footer', array($this, 'enqueue_script'));
    }

    function activate(){
        flush_rewrite_rules();
    }
    function deactivate(){
        flush_rewrite_rules();
    }

    function enqueue_style(){
        wp_enqueue_style( 'is_sticky_socials_style', plugins_url( '/src/dist/css/style.css', __FILE__ ), array());
    }

    function enqueue_script(){
        wp_enqueue_script( 'is_sticky_socials_script', plugins_url( '/src/dist/js/main.js', __FILE__ ), array('jquery'),true);
    }
    
}

if (class_exists('is_sticky_socials')){
    $isStickySocials = new is_sticky_socials();
    $isStickySocials->register_styles();
    $isStickySocials->register();
    $isStickySocials->init();
    $isStickySocials->load_template();
}

// activate
register_activation_hook( __FILE__, array($isStickySocials, 'activate'));

// deactivate
register_deactivation_hook( __FILE__, array($isStickySocials, 'deactivate'));
