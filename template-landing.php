<?php
/**
 * The template for displaying the landing page.
 *
 * Template Name: Landing Page
 *
 */

// Get the special header for landing
get_header('landing');
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            <img alt="Welcome image" src="<?php echo get_template_directory() . '/assets/images/detalhe/welcome.jpg' ?>">
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// Get the special footer for landing
get_footer('landing');
