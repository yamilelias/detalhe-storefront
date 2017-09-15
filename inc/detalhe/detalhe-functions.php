<?php
/**
 * Created by PhpStorm.
 * User: yamilelias
 * Date: 14/09/17
 * Time: 11:03 AM
 */

if ( ! function_exists( 'detalhe_custom_styles_and_scripts' ) ) {
    /**
     * Function to generate the styles and scripts needed in head
     *
     * @since  1.0.0
     */
    function detalhe_custom_styles_and_scripts() {
        // Check for common styles and scripts
        if(!wp_script_is('jquery')){
            wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js');
        } else {
            wp_dequeue_script('jquery');

            wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js');
        }
        if(!wp_style_is('bootstrap-js')){
            wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
        } else {
            wp_dequeue_script('bootstrap-js');

            wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
        }
        if(!wp_style_is('bootstrap-css')){
            wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        } else {
            wp_dequeue_style('bootstrap-css');

            wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        }

        // Check for custom styles and scripts
        if(!wp_style_is('detalhe-css')){
            wp_enqueue_style( 'detalhe-css', get_template_directory_uri() . '/assets/sass/detalhe/detalhe.css');
        }
    }
}

/**
 * Get only the URL from the custom logo and not all the bundle with <a> and <img> elements
 *
 * @since 1.0.0
 */
function get_custom_logo_url(){
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    echo $image[0];
}

/**
 * Returns the url to the landing image url (default or the one set into the start page)
 *
 * @since 1.0.0
 * @return string url to the image, default or set in the page
 */
function get_landing_image_url(){
    echo has_post_thumbnail() ? get_the_post_thumbnail() : get_template_directory_uri() . '/assets/images/detalhe/welcome.jpg';
}

/**
 * Get the styles for the header
 *
 * @since 1.0.0
 */
function detalhe_get_landing_header_styles() {
    echo 'background: url('. get_landing_image_url() .') no-repeat center;' .
          ''; // Get the padding for the image in the background from the image set
}

if ( ! function_exists( 'detalhe_display_landing_logo' ) ) {
    /**
     * Landing page display header logo
     *
     * @since  1.0.0
     */
    function detalhe_display_landing_logo() {
        ?>
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div id="header-background" style="<?php detalhe_get_landing_header_styles() ?>">
                        <?php the_custom_logo(); ?>
                    </div>
                </div>
            </div>
        </nav>
        <?php
    }
}

if ( ! function_exists( 'detalhe_display_footer_menu' ) ) {
    /**
     * Landing page display footer menu
     *
     * @since  1.0.0
     */
    function detalhe_display_footer_menu() {
        if(has_nav_menu( 'landing-footer-menu' )){
            wp_nav_menu(
                array(
                    'container'         => 'div',
//                    'theme_location'	=> 'company-footer-menu',
                    'container_class'	=> 'wrap',
                    'container_id'      => 'landing-footer-menu',
                    'menu_class'        => '',
                    'items_wrap'        => '<ul class="nav navbar-nav landing-menu">%3$s</ul>'
                )
            );
        } else {
            ?>
            <div class="wrap">
                <ul class="nav navbar-nav landing-menu">
                    <li><a href="#">Contacto</a></li>
                    <li><a href="#">Tienda en Línea</a></li>
                    <li><a href="#">Social</a></li>
                </ul>
            </div>
            <?php
        }
    }
}

