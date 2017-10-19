<?php
/**
 * Author: yamilelias
 * Author URI: <yamileliassoto@gmail.com>
 * Date: 16/10/17
 * Time: 12:14 PM
 *
 * The template for displaying all the current brands that exist. This page template will display any functions hooked into the `brands` action.
 *
 * Template name: Display Brands
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php
            /**
             * Functions hooked in to brands action
             *
             * @hooked show_existing_brands      - 10
             */
            do_action( 'brands_view' ); ?>

        </main><!-- #main -->
    </div><!-- #primary -->
<?php
get_footer();