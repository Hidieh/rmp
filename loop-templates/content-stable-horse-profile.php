<?php
global $current_user;
wp_get_current_user();
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

    <h1 class="entry-title">Omat tallit ja hevoset : <?php echo $current_user->display_name; ?> <small>#<?php echo $current_user->ID; ?></small></h1>

	</header><!-- .entry-header -->

	<div class="entry-content">

    <?php echo get_the_content(); ?>
        <h2>
          Tallit
        </h2>

        <p>
          <a href="<?php echo get_permalink(get_page_by_title('Lisää talli')); ?>" role="button" class="btn btn-sm btn-primary">Lisää talli</a>
        </p>

        <?php
          $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'stable',
						'meta_key'		=> 'owner_id_num',
						'meta_value'	=> $current_user->ID
           );
          // query
          $the_query = new WP_Query( $args );
          ?>
          <?php if( $the_query->have_posts() ): ?>
          <ul>
          <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <li>
                <a href="<?php echo get_post_permalink(); ?>"><?php the_title(); ?></a>
            </li>
          <?php endwhile; ?>
          </ul>
          <?php endif; ?>

          <?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>

        <h2>
          Hevoset
        </h2>

				<p><a href="http://www.megasim.eu/rmp/piilotetut-hevoset/">Profiilista piilotetut hevoset</a></p>

        <p>
          <a href="<?php echo get_permalink(get_page_by_title('Ensiarvostelu')); ?>" role="button" class="btn btn-sm btn-primary">Tuo hevonen ensiarvosteluun</a>
        </p>

         <?php
           $args = array(
              'numberposts'	=> -1,
              'post_type'		=> 'horse',
              'meta_query'	=> array(
                'relation'		=> 'AND',
                array(
                  'key'	  	=> 'owner_id_num',
                  'value'	  	=> $current_user->ID,
                  'compare' 	=> '=',
                ),
                array(
                  'key'	  	=> 'show_horse_profile',
                  'value'	  	=> '1',
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
                <th>Talli</th>
                <th>Ensiarvostelutulos</th>
              </tr>
            </thead>
          <?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <?php
            $breed_ID = get_field("breed");
            $breed = get_field("short", $breed_ID);
            $disc = get_field_object("discipline");
            $disc_value = $disc['value'];
            $disc_label = $disc['choices'][ $disc_value ];
            $skp = get_field_object('sex');
            $skp_value = $skp['value'];
            if ($skp_value == '0') { $sex = 't'; }
            else if ($skp_value == '1') { $sex = 'o'; }
            else if ($skp_value == '2') { $sex = 'r'; }
            ?>
            <tr>
              <td><?php echo $breed; ?>-<?php echo $sex; ?> <a href="<?php echo get_post_permalink(); ?>"><?php the_title(); ?></a></td>
              <td><?php echo $disc_label; ?></td>
              <td><?php if(get_field("stable_id", get_the_ID())) { echo get_the_title(get_field("stable_id", get_the_ID())); } else { echo '-'; } ?></td>
              <td><strong><?php echo get_field("basic_evaluation_grade"); ?></strong> <small><?php echo get_field("basic_evaluation_points"); ?>/1900p.</small></td>
            </tr>
          <?php endwhile; ?>
          </table>
        <?php endif; ?>

        <?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
