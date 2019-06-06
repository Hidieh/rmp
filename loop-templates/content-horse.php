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
          echo '<div class="alert alert-success" role="alert">Hevosen tietoja muokattiin onnistuneesti</div>';
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

        <?php

        if (class_exists('ACFAllObj')) {
            $breeds = ACFAllObj::get('breed', get_the_ID());
            $height = ACFAllObj::get('height', get_the_ID());
            $dob = ACFAllObj::get('date_of_birth', get_the_ID());
            $owner_id = ACFAllObj::get('owner_id', get_the_ID());
            $breeder = ACFAllObj::get('breeder_id', get_the_ID());
            $breeder_stable = ACFAllObj::get('breeder_stable_id', get_the_ID());
            $pedigree = ACFAllObj::get('no_pedigree', get_the_ID());
            $stable = ACFAllObj::get('stable_id', get_the_ID());
            $vh_id = ACFAllObj::get('vh_id', get_the_ID());
            $dam = ACFAllObj::get('dam_id', get_the_ID());
            $dam_points = ACFAllObj::get('dam_points', get_the_ID());
            $sire = ACFAllObj::get('sire_id', get_the_ID());
            $sire_points = ACFAllObj::get('sire_points', get_the_ID());
            $url = ACFAllObj::get('url', get_the_ID());
            $basic_grade = ACFAllObj::get('basic_evaluation_grade', get_the_ID());
            $basic_points = ACFAllObj::get('basic_evaluation_points', get_the_ID());
            $points_behaviour = ACFAllObj::get('points_behaviour', get_the_ID());
        } else {
            $breeds = get_field('breed', get_the_ID());
            $height = get_field('height', get_the_ID());
            $dob = get_field('date_of_birth', get_the_ID());
            $owner_id = get_field('owner_id', get_the_ID());
            $breeder = get_field('breeder_id', get_the_ID());
            $breeder_stable = get_field('breeder_stable_id', get_the_ID());
            $pedigree = get_field('no_predigree', get_the_ID());
            $stable = get_field('stable_id', get_the_ID());
            $vh_id = get_field("vh_id", get_the_ID());
            $dam = get_field('dam_id', get_the_ID());
            $dam_points = get_field('dam_points', get_the_ID());
            $sire = get_field('sire_id', get_the_ID());
            $sire_points = get_field('sire_points', get_the_ID());
            $url = get_field('sire_points', get_the_ID());
            $basic_grade = get_field('basic_evaluation_grade', get_the_ID());
            $basic_points = get_field('basic_evaluation_points', get_the_ID());
            $points_behaviour = get_field("points_behaviour", get_the_ID());
        }
        if ($dob) {
            $birthdate = date("d.m.Y", strtotime($dob));
        }
        else {
            $birthdate = '-';
        }

        $breed = get_the_title($breeds);
        $owner = get_userdata($owner_id);

        ?>
    <div class="profile-info row">
      <div class="col-md-6">
        <dl class="row">
        <dt class="col-sm-3">Rotu</dt>
        <dd class="col-sm-9"><?php echo $breed; ?></dd>
        <dt class="col-sm-3">Sukupuoli</dt>
        <?php
          $skp = get_field_object('sex');
          $skp_value = $skp['value'];
          $skp_label = $skp['choices'][ $skp_value ];
        ?>
        <dd class="col-sm-9"><?php echo $skp_label; ?>
        <dt class="col-sm-3">Säkäkorkeus</dt>
        <dd class="col-sm-9"><?php echo $height; ?>cm</dd>
        <dt class="col-sm-3">Syntymäaika</dt>
        <dd class="col-sm-9"><?php echo $birthdate; ?></dd>
        <dt class="col-sm-3">Painotus</dt>
        <?php
          $disc = get_field_object('discipline');
          $disc_value = $disc['value'];
          $disc_label = $disc['choices'][ $disc_value ];
        ?>
        <dd class="col-sm-9"><?php echo $disc_label; ?></dd>
        <dt class="col-sm-3">Omistaja</dt>
        <dd class="col-sm-9"><?php echo '<a href="' . get_author_posts_url($owner_id) . '">' . $owner->display_name . '</a>'; ?></dd>
        <dt class="col-sm-3">Kotitalli</dt>
        <dd class="col-sm-9"><?php if ($stable > '0') { echo '<a href="' . get_permalink( $stable ) . '">' . get_the_title($stable) . '</a>'; } else { echo '-'; } ?></dd>
        <dt class="col-sm-3">Kasvattaja</dt>
        <dd class="col-sm-9"><?php
        if($pedigree == '1') { echo "<em>evm</em>"; }
        else if($breeder) { echo '<a href="' . get_author_posts_url($breeder['ID']) . '">' . $breeder['display_name'] . '</a>'; }
        else { echo '-'; } ?>
        <?php if ($breeder && $breeder_stable) { echo ", "; } ?>
        <?php
        if($breeder_stable) { echo '<a href="' . get_post_permalink($breeder_stable) . '">' . get_the_title($breeder_stable) . '</a>'; } ?>
        </dd>
        <dt class="col-sm-3">VH-tunnus</dt>
        <dd class="col-sm-9"><?php if($vh_id) { echo '<a href="http://www.virtuaalihevoset.net/?hevoset/hevosrekisteri/hevonen.html?vh=' . $vh_id . '">' . $vh_id . '</a>'; } else { echo '-';} ?></dd>
        <dt class="col-sm-3">Isä</dt>
        <dd class="col-sm-9"><?php if($pedigree == '1') { echo "evm";}
          else if($sire) {
            echo '<a href="' . get_permalink($sire) . '" target="_blank">' . get_the_title($sire) . '</a>';
            if ($sire_points == 0) { echo ' <small><em>ei otettu huomioon ensiarvostelussa</em></small>'; }
          }
          else { echo '<em>isää ei ole arvosteltu</em>';} ?></dd>
        <dt class="col-sm-3">Emä</dt>
        <dd class="col-sm-9"><?php if($pedigree == '1') { echo "evm";}
          else if($dam) {
          echo '<a href="' . get_permalink($dam) . '" target="_blank">' . get_the_title($dam) . '</a>';
          if ($dam_points == 0) { echo ' <small><em>ei otettu huomioon ensiarvostelussa</em></small>'; }
          }
          else { echo '<em>emää ei ole arvosteltu</em>';} ?></dd>
      </dl>
        <?php
        if ($url) {
        ?>
        <a class="btn btn-primary btn-sm" href="<?php echo $url; ?>" target="_blank" role="button">Hevosen omat WWW-sivut</a>
        <?php } ?>
      </div>
      <div class="col-md-6">
        <div class="card mx-auto" style="width: 60%;">

          <div class="card-body text-center">
            <?php
            if ($basic_grade == "1 Star Prospect") { echo '<img src="' . get_stylesheet_directory_uri() . '/img/1-star-prospect.png" alt="1 Star Prospect">'; }
            else if ($basic_grade == "2 Star Prospect") { echo '<img src="' . get_stylesheet_directory_uri() . '/img/2-star-prospect.png" alt="2 Star Prospect">'; }
            else if ($basic_grade == "3 Star Prospect") { echo '<img src="' . get_stylesheet_directory_uri() . '/img/3-star-prospect.png" alt="3 Star Prospect">'; }
            else if ($basic_grade == "4 Star Prospect") { echo '<img src="' . get_stylesheet_directory_uri() . '/img/4-star-prospect.png" alt="4 Star Prospect">'; }
            else if ($basic_grade == "5 Star Prospect") { echo '<img src="' . get_stylesheet_directory_uri() . '/img/5-star-prospect.png" alt="5 Star Prospect">'; }
            ?>
            <h5 class="card-title"><?php echo $basic_grade; ?></h5>
            <p class="card-text"><?php echo $basic_points; ?>/1900 pistettä</p>
          </div>
        </div>
      </div>
    </div>

    <ul class="nav nav-pills horse-profile-pills mt-3" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-evaluation-tab" data-toggle="pill" href="#pills-evaluation" role="tab" aria-controls="pills-evaluation" aria-selected="true">Arvostelutulokset</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-copy-code-tab" data-toggle="pill" href="#pills-copy-code" role="tab" aria-controls="pills-copy-code" aria-selected="false">Kopioi tuloskoodi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-pedigree-tab" data-toggle="pill" href="#pills-pedigree" role="tab" aria-controls="pills-pedigree" aria-selected="false">Suku ja jälkeläiset</a>
      </li>
      <?php
      $current = get_current_user_id();
      if ($current == $owner_id) {
      ?>
      <li class="nav-item">
        <a class="nav-link" id="pills-edit-horse-tab" data-toggle="pill" href="#pills-edit-horse" role="tab" aria-controls="pills-edit-horse" aria-selected="false">Muokkaa hevosen tietoja</a>
      </li>
      <?php } ?>
    </ul>
    <div class="tab-content horse-profile-main-tabs pt-3 pb-3" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-evaluation" role="tabpanel" aria-labelledby="pills-evaluation-tab">

        <ul class="nav nav-pills horse-evaluation-pills mt-3 mb-3" id="pills-tab-sec" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="basic-evaluation-tab" data-toggle="pill" role="tab" aria-controls="basic-evaluation" aria-selected="true" href="#basic-evaluation">Ensiarvostelu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="quality-evaluation-tab" data-toggle="pill" role="tab" aria-controls="quality-evaluation" aria-selected="false" href="#quality-evaluation">Laatuarvostelu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="progeny-evaluation-tab" data-toggle="pill" role="tab" aria-controls="progeny-evaluation" aria-selected="false" href="#progeny-evaluation">Jälkeläislaatuarvostelu</a>
          </li>
        </ul>

        <div class="tab-content" id="pills-tabContent-sec">
          <div class="tab-pane fade show active" id="basic-evaluation" role="tabpanel" aria-labelledby="basic-evaluation-tab">
            <h2>
              Ensiarvostelun tulokset
            </h2>

            <div class="profile-points row">
              <div class="col-md-6">
                <h3>
                  Rakenne <small><?php echo get_field("conformation_grade", get_the_ID()) ?>%</small>
                </h3>
                <?php echo printPoints(get_field("points_head", get_the_ID()), "Pää, kaula ja etuosa"); ?>
                <?php echo printPoints(get_field("points_body", get_the_ID()), "Runko ja takaosa"); ?>
                <?php echo printPoints(get_field("points_legs", get_the_ID()), "Jalat ja kaviot"); ?>
              </div>
              <div class="col-md-6">
                <h3>
                  Liikkeet <small><?php echo get_field("gaits_grade", get_the_ID()) ?>%</small>
                </h3>
                <?php echo printPoints(get_field("points_walk", get_the_ID()), "Käynti"); ?>
                <?php echo printPoints(get_field("points_trot", get_the_ID()), "Ravi"); ?>
                <?php echo printPoints(get_field("points_canter", get_the_ID()), "Laukka"); ?>
              </div>
              <div class="col-md-6">
                <h3>
                  Luonne <small><?php echo get_field("characteristics_grade", get_the_ID()) ?>%</small>
                </h3>
                <?php echo printPoints(get_field("points_courage", get_the_ID()), "Rohkeus"); ?>
                <?php echo printPoints(get_field("points_obedience", get_the_ID()), "Kuuliaisuus"); ?>
                <?php echo printPoints(get_field("points_temperament", get_the_ID()), "Temperamentti"); ?>
                <?php echo printPoints(get_field("points_sensitivity", get_the_ID()), "Herkkyys"); ?>
                <?php echo printPoints(get_field("points_intelligence", get_the_ID()), "Älykkyys"); ?>
              </div>
              <div class="col-md-6">
                <h3>
                  Taidot <small><?php echo get_field("skills_grade", get_the_ID()) ?>%</small>
                </h3>
                <?php echo printPoints(get_field("points_speed", get_the_ID()), "Nopeus"); ?>
                <?php echo printPoints(get_field("points_endurance", get_the_ID()), "Kestävyys"); ?>
                <?php echo printPoints(get_field("points_agility", get_the_ID()), "Ketteryys"); ?>
                <?php echo printPoints(get_field("points_jump", get_the_ID()), "Hyppytekniikka"); ?>
                <?php echo printPoints(get_field("points_collection", get_the_ID()), "Kokoamiskyky"); ?>
                <?php echo printPoints(get_field("points_strength", get_the_ID()), "Voima"); ?>
              </div>
            </div>
            <h3>
              Pisteet arvostelutilaisuudessa
            </h3>
            <div class="profile-points row">
              <div class="col-md-6">
                <?php echo printPoints(get_field("points_rideability", get_the_ID()), "Ratsastettavuus/ajettavuus"); ?>
              </div>

              <div class="col-md-6">
                <?php echo printPoints($points_behaviour, "Käytös tilaisuudessa"); ?>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="quality-evaluation" role="tabpanel" aria-labelledby="quality-evaluation-tab">
            <h2>Laatuarvostelun tulokset</h2>
            <p><em>Hevosta ei ole vielä arvosteltu.</em></p>
          </div>
          <div class="tab-pane fade" id="progeny-evaluation" role="tabpanel" aria-labelledby="progeny-evaluation-tab">
            <h2>Jälkeläislaatuarvostelun tulokset</h2>
            <p><em>Hevosta ei ole vielä arvosteltu.</em></p>
          </div>
        </div>

      </div>
      <div class="tab-pane fade" id="pills-copy-code" role="tabpanel" aria-labelledby="pills-copy-code-tab">
        <h2>
          Kopioi koodit sivuille
        </h2>

        <div class="row">
          <div class="col-md-4">
            Arvo tähän<br>
            <div class="rmp-progress rmp-green"><div style="width:85%;"><span>85</span></div></div>
            Arvo tähän<br>
            <div class="rmp-progress rmp-blue"><div style="width:55%;"><span>55</span></div></div>
            Arvo tähän<br>
            <div class="rmp-progress rmp-orange"><div style="width:35%;"><span>35</span></div></div>
            Arvo tähän<br>
            <div class="rmp-progress rmp-red"><div style="width:20%;"><span>20</span></div></div>
          </div>
          <div class="col-md-4">
            <h3>
              HTML-koodi
            </h3>
            <textarea cols="40" rows="5"></textarea>
          </div>
          <div class="col-md-4">
            <h3>
              CSS-koodi
            </h3>
            <textarea cols="40" rows="5">
