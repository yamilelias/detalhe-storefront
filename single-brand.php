<?php
/**
 * The main template file for brands.
 *
 * @package detalhe-storefront
 */

get_header();

?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php
            /**
             * Functions hooked in to single-brand action
             *
             * @hooked recent_products           - 30
             * @hooked render_our_brands_section - 40
             * @hooked featured_products         - 90
             */
            do_action( 'single-brand' ); ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php

get_footer();
