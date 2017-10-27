<?php
/**
 * The main template file for brands.
 *
 * @package detalhe-storefront
 */

get_header();

?>

    <div id="primary" class="content-area brand-page">
        <main id="main" class="site-main" role="main">

            <?php
            /**
             * Functions hooked in to single-brand action
             *
             * @hooked recent_products           - 20
             * @hooked show_other_brands_section - 30
             */
            do_action( 'single_brand' );
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php

get_footer();