.rmp-progress {
  height: 20px;
  position: relative;
  background: #555;
  -moz-border-radius: 25px;
  -webkit-border-radius: 25px;
  border-radius: 25px;
  box-sizing: content-box;
  box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
  margin-top:10px;
  margin-bottom:10px;
}

.rmp-progress > div {
  display: block;
  height: 100%;
  border-top-right-radius: 8px;
  border-bottom-right-radius: 8px;
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
  background-color: rgb(43,194,83);
  background-image: linear-gradient(
    center bottom,
    rgb(43,194,83) 37%,
    rgb(84,240,84) 69%
  );
  box-shadow:
    inset 0 2px 9px  rgba(255,255,255,0.3),
    inset 0 -2px 6px rgba(0,0,0,0.4);
  position: relative;
  overflow: hidden;
  text-align:center;
  line-height: 1.1;
}

.rmp-progress > div > span {
  color:#fff;
  font-size:12px;
  text-align:center;
}

.rmp-green > div {
  background-color: #5cd06a;
  background-image: linear-gradient(to bottom, #5cd06a, #2bbf54);
}

.rmp-blue > div {
  background-color: #5d84dc;
  background-image: linear-gradient(to bottom, #5d84dc, #376dc3);
}

.rmp-orange > div {
  background-color: #f1a165;
  background-image: linear-gradient(to bottom, #f1a165, #f36d0a);
}

.rmp-red > div {
  background-color: #f0a3a3;
  background-image: linear-gradient(to bottom, #f0a3a3, #f42323);
}</textarea>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="pills-pedigree" role="tabpanel" aria-labelledby="pills-pedigree-tab">
        <h2>
          Sukutaulu
        </h2>
        <?php
        if ($sire) {
          $sire_sire = get_field("sire_id", $sire);
          if ($sire_sire) {
            $sire_sire_sire = get_field("sire_id", $sire_sire);
            $sire_sire_dam = get_field("dam_id", $sire_sire);
          }
          else {
            $sire_sire_sire = null;
            $sire_sire_dam = null;
          }
          $sire_dam = get_field("dam_id", $sire);
          if ($sire_dam) {
            $sire_dam_sire = get_field("sire_id", $sire_dam);
            $sire_dam_dam = get_field("dam_id", $sire_dam);
          }
          else {
            $sire_dam_sire = null;
            $sire_dam_dam = null;
          }
        }
        else {
          $sire_sire = null;
          $sire_dam = null;
          $sire_sire_sire = null;
          $sire_sire_dam = null;
          $sire_dam_sire = null;
          $sire_dam_dam = null;
        }

        if ($dam) {
          $dam_sire = get_field("sire_id", $dam);
          if ($dam_sire) {
            $dam_sire_sire = get_field("sire_id", $dam_sire);
            $dam_sire_dam = get_field("dam_id", $dam_sire);
          }
          else {
            $dam_sire_sire = null;
            $dam_sire_dam = null;
          }
          $dam_dam = get_field("dam_id", $dam);
          if ($dam_dam) {
            $dam_dam_sire = get_field("sire_id", $dam_dam);
            $dam_dam_dam = get_field("dam_id", $dam_dam);
          }
          else {
            $dam_dam_sire = null;
            $dam_dam_dam = null;
          }
        }
        else {
          $dam_sire = null;
          $dam_dam = null;
          $dam_sire_sire = null;
          $dam_sire_dam = null;
          $dam_dam_sire = null;
          $dam_dam_dam = null;
        }
        ?>
        <table class="pedigree" border="1">
        <tr>
          <td rowspan="4"><strong>i.</strong> <?php echo printPedigreeParent($sire); ?></td>
          <td rowspan="2"><strong>ii.</strong> <?php echo printPedigreeParent($sire_sire); ?></td>
          <td rowspan="1"><strong>iii.</strong> <?php echo printPedigreeParent($sire_sire_sire); ?></td>
          <tr>
            <td rowspan="1"><strong>iie.</strong> <?php echo printPedigreeParent($sire_sire_dam); ?></td>
          </tr>
          <td rowspan="2"><strong>ie.</strong> <?php echo printPedigreeParent($sire_dam); ?></td>
          <td rowspan="1"><strong>iei.</strong> <?php echo printPedigreeParent($sire_dam_sire); ?></td>
          <tr>
            <td rowspan="1"><strong>iee.</strong> <?php echo printPedigreeParent($sire_dam_dam); ?></td>
          </tr>
        </tr>
        <tr>
          <td rowspan="4"><strong>e.</strong> <?php echo printPedigreeParent($dam); ?></td>
          <td rowspan="2"><strong>ei.</strong> <?php echo printPedigreeParent($dam_sire); ?></td>
          <td rowspan="1"><strong>eii.</strong> <?php echo printPedigreeParent($dam_sire_sire); ?></td>
          <tr>
            <td rowspan="1"><strong>eie.</strong> <?php echo printPedigreeParent($dam_sire_dam); ?></td>
          </tr>
          <td rowspan="2"><strong>ee.</strong> <?php echo printPedigreeParent($dam_dam); ?></td>
          <td rowspan="1"><strong>eei.</strong> <?php echo printPedigreeParent($dam_dam_sire); ?></td>
          <tr>
            <td rowspan="1"><strong>eee.</strong> <?php echo printPedigreeParent($dam_dam_dam); ?></td>
          </tr>
        </tr>
      </table>

        <h2>
          Jälkeläiset
        </h2>
        <?php
        $skp = get_field_object('sex', get_the_ID());
        $skp_value = $skp['value'];
        if ($skp_value == '0') { $sex_label = 'tamma'; }
        else { $sex_label = 'ori'; }

        if ($sex_label == "tamma") { $parenttype = 'dam_id'; }
        else { $parenttype = 'sire_id'; }
             $args = array(
                'numberposts'	=> -1,
                'post_type'		=> 'horse',
                'meta_query'	=> array(
                  'relation'		=> 'AND',
                  array(
                    'key'	  	=> $parenttype,
                    'value'	  	=> get_the_ID(),
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
            <?php if( $the_query->have_posts() ) { ?>
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
          <?php }
          else { echo 'Ei arvosteltuja jälkeläisiä.'; } ?>

          <?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>

      </div>
      <div class="tab-pane fade" id="pills-edit-horse" role="tabpanel" aria-labelledby="pills-edit-horse-tab">
        <h2>
          Muokkaa hevosen tietoja
        </h2>

        <?php
        $args = array("url");

        if (!get_field("sire_id", get_the_ID())) {
          array_push($args, "sire_id");
        }

        if (!get_field("dam_id", get_the_ID())) {
          array_push($args, "dam_id");
        }

        if (!get_field("height", get_the_ID())) {
          array_push($args, "height");
        }

        $skp = get_field("sex", get_the_ID());
        if ($skp == "1 : ori") {
          array_push($args, "sex");
        }

        $vhtunnus = get_field("vh_id", get_the_ID());
        if (!$vhtunnus) {
          array_push($args, "vh_id");
        }

        if (!get_field("breeder_id", get_the_ID())) {
          array_push($args, "breeder_id");
        }

        if (!get_field("breeder_stable_id", get_the_ID())) {
          array_push($args, "breeder_stable_id");
        }
        array_push($args, "owner_id", "stable_id", "show_horse_profile");
        ?>

        <?php
        $edit_post = array(
          'id'                 => 'edit-horse-form',
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
