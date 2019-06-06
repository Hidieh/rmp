<?php

function giveRandomNumber($min,$max,$std_deviation,$step=1) {
  $rand1 = (float)mt_rand()/(float)mt_getrandmax();
  $rand2 = (float)mt_rand()/(float)mt_getrandmax();
  $gaussian_number = sqrt(-2 * log($rand1)) * cos(2 * M_PI * $rand2);
  $mean = ($max + $min) / 2;
  $random_number = ($gaussian_number * $std_deviation) + $mean;
  $random_number = round($random_number / $step) * $step;
  if($random_number < $min || $random_number > $max) {
    $random_number = giveRandomNumber($min,$max,$std_deviation);
  }
  if($random_number < 0) { $random_number = 0;}
  if($random_number > 100) { $random_number = 100;}
  return $random_number;
}

function countEvaluationPoints(Horse $horse) {
    // rakenteen yhteispisteet
    $conformation = $horse->pointHead + $horse->pointBody + $horse->pointLegs;

    // askellajien yhteispisteet
    $gaits = $horse->pointWalk + $horse->pointTrot + $horse->pointCanter;

    // luonteen yhteispisteet
    $characteristics = $horse->pointCourage + $horse->pointObedience + $horse->pointTemperament + $horse->pointSensitivity + $horse->pointIntelligence;

    // taitojen yhteispisteet
    $skills = $horse->pointSpeed + $horse->pointEndurance + $horse->pointAgility + $horse->pointJump + $horse->pointCollection + $horse->pointStrength;

    $points = $conformation + $gaits + $characteristics + $skills + $horse->pointRideability + $horse->pointBehaviour;

    return $points;
}

// Tallenna saavutettu taso pisteiden perusteella
function setEvaluationGrade($points) {
    $level = "Error";
    if ($points < 380) {
        $level = "No Grade";
    }
    else if ($points < 665) {
        $level = "1 Star Prospect";
    }
    else if ($points < 950) {
        $level = "2 Star Prospect";
    }
    else if ($points < 1235) {
        $level = "3 Star Prospect";
    }
    else if ($points < 1520) {
        $level = "4 Star Prospect";
    }
    else if ($horse->pointBehaviour > 50 && $horse->pointRideability > 50 && $horse->conformationGrade > 50 && $horse->gaitsGrade > 50 && $horse->characteristicsGrade > 50 && $horse->skillsGrade > 50) {
        $level = "5 Star Prospect";
    }
    else {
        $level = "4 Star Prospect";
    }
    return $level;
}

// Lasketaan ratsastettavuuden arvo
function countRideabilityValue(Horse $horse) {
    $points = $horse->gaitsGrade + $horse->characteristicsGrade + $horse->skillsGrade;
    $points = $points / 3 + giveRandomNumber(-10,15,5);
    if ($points > 100) { $points = 100; }
    return round($points);
}

// Lasketaan "käytös tilaisuudessa" -arvo
function countBehaviourValue(Horse $horse) {
    $points = $horse->pointCourage + $horse->pointObedience + $horse->pointTemperament + $horse->pointSensitivity + $horse->pointIntelligence;
    $points = $points / 4 + giveRandomNumber(-10,15,5);
    if ($points > 100) { $points = 100; }
    return round($points);
}


/* YLEISARVOSANAT
* Lasketaan ja asetetaan prosentuaaliet arvosanat neljälle yleispistekategorialle
*/

// rakenne
function setConformationGrade($horse) {
    $grade = ($horse->pointHead + $horse->pointBody + $horse->pointLegs) / 300 * 100;
    return round($grade);
}

// askellajit
function setGaitsGrade(Horse $horse) {
    $grade = ($horse->pointWalk + $horse->pointTrot + $horse->pointCanter) / 300 * 100;
    return round($grade);
}

// luonne
function setCharacteristicsGrade(Horse $horse) {
    $grade = ($horse->pointCourage + $horse->pointTemperament + $horse->pointSensitivity + $horse->pointIntelligence + $horse->pointObedience) / 500 * 100;
    return round($grade);
}

// taidot
function setSkillsGrade(Horse $horse) {
    $grade = ($horse->pointSpeed + $horse->pointEndurance + $horse->pointAgility + $horse->pointJump + $horse->pointCollection + $horse->pointStrength) / 600 * 100;
    return round($grade);
}

