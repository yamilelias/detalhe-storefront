<?php
/**
 * Created by PhpStorm.
 * User: yamilelias
 * Date: 14/09/17
 * Time: 11:03 AM
 */

use Com\Detalhe\Core\Controllers\Brands;

/**
 * Validate if the core plugin is active in order to use the functions from it.
 *
 * @since 1.0.0
 * @return bool
 */
function is_detalhe_core_actived(){
    return class_exists( 'Detalhe_Core' ) ? true : false;
}

if ( ! function_exists( 'detalhe_custom_styles_and_scripts' ) ) {
    /**
     * Function to generate the styles and scripts needed in head
     *
     * @since  1.0.0
     */
    function detalhe_custom_styles_and_scripts() {
        // Check for common styles and scripts
        if(!wp_script_is('vendor-jquery')){
            wp_enqueue_script('vendor-jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js');
        } else {
            wp_dequeue_script('vendor-jquery');

            wp_enqueue_script('vendor-jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js');
        }
        if(!wp_style_is('bootstrap-js')){
            wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', ['vendor-jquery']);
        } else {
            wp_dequeue_script('bootstrap-js');

            wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', ['vendor-jquery']);
        }
        if(!wp_style_is('bootstrap-css')){
            wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        } else {
            wp_dequeue_style('bootstrap-css');

            wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        }
        if(!wp_style_is('ionicons')){
            wp_enqueue_style( 'ionicons', get_template_directory_uri() . '/assets/css/ionicons.min.css');
        } else {
            wp_dequeue_style('ionicons');

            wp_enqueue_style( 'ionicons', get_template_directory_uri() . '/assets/css/ionicons.min.css');
        }

        // Check for custom styles and scripts
        if(!wp_style_is('detalhe-css')){
            wp_enqueue_style( 'detalhe-css', get_template_directory_uri() . '/assets/sass/detalhe/detalhe.css', ['bootstrap-css']);
        }
    }
}

/**
 * Get only the URL from the custom logo and not all the bundle with <a> and <img> elements
 *
 * @since 1.0.0
 * @param bool $echo Choose if you want to echo the result or return it
 */
function get_custom_logo_url( $echo = true ){
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );

    if(!$echo){
        return $image[0];
    }

    echo $image[0];
}

/**
 * It will return the header image depending if the detalhe plugin is active and if there is a brand present. If
 * none of them are true, then return the normal header.
 *
 * @uses  fetch_header_image()
 * @since  1.0.0
 */
function detalhe_get_header_image() {
    // If the plugin is active, then follow the business logic and check if there is a brand present
    if(is_detalhe_core_actived()) {
        $brand = Brands::get_current_brand();
        $have_brand = Brands::have_brand();

        // If there is a brand present, then display the brand banner.
        if($have_brand) {

            fetch_header_image($brand->header_banner);
        }
    } else {

        // Fetch the normal header if the plugin is deactivated.
        fetch_header_image();
    }
}

/**
 * Fetch image header and all the styles for it.
 *
 * @uses  get_header_image()
 * @since 1.0.0
 * @param object|string $image
 */
function fetch_header_image($image = '') {

    $header_data = isset($image) ? $image : get_custom_header(); // Get the header if an image is not provided
    $header_bg_image = '';

    if (has_header_image()) {
        $header_bg_image = 'url(' . esc_url( $header_data->url ) . ')';
    }

    $styles = array();

    if ( '' !== $header_bg_image ) {
        $styles['background-image'] = $header_bg_image;
        $styles['height'] = $header_data->height . 'px'; // So it at least shows all the banner
    }

    foreach ( $styles as $style => $value ) {
        echo esc_attr( $style . ': ' . $value . '; ' );
    }
}

/**
 * Display the site title or logo
 *
 * @since 2.1.0
 * @param bool $echo Echo the string or return it.
 * @return string
 */
function detalhe_site_title_or_logo($echo = true) {
    $html = '';

    if(has_custom_logo()){
        $logo_url = get_custom_logo_url(false);
        $html = '<img id="brand-logo" alt="Brand" src="'. $logo_url .'">';
    } else {
        // Deploy the name of the site only if no logo is present
        $html = get_bloginfo('name');
    }

    if ( ! $echo ) {
        return $html;
    }

    echo $html;
}

/**
 * Register custom menus.
 *
 * @since 1.0.0
 */
function register_custom_menus() {
    register_nav_menus(
        array(
            'landing-menu' => __( 'Landing Menu' ),
        )
    );
}
add_action( 'init', 'register_custom_menus' );