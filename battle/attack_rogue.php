<?php
	$CRITICAL_CHANCE =		20;		//Percent Chance to Land a Critical against an Evenly Leveled Monster
		$CRITICAL_DAMAGE =	50;		//Additional Damage % Added
	$COMBO_CHANCE =			15;		//Chance to increase Number of Attacks by 1 (+Speed)
	$COMBO_DECAY =			15;		//Combo Chance's Decay Overtime
		$COMBO_BOOST = 		10;		//Each Attack delivers increasingly more damage
	$SPD_PER_ATK =			10;		//Points in Speed Per Extra Attack

	# ROGUE #
		$actions = array();
			
		$totalDamage = 0;
		$comboBooster = 0;
		$finalNotify = false;
		$actualNumberOfAttacks = 0;
		$numberOfAttacks = max( 1, floor(percentOf($hero_Speed, $SPD_PER_ATK)) );
		
		for ($a = 0; $a < $numberOfAttacks; $a++) {
			$actualNumberOfAttacks++;
		
			$damage = $hero->Damage();
			$damage += percentOf($damage, $hero_Power);
			$damage += percentOf($damage, $comboBooster);
			
			$comboChance = ($COMBO_CHANCE + $hero_Speed) - ($COMBO_DECAY * $a);
			
			if (chance($comboChance)) {
				$numberOfAttacks++;
			}
			
			$critical = false;
			if (chance($CRITICAL_CHANCE-($fear * 5))) {
				$damage += percentOf($damage, $CRITICAL_DAMAGE);
				$critical = true;
			}
			
			$comboBooster += ($COMBO_BOOST + percentOf($COMBO_BOOST, $hero->has_Perk(4))); //ROGUE PERK - OPPORTUNIST
			
			switch($actualNumberOfAttacks) {
				case 5:
					$notify = "Swift!";
					$finalNotify = "Swift";
					break;
				case 7:
					$notify = "Furious!";
					$finalNotify = "Furious";
					break;
				case 10:
					$notify = "Unstoppable!";
					$finalNotify = "Unstoppable";
				default:
					$notify = false;
			}
			
			$damage = round( $damage );
			$damage = max( 1, $damage );
			$totalDamage += $damage;
			array_push($actions, array(
				"damage" => $damage,
				"critical" => $critical,
				"notify" => $notify
			));
		}
	
		if ($actualNumberOfAttacks > 1) {
			array_push( $round["log"], array("icon" => false, "message" => "{$hero->Name()} leaps into a {$actualNumberOfAttacks}-hit combo! <span class=\"damage\">[{$totalDamage} DMG]</span>") );
		} else {
			array_push( $round["log"], array("icon" => false, "message" => "{$hero->Name()} delivers a lethal jab! <span class=\"damage\">[{$totalDamage} DMG]</span>") );
		}
	
	$round["actions"] = $actions;
?>