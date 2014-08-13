<?php
	$usedAbility = false;
	$ability = array();

	# RETALIATE #
	if (chance( $defender->has_Ability(1) )) {
		$ability = $defender->detail_Ability(1);
		
		$defender->augments["buff"] = $ability;
		array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$defender->Name()}'s <span class=\"ability\">Retaliate</span> boosts {$defender->Pronoun()} <span class=\"stat-power\">Power</span>!" ) );
	}
	
	# BARBS #
	else if (chance( $defender->has_Ability(17) )) {
		$ability = $defender->detail_Ability(17);	

		$defender->augments["buff"] = $ability;
		array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$defender->Name()}'s <span class=\"ability\">Barbs</span> boosts {$defender->Pronoun()} <span class=\"stat-armor\">Armor</span>!" ) );
	} 
	
	# SYPHON #
	else if (chance( $attacker->has_Ability(16) )) {
		$ability = $attacker->detail_Ability(16);

		$restore = percentOf(eq_MaxHealth($attacker->Level()), $ability["amount"]);
		$attacker->inc_Health($restore);

		array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Syphon</span> restores {$attacker->Pronoun()}'s <span class=\"stat-health\">Health</span>!" ) );	
	}
	
	else {
		# PUMMEL #
		if (chance( $attacker->has_Ability(2) )) {
			$ability = $attacker->detail_Ability(2);
			
			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Pummel</span> stuns {$defender->Name()}!" ) );
		}
		
		# AMBUSH #
		else if (chance( $attacker->has_Ability(3) )) {
			$ability = $attacker->detail_Ability(3);	

			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Ambush</span> boosts {$attacker->Pronoun()} <span class=\"stat-speed\">Speed</span>!" ) );
		}
		
		# BLIND #
		else if (chance( $attacker->has_Ability(4) )) {
			$ability = $attacker->detail_Ability(4);		

			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Blind</span> reduces {$defender->Name()}'s <span class=\"stat-armor\">Armor</span>!" ) );
		}
		
		# ENGULF #
		else if (chance( $attacker->has_Ability(5) )) {
			$ability = $attacker->detail_Ability(5);

			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Engulf</span> ignites {$defender->Name()}!" ) );
		}
		
		# CHILL #
		else if (chance( $attacker->has_Ability(6) )) {
			$ability = $attacker->detail_Ability(6);	

			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Chill</span> reduces {$defender->Name()}'s <span class=\"stat-speed\">Speed</span>!" ) );	
		}
		
		# HOWL #
		else if (chance( $attacker->has_Ability(7) )) {
			$ability = $attacker->detail_Ability(7);		
			
			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Howl</span> boosts {$attacker->Pronoun()} <span class=\"stat-power\">Power</span>!" ) );
		}
		
		# SUNDER #
		else if (chance( $attacker->has_Ability(8) )) {
			$ability = $attacker->detail_Ability(8);

			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Sunder</span> reduces {$defender->Name()}'s <span class=\"stat-speed\">Speed</span>!" ) );
		}
		
		# TOXIN #
		else if (chance( $attacker->has_Ability(9) )) {
			$ability = $attacker->detail_Ability(9);
			
			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Toxin</span> poisons {$defender->Name()}!" ) );				
		}
		
		# ENRAGE #
		else if (chance( $attacker->has_Ability(10) )) {
			$ability = $attacker->detail_Ability(10);
			
			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Enrage</span> boosts {$attacker->Pronoun()} <span class=\"stat-power\">Power</span>!" ) );	
		}
		
		# CLEAVE #
		else if (chance( $attacker->has_Ability(11) )) {
			$ability = $attacker->detail_Ability(11);		
			
			$usedAbility = true;		
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Cleave</span> tears into {$defender->Name()}!" ) );
		}
		
		# SEAR #
		else if (chance( $attacker->has_Ability(12) )) {
			$ability = $attacker->detail_Ability(12);		
		
			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Sear</span> reduces {$defender->Name()}'s <span class=\"stat-power\">Power</span>!" ) );
		}
		
		# FOCUS #
		else if (chance( $attacker->has_Ability(13) )) {
			$ability = $attacker->detail_Ability(13);

			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Focus</span> boosts {$attacker->Pronoun()} Critical Chance!" ) );	
		}
		
		# SAP #
		else if (chance( $attacker->has_Ability(14) )) {
			$ability = $attacker->detail_Ability(14);		
			
			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Sap</span> stuns {$defender->Name()}!" ) );	
		}
		
		# EXPOSE #
		else if (chance( $attacker->has_Ability(15) )) {
			$ability = $attacker->detail_Ability(15);	

			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Expose</span> reduces {$defender->Name()}'s <span class=\"stat-armor\">Armor</span>!" ) );		
		}
		
		# TRAMPLE #
		else if (chance( $attacker->has_Ability(18) )) {
			$ability = $attacker->detail_Ability(18);		
			
			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Trample</span> boosts {$defender->Pronoun()} <span class=\"stat-power\">Power</span>!" ) );	
		}
		
		# CONSTRICT #
		else if (chance( $attacker->has_Ability(19) )) {
			$ability = $attacker->detail_Ability(19);		
			
			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Constrict</span> reduces {$defender->Name()}'s <span class=\"stat-speed\">Speed</span>!" ) );	
		}
		
		# CRUSH #
		else if (chance( $attacker->has_Ability(20) )) {
			$ability = $attacker->detail_Ability(20);		
			
			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Crush</span> boosts {$attacker->Pronoun()} <span class=\"stat-power\">Power</span>!" ) );
		}
		
		# GROWTH #
		else if (chance( $attacker->has_Ability(21) )) {
			$ability = $attacker->detail_Ability(21);		
			
			$usedAbility = true;
			array_push($round["log"], array( "icon" => $ability["pic"], "message" => "{$attacker->Name()}'s <span class=\"ability\">Growth</span> boosts {$attacker->Pronoun()} <span class=\"stat-armor\">Armor</span>!" ) );
		}
		
		if ($usedAbility) {
			if($ability["target"] == "self") {
				$attacker->augments["buff"] = $ability;
			} else if ($ability["target"] == "target") {
				$defender->augments["debuff"] = $ability;
			}
		}
	}
	
?>