// Luo random hevonen / suvuttoman hevosen vanhempien luonti laskemista varten
function generateRandomHorse($disc) {
    $horse = new Horse();

    $horse->setProperty("name","Test Horse");

    // Arvotaan ensin arvosanat rakenteelle ja liikkeille
    // Showpainotteinen, erikoisarviot myös rakenteesta
    if ($disc == '12') {
      $horse->setProperty("pointHead",giveRandomNumber(10,100,25));
      $horse->setProperty("pointBody",giveRandomNumber(10,100,25));
      $horse->setProperty("pointLegs",giveRandomNumber(10,100,25));
    }
    else {
      $horse->setProperty("pointHead",giveRandomNumber(0,100,25));
      $horse->setProperty("pointBody",giveRandomNumber(0,100,25));
      $horse->setProperty("pointLegs",giveRandomNumber(0,100,25));
    }

    // Koulu-, valjakko- tai askellajipainotteinen
    if ($disc == '2' || $disc == '4' || $disc == '7') {
      $horse->setProperty("pointWalk",giveRandomNumber(10,100,25));
      $horse->setProperty("pointTrot",giveRandomNumber(10,100,25));
      $horse->setProperty("pointCanter",giveRandomNumber(10,100,25));
    }

    // Laukkapainotteinen
    else if ($disc == '8') {
      $horse->setProperty("pointWalk",giveRandomNumber(0,100,25));
      $horse->setProperty("pointTrot",giveRandomNumber(0,100,25));
      $horse->setProperty("pointCanter",giveRandomNumber(20,100,25));
    }

    //Ravipainotteinen
    else if ($disc == '9') {
      $horse->setProperty("pointWalk",giveRandomNumber(0,100,25));
      $horse->setProperty("pointTrot",giveRandomNumber(20,100,25));
      $horse->setProperty("pointCanter",giveRandomNumber(0,100,25));
    }

    //Showpainotteinen
    else if ($disc == '12') {
      $horse->setProperty("pointWalk",giveRandomNumber(10,100,25));
      $horse->setProperty("pointTrot",giveRandomNumber(10,100,25));
      $horse->setProperty("pointCanter",giveRandomNumber(10,100,25));
    }

    //Estepainotteinen
    else if ($disc == '1') {
      $horse->setProperty("pointWalk",giveRandomNumber(0,100,25));
      $horse->setProperty("pointTrot",giveRandomNumber(0,100,25));
      $horse->setProperty("pointCanter",giveRandomNumber(20,100,25));
    }

    //Yleispainotteinen, kenttäpainotteinen, westernpainotteinen, matkaratsastuspainotteinen, työhevospainotteinen
    else {
      $horse->setProperty("pointWalk",giveRandomNumber(0,100,25));
      $horse->setProperty("pointTrot",giveRandomNumber(0,100,25));
      $horse->setProperty("pointCanter",giveRandomNumber(0,100,25));
    }

    $horse->setProperty("pointCourage",giveRandomNumber(0,100,25));

    // Erikoislaskenta tottelevaisuudelle, suoritetaan työhevospainotteisille
    if ($disc == '11') {
      $horse->setProperty("pointObedience",giveRandomNumber(20,100,25));
    }
    else {
      $horse->setProperty("pointObedience",giveRandomNumber(0,100,25));
    }

    $horse->setProperty("pointTemperament",giveRandomNumber(0,100,25));
    $horse->setProperty("pointSensitivity",giveRandomNumber(0,100,25));
    $horse->setProperty("pointIntelligence",giveRandomNumber(0,100,25));

    // Erikoislaskenta nopeudelle, suoritetaan western-, askellaji-, laukka-, ravi- ja matkaratsastuspainotteiselle
    if ($disc == '6' || $disc == '7' || $disc == '8' || $disc == '9' || $disc == '10') {
      $horse->setProperty("pointSpeed",giveRandomNumber(20,100,25));
    }
    else {
      $horse->setProperty("pointSpeed",giveRandomNumber(0,100,25));
    }

    // Erikoislaskenta kestävyydelle, suoritetaan kenttä-, laukka-, ravi-, matkaratsastus- ja työshevospainotteiselle
    if ($disc == '3' || $disc == '8' || $disc == '9' || $disc == '10' || $disc == '11') {
      $horse->setProperty("pointEndurance",giveRandomNumber(20,100,25));
    }
    else {
      $horse->setProperty("pointEndurance",giveRandomNumber(0,100,25));
    }

    // Erikoislaskenta ketteryydelle, suoritetaan este-, kenttä-, valjakko- ja westernpainotteiselle
    if ($disc == '1' || $disc == '3' || $disc == '4' || $disc == '6') {
      $horse->setProperty("pointAgility",giveRandomNumber(20,100,25));
    }
    else {
      $horse->setProperty("pointAgility",giveRandomNumber(0,100,25));
    }

    // Erikoislaskenta hyppykyvylle, suoritetaan este- ja kenttäpainotteiselle
    if ($disc == '1' || $disc == '3') {
      $horse->setProperty("pointJump",giveRandomNumber(20,100,25));
    }
    else {
      $horse->setProperty("pointJump",giveRandomNumber(0,100,25));
    }

    // Erikoislaskenta kokoamiskyvylle, suoritetaan este-, koulu- ja valjakkopainotteiselle
    if ($disc == '1' || $disc == '2' || $disc == '4') {
      $horse->setProperty("pointCollection",giveRandomNumber(20,100,25));
    }
    else {
      $horse->setProperty("pointCollection",giveRandomNumber(0,100,25));
    }

    // Erikoislaskenta voimalle, suoritetaan koulu-, western-, matkaratsastus- ja työhevospainotteiselle
    if ($disc == '2' || $disc == '6' || $disc == '10' || $disc == '11') {
      $horse->setProperty("pointStrength",giveRandomNumber(20,100,25));
    }
    else {
      $horse->setProperty("pointStrength",giveRandomNumber(0,100,25));
    }

    // Arvotaan arvot periyttämisen vahvuudelle per arvostelukohta
    $horse->setProperty("pointHeadPass",mt_rand(1,2));
    $horse->setProperty("pointBodyPass",mt_rand(1,2));
    $horse->setProperty("pointLegsPass",mt_rand(1,2));
    $horse->setProperty("pointWalkPass",mt_rand(1,2));
    $horse->setProperty("pointTrotPass",mt_rand(1,2));
    $horse->setProperty("pointCanterPass",mt_rand(1,2));
    $horse->setProperty("pointCouragePass",mt_rand(1,2));
    $horse->setProperty("pointObediencePass",mt_rand(1,2));
    $horse->setProperty("pointTemperamentPass",mt_rand(1,2));
    $horse->setProperty("pointSensitivityPass",mt_rand(1,2));
    $horse->setProperty("pointIntelligencePass",mt_rand(1,2));
    $horse->setProperty("pointSpeedPass",mt_rand(1,2));
    $horse->setProperty("pointEndurancePass",mt_rand(1,2));
    $horse->setProperty("pointAgilityPass",mt_rand(1,2));
    $horse->setProperty("pointJumpPass",mt_rand(1,2));
    $horse->setProperty("pointCollectionPass",mt_rand(1,2));
    $horse->setProperty("pointStrengthPass",mt_rand(1,2));

    // Asetetaan ansaitut arvosanat ja loppuarviot
    $horse->setProperty("conformationGrade",setConformationGrade($horse));
    $horse->setProperty("gaitsGrade",setGaitsGrade($horse));
    $horse->setProperty("characteristicsGrade",setCharacteristicsGrade($horse));
    $horse->setProperty("skillsGrade",setSkillsGrade($horse));
    $horse->setProperty("pointRideability",countRideabilityValue($horse));
    $horse->setProperty("pointBehaviour",countBehaviourValue($horse));
    $horse->setProperty("basicEvaluationPoints",countEvaluationPoints($horse));
    $horse->setProperty("basicEvaluationGrade",setEvaluationGrade($horse->basicEvaluationPoints));

    return $horse;
}

