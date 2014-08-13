<?php
	$DUNGEON_MAXLEVEL =		20;
	$BATTLE_CHANCE = 		40;
	$TREASURE_CHANCE =		50;
		$RARE_CHANCE =		0;
		$COMMON_CHANCE =	10;
		$MEND_CHANCE =		50;
	$TRAP_CHANCE =			5;
		
	# MARK #

	if($mark = $hero->Mark($explore["floor"]))
	{
		$explore["event_category"] = "battle";
		$explore["event_specific"] = "notorious";
		$explore["event_details"] = $mark;
		
		$monster = array();	
		
		$monster["origin"] = "mark";
		
		$floorInfluence = floor($explore["floor"] / 10);
		$minLevel = $floorInfluence * 2;
		$maxLevel = $minLevel + 3;
		
		$minLevel = max($hero->Level(), $minLevel);
		$minLevel = min(20, $minLevel);
		$maxLevel = min(20, $maxLevel);
		
		$monster["id"] = $mark;
		$monster["level"] = rand($minLevel, $maxLevel);
		$monster["type"] = "notorious";
		
		$explore["event_details"] = json_encode($monster);
	}
	
	# BATTLE #
	
	else if (chance($BATTLE_CHANCE)) {
		$explore["event_category"] = "battle";
		
		$monster = array();

		$monster["origin"] = "random";
		
		$floorInfluence = floor($explore["floor"] / 10);
		$minLevel = $floorInfluence * 2;
		$maxLevel = $minLevel + 3;
		
		$minLevel = max(1, $minLevel);
		$minLevel = min(20, $minLevel);
		$maxLevel = min(20, $maxLevel);
		
		$monster["level"] = rand($minLevel, $maxLevel);
		$monster["tier"] = rand(1, 3);
		
		if (chance($explore["floor"])) {
			$monster["type"] = "fiend";
		} else {	
			$monster["type"] = "minion";
		}
		
		if (chance($explore["floor"]/3)) {
			$monster["rank"] = 2;	//VILE
		} else if (chance($explore["floor"]/2)) {
			$monster["rank"] = 1;	//DIRE
		} else {
			$monster["rank"] = 0;	//NORMAL
		}	
		
		$explore["event_specific"] = $monster["type"];
		$explore["event_details"] = json_encode($monster);
	}
	
	# TREASURE #
	
	else if (chance($TREASURE_CHANCE) && $type == "advance" && $hero->Level() <= $DUNGEON_MAXLEVEL) {
		$explore["event_category"] = "treasure";
		
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
	}
	
	# TRAP #
	
	else if (chance($TRAP_CHANCE)) {
		$explore["event_category"] = "trap";
		$explore["event_specific"] = "light";
		$explore["event_details"] = $hero->get_ExploreTrap("light");
	}
?>