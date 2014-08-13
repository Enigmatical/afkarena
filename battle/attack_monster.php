<?php
	$MONSTER_CRITICAL_CHANCE =		10;		//Percent Chance to Land a Critical against an Evenly Leveled Hero
		$MONSTER_CRITICAL_DAMAGE =	35;		//Additional Damage % Added
	$MONSTER_POWER_BOOST =			10;		//Per FEAR Level
		
	$actions = array();
	
	$totalDamage = 0;
	
	$damage = $monster->Damage();
	
	$damage += percentOf($damage, $MONSTER_POWER_BOOST * $fear);
	
	$critical = false;
	if(chance($MONSTER_CRITICAL_CHANCE+($fear * 5)) || $monster->status["focus"] == true) {
		$damage += percentOf($damage, $MONSTER_CRITICAL_DAMAGE);
		if($hero->has_Perk(5)) {	//ROGUE PERK - ELUSIVE
			$damage -= percentOf($damage, $hero->has_Perk(5));
		}
	}
	
	$damage -= $hero_Armor;
	
	if ($hero->has_Perk(2) && $hero->Health('percent') < 25) { //WARRIOR PERK - RESILIENT
		$damage -= percentOf($damage, $hero->has_Perk(2));
	}
	
	if ($hero->has_Perk(7) && $INITIAL_POWER_BOOST <= 0) {	//MAGE PERK - PERCEPTIVE
		$damage -= percentOf($damage, $hero->has_Perk(7));
	}
	
	$damage = max( 1, $damage );
	$damage = round( $damage );
	$totalDamage = $damage;
	
	array_push($actions, array(
		"damage" => $damage,
		"critical" => $critical,
		"notify" => false
	));
	
	if ($critical) {
		array_push($round["log"], array("icon" => false, "message" => "{$monster->Name()} delivers a <span class=\"special\">Critical</span> Strike! <span class=\"damage\">[{$totalDamage} DMG]</span>") );
	} else {
		array_push($round["log"], array("icon" => false, "message" => "{$monster->Name()} delivers a strike! <span class=\"damage\">[{$totalDamage} DMG]</span>") );
	}
	
	$round["actions"] = $actions;
?>