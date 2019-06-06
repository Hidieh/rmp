<?php

/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

   <?php $idi = get_query_var( 'muokkaa', "0" );  ?>
        <?php
        if ($idi == "valmis") {
          echo '<div class="alert alert-success" role="alert">Tallin tietoja muokattiin onnistuneesti</div>';
        }
        else if ($idi == "0") {

        }
        else {

        }
        ?>

	<header class="entry-header">

    <h1 class="entry-title"><?php the_title(); ?> <small>#<?php the_ID(); ?></small></h1>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

    <div class="profile-info row">
        <dl class="row">
        <dt class="col-sm-3">Omistaja(t)</dt>
        <?php
          $user_info = get_field("owner_id", get_the_ID());

          $args = array(
             'numberposts'	=> -1,
             'posts_per_page' => -1,
             'post_type'		=> 'horse',
             'meta_query'	=> array(
               'relation'		=> 'AND',
               array(
                 'key'	  	=> 'stable_id',
                 'value'	  	=> get_the_ID(),
                 'compare' 	=> '=',
               ),
               array(
                 'key'	  	=> 'show_horse_profile',
                 'value'	  	=> 1,
                 'compare' 	=> '=',
               ),
             ));
         // query
         $the_query = new WP_Query( $args );
         $horsecount = count($the_query->posts);
         wp_reset_query();
         $args = array(
            'numberposts'	=> -1,
            'posts_per_page' => -1,
            'post_type'		=> 'horse',
            'meta_query'	=> array(
              'relation'		=> 'AND',
              array(
                'key'	  	=> 'breeder_stable_id',
                'value'	  	=> get_the_ID(),
                'compare' 	=> '=',
              ),
              array(
                'key'	  	=> 'show_horse_profile',
                'value'	  	=> 1,
                'compare' 	=> '=',
              ),
            ));
        // query
        $the_query = new WP_Query( $args );
        $breedhorsecount = count($the_query->posts);
        wp_reset_query();
        ?>
        <dd class="col-sm-9"><?php echo '<a href="' . get_author_posts_url($user_info['ID']) . '">' . $user_info['display_name'] . '</a>'; ?></dd>
        <dt class="col-sm-3">Hevosia yhteensä</dt>
        <dd class="col-sm-9"><?php echo $horsecount; ?> kpl</dd>
        <dt class="col-sm-3">Kasvatteja yhteensä</dt>
        <dd class="col-sm-9"><?php echo $breedhorsecount; ?> kpl</dd>
      </dl>
        <?php
        if (get_field("url", get_the_ID())) {
        ?>
        <div class="clearfix"></div>
        <a class="btn btn-primary btn-sm" href="<?php echo get_field("url", get_the_ID()); ?>" target="_blank" role="button">Tallin omat WWW-sivut</a>
        <?php } ?>
    </div>

    <ul class="nav nav-pills horse-profile-pills mt-3 mb-3" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-horses-tab" data-toggle="pill" href="#pills-horses" role="tab" aria-controls="pills-horses" aria-selected="true">Tallin hevoset</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-homebreds-tab" data-toggle="pill" href="#pills-homebreds" role="tab" aria-controls="pills-homebreds" aria-selected="false">Tallin kasvatit</a>
      </li>
      <?php
      $current = get_current_user_id();
      $owner = get_field("owner_id", get_the_ID());
      if ($current == $owner['ID']) {
      ?>
      <li class="nav-item">
        <a class="nav-link" id="pills-edit-stable-tab" data-toggle="pill" href="#pills-edit-stable" role="tab" aria-controls="pills-edit-stable" aria-selected="false">Muokkaa tallin tietoja</a>
      </li>
      <?php } ?>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-horses" role="tabpanel" aria-labelledby="pills-horses-tab">
        <h2>
          Tallin hevoset
        </h2>

        <?php
           $args = array(
              'numberposts'	=> -1,
              'posts_per_page' => -1,
              'post_type'		=> 'horse',
              'meta_query'	=> array(
                'relation'		=> 'AND',
                array(
                  'key'	  	=> 'stable_id',
                  'value'	  	=> get_the_ID(),
                  'compare' 	=> '=',
                ),
                array(
                  'key'	  	=> 'show_horse_profile',
                  'value'	  	=> 1,
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


      </div>
      <div class="tab-pane fade" id="pills-homebreds" role="tabpanel" aria-labelledby="pills-homebreds-tab">
        <h2>
          Tallin kasvatit
        </h2>

        <?php
           $args = array(
              'numberposts'	=> -1,
              'posts_per_page' => -1,
              'post_type'		=> 'horse',
              'meta_query'	=> array(
                'relation'		=> 'AND',
                array(
                  'key'	  	=> 'breeder_stable_id',
                  'value'	  	=> get_the_ID(),
                  'compare' 	=> '=',
                ),
                array(
                  'key'	  	=> 'show_horse_profile',
                  'value'	  	=> 1,
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

      </div>

      <div class="tab-pane fade" id="pills-edit-stable" role="tabpanel" aria-labelledby="pills-edit-stable-tab">
        <h2>
          Muokkaa tallin tietoja
        </h2>

        <?php
        $args = array('url', 'owner_id', 'about', 'breeder_prefix');
        ?>

        <?php
        $edit_post = array(
          'id'                 => 'edit-stable-form',
          'post_id'            => get_the_ID(),
          'form'               => true,
          'fields'             => $args,
          'submit_value'       => 'Tallenna muutokset',
          'html_submit_button'	=> '<input type="submit" class="btn btn-primary" value="%s" />',

        );
        acf_form( $edit_post );
        ?>

      </div>
    </div>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
