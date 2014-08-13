<?php
	global $_CONFIG;
	
	// ACCOUNT -> HEROES, Maximum Number of Heroes per User
		$_CONFIG["MAX_HEROES"] = 			5;		//Heroes
	
	// HERO -> PERKS, Highest Attainable Rank
		$_CONFIG["MAX_PERK_RANK"] =			50;
		
	// EXPLORE -> ADVANCE / RETREAT, Step Amounts
		$_CONFIG["EXPLORE_ADVANCE_STEP"] = 	1;		//Floors
		$_CONFIG["EXPLORE_RETREAT_STEP"] =	5;		//Floors	
		
	// BATTLE -> CREATE MONSTER, Percentage of Hero
		$_CONFIG["BATTLE_HERO_ALLOWANCE"] = 100;	//Percent (%)
?>