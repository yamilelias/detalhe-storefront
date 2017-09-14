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
 */
add_action('detalhe_landing_header', 'detalhe_display_landing_logo', 10);

/**
 * Landing Footer
 *
 * @see  detalhe_display_footer_menu()
 */
add_action('detalhe_landing_footer', 'detalhe_display_footer_menu', 10);

/**
 * Others
 */
add_action('wp_enqueue_scripts', 'detalhe_custom_styles_and_scripts');