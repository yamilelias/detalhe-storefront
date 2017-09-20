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
 * Returns the url to the landing image url (default or the one set into the start page)
 *
 * @since 1.0.0
 * @return string url to the image, default or set in the page
 */
function get_landing_image_url(){
    echo has_post_thumbnail() ? get_the_post_thumbnail() : get_template_directory_uri() . '/assets/images/detalhe/welcome.jpg';
}

/**
 * Apply inline style to the Storefront header.
 *
 * @uses  get_header_image()
 * @since  2.0.0
 */
function detalhe_get_header_image() {
    $header_data = get_custom_header();
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
function detalhe_site_title_or_logo($echo = true){
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

if ( ! function_exists( 'detalhe_primary_navigation' ) ) {
    /**
     * Display Primary Navigation
     *
     * @since  1.0.0
     * @return void
     */
    function detalhe_primary_navigation() {
        $logo_item = '<div class="navbar-header" style="padding-top: .5em;">
                        <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span>' . esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ) .'</span></button>' .
                        '<a class="navbar-brand" href="'.get_site_url().'">'
                            . detalhe_site_title_or_logo(false) . // So it won't echo and return the item
                        '</a>' .
                      '</div>';
        ?>
        <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location'	=> 'primary',
                    'container_class'	=> 'primary-navigation container-fluid',
                    'items_wrap'        => $logo_item .'<ul>%3$s</ul>'
                )
            );

            wp_nav_menu(
                array(
                    'theme_location'	=> 'handheld',
                    'container_class'	=> 'handheld-navigation',
                    'items_wrap'        => $logo_item .'<ul>%3$s</ul>'
                )
            );
            ?>
        </nav><!-- #site-navigation -->
        <?php
    }
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

/**
 * Register custom menus.
 *
 * @since 1.0.0
 */
function register_footer_menus() {
    register_nav_menus(
        array(
            'landing-footer-menu' => __( 'Landing Footer Menu' ),
        )
    );
}
add_action( 'init', 'register_footer_menus' );

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
                    'theme_location'	=> 'landing-footer-menu',
                    'container_class'	=> 'wrap',
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

if ( ! function_exists( 'storefront_recent_products' ) ) {
    /**
     * Display Recent Products
     * Hooked into the `homepage` action in the homepage template
     *
     * @since  1.0.0
     * @param array $args the product section args.
     * @return void
     */
    function storefront_recent_products( $args ) {

        if ( storefront_is_woocommerce_activated() ) {

            $args = apply_filters( 'storefront_recent_products_args', array(
                'limit' 			=> 4,
                'columns' 			=> 4,
                'title'				=> __( 'New In', 'storefront' ),
            ) );

            $shortcode_content = storefront_do_shortcode( 'recent_products', apply_filters( 'storefront_recent_products_shortcode_args', array(
                'per_page' => intval( $args['limit'] ),
                'columns'  => intval( $args['columns'] ),
            ) ) );

            /**
             * Only display the section if the shortcode returns products
             */
            if ( false !== strpos( $shortcode_content, 'product' ) ) {

                echo '<section class="storefront-product-section storefront-recent-products" aria-label="' . esc_attr__( 'Recent Products', 'storefront' ) . '">';

                do_action( 'storefront_homepage_before_recent_products' );

                echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

                do_action( 'storefront_homepage_after_recent_products_title' );

                echo $shortcode_content;

                do_action( 'storefront_homepage_after_recent_products' );

                echo '</section>';

            }
        }
    }
}

