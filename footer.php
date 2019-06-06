<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">

							<p>
                &copy; 2018 Rate My Pony | 
                <?php
                if (!is_user_logged_in()) {
                  echo '<a href="' .  wp_login_url(get_permalink()) . '">Kirjaudu sisään</a> tai ';
                  echo '<a href="' . site_url('/wp-login.php?action=register&redirect_to=' . get_permalink()) . '">Rekisteröidy</a>';
                }
                else {
                  echo '<a href="' .  wp_logout_url(get_permalink()) . '">Kirjaudu ulos</a>';
                }
                ?>
              </p>
					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>


</body>

</html>