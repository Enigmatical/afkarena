<?php 
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	
	$type = $_GET["type"];
	$type = decode($type);
	
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
		
	if ($type == "start") {
		if ($hero->get_ExploreID())
		{
			header("Location:/explore/dungeon.php");
			exit;
		}
	
		$did = decode($_GET["dungeon"]);
		
		$hero->Explore($did);
		
		header("Location:/explore/dungeon.php");
	} else {
		$explore = $hero->detail_Explore();
		$explore["event_category"] = "";
		$explore["event_specific"] = "";
		$explore["event_details"] = "";
		
		if ($type == "advance") {
			$hero->inc_Stat("dungeonTravel", 1);
			$hero->inc_Stat("dungeon-{$hero->get_DungeonID()}Travel", $_CONFIG["EXPLORE_ADVANCE_STEP"]);
		
			$explore["floor"] += $_CONFIG["EXPLORE_ADVANCE_STEP"];
			$explore["max_floor"] += $_CONFIG["EXPLORE_ADVANCE_STEP"];
			if ($explore["streak_duration"] > 0) {
				$explore["streak_duration"] -= 1;
			}
			if ($explore["streak_duration"] == 0) {
				$explore["streak"] = 0;
				$explore["streak_duration"] = 0;
			}
		}
		if ($type == "retreat") {
			$explore["floor"] -= $_CONFIG["EXPLORE_RETREAT_STEP"];
			$explore["streak"] = 0;
			$explore["streak_duration"] = 0;
		}
		
		if ($explore["floor"] > 0) {
			
			include "travel-dungeon_" . $hero->get_DungeonID() . ".php";
			
			$hero->save_Explore($explore);
			$hero->save();
		
			header("Location:/explore/dungeon.php");
		} else {
			
			$eid = $hero->get_ExploreID();
			
			$resultsUrl = "/explore/results.php?eid={$eid}&quest=0&leveled=0";
			
			if ($hero->Depth($explore["max_floor"]) == "complete")
			{
				$rewards = $hero->get_QuestRewards();
				
				$leveled = $hero->has_Leveled();
				
				$resultsUrl = "/explore/results.php?eid={$eid}&quest=1&qexp={$rewards["exp"]}&qgold={$rewards["gold"]}&qiron={$rewards["ore_common"]}&qcobalt={$rewards["ore_rare"]}&leveled={$leveled}";
			}
			
			$hero->Escape();
			
			$hero->save();
			
			header("Location:{$resultsUrl}");
		}
	}
?>