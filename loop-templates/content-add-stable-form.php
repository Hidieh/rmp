<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

    <h1 class="entry-title"><?php the_title(); ?></h1>

	</header><!-- .entry-header -->

	<div class="entry-content">
    
    <?php echo get_the_content(); ?>
    
    <?php $idi = get_query_var( 'takaisin', 0 );  ?>
    <?php
    if ($idi != 0) {
    ?>
    <div class="alert alert-success" role="alert">
      <?php echo get_the_title($idi); ?> lisättiin onnistuneesti talleihisi.
    </div>
    <?php } ?>
    
    <?php if(is_user_logged_in()) { ?>
    <div class="card mt-3">
      <div class="card-body">
        <?php 
          $new_post = array(
            'id'                 => 'add-stable-form',
            'post_id'            => 'new_post',
            'form'               => true,
            'post_title'         => true,
            'fields'             => array('url', 'about', 'breeder_prefix'),
            'submit_value'       => 'Lisää talli',
            'html_submit_button'	=> '<input type="submit" class="btn btn-primary" value="%s" />',
            'new_post'		  => array(
              'post_type'		=> 'stable',
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
      Kirjaudu sisään voidaksesi lisätä tallin.
    </p>
    <?php } ?>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
