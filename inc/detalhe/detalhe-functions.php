<?php
/**
 * Created by PhpStorm.
 * User: yamilelias
 * Date: 14/09/17
 * Time: 11:03 AM
 */


// Change number or products per row to 5
add_filter('loop_shop_columns', 'loop_columns', 999);
function loop_columns() {
  return 5; // 5 products per row
}

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
            wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js');
        } else {
            wp_dequeue_script('bootstrap-js');

            wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js');
        }
        if(!wp_style_is('bootstrap-css')){
            wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.css.js');
        } else {
            wp_dequeue_style('bootstrap-css');

            wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css');
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

/**
 * Display Header Cart. Code got from the woocommerce storefront theme.
 *
 * @since  1.0.0
 * @uses  storefront_is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
function display_cart() {
    if ( storefront_is_woocommerce_activated() ) {
        ?>
        <ul id="site-header-cart" class="site-header-cart menu">
            <li class="nav navbar-nav navbar-right">
                <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'storefront' ); ?>">
                    <span class="count"><?php echo WC()->cart->get_cart_contents_count();?></span>
                </a>
            </li>
            <li class="">
                <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
            </li>
        </ul>

        <?php
    }
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
                    'items_wrap'        => $logo_item .'<ul>%3$s</ul>',
                )
            );
            ?>
        </nav><!-- #site-navigation -->
        <?php
        display_cart(); // Display the cart
    }
}

if ( ! function_exists( 'detalhe_landing_navigation' ) ) {
    /**
     * Display Primary Navigation
     *
     * @since  1.0.0
     * @return void
     */
    function detalhe_landing_navigation() {
        $logo_item = '<div class="navbar-header" style="padding-top: .5em;">
                        <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span>' . esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ) .'</span></button>' .
            '<a class="navbar-brand" href="'.get_site_url().'">'
            . detalhe_site_title_or_logo(false) . // So it won't echo and return the item
            '</a>' .
            '</div>';
        ?>
        <nav id="landing-menu" class="" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
            <?php
            if(has_nav_menu( 'landing-menu' )){
                wp_nav_menu(
                    array(
                        'container'         => 'div',
                        'theme_location'	=> 'landing-menu',
                        'container_class'	=> 'wrap',
                        'menu_class'        => '',
                        'items_wrap'        => $logo_item . '<ul class="nav navbar-nav landing-menu">%3$s</ul>'
                    )
                );
            } else {
                echo $logo_item; // Set first the logo, then the default navbar
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

/**
 * Register custom menus.
 *
 * @since 1.0.0
 */
function register_custom_menus() {
    register_nav_menus(
        array(
            'landing-footer-menu' => __( 'Landing Footer Menu' ),
        )
    );
}
add_action( 'init', 'register_custom_menus' );