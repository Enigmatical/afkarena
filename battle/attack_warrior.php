<?php
	$CRITICAL_CHANCE =		10;		//Percent Chance to Land a Critical against an Evenly Leveled Monster
		$CRITICAL_DAMAGE =	50;		//Additional Damage Added
	$CRUSHING_CHANCE =		15;		//Percent Chance to Land a Crushing! attack
		$CRUSHING_DAMAGE =	25;		//Additional Damage Added
	$SPD_PER_ATK =			10;		//Points in Speed Per Extra Attack

	# WARRIOR #
		$actions = array();
		
		$totalDamage = 0;
		$crushingFlag = false;
		$actualNumberOfAttacks = 0;
		$numberOfAttacks = max( 1, floor(percentOf($hero_Speed, $SPD_PER_ATK)) );
		
		for ($a = 0; $a < $numberOfAttacks; $a++) {
			$actualNumberOfAttacks++;
			
			# CRUSHING CHANCE - Slight chance to land a Crushing! Blow which is immediately followed by a Devastate!*
			# THIS WILL IMMEDIATELY END THE COMBO! (Which makes Speed useful, but not super Useful) #
			if(chance($CRUSHING_CHANCE)) {
				$crushingFlag = true;
			
				$damage = $hero->Damage();
				$damage += percentOf($damage, $hero_Power);
				
				$damage = round( $damage );
				$damage = max( 1, $damage );
				$totalDamage += $damage;
				array_push($actions, array(
					"damage" => $damage,
					"critical" => false,
					"notify" => false
				));
				
				$actualNumberOfAttacks++;
				
				$rating = $hero->get_EquipRating("weapon");
				$damage = $rating["max"];
				
				$damage += percentOf($damage, ($CRUSHING_DAMAGE + $hero->has_Perk(1))); //WARRIOR PERK - BUTCHER
				
				$damage = round( $damage );
				$damage = max( 1, $damage );
				$totalDamage += $damage;
				array_push($actions, array(
					"damage" => $damage,
					"critical" => false,
					"notify" => "Devastate!"
				));
				
				break;
			} else {
				$damage = $hero->Damage();
				$damage += percentOf($damage, $hero_Power);

				
				$critical = false;
				if(chance($CRITICAL_CHANCE-($fear * 5))) {
					$damage += percentOf($damage, $CRITICAL_DAMAGE);
					$critical = true;
				}
				
				$damage = round( $damage );
				$damage = max( 1, $damage );
				$totalDamage += $damage;
				array_push($actions, array( 
					"damage" => $damage, 
					"critical" => $critical,
					"notify" => false
				));
			}
		}
		
		if ($actualNumberOfAttacks > 1) {
			array_push( $round["log"], array("icon" => false, "message" => "{$hero->Name()} launches a flurry of {$actualNumberOfAttacks} blows! <span class=\"damage\">[{$totalDamage} DMG]</span>") );
		} else {
			array_push( $round["log"], array("icon" => false, "message" => "{$hero->Name()} strikes with a heavy blow! <span class=\"damage\">[{$totalDamage} DMG]</span>") );
		}
		
	$round["actions"] = $actions;
?>