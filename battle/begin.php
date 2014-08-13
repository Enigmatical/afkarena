<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	include "../classes/Monster.php";
			
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	if ($hero->get_BattleID())
	{
		header("Location:/battle/engage.php");
		exit;
	}	
	
	$explore = $hero->detail_Explore();
	
	$hero->save();
			
	$monster = new Monster();
	
	$md = json_decode($explore["event_details"], true);
	
	if ($md["origin"] == "random") {
		$monster->random($md["level"], $md["tier"], $md["type"], $md["rank"]);
	} else {
		$monster->specific($md["id"], $md["level"], $md["type"]);
	}
	
	if($hero->Level() > $monster->Level()) {
		$levelDifference = $hero->Level() - $monster->Level();
		$monster->exp -= round( percentOf($monster->exp, $levelDifference * 30) );
		$monster->exp = max( $monster->exp, 0 );
	}
	
	if($hero->Level() < $monster->Level()) {
		$levelDifference = $monster->Level() - $hero->Level();
		$monster->exp += round( percentOf($monster->exp, $levelDifference * 10) );
	}
	
	//KLEPTOMANIAC (ROGUE PERK)
	if ($hero->has_Perk(8)) {
		$monster->loot["gold"] += round( percentOf($monster->loot["gold"], $hero->has_Perk(8)) );
	}
	
	//LOREMASTER (MAGE PERK)
	if ($hero->has_Perk(9)) {
		$monster->exp += round( percentOf($monster->exp, $hero->has_Perk(9)) );
	}
	
	$bid = uniqid();
	$hid = $hero->ID();
	$json = $monster->to_json();
	
	
	query("INSERT INTO battle (id, hero_id, type, monster, status, created) VALUE ('{$bid}', '{$hid}', 'monster', '{$json}', 'ready', NOW())");
	query("UPDATE heroes SET current_battle = '{$bid}' WHERE id = '{$hid}'");
	
	header("Location:engage.php");
?>