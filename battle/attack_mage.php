<?php
	
	$CRITICAL_CHANCE =			15;		//Percent Chance to Land a Critical against an Evenly Leveled Monster
		$CRITICAL_DAMAGE =		50;		//Additional Damage % Added
		$POWER_DECAY =			5;		//Power Decay Rate Per Round
		$POWER_MINIMUM =		-25;	//Lowest Power Decay Possible
	$FLAREUP_CHANCE =			10;		//Chance to temporarily boost PowerBoost
		$FLAREUP_AMOUNT =		25;		//Amount to boost PowerBoost
	$SPD_PER_ATK =				10;		//Points in Speed Per Extra Attack
	
	# MAGE #
		$actions = array();
		
		$totalDamage = 0;
		$flareUpFlag = false;
		$powerBoost = ($INITIAL_POWER_BOOST + $hero_Power) - ( ($battle_HeroRounds - 1) * $POWER_DECAY);
		$powerBoost = max( $powerBoost, $POWER_MINIMUM );
		$actualNumberOfAttacks = 0;
		
		$numberOfAttacks = max(1, floor(percentOf($hero_Speed, $SPD_PER_ATK)) );
		
		for ($a = 0; $a < $numberOfAttacks; $a++) {
			$actualNumberOfAttacks++;
			
			$notify = false;
			if (chance($FLAREUP_CHANCE)) {
				$INITIAL_POWER_BOOST += ($FLAREUP_AMOUNT + percentOf($FLAREUP_AMOUNT, $hero->has_Perk(6))); //MAGE PERK - DEMOLITIONIST
				$notify = "Flare Up!";
			}	
		
			$damage = $hero->Damage();
			$damage += percentOf($damage, $powerBoost);
			
			$critical = false;
			if (chance($CRITICAL_CHANCE-($fear * 5))) {
				$damage += percentOf($damage, $CRITICAL_DAMAGE);
				$critical = true;
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
		
		if($actualNumberOfAttacks > 1) {
			array_push( $round["log"], array("icon" => false, "message" => "{$hero->Name()} channels {$actualNumberOfAttacks} explosive attacks! <span class=\"damage\">[{$totalDamage} DMG]</span>") );
		} else {
			array_push( $round["log"], array("icon" => false, "message" => "{$hero->Name()} performs a blistering attack! <span class=\"damage\">[{$totalDamage} DMG]</span>") );
		}
		
	$round["actions"] = $actions;
?>