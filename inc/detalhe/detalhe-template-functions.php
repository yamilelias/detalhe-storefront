<?php
/**
 * Author: yamilelias
 * Author URI: <yamileliassoto@gmail.com>
 * Date: 23/10/17
 * Time: 10:12 AM
 */

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
                            'theme_location'	=> 'landing-menu',
                            'container_class'	=> 'wrap',
                            'menu_class'        => '',
                            'items_wrap'        => '<ul class="landing-menu nav navbar-nav">%3$s</ul>'
                        )
                    );
                } else {
                    ?>
                    <div class="wrap">
                        <ul class="landing-menu nav navbar-nav">
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Store</a></li>
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

if ( ! function_exists( 'detalhe_brand_products' ) ) {
    /**
     * Display Brand Products
     * Hooked into single-brand action in the single-brand template
     *
     * @since  1.0.0
     * @param array $args the product section args.
     * @return void
     */
    function detalhe_brand_products( $args ) {

        if ( storefront_is_woocommerce_activated() ) {

            $args = apply_filters( 'storefront_brand_products_args', array(
                'per_page'          => 4,
                'limit' 			=> 4,
                'columns' 			=> 4,
                'category'          => 'paquilia',
                'title'				=> __( 'All Products', 'storefront' ),
            ) );

            $shortcode_content = storefront_do_shortcode( 'brand_products', apply_filters( 'storefront_brand_products_shortcode_args', array(
                'per_page' => intval( $args['limit'] ),
                'columns'  => intval( $args['columns'] ),
            ) ) );

            echo '<section class="storefront-product-section storefront-brand-products" aria-label="' . esc_attr__( 'All Products', 'storefront' ) . '">';

            echo $shortcode_content;

            echo '</section>';
        }
    }
}