<?php
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style('custom-styles', get_stylesheet_directory_uri() . '/css/custom.css');
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'popper-scripts', get_template_directory_uri() . '/js/popper.min.js', array(), false);
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function replace_core_jquery_version() {
    wp_deregister_script( 'jquery' );
    // Change the URL if you want to load a local copy of jQuery from your own server.
    wp_register_script( 'jquery', "https://code.jquery.com/jquery-3.1.1.min.js", array(), '3.1.1' );
}
add_action( 'wp_enqueue_scripts', 'replace_core_jquery_version' );

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'rmp-understrap', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

include_once('functions/objects.php');
include_once('functions/math.php');

// Lomakkeenkäsittelijät

function my_acf_submit_form( $form, $post_id ) {

    // Ensiarvostelu-lomake
    if ($form['id'] == "basic-evaluation-form") {
    $sire = get_field( "sire_id", $post_id );
    $dam = get_field( "dam_id", $post_id );
    $disc = get_field( "discipline", $post_id );
    $today = date("Y/m/d");

    if ($sire === NULL && $dam === NULL) {
      $horse = generateRandomHorse($disc);
      update_field( "sire_points", 0, $post_id );
      update_field( "dam_points", 0, $post_id );
    }
    else if ($sire === NULL || $dam === NULL) {
      if ($sire === NULL) {
        $sire = generateRandomHorse($disc);
        $dam = turnToObject($dam);
        update_field( "sire_points", 0, $post_id );
        update_field( "dam_points", 1, $post_id );
      }
      else if ($dam === NULL) {
        $sire = turnToObject($sire);
        $dam = generateRandomHorse($disc);
        update_field( "sire_points", 1, $post_id );
        update_field( "dam_points", 0, $post_id );
      }
      $horse = generateByParents($sire, $dam);
    }
    else {
      $sire = turnToObject($sire);
      $dam = turnToObject($dam);
      $horse = generateByParents($sire, $dam);
      update_field( "sire_points", 1, $post_id );
      update_field( "dam_points", 1, $post_id );
    }

    // Päivitä hevosen pistekenttiin uudet arvot
    update_field( "points_head", $horse->pointHead, $post_id );
    update_field( "points_head_pass", $horse->pointHeadPass, $post_id );
    update_field( "points_body", $horse->pointBody, $post_id );
    update_field( "points_body_pass", $horse->pointBodyPass, $post_id );
    update_field( "points_legs", $horse->pointLegs, $post_id );
    update_field( "points_legs_pass", $horse->pointLegsPass, $post_id );
    update_field( "points_walk", $horse->pointWalk, $post_id );
    update_field( "points_walk_pass", $horse->pointWalkPass, $post_id );
    update_field( "points_trot", $horse->pointTrot, $post_id );
    update_field( "points_trot_pass", $horse->pointTrotPass, $post_id );
    update_field( "points_canter", $horse->pointCanter, $post_id );
    update_field( "points_canter_pass", $horse->pointCanterPass, $post_id );
    update_field( "points_courage", $horse->pointCourage, $post_id );
    update_field( "points_courage_pass", $horse->pointCouragePass, $post_id );
    update_field( "points_obedience", $horse->pointObedience, $post_id );
    update_field( "points_obedience_pass", $horse->pointObediencePass, $post_id );
    update_field( "points_temperament", $horse->pointTemperament, $post_id );
    update_field( "points_temperament_pass", $horse->pointTemperamentPass, $post_id );
    update_field( "points_sensitivity", $horse->pointSensitivity, $post_id );
    update_field( "points_sensitivity_pass", $horse->pointSensitivityPass, $post_id );
    update_field( "points_intelligence", $horse->pointIntelligence, $post_id );
    update_field( "points_intelligence_pass", $horse->pointIntelligencePass, $post_id );
    update_field( "points_speed", $horse->pointSpeed, $post_id );
    update_field( "points_speed_pass", $horse->pointSpeedPass, $post_id );
    update_field( "points_endurance", $horse->pointEndurance, $post_id );
    update_field( "points_endurance_pass", $horse->pointEndurancePass, $post_id );
    update_field( "points_agility", $horse->pointAgility, $post_id );
    update_field( "points_agility_pass", $horse->pointAgilityPass, $post_id );
    update_field( "points_jump", $horse->pointJump, $post_id );
    update_field( "points_jump_pass", $horse->pointJumpPass, $post_id );
    update_field( "points_collection", $horse->pointCollection, $post_id );
    update_field( "points_collection_pass", $horse->pointCollectionPass, $post_id );
    update_field( "points_strength", $horse->pointStrength, $post_id );
    update_field( "points_strength_pass", $horse->pointStrengthPass, $post_id );
    update_field( "points_rideability", $horse->pointRideability, $post_id );
    update_field( "points_behaviour", $horse->pointBehaviour, $post_id );
    update_field( "conformation_grade", $horse->conformationGrade, $post_id );
    update_field( "gaits_grade", $horse->gaitsGrade, $post_id );
    update_field( "characteristics_grade", $horse->characteristicsGrade, $post_id );
    update_field( "skills_grade", $horse->skillsGrade, $post_id );
    update_field( "basic_evaluation_points", $horse->basicEvaluationPoints, $post_id );
    update_field( "basic_evaluation_grade", $horse->basicEvaluationGrade, $post_id );
    update_field( "registeration_date", $today, $post_id );
    update_field( "basic_evaluation_date", $today, $post_id );
    $user = wp_get_current_user();
    update_field( "owner_id", $user->ID, $post_id );
    update_field( "owner_id", $user->ID, $post_id );
    update_field( "owner_id_num", $user->ID, $post_id );
    $owner = get_field( "owner_id", $post_id);
    $history = get_field("owner_history", $post_id);
    $history .= $owner['display_name'] . ", alkaen " . date("d.m.Y");
    update_field( "owner_history", $history, $post_id );

    // redirect
    wp_redirect( get_site_url() . '/ensiarvostelu/?takaisin=' . $post_id);
  }

  // Hevosen tietojen muokkauslomake
  if ($form['id'] == "edit-horse-form") {

    $new_owner = get_field("owner_id", $post_id);
    $new_owner_id = $new_owner['ID'];
    $old_history = get_field("owner_history", $post_id);
    $old_history .= "\n" . $new_owner['display_name'] . ", alkaen " . date("d.m.Y");
    update_field( "owner_id_num", $new_owner_id, $post_id );
    update_field( "owner_history", $old_history, $post_id );

    wp_redirect( get_site_url() . '/horse/' . $post_id . '/?muokkaa=valmis');
  }

  // Lisää talli-lomake
  if ($form['id'] == "add-stable-form") {

    $today = date("Y/m/d");

    $user = wp_get_current_user();
    update_field( "owner_id", $user->ID, $post_id );
    update_field( "owner_id_num", $user->ID, $post_id );
    update_field( "registeration_date", $today, $post_id );

    wp_redirect( get_site_url() . '/lisaa-talli/?takaisin=' . $post_id);
  }

	exit;
}
add_action('acf/submit_form', 'my_acf_submit_form', 10, 2);

