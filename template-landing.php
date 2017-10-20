<?php
/**
 * The template for displaying the landing page. It will show a full page carousel only with a menu in the upper part.
 *
 * Template Name: Landing Page
 *
 * @package detalhe
 */

// Get the special header for landing
get_header('landing');

    /**
     * Functions hooked into detalhe_landing_page action
     *
     * @hooked detalhe_landing_carousel - 10
     */
    do_action( 'detalhe_landing_page' );


get_footer('landing');