// Sanallisen arvosanan antaminen pistemäärälle
function giveGrade($points) {
    if ($points < 21) {
        $grade = "Heikko";
    }
    else if ($points < 51) {
        $grade = "Kohtalainen";
    }
    else if ($points < 81) {
        $grade = "Hyvä";
    }
    else {
        $grade = "Erinomainen";
    }
    return $grade;
}

/* PERINNÖLLINEN LASKENTA
 * Jos hevosella on jo arvostellut isä ja/tai emä, suoritetaan sille perinnöllinen laskenta
 * Vanhempien/vanhemman pisteet vaikuttavat varsan pisteisiin. Jos toista vanhempaa ei ole olemassa, generoidaan random-hevonen
 */

function countFoalPoint(Horse $dad,Horse $mom,$gene) {
    $val1 = $dad->$gene;
    $val2 = $mom->$gene;
    $pass = $gene . "Pass";
    $pass1 = $dad->$pass;
    $pass2 = $mom->$pass;
    $point = 0;

    // Jos vanhempien periyttämisarvot yli 0, eli periyttävät normaalisti tai vahvasti, otetaan painotukset huomioon (1 tai 2)
    if ($pass1 + $pass2 > 0) {
        $count = (($val1 * $pass1) + ($val2 * $pass2))/($pass1 + $pass2);
        $point = giveRandomNumber($count-15,$count+15,5);
    }
    else {
        $point = giveRandomNumber(0,100,25);
    }
    return $point;
}

