<?php

class Horse
{
  public $name; // hevosen nimi
  public $breed; // hevosen rotu
  public $sex; // hevosen sukupuoli
  public $height; // hevosen säkäkorkeus, cm
  public $dateOfBirth; // hevosen syntymäaika
  public $vhId; // hevosen vh-tunnus
  public $ownerId; // hevosen omistajan id
  public $pointHead; // pisteet: Pää, kaula, etuosa
  public $pointHeadPass; // periytyvyys: Pää, kaula, etuosa
  public $pointBody; // pisteet: Runko, takaosa
  public $pointBodyPass; // periytyvyys: Runko, takaosa
  public $pointLegs; // pisteet: Jalat, kaviot
  public $pointLegsPass; // periytyvyys: Jalat, kaviot
  public $pointWalk; // pisteet: Käynti
  public $pointWalkPass; // periytyvyys: Käynti
  public $pointTrot; // pisteet: Ravi
  public $pointTrotPass; // periytyvyys: Ravi
  public $pointCanter; // pisteet: Laukka
  public $pointCanterPass; // periytyvyys: Laukka
  public $pointCourage; // pisteet: Rohkeus
  public $pointCouragePass; // periytyvyys: Rohkeus
  public $pointObedience; // pisteet: Kuuliaisuus
  public $pointObediencePass; // periytyvyys: Kuuliaisuus
  public $pointTemperament; // pisteet: Temperamentti
  public $pointTemperamentPass; // periytyvyys: Temperamentti
  public $pointSensitivity; // pisteet: Herkkyys
  public $pointSensitivityPass; // periytyvyys: Herkkyys
  public $pointIntelligence; // pisteet: Älykkyys
  public $pointIntelligencePass; // periytyvyys: Älykkyys
  public $pointSpeed; // pisteet: Nopeus
  public $pointSpeedPass; // periytyvyys: Nopeus
  public $pointEndurance; // pisteet: Kestävyys
  public $pointEndurancePass; // periytyvyys: Kestävyys
  public $pointAgility; // pisteet: Ketteryys
  public $pointAgilityPass; // periytyvyys: Ketteryys
  public $pointJump; // pisteet: Hyppytekniikka
  public $pointJumpPass; // periytyvyys: Hyppytekniikka
  public $pointCollection; // pisteet: Kokoamiskyky
  public $pointCollectionPass; // periytyvyys: Kokoamiskyky
  public $pointStrength; // pisteet: Voima
  public $pointStrengthPass; // periytyvyys: Voima
  public $pointRideability; // pisteet: Ratsastettavuus / Ajettavuus
  public $pointBehaviour; // pisteet: Käytös tilaisuudessa
  public $basicEvaluationPoints; // yhteispisteet ensiarvioinnissa
  public $basicEvaluationGrade; // yhteispisteet ensiarvioinnissa
  public $conformationGrade; // yhteistulos rakenteelle
  public $gaitsGrade; // yhteistulos askellajeille
  public $characteristicsGrade; // yhteistulos luonteelle
  public $skillsGrade; // yhteistulos taidoille

  public function setProperty($prop, $val)
  {
      $this->$prop = $val;
  }
 
  public function getProperty($prop)
  {
      return $this->$prop;
  }
}



?>