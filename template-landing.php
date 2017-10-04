<?php
/**
 * The template for displaying the landing page. Please not that is not more than a header and a footer, without content.
 *
 * Template Name: Landing Page
 *
 * @package detalhe
 */

// Get the special header for landing
get_header('landing');
?>
<div id="landing-image">
    <div>
        <img src="<?php get_landing_image_url() ?>" alt="" />
    </div>
</div>


<?php
// There is no footer in the landing page