function generateByParents(Horse $parent1, Horse $parent2) {
    $horse = new Horse();

    $pointHead = countFoalPoint($parent1,$parent2,"pointHead");
    $horse->setProperty("pointHead",$pointHead);
    $horse->setProperty("pointBody",countFoalPoint($parent1,$parent2,"pointBody"));
    $horse->setProperty("pointLegs",countFoalPoint($parent1,$parent2,"pointLegs"));
    $horse->setProperty("pointWalk",countFoalPoint($parent1,$parent2,"pointWalk"));
    $horse->setProperty("pointTrot",countFoalPoint($parent1,$parent2,"pointTrot"));
    $horse->setProperty("pointCanter",countFoalPoint($parent1,$parent2,"pointCanter"));
    $horse->setProperty("pointCourage",countFoalPoint($parent1,$parent2,"pointCourage"));
    $horse->setProperty("pointObedience",countFoalPoint($parent1,$parent2,"pointObedience"));
    $horse->setProperty("pointTemperament",countFoalPoint($parent1,$parent2,"pointTemperament"));
    $horse->setProperty("pointSensitivity",countFoalPoint($parent1,$parent2,"pointSensitivity"));
    $horse->setProperty("pointIntelligence",countFoalPoint($parent1,$parent2,"pointIntelligence"));
    $horse->setProperty("pointSpeed",countFoalPoint($parent1,$parent2,"pointSpeed"));
    $horse->setProperty("pointEndurance",countFoalPoint($parent1,$parent2,"pointEndurance"));
    $horse->setProperty("pointAgility",countFoalPoint($parent1,$parent2,"pointAgility"));
    $horse->setProperty("pointJump",countFoalPoint($parent1,$parent2,"pointJump"));
    $horse->setProperty("pointCollection",countFoalPoint($parent1,$parent2,"pointCollection"));
    $horse->setProperty("pointStrength",countFoalPoint($parent1,$parent2,"pointStrength"));
    $horse->setProperty("pointHeadPass",mt_rand(0,2));
    $horse->setProperty("pointBodyPass",mt_rand(0,2));
    $horse->setProperty("pointLegsPass",mt_rand(0,2));
    $horse->setProperty("pointWalkPass",mt_rand(0,2));
    $horse->setProperty("pointTrotPass",mt_rand(0,2));
    $horse->setProperty("pointCanterPass",mt_rand(0,2));
    $horse->setProperty("pointCouragePass",mt_rand(0,2));
    $horse->setProperty("pointObediencePass",mt_rand(0,2));
    $horse->setProperty("pointTemperamentPass",mt_rand(0,2));
    $horse->setProperty("pointSensitivityPass",mt_rand(0,2));
    $horse->setProperty("pointIntelligencePass",mt_rand(0,2));
    $horse->setProperty("pointSpeedPass",mt_rand(0,2));
    $horse->setProperty("pointEndurancePass",mt_rand(0,2));
    $horse->setProperty("pointAgilityPass",mt_rand(0,2));
    $horse->setProperty("pointJumpPass",mt_rand(0,2));
    $horse->setProperty("pointCollectionPass",mt_rand(0,2));
    $horse->setProperty("pointStrengthPass",mt_rand(0,2));
    $horse->setProperty("conformationGrade",setConformationGrade($horse));
    $horse->setProperty("gaitsGrade",setGaitsGrade($horse));
    $horse->setProperty("characteristicsGrade",setCharacteristicsGrade($horse));
    $horse->setProperty("skillsGrade",setSkillsGrade($horse));
    $horse->setProperty("pointRideability",countRideabilityValue($horse));
    $horse->setProperty("pointBehaviour",countBehaviourValue($horse));
    $horse->setProperty("basicEvaluationPoints",countEvaluationPoints($horse));
    $horse->setProperty("basicEvaluationGrade",setEvaluationGrade($horse->basicEvaluationPoints));

    return $horse;
}

