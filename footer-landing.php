<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package detalhe
 */

?>

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="landing-menu">
			<?php
			/**
			 * Functions hooked in to detalhe_landing_footer action
			 *
			 * @hooked detalhe_display_footer_menu - 10
			 */
			do_action( 'detalhe_landing_footer' ); ?>

	</footer>

	<?php do_action( 'storefront_after_footer' ); ?>

<?php wp_footer(); ?>

</body>
</html>
