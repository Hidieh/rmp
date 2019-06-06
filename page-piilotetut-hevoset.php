<?php
/**
 * Template file for user profile
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
  <?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

    <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

        <div class="row">

            <!-- Do the left sidebar check and opens the primary div -->
            <?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

            <main class="site-main" id="main">

                <?php if ( have_posts() ) : ?>

                    <?php /* Start the Loop */ ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                      <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                        <h1>Profiilista piilotetut hevoset</h1>

                        <p>Tällä sivulla näet profiilistasi piilottamasi hevoset.</p>

                        <?php
                        $current = get_current_user_id();
                        $owner = get_field("owner_id", get_the_ID());
                        if ($current == $owner['ID']) {
                        ?>

                        <?php
                           $args = array(
                              'numberposts'	=> -1,
                              'post_type'		=> 'horse',
                              'meta_query'	=> array(
                                'relation'		=> 'AND',
                                array(
                                  'key'	  	=> 'owner_id',
                                  'value'	  	=> get_the_ID(),
                                  'compare' 	=> '=',
                                ),
                                array(
                                  'key'	  	=> 'show_horse_profile',
                                  'value'	  	=> 0,
                                  'compare' 	=> '=',
                                ),
                              ));
                          // query
                          $the_query = new WP_Query( $args );
                          ?>
                          <?php if( $the_query->have_posts() ): ?>
                          <table class="table horse-list-profile">
                            <thead>
                              <tr>
                                <th>Hevonen</th>
                                <th>Painotus</th>
                                <th>Ensiarvostelutulos</th>
                              </tr>
                            </thead>
                          <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <?php
                            $breed_ID = get_field("breed");
                            $breed = get_field("short", $breed_ID);
                            $disc = get_field_object("discipline");
                            $disc_value = $disc['value'];
                            $disc_label = $disc['choices'][$disc_value];
                            $skp = get_field_object('sex');
                            $skp_value = $skp['value'];
                            if ($skp_value == '0') { $sex = 't'; }
                            else if ($skp_value == '1') { $sex = 'o'; }
                            else if ($skp_value == '2') { $sex = 'r'; }
                            ?>
                            <tr>
                              <td><?php echo $breed; ?>-<?php echo $sex; ?> <a href="<?php echo get_post_permalink(); ?>"><?php the_title(); ?></a></td>
                              <td><?php echo $disc_label; ?></td>
                              <td><strong><?php echo get_field("basic_evaluation_grade"); ?></strong> <small><?php echo get_field("basic_evaluation_points"); ?>/1900p.</small></td>
                            </tr>
                          <?php endwhile; ?>
                          </table>
                        <?php endif; ?>

                        <?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>

                        <?php } ?>

                    <?php endwhile; ?>

                <?php else : ?>

                    <?php get_template_part( 'loop-templates/content', 'stable-horse-profile' ); ?>

                <?php endif; ?>

            </main><!-- #main -->

        <!-- Do the right sidebar check -->
        <?php get_template_part( 'global-templates/right-sidebar-check' ); ?>


    </div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