function turnToObject($id) {
    $horse = new Horse();

    $horse->setProperty("pointHead",get_field("points_head", $id));
    $horse->setProperty("pointBody",get_field("points_body", $id));
    $horse->setProperty("pointLegs",get_field("points_legs", $id));
    $horse->setProperty("pointWalk",get_field("points_walk", $id));
    $horse->setProperty("pointTrot",get_field("points_trot", $id));
    $horse->setProperty("pointCanter",get_field("points_canter", $id));
    $horse->setProperty("pointCourage",get_field("points_courage", $id));
    $horse->setProperty("pointObedience",get_field("points_obedience", $id));
    $horse->setProperty("pointTemperament",get_field("points_temperament", $id));
    $horse->setProperty("pointSensitivity",get_field("points_sensitivity", $id));
    $horse->setProperty("pointIntelligence",get_field("points_intelligence", $id));
    $horse->setProperty("pointSpeed",get_field("points_speed", $id));
    $horse->setProperty("pointEndurance",get_field("points_endurance", $id));
    $horse->setProperty("pointAgility",get_field("points_agility", $id));
    $horse->setProperty("pointJump",get_field("points_jump", $id));
    $horse->setProperty("pointCollection",get_field("points_collection", $id));
    $horse->setProperty("pointStrength",get_field("points_strength", $id));
    $horse->setProperty("pointHeadPass",get_field("points_head_pass", $id));
    $horse->setProperty("pointBodyPass",get_field("points_body_pass", $id));
    $horse->setProperty("pointLegsPass",get_field("points_legs_pass", $id));
    $horse->setProperty("pointWalkPass",get_field("points_walk_pass", $id));
    $horse->setProperty("pointTrotPass",get_field("points_trot_pass", $id));
    $horse->setProperty("pointCanterPass",get_field("points_canter_pass", $id));
    $horse->setProperty("pointCouragePass",get_field("points_courage_pass", $id));
    $horse->setProperty("pointObediencePass",get_field("points_obedience_pass", $id));
    $horse->setProperty("pointTemperamentPass",get_field("points_temperament_pass", $id));
    $horse->setProperty("pointSensitivityPass",get_field("points_sensitivity_pass", $id));
    $horse->setProperty("pointIntelligencePass",get_field("points_intelligence_pass", $id));
    $horse->setProperty("pointSpeedPass",get_field("points_speed_pass", $id));
    $horse->setProperty("pointEndurancePass",get_field("points_endurance_pass", $id));
    $horse->setProperty("pointAgilityPass",get_field("points_agility_pass", $id));
    $horse->setProperty("pointJumpPass",get_field("points_jump_pass", $id));
    $horse->setProperty("pointCollectionPass",get_field("points_collectio_pass", $id));
    $horse->setProperty("pointStrengthPass",get_field("points_strength_pass", $id));
    $horse->setProperty("conformationGrade",get_field("conformation_grade", $id));
    $horse->setProperty("gaitsGrade",get_field("gaits_grade", $id));
    $horse->setProperty("characteristicsGrade",get_field("characteristics_grade", $id));
    $horse->setProperty("skillsGrade",get_field("skills_grade", $id));
    $horse->setProperty("pointRideability",get_field("points_rideability", $id));
    $horse->setProperty("pointBehaviour",get_field("points_behaviour", $id));
    $horse->setProperty("basicEvaluationPoints",get_field("basic_evaluation_points", $id));
    $horse->setProperty("basicEvaluationGrade",get_field("basic_evaluation_grade", $id));

    return $horse;
}

?>
