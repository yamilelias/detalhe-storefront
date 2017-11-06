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
            '<a class="navbar-brand" href="' . get_permalink( wc_get_page_id( 'shop' ) ) .'">'
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
        <?php if ( storefront_is_woocommerce_activated() ) { ?>
            <div class="navigation-widgets">
                <div class="site-search">
                    <?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
                </div>
                <?php display_cart(); // Display the shopping cart?>
            </div>
        <?php }
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
                    <a class="navbar-brand" href="#"><img id="brand-logo" alt="Brand" src="<?php echo get_template_directory_uri() . '/assets/images/detalhe/detalhe_blanco_logo.png' ?>"></a>
                </div>
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
                <div class="carousel-inner" role="listbox">
                    <!-- Slide One - Set the background image for this slide in the line below -->
                    <div class="carousel-item item active" style="background-image: url('<?php echo get_slide_path('slide_00.jpg') ?>')">
                    </div>
                    <!-- Slide Two - Set the background image for this slide in the line below -->
                    <div class="carousel-item item" style="background-image: url('<?php echo get_slide_path('slide_01.jpg') ?>')">
                    </div>
                    <!-- Slide Three - Set the background image for this slide in the line below -->
                    <div class="carousel-item item" style="background-image: url('<?php echo get_slide_path('slide_02.jpg') ?>')">
                    </div>
                </div>
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
            $brand = \Com\Detalhe\Core\Controllers\Brands::get_current_brand();

            $args = apply_filters( 'storefront_products_args', array(
                'per_page'          => 4,
                'limit' 			=> -1,
                'columns' 			=> 4,
                'category'          => $brand->post_name,
                'title'				=> __( 'All Products', 'storefront' ),
            ) );

            $shortcode_content = storefront_do_shortcode( 'products', apply_filters( 'storefront_products_shortcode_args', array(
                'per_page' => intval( $args['limit'] ),
                'columns'  => intval( $args['columns'] ),
            ) ) );

            echo '<section class="storefront-product-section storefront-brand-products" aria-label="' . esc_attr__( 'All Products', 'storefront' ) . '">';

            echo $shortcode_content;

            echo '</section>';
        }
    }
}