<?php
	$DUNGEON_MAXLEVEL =		60;
	$BATTLE_CHANCE = 		50;
		$BATTLE_STREAK =	65;
	$TREASURE_CHANCE =		40;
		$TREASURE_STREAK =	75;
		$RARE_CHANCE =		3;
		$COMMON_CHANCE =	30;
		$MEND_CHANCE =		30;
	$TRAP_CHANCE =			5;
		$HEAVY_CHANCE =		20;
		
	# MARK #

	if($mark = $hero->Mark($explore["floor"]))
	{
		$explore["event_category"] = "battle";
		$explore["event_specific"] = "notorious";
		$explore["event_details"] = $mark;
		
		$monster = array();	
		
		$monster["origin"] = "mark";
		
		$floorInfluence = floor($explore["floor"] / 13);
		$minLevel = $floorInfluence * 2 + 30;
		$maxLevel = $minLevel + 3;
		
		$minLevel = max($hero->Level(), $minLevel);
		$minLevel = min(60, $minLevel);
		$maxLevel = min(60, $maxLevel);
		
		$monster["id"] = $mark;
		$monster["level"] = rand($minLevel, $maxLevel);
		$monster["type"] = "notorious";
		
		$explore["event_details"] = json_encode($monster);
	}

	# BATTLE #
	
	else if (chance($BATTLE_CHANCE) || ($explore["streak"] == 2 && chance($BATTLE_STREAK))) {
		$explore["event_category"] = "battle";
		
		$monster = array();
		
		$monster["origin"] = "random";
		
		$floorInfluence = floor($explore["floor"] / 13);
		$minLevel = $floorInfluence * 2 + 30;
		$maxLevel = $minLevel + 3;
		
		$minLevel = max(30, $minLevel);
		$minLevel = min(60, $minLevel);
		$maxLevel = min(60, $maxLevel);
		
		$monster["level"] = rand($minLevel, $maxLevel);
		$monster["tier"] = rand(1, 5);
		
		if ($explore["streak"] == 2) {
			if (chance($explore["floor"])) {
				$monster["type"] = "tyrant";
			} else {
				$monster["type"] = "fiend";
			}

			if (chance($explore["floor"]/2)) {
				$monster["rank"] = 4;	//ANCIENT
			} else if (chance($explore["floor"])) {
				$monster["rank"] = 3;	//ENRAGED
			} else {
				$monster["rank"] = 2;	//VILE
			}				
		} else {
			if (chance($explore["floor"]/2)) {
				$monster["type"] = "tyrant";
			} else if (chance($explore["floor"])) {
				$monster["type"] = "fiend";
			} else {	
				$monster["type"] = "minion";
			}		
			
			if (chance($explore["floor"]/5)) {
				$monster["rank"] = 4;	//ANCIENT
			} else if (chance($explore["floor"]/4)) {
				$monster["rank"] = 3;	//ENRAGED
			} else if (chance($explore["floor"]/3)) {
				$monster["rank"] = 2;	//VILE
			} else if (chance($explore["floor"]/2)) {
				$monster["rank"] = 1;	//DIRE
			} else {
				$monster["rank"] = 0;	//NORMAL
			}	
		}
		
		$explore["event_specific"] = $monster["type"];
		$explore["event_details"] = json_encode($monster);
	}
	
	# TREASURE #
	
	else if ( ( (chance($TREASURE_CHANCE)) || ($explore["streak"] == 1 && chance($TREASURE_STREAK)) ) && $type == "advance" && $hero->Level() <= $DUNGEON_MAXLEVEL) {
		$explore["event_category"] = "treasure";
		
		if ($explore["streak"] == 1) {
			if (chance($RARE_CHANCE)) {
				$explore["event_specific"] = "rare";
				$explore["event_details"] = $hero->get_ExploreTreasure("rare", $explore["floor"], $explore["streak"]);
				$explore["loot_rare"] += $explore["event_details"];
			} else if (chance($MEND_CHANCE) && $hero->Health('percent') < 100) {
				$explore["event_specific"] = "health";
				$explore["event_details"] = $hero->get_ExploreMend($explore["streak"]);	
			} else if (chance($COMMON_CHANCE)) {
				$explore["event_specific"] = "common";
				$explore["event_details"] = $hero->get_ExploreTreasure("common", $explore["floor"], $explore["streak"]);
				$explore["loot_common"] += $explore["event_details"];
			} else {
				$explore["event_specific"] = "gold";
				$explore["event_details"] = $hero->get_ExploreTreasure("gold", $explore["floor"], $explore["streak"]);
				$explore["loot_gold"] += $explore["event_details"];		
			}		
		} else {
			if (chance($RARE_CHANCE * 2)) {
				$explore["event_specific"] = "rare";
				$explore["event_details"] = $hero->get_ExploreTreasure("rare", $explore["floor"], $explore["streak"]);
				$explore["loot_rare"] += $explore["event_details"];
			} else if (chance($MEND_CHANCE * 2) && $hero->Health('percent') < 100) {
				$explore["event_specific"] = "health";
				$explore["event_details"] = $hero->get_ExploreMend($explore["streak"]);	
			} else if (chance($COMMON_CHANCE * 2)) {
				$explore["event_specific"] = "common";
				$explore["event_details"] = $hero->get_ExploreTreasure("common", $explore["floor"], $explore["streak"]);
				$explore["loot_common"] += $explore["event_details"];
			} else {
				$explore["event_specific"] = "gold";
				$explore["event_details"] = $hero->get_ExploreTreasure("gold", $explore["floor"], $explore["streak"]);
				$explore["loot_gold"] += $explore["event_details"];		
			}	
		}
	}
	
	# TRAP #
	
	else if (chance($TRAP_CHANCE) && $explore["streak"] == 0) {
		$explore["event_category"] = "trap";
		
		if (chance($HEAVY_CHANCE)) {
			$explore["event_specific"] = "heavy";
			$explore["event_details"] = $hero->get_ExploreTrap("heavy");
		} else {
			$explore["event_specific"] = "light";
			$explore["event_details"] = $hero->get_ExploreTrap("light");
		}
	}
	
	# STREAK #
	
	else if ($type == "advance" && $explore["streak"] == 0) {
		if (chance($explore["floor"]/4)) {
			$explore["event_category"] = "streak";
			$explore["streak_duration"] = rand(1, 10);
			if (chance(50)) {
				$explore["event_specific"] = "green";
				$explore["streak"] = 1;			
			} else {
				$explore["event_specific"] = "red";
				$explore["streak"] = 2;
			}
		}
	}
?>