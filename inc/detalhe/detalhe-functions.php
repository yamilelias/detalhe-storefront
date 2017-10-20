<?php
/**
 * Created by PhpStorm.
 * User: yamilelias
 * Date: 14/09/17
 * Time: 11:03 AM
 */

/**
 * Validate if the core plugin is active in order to use the functions from it.
 *
 * @since 1.0.0
 * @return bool
 */
function is_detalhe_core_actived(){
    return class_exists( 'Detalhe_Core' ) ? true : false;
}

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
        $have_brand = \Com\Detalhe\Core\Controllers\Brands::have_brand();

        // If there is a brand present, then display the brand banner.
        if($have_brand) {
            $brand = \Com\Detalhe\Core\Controllers\Brands::get_current_brand();

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
 * @param array $image
 */
function fetch_header_image($image = array()) {
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
        $logo_item = '<div class="navbar-header">' .
//                        '<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span>' . esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ) .'</span></button>' .
                        '<a class="navbar-brand" href="'.get_site_url().'/shop">'
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
                    'items_wrap'        => $logo_item .'<ul class="main-menu">%3$s</ul>',
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
    ?>
        <!-- Navigation -->
        <nav id="landing-menu" class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><?php detalhe_site_title_or_logo() ?></a>
                </div>
<!--                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">-->
<!--                    <span class="navbar-toggler-icon"></span>-->
<!--                </button>-->
                <?php
            if(has_nav_menu( 'landing-menu' )){
                wp_nav_menu(
                    array(
                        'container'         => 'div',
                        'theme_location'	=> 'landing-menu nav navbar-nav',
                        'container_class'	=> 'wrap',
                        'menu_class'        => '',
                        'items_wrap'        => '<ul class="landing-menu">%3$s</ul>'
                    )
                );
            } else {
                ?>
                <div class="wrap">
                    <ul class="landing-menu nav navbar-nav">
                        <li><a href="#">Contacto</a></li>
                        <li><a href="#">Tienda en Línea</a></li>
                        <li><a href="#">Social</a></li>
                    </ul>
                </div>
                <?php
            } ?>
            </div>
        </nav>
        <?php
    }
}

if ( ! function_exists( 'detalhe_landing_carousel' ) ) {
    /**
     * Display Carousel for the landing page
     * TODO: Make it customizable by admin panel
     *
     * @since  1.0.0
     * @return void
     */
    function detalhe_landing_carousel() {
        ?>

        <header>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <!-- Slide One - Set the background image for this slide in the line below -->
                    <div class="carousel-item item active" style="background-image: url('http://placehold.it/1900x1080')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>First Slide</h3>
                            <p>This is a description for the first slide.</p>
                        </div>
                    </div>
                    <!-- Slide Two - Set the background image for this slide in the line below -->
                    <div class="carousel-item item" style="background-image: url('http://placehold.it/1900x1080')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>Second Slide</h3>
                            <p>This is a description for the second slide.</p>
                        </div>
                    </div>
                    <!-- Slide Three - Set the background image for this slide in the line below -->
                    <div class="carousel-item item" style="background-image: url('http://placehold.it/1900x1080')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>Third Slide</h3>
                            <p>This is a description for the third slide.</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </header>

        <?php
    }
}

/**
 * Register custom menus.
 *
 * @since 1.0.0
 */
function register_custom_menus() {
    register_nav_menus(
        array(
            'landing-footer-menu' => __( 'Landing Menu' ),
        )
    );
}
add_action( 'init', 'register_custom_menus' );