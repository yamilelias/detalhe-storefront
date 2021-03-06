<?php
/**
 * Created by PhpStorm.
 * User: yamilelias
 * Date: 14/09/17
 * Time: 11:03 AM
 */

/**
 * Landing Header
 *
 * @see  detalhe_display_landing_logo()
 * @see  detalhe_landing_navigation()
 * @see  detalhe_landing_carousel()
 */
add_action('detalhe_landing_header', 'detalhe_landing_navigation', 10);

/**
 * Landing page
 */
add_action('detalhe_landing_page', 'detalhe_landing_carousel',  10);
add_action('detalhe_landing_page', 'detalhe_contact_modal',     30);

/**
 * Header
 *
 * @see  storefront_secondary_navigation()
 * @see  storefront_primary_navigation()
 */
add_action( 'detalhe_header', 'storefront_secondary_navigation',             30 );
add_action( 'detalhe_header', 'storefront_primary_navigation_wrapper',       42 );
add_action( 'detalhe_header', 'detalhe_primary_navigation',                  50 );
add_action( 'detalhe_header', 'storefront_primary_navigation_wrapper_close', 68 );

/**
 * Single Brand Page
 */
add_action( 'single_brand', 'storefront_recent_products',  20 );

/**
 * Landing Footer
 *
 * @see  detalhe_display_footer_menu()
 */
add_action('detalhe_landing_footer', 'detalhe_display_footer_menu', 10);

/**
 * Others
 *
 * @see detalhe_custom_styles_and_scripts()
 */
add_action('wp_enqueue_scripts', 'detalhe_custom_styles_and_scripts');