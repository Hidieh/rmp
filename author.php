<?php
/**
 * The template for displaying the author pages.
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package understrap
 */

get_header();
$container   = get_theme_mod( 'understrap_container_type' );
?>


<div class="wrapper" id="author-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<header class="page-header author-header">

					<?php
					$curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug',
						$author_name ) : get_userdata( intval( $author ) );
					?>

					<h1><?php echo esc_html( $curauth->display_name ); ?></h1>

					<!-- <?php if ( ! empty( $curauth->ID ) ) : ?>
						<?php echo get_avatar( $curauth->ID ); ?>
					<?php endif; ?> -->
          
          <?php $testid = get_current_user_id(); if( $testid = $curauth->ID) { ?>
          <p>
            <a href="<?php echo get_edit_user_link(); ?>">Muokkaa omia tietoja</a>
          </p>
          <?php } ?>

					<dl>
						<?php if ( ! empty( $curauth->user_url ) ) : ?>
							<dt><?php esc_html_e( 'Website', 'understrap' ); ?></dt>
							<dd>
								<a href="<?php echo esc_url( $curauth->user_url ); ?>"><?php echo esc_html( $curauth->user_url ); ?></a>
							</dd>
						<?php endif; ?>

						<?php if ( ! empty( $curauth->user_description ) ) : ?>
							<dt><?php esc_html_e( 'Profile', 'understrap' ); ?></dt>
							<dd><?php echo esc_html( $curauth->user_description ); ?></dd>
						<?php endif; ?>
            
					</dl>

				</header><!-- .page-header -->
        
        <div class="entry-content">
          <h2>
            Tallit
          </h2>
          
          <?php if( $testid = $curauth->ID) { ?>
          <a href="" role="button" class="btn btn-primary btn-sm mb-3">Lisää uusi talli</a>
          <?php } ?>
          
          <?php 
          $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'stable',
            'meta_query'	=> array(
              'relation'		=> 'AND',
              array(
                'key'	  	=> 'owner_id_num',
                'value'	  	=> $curauth->ID,
                'compare' 	=> '=',
              ),
           ));
          // query
          $the_query = new WP_Query( $args );
          ?>
          <?php if( $the_query->have_posts() ): ?>
          <ul>
          <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <li>
                <?php the_title(); ?>
              </a>
            </li>
          <?php endwhile; ?>
          </ul>
          <?php endif; ?>

          <?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>
         
          <h2>
            Hevoset
          </h2>
      
          <?php if( $testid = $curauth->ID) { ?>
          <a href="" role="button" class="btn btn-primary btn-sm mb-3">Tuo uusi hevonen ensiarvosteluun</a>
          <?php } ?>
      
          <?php 
           $args = array(
              'numberposts'	=> -1,
              'post_type'		=> 'horse',
              'meta_query'	=> array(
                'relation'		=> 'AND',
                array(
                  'key'	  	=> 'owner_id_num',
                  'value'	  	=> $curauth->ID,
                  'compare' 	=> '=',
                ),
              ));
          // query
          $the_query = new WP_Query( $args );
          ?>
          <?php if( $the_query->have_posts() ): ?>
          <ul>
          <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <li>
              <a href="<?php echo get_post_permalink(); ?>"><?php the_title(); ?></a> <?php echo get_field("basic_evaluation_grade"); ?> <small><?php echo get_field("basic_evaluation_points"); ?>/1900p.</small>
            </li>
          <?php endwhile; ?>
          </ul>
        <?php endif; ?>

        <?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>
        </div>


			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

	</div> <!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
