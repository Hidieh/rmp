<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

acf_form_head(); 
get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>
<?php include_once('functions/objects.php'); ?>
<?php include_once('functions/math.php'); ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'loop-templates/content', get_post_format() );
						?>

					<?php endwhile; ?>

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>
        
				<?php endif; ?>
        <?php $idi = get_query_var( 'takaisin', 0 );  ?>
        <?php
        if ($idi != 0) {
        ?>
        <div class="alert alert-success" role="alert">
          <a href="<?php echo get_permalink($idi); ?>"><?php echo get_the_title($idi); ?></a> arvioitiin onnistuneesti! Hevonen sai <?php echo get_field("basic_evaluation_points", $idi); ?> pistettä ja arvosanan <strong><?php echo get_field("basic_evaluation_grade", $idi); ?></strong>
        </div>
        <?php } ?>
        
        <div class="card">
          <div class="card-header">
            Tuo hevonen ensiarvosteluun
          </div>
          <div class="card-body">
            <?php 
              $new_post = array(
                'id'                 => 'basic-evaluation-form',
                'post_id'            => 'new_post',
                'form'               => true,
                'post_title'         => true,
                'field_groups'       => array(27),
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
        
<!--
        <h2>
          Value testing
        </h2>

       <?php

          $isa = new Horse();
          $ema = new Horse();
          $isa = generateRandomHorse();
          $ema = generateRandomHorse();

          $varsa = generateByParents($isa, $ema);
          $varsa2 = generateByParents($isa, $ema);
        ?>

        <table class="taulukko">
          <thead>
            <tr>
              <th>Arvo</th>
              <th>Isä</th>
              <th>Emä</th>
              <th>Varsa</th>
              <th>Varsa2</th>
            </tr>
          </thead>
          <tbody>
            <tr class="overview"><?php $property = "conformationGrade"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property); ?> %</td>
              <td><?php echo $ema->getProperty($property); ?> %</td>
              <td><?php echo $varsa->getProperty($property); ?> %</td>
              <td><?php echo $varsa2->getProperty($property); ?> %</td>
            </tr>
            <tr><?php $property = "pointHead"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointBody"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointLegs"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr class="overview"><?php $property = "gaitsGrade"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property); ?> %</td>
              <td><?php echo $ema->getProperty($property); ?> %</td>
              <td><?php echo $varsa->getProperty($property); ?> %</td>
              <td><?php echo $varsa2->getProperty($property); ?> %</td>
            </tr>
            <tr><?php $property = "pointWalk"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointTrot"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointCanter"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr class="overview"><?php $property = "characteristicsGrade"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property); ?> %</td>
              <td><?php echo $ema->getProperty($property); ?> %</td>
              <td><?php echo $varsa->getProperty($property); ?> %</td>
              <td><?php echo $varsa2->getProperty($property); ?> %</td>
            </tr>
            <tr><?php $property = "pointCourage"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointObedience"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointTemperament"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointSensitivity"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointIntelligence"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr class="overview"><?php $property = "skillsGrade"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property); ?> %</td>
              <td><?php echo $ema->getProperty($property); ?> %</td>
              <td><?php echo $varsa->getProperty($property); ?> %</td>
              <td><?php echo $varsa2->getProperty($property); ?> %</td>
            </tr>
            <tr><?php $property = "pointSpeed"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointEndurance"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointAgility"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointJump"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointCollection"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr><?php $property = "pointStrength"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property) . " <small>" . $isa->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($isa->getProperty($property)); ?></em></td>
              <td><?php echo $ema->getProperty($property) . " <small>" . $ema->getProperty($property . "Pass") . "</small>"; ?> <em><?php echo giveGrade($ema->getProperty($property)); ?></em></td>
              <td><?php echo $varsa->getProperty($property); ?> <em><?php echo giveGrade($varsa->getProperty($property)); ?></em></td>
              <td><?php echo $varsa2->getProperty($property); ?> <em><?php echo giveGrade($varsa2->getProperty($property)); ?></em></td>
            </tr>
            <tr class="overview"><?php $property = "pointRideability"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property); ?></td>
              <td><?php echo $ema->getProperty($property); ?></td>
              <td><?php echo $varsa->getProperty($property); ?></td>
              <td><?php echo $varsa2->getProperty($property); ?></td>
            </tr>
            <tr class="overview"><?php $property = "pointBehaviour"; ?>
              <td><?php echo $property; ?></td>
              <td><?php echo $isa->getProperty($property); ?></td>
              <td><?php echo $ema->getProperty($property); ?></td>
              <td><?php echo $varsa->getProperty($property); ?></td>
              <td><?php echo $varsa2->getProperty($property); ?></td>
            </tr>
            <tr class="total">
              <td>Total Points:</td>
              <td><strong><?php echo $isa->getProperty("basicEvaluationPoints"); ?></strong></td>
              <td><strong><?php echo $ema->getProperty("basicEvaluationPoints"); ?></strong></td>
              <td><strong style="color:red;"><?php echo $varsa->getProperty("basicEvaluationPoints"); ?></strong></td>
              <td><strong style="color:red;"><?php echo $varsa2->getProperty("basicEvaluationPoints"); ?></strong></td>
            </tr>
            <tr class="total">
              <td>Prize:</td>
              <td><strong><?php echo $isa->getProperty("basicEvaluationGrade"); ?></strong></td>
              <td><strong><?php echo $ema->getProperty("basicEvaluationGrade"); ?></strong></td>
              <td><strong style="color:red;"><?php echo $varsa->getProperty("basicEvaluationGrade"); ?></strong></td>
              <td><strong style="color:red;"><?php echo $varsa2->getProperty("basicEvaluationGrade"); ?></strong></td>
            </tr>
          </tbody>
        </table>
-->
			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>
		

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