// Yksittäisen ominaisuuspistetulokste progress-bar hevosprofiiliin
function printPoints($value, $text) {
    if ($value < 21) { $class = "bg-danger"; }
    else if ($value < 51) { $class = "bg-warning"; }
    else if ($value < 81) { $class = "bg-info"; }
    else { $class = "bg-success"; }
    return '<div><strong>' . $text . '</strong> <small><em>' . giveGrade($value) . '</em></small>
    <div class="progress">
    <div class="progress-bar ' . $class . '" role="progressbar" aria-valuenow="' . $value . '"
    aria-valuemin="0" aria-valuemax="100" style="width:' . $value . '%">'.
    $value . ' p.</div></div></div>';
}

// Lomakkeen käsittelijän GET_parameteri-avusteet
function add_query_vars_filter( $vars ) {

    $vars[] = "takaisin";
    $vars[] = "muokkaa";
    return $vars;

}
add_filter( 'query_vars', 'add_query_vars_filter' );

// Title-kentän nimen muutos
function my_acf_prepare_field( $field ) {

    $field['label'] = "Nimi";
    return $field;

}
add_filter('acf/prepare_field/name=_post_title', 'my_acf_prepare_field');

// Owner_id-kentän nimen muutos
function my_acf_prepare_field2( $field ) {

    $field['label'] = "Vaihda omistajaa";
    return $field;

}
add_filter('acf/prepare_field/name=owner_id', 'my_acf_prepare_field2');

// painike-shortcode
function tee_painike($atts) {
    $a = shortcode_atts( array(
        'teksti' => null,
        'url' => null,
    ), $atts );
    if ($a['teksti'] != null && $a['url'] != null) {
        $painike = '<a href="' . $a['url'] . '" class="btn btn-primary" role="button">' . $a['teksti'] . '</a>';
        return $painike;
    }
    else {
        return;
    }
}
add_shortcode( 'painike', 'tee_painike' );

// Näytä oikea palkinto profiilissa
function printRosette($grade) {
  if ($grade == "1 Star Prospect") {
    $rname = "rosette1.jpg";
  }
  else if ($grade == "2 Star Prospect") {
    $rname = "rosette2.jpg";
  }
  else if ($grade == "3 Star Prospect") {
    $rname = "rosette3.jpg";
  }
  else if ($grade == "4 Star Prospect") {
    $rname = "rosette4.jpg";
  }
  else if ($grade == "5 Star Prospect") {
    $rname = "rosette5.jpg";
  }
  return $grade;
}

// Tulosta vanhemman tiedot sukutauluun
function printPedigreeParent($p_id) {
  if ($p_id != null) {
    $height = get_field("height", $p_id);
    $breed_ID = get_field("breed", $p_id);
    $breed = get_field("short", $breed_ID);
    $sex = get_field_object('sex', $p_id);
    $sex_value = $sex['value'];
    $sex_label = $sex['choices'][ $sex_value ];
    $parent = '<a href="' . get_post_permalink($p_id) . '">' . get_the_title($p_id) . '</a><br><small>' . $breed . ', ' . $sex_label . ', ' . $height . 'cm</small><br>' . printRosette(get_field("basic_evaluation_grade", $p_id));
    return $parent;
  }
  else {
    return "<em>hevosta ei ole arvosteltu</em>";
  }
}
