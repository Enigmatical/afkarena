<?php
	include "../includes/security.php";
	
	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	include "../classes/Monster.php";
	
	header("Content-Type: text/plain");
	
	# PREPARE #
		$hero = new Hero();
		$hero->load($_SESSION["hero_id"]);

		$battleID = $hero->get_BattleID();
		
		$hero->identifier = "hero";
		$hero->combat = array( 
								"power" => 0, 
								"speed" => 0,
								"armor" => 0 
							);
		$hero->status = array( "stun" => false, "focus" => false );
		$hero->augments = array( "buff" => null, "debuff" => null );
		
		$monster = new Monster();
		$monster->load($battleID);
		
		$monster->identifier = "monster";
		$monster->combat = array(
								"power" => 0,
								"speed" => 0,
								"armor" => 0
							);
		$monster->status = array( "stun" => false, "focus" => false );
		$monster->augments = array( "buff" => null, "debuff" => null );
				
		$INITIAL_POWER_BOOST = 0; //For all other classes
		if($hero->Job() == "mage") { $INITIAL_POWER_BOOST = 25; }	//Mages Only - Starts off with a large power boost that flunctuates during battle
		
	# INTIMIDATION #
		$fear = 0;
		if ($monster->Level() > $hero->Level()) {
			$fear = $monster->Level() - $hero->Level();
		}
	
	# INITIATIVE #
		$hero_init = rand(1, 20) + percentOf($hero->get_EquipRating("speed"), 10);
		$monster_init = rand(1, 20) + $fear;
	
		$battle_order = $hero_init >= $monster_init ? array("hero", "monster") : array("monster", "hero");
		$battle_who = 0;
	
	$battle = array();
	$battle["rounds"] = array();
	
	$battle_HeroRounds = 0;
	$battle_MonsterRounds = 0;
	
	$stop_battle = 0;
	
	while ($stop_battle == 0) {
		
		$round = array();
		$round["log"] = array();
				
		# WHO IS ATTACKING?  WHO IS DEFENDING? #
			$round["attacker"] = $battle_order[$battle_who];
			
			if ($round["attacker"] == "hero") {
				$attacker = &$hero;
				$defender = &$monster;
			} else {
				$attacker = &$monster;
				$defender = &$hero;
			}
						
		# MODIFY THE HERO'S STATS WITH THE AUGMENTS #
			$hero_Power = 0;
			$hero_Speed = $hero->get_EquipRating("trinket");
			$hero_Armor = $hero->get_EquipRating("armor");
			
			$hero->combat = array( 
									"power" => 0, 
									"speed" => 0,
									"armor" => 0 
								);
			$hero->status = array( "stun" => false, "focus" => false );			
			
			$monster->combat = array(
									"power" => 0,
									"speed" => 0,
									"armor" => 0
								);
			$monster->status = array( "stun" => false, "focus" => false );
			
			switch($fear) {
				case $fear > 0 && $fear <= 2:
					$hero_Armor -= percentOf($hero_Armor, 25);
					break;
				case $fear > 2:
					$hero_Armor -= percentOf($hero_Armor, (50 + (10 * ($fear-3))));
			}
						
			if ($attacker->augments["buff"]) {
				$augment = &$attacker->augments["buff"];
				
				if ($augment["stacks"] > 0) {
					if ($augment["affects"] == "power" || $augment["affects"] == "armor" || $augment["affects"] == "speed") {
						$attacker->combat[$augment["affects"]] += $augment["amount"];
					}
					else if ($augment["affects"] == "focus") {
						$attacker->status["focus"] = true;
					}
					$augment["stacks"] = $augment["stacks"] - 1;
					if ($augment["stacks"] == 0) { $attacker->augments["buff"] = null; }
				}
			}
			if ($attacker->augments["debuff"]) {
				$augment = &$attacker->augments["debuff"];
								
				if ($augment["stacks"] > 0) {
					if ($augment["affects"] == "power" || $augment["affects"] == "armor" || $augment["affects"] == "speed") {
						$attacker->combat[$augment["affects"]] -= $augment["amount"];
					}
					else if ($augment["affects"] == "stun") {
						$attacker->status["stun"] = true;
					}
					else if ($augment["affects"] == "health") {
						$damage = round( percentOf(eq_MaxHealth($defender->Level()), $augment["amount"]) );
						$attacker->dec_Health($damage);
						array_push($round["log"], array("icon" => false, "message" => "{$attacker->Name()} suffers from {$augment["debuff"]}! <span class=\"damage\">[{$damage} DMG]</span>") );
					}
					
					$augment["stacks"] = $augment["stacks"] - 1;
					
					if ($augment["stacks"] == 0) { $attacker->augments["debuff"] = null; }
				}				
			}
			
			if ($defender->augments["buff"]) {
				$augment = &$defender->augments["buff"];
				if ($augment["stacks"] > 0) {
					if ($augment["affects"] == "power" || $augment["affects"] == "armor" || $augment["affects"] == "speed") {
						$defender->combat[$augment["affects"]] += $augment["amount"];
					}
				} else {
					$defender->augments["buff"] = null;
				}
			}
			if ($defender->augments["debuff"]) {
				$augment = &$defender->augments["debuff"];
				if ($augment["stacks"] > 0) {
					if ($augment["affects"] == "power" || $augment["affects"] == "armor" || $augment["affects"] == "speed") {
						$defender->combat[$augment["affects"]] -= $augment["amount"];
					}
				} else {
					$defender->augments["debuff"] = null;
				}
			}
			
		# ATTACK #
			if ($attacker->status["stun"]) {
				$totalDamage = 0;
				$round["actions"] = array();
				array_push( $round["log"], array( "icon" => false, "message" => "{$attacker->Name()} is <span class=\"ability\">Stunned</span> and cannot attack!" ) );	
			} else {
				
				# ABILTIES #
				include "abilities.php";			
			
				if ($attacker->identifier == "hero") {			
					$battle_HeroRounds++;
					
					$hero_Power += $hero->combat["power"];
					$hero_Speed += percentOf($hero_Speed, $hero->combat["speed"]);
					$hero_Armor += percentOf($hero_Armor, $hero->combat["armor"]);
					
					if ($monster->combat["power"] > 0) {
						$hero_Armor -= percentOf($hero_Armor, $monster->combat["power"]);
					} else {
						$hero_Armor += percentOf($hero_Armor, abs($monster->combat["power"]));
					}
					
					if ($monster->combat["armor"] > 0) {
						$hero_Power -= $monster->combat["armor"];
					} else {
						$hero_Power += abs($monster->combat["armor"]);
					}
					
					if ($monster->combat["speed"] > 0) {
						$hero_Speed -= percentOf($hero_Speed, $monster->combat["speed"]);
					} else {
						$hero_Speed += percentOf($hero_Speed, abs($monster->combat["speed"]));
					}
					
					$hero_Power = round( $hero_Power );
					$hero_Speed = round( $hero_Speed );
					$hero_Armor = round( $hero_Armor );
										
					include "attack_" . strtolower($attacker->Job()) . ".php";
				} else {
					$battle_MonsterRounds++;
					include "attack_monster.php";
				}
			}
			
			$round["hero"]["augments"]["buff"] = $hero->augments["buff"];
			$round["hero"]["augments"]["debuff"] = $hero->augments["debuff"];
			$round["monster"]["augments"]["buff"] = $monster->augments["buff"];
			$round["monster"]["augments"]["debuff"] = $monster->augments["debuff"];
			
		# DEAL DAMAGE #
			$defender->dec_Health($totalDamage);
			$round["hero"]["health"]["value"] = $hero->Health();
			$round["hero"]["health"]["percent"] = $hero->Health('percent');
			$round["monster"]["health"]["value"] = $monster->Health();
			$round["monster"]["health"]["percent"] = $monster->Health('percent');
			
		array_push($battle["rounds"], $round);
			
		# CHECK FOR END OF BATTLE #
			if ($defender->Health() <= 0 && $attacker->Health() <= 0) {
				$battle["winner"] = "monster";
				$stop_battle = 1;
			}
			
			else if ($defender->Health() <= 0) {
				$battle["winner"] = $attacker->identifier;
				$stop_battle = 1;
			}
			
			else if ($attacker->Health() <= 0) {
				$battle["winner"] = $defender->identifier;
				$stop_battle = 1;
			}
			
			$battle_who = ($battle_who == 0) ? 1 : 0;
	}
	
	unset($hero->identifier, $hero->combat, $hero->status, $hero->augments);
	unset($monster->identifier, $monster->combat, $monster->status, $monster->augments);
	
	$battle["results"] = array();
	
	if ($battle["winner"] == "hero") {
		$gainExp = $hero->inc_Exp($monster->exp);
		
		$battle["results"]["exp"]["gain"] = $gainExp;
		
		$battle["results"]["gold"] = $monster->Loot("gold");
		$battle["results"]["ore_common"] = $monster->Loot("ore_common");
		$battle["results"]["ore_rare"] = $monster->Loot("ore_rare");
		
		$battle["results"]["drops"] = array();
		
		foreach( $monster->drops as $drop ) {
			if ($hero->Gather($drop)) {
				$q = $hero->inc_Drop($drop);
				$d = $hero->detail_Drop($drop);
				
				array_push( $battle["results"]["drops"], array( "name" => $d["name"], "pic" => $d["pic"], "target" => $q["target"], "actual" => $q["actual"], "need" => $q["need"] ) );
			}
		}
		
		$battle["results"]["complete_quest"] = array();
		
		if ($hero->has_GatherCompleted() == "complete") {
			$rewards = $hero->get_QuestRewards();

			array_push( $battle["results"]["complete_quest"], array( "type" => "gather", "rewards" => $rewards ) );
		}
		
		if ($hero->has_MarkCompleted($monster->ID()) == "complete") {
			$rewards = $hero->get_QuestRewards();
			
			array_push( $battle["results"]["complete_quest"], array( "type" => "mark", "rewards" => $rewards ) );			
		}
		
		if ($hero->has_Leveled()) {
			$battle["results"]["exp"]["percent"] = 100;
			$battle["results"]["levelUp"] = true;
		} else {
			$battle["results"]["exp"]["percent"] = $hero->Exp('percent');
			$battle["results"]["levelUp"] = false;	
		}
		
		$hero->Victory($monster->Loot("gold"), $monster->Loot("ore_common"), $monster->Loot("ore_rare"), $monster->Level());
	} else {
		$hero->inc_Health(25, true);
		$hero->Defeat();
	}
	
	$hero_json = addslashes(json_encode($hero));
	$battle_json = addslashes(json_encode($battle));
	
	query("UPDATE battle SET hero = '{$hero_json}', battle = '{$battle_json}' WHERE id = '{$battleID}'");
	
	$hero->save();
	
	echo json_encode($battle);
?>