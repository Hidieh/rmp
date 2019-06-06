<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

    <h1 class="entry-title"><?php the_title(); ?></h1>

	</header><!-- .entry-header -->

	<div class="entry-content">

    <?php echo get_the_content(); ?>

    <?php $idi = get_query_var( 'takaisin', 0 );  ?>
    <?php if ($idi != 0) { ?>
    <div class="alert alert-success" role="alert">
      <a href="<?php echo get_permalink($idi); ?>"><?php echo get_the_title($idi); ?></a> arvioitiin onnistuneesti! Hevonen sai <?php echo get_field("basic_evaluation_points", $idi); ?> pistettä ja 
      arvosanan <strong><?php echo get_field("basic_evaluation_grade", $idi); ?></strong>. Katso tarkemmat tulokset <a href="<?php echo get_permalink($idi); ?>" target="_blank">täältä</a>!
    </div>
    <?php } ?>
    <?php if(is_user_logged_in()) { ?>
    <div class="card mt-3">
      <div class="card-body">
        <?php
          $new_post = array(
            'id'                 => 'basic-evaluation-form',
            'post_id'            => 'new_post',
            'form'               => true,
            'post_title'         => true,
            'field_groups'       => array(12),
            'submit_value'       => 'Arvioi tämä hevonen',
            'html_submit_button'	=> '<input type="submit" class="btn btn-primary" value="%s" />',
            'new_post'		  => array(
              'post_type'		=> 'horse',
              'post_status'	=> 'publish'
            ),
          );
          acf_form( $new_post );
          ?>
      </div>
    </div>
    <?php }
    else { ?>
    <p>
      Sinun tulee olla kirjautuneena sisään tuodaksesi hevosen ensiarvosteluun.
    </p>
    <?php } ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
