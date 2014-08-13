<?php
	class Hero {
		
		# CONSTANTS #
		
		const 
		
			# GENERAL #
			MAX_LEVEL =					60,		//Maximum Hero Level Attainable
			
			# POWER #
			WARRIOR_POWER_BOOST =		5,		//Increase Base Power by % (Warriors are strong)
			ROGUE_POWER_BOOST =			0,		//Increase Base Power by % (Muscles do not lend to Sneakiness)
			MAGE_POWER_BOOST =			10,		//Increase Base Power by % (Glass Cannons!)
			
			# SPEED #
			WARRIOR_SPEED_BOOST =		0,		//Increase Base Speed by % (Not Super Quick)
			ROGUE_SPEED_BOOST =			10,		//Increase Base Speed by % (Super Quick)
			MAGE_SPEED_BOOST =			5,		//Increase Base Speed by % (Moderately Super Quick)
			
			# ARMOR #
			WARRIOR_ARMOR_BOOST =		10,		//Increase Base Health by % (Warriors are more durable)
			ROGUE_ARMOR_BOOST =			5,		//Increase Base Health by % (Rogues are more agile)
			MAGE_ARMOR_BOOST =			0,		//Increase Base Health by % (Mages are squishy!)
			
			# EQUIPMENT #
			EQUIP_MAXRANK =				6,		//Maximum Base Rank for Equipment
			EQUIP_NEED =				8,		//Number of Enchants Before New Equipment is Offered
			ENCHANT_WORTH =				10,		//Determines Enchant "Rank" (ENCHANT LEVEL / ENCHANT_WORTH = SUFFIX/PREFIX RANK)
			ENCHANT_MAXNAME =			5,		//Maximum Equipment Prefixes & Suffixes
			ENCHANT_MINOR_BOOST =		1,		//Minor Enchant Boost Amount (Higher = More %)
			ENCHANT_MAJOR_BOOST =		1,		//Major Enchant Boost Amount (Higher = More Attribute)
			
			# MEND #
			MEND_MINOR_DONATION =		10,		//Percent of the Hero's Total Gold (Donation)
			MEND_MAJOR_DONATION =		25,		//Percent of the Hero's Total Gold (Donation)
			MEND_MINOR_LOW =			25,		//Lower % of HP Restored by Mend Minor
			MEND_MINOR_HIGH =			50,		//Higher % of HP Restored by Mend Minor
			
			# TRAIN #
			TRAIN_PERK_MAXRANK =		30,		//Maximum Perk Rank Attainable
			
			# FORGE #
			FORGE_GOLD_COST =			100,	//Per Rank Increase (AMT * RANK = COST)
			FORGE_MINOR_COST =			3,		//Per Minor Enchant (in Iron Ore)
			FORGE_MAJOR_COST =			3,		//Per Major Enchant (in Cobalt Ore)
			
			# EXPLORE #
			EXPLORE_MEND_LOW =			25,		//Lower % of HP Restored by Treasure->Mend
			EXPLORE_MEND_HIGH =			50,		//Lower % of HP Restored by Treasure->Mend
			EXPLORE_TRAP_LOW =			5,		//Damage % of Health (Light Trap)
			EXPLORE_TRAP_HIGH =			15,		//Damage % of Health (Medium Trap)
			
			# BATTLE #
			BATTLE_GOLD_FRACTION =		50,		//Percent of Gold left after Defeat in Battle :(
			BATTLE_ORE_FRACTION =		25,		//Percent of Ore left after Defeat in Battle :(
			
			# QUEST #
			QUESTS_PER_RANK =			3,		//How many quests per rank?
			QUEST_GOLD_REWARD =			10,		//Gold reward per Quest Rank

			# SCORE #
			SCORE_LEVEL =				200,	//How many Points rewarded Per Level
			SCORE_EQUIP_BASE =			100,	//How many Points rewarded Per Base Equip Level
			SCORE_EQUIP_MAJOR =			20,		//How many Points rewarded Per Major Equip Level
			SCORE_EQUIP_MINOR =			4,		//How many Points rewarded Per Minor Equip Level
			SCORE_LABYRINTH_RANK =		20,		//How many Points rewarded Per Quest Rank
			SCORE_MARSHES_RANK =		10,		//How many Points rewarded Per Quest Rank
			SCORE_CELLAR_RANK =			5,		//How many Points rewarded Per Quest Rank
			SCORE_BATTLE_WORTHY =		1;		//How many Points rewarded for Battling Equal Level Monsters
		
		
		# VARIABLES #
		
		public
			
			# GENERAL #
			$id,								//Hero's ID
			$name,								//Hero's Name
			$job,								//Hero's Job
			$gender,							//Hero's Gender
			
			# VITALS #
			$level,								//Hero's Level
			$health,							//Hero's Current HP
			$exp,								//Hero's Current EXP
			
			# LOOT #
			$loot,
			
			# EQUIPMENT #
			$equipment,							//Hero's Equipment
			
			# ABILITIES #
			$abilities,							//Hero's Abilities
			
			# PERKS #
			$perks,								//Hero's Perks
			
			# QUEST LOG #
			$quest_log,							//Hero's Quest Log
			
			# STATS #
			$stats;								//Hero's Statistics


		# MEND #
		
		function Mend($type) {
			$mend = array();
			
			switch($type) {
				case "minor":
					$rec_perc = rand(self::MEND_MINOR_LOW, self::MEND_MINOR_HIGH);
					break;		
				case "major":
					$rec_perc = 100;
					break;
			}
			
			$mend["before"] = $this->Health();
			
			$recover = $this->inc_Health($rec_perc, true);
			
			$mend["boost"] = $recover;
			$mend["after"] = $this->Health();
			
			$this->dec_Loot('gold', $this->cost_Mend($type));
			
			return $mend;
		}
		
			function cost_Mend($type) {
				$modifier = array( 
					"minor" => self::MEND_MINOR_DONATION, 
					"major" => self::MEND_MAJOR_DONATION
				);
				
				$cost = percentOf($this->Loot('gold'), $modifier[$type]);
				
				if ($perk = $this->has_Perk(3)) { $cost -= percentOf($cost, $perk); }  //WARRIOR PERK - CHARISMATIC
				
				return round( $cost );
			}
				
		# TRAIN #
		
		function Train($pid) {
			$train = array();
			
			$train["before"] = $this->has_Perk($pid);
			
			if ($this->Loot('vouchers') > 0) { $this->dec_Loot('vouchers', 1); }
			else { return false; }
			
			$result = $this->inc_Perk($pid);
			
			$train["after"] = $this->has_Perk($pid);
			$train["boost"] = $result;
			
			return $train;
		}
		
		# FORGE #
		
		function Enchant($e, $type) {
			$enchant = array();
		
			$preHealth = $this->Health('percent');
			
			$cost = $this->cost_Forge($e, $type);
			
			if ($this->get_EquipNeed($e) == 0) { return false; }
			
			switch($type) {
				case 'minor':
					if ($this->Loot('ore_common') >= $cost) { $this->dec_Loot('ore_common', $cost); }
					else { return false; }
					$boost = self::ENCHANT_MINOR_BOOST;
					break;
				case 'major':
					if ($this->Loot('ore_rare') >= $cost) { $this->dec_Loot('ore_rare', $cost); }
					else { return false; }
					$boost = self::ENCHANT_MAJOR_BOOST;
					break;
			}
			
			$enchant["before"] = $this->get_EquipBonus($e, $type);
			$result = $this->inc_Equip($e, $type);
			$enchant["after"] = $this->get_EquipBonus($e, $type);
			$enchant["boost"] = $result * $boost;
			
			$postHealth = $this->Health('percent');
			
			$this->inc_Health($preHealth-$postHealth, true);
			
			if ($this->can_IncreaseEquip($e)) { $this->dec_EquipNeed($e); }
			
			return $enchant;
		}
		
		function Forge($e) {
			$cost = $this->cost_Forge($e, 'forge');
			
			if ($this->Loot('gold') >= $cost) { $this->dec_Loot('gold', $cost); }
			else { return false; }
			
			$this->inc_Equip($e, 'base');
			$this->reset_EquipNeed($e);
						
			return true;
		}
		
			function can_IncreaseEquip($e) {
				return $this->Equip($e, 'base') < self::EQUIP_MAXRANK ? true : false;
			}
		
			function detail_NextForge($e) {
				$nextRank = $this->Equip($e, 'base') + 1;
				$details = query("SELECT * FROM {$e} WHERE job = '{$this->Job()}' AND rank = '{$nextRank}'");
				return mysql_fetch_assoc($details);
			}
			
			function cost_Forge($e, $type) {
				$nextRank = $this->Equip($e, 'base') + 1;
				
				switch($type)
				{
					case 'forge':
						$cost = $nextRank * self::FORGE_GOLD_COST;
						if ($perk = $this->has_Perk(3)) { $cost -= percentOf($cost, $perk); } //WARRIOR PERK - CHARISMATIC
						break;
					case 'minor':
						$cost = self::FORGE_MINOR_COST;
						break;
					case 'major':
						$cost = self::FORGE_MAJOR_COST;
						break;
				}
				
				return round( $cost );
			}
				
		# EXPLORE #
		
		function Explore($did) {
			$hid = $this->ID();
			$eid = uniqid();
			
			query(
				"INSERT 
					INTO explore 
					( id, hero_id, dungeon_id, floor, max_floor, event_category, event_specific, event_details, streak, streak_duration, loot_gold, loot_common, loot_rare, status, created )
					VALUES
					( '{$eid}', '{$hid}', '{$did}', 1, 1, '', '', '', 0, 0, 0, 0, 0, 'in progress', NOW())"
			);
							
			query("UPDATE heroes SET current_explore = '{$eid}' WHERE id = '{$hid}'");
		}
		
		function Escape() {
			$hid = $this->ID();
			$eid = $this->get_ExploreID();
			$explore = $this->detail_Explore($eid);
			
			$exploreGold = $this->inc_Loot('gold', $explore['loot_gold']);
			$exploreCommon = $this->inc_Loot('ore_common', $explore['loot_common']);
			$exploreRare = $this->inc_Loot('ore_rare', $explore['loot_rare']);
			
			$this->inc_Stat('gatherGold', $exploreGold);
			$this->inc_Stat('gatherCommon', $exploreCommon);
			$this->inc_Stat('gatherRare', $exploreRare);
			
			if ($this->Stat('dungeon-' . $explore["dungeon_id"] . "MaxFloor") < $explore["max_floor"]) {
				$this->set_Stat('dungeon-' . $explore["dungeon_id"] . "MaxFloor", $explore["max_floor"]);
			}
		
			query("UPDATE explore SET event_category = '', event_specific = '', status = 'escape', finished = NOW() WHERE id = '{$eid}'");
			query("UPDATE heroes SET current_explore = '' WHERE id = '{$hid}'");
		}	
			
			function detail_Explore($eid = '') {
				if (empty($eid)) { $eid = $this->get_ExploreId(); }
				$result = query("SELECT * FROM explore WHERE id = '{$eid}'");
				return mysql_fetch_assoc($result);
			}
			
			function save_Explore($explore) {
				$eid = $explore["id"];

				query(
					"UPDATE explore 
						SET 
							floor = '{$explore['floor']}', 
							max_floor = '{$explore["max_floor"]}', 
							event_category = '{$explore['event_category']}', 
							event_specific = '{$explore['event_specific']}', 
							event_details = '{$explore['event_details']}', 
							streak = '{$explore['streak']}', 
							streak_duration = '{$explore['streak_duration']}', 
							loot_gold = '{$explore['loot_gold']}', 
							loot_common = '{$explore['loot_common']}', 
							loot_rare = '{$explore['loot_rare']}', 
							status = '{$explore['status']}'
						WHERE id = '{$eid}'"
				);
			}
			
			function get_ExploreTreasure($type, $floor, $streak) {
				$amt = 0;
				
				switch($type) {
					case 'gold':
						$amt = rand(1, $floor);
						break;
					case 'common':
						$amt = rand(1, 2);
						break;
					case 'rare':
						$amt = 1;
						break;
				}
				
				if ($streak == 1) { $amt = $amt * 2; }
				
				return $amt;
			}
			
			function get_ExploreMend($streak) {
				$percent = rand(self::EXPLORE_MEND_LOW, self::EXPLORE_MEND_HIGH);	
				$mend = $this->inc_Health($percent, true);
				return $mend;
			}
			
			function get_ExploreTrap($type) {
				if ($this->Health('percent') <= self::EXPLORE_TRAP_HIGH) { $trap = 0; }
				else {
					switch($type) {
						case "heavy":
							$trap = $this->dec_Health(self::EXPLORE_TRAP_LOW, true);
							break;
						default:
							$trap = $this->dec_Health(self::EXPLORE_TRAP_HIGH, true);
							break;
					}
				}
				
				return $trap;
			}
		
		# BATTLE #
		
		function Damage() {
			$rating = $this->get_EquipRating('weapon');
			return rand($rating["min"], $rating["max"]);
		}
		
		function Victory($gold, $common, $rare, $mLevel) {
			$hid = $this->ID();
			$eid = $this->get_ExploreID();
			$bid = $this->get_BattleID();
			
			$explore = $this->detail_Explore($eid);
			
			if ($explore["event_specific"] == "minion" || $explore["event_specific"] == "fiend" || $explore["event_specific"] == "tyrant") {
				$this->inc_Stat("defeat" . ucfirst($explore["event_specific"]), 1);
			}
			
			$this->inc_Stat("battleTotal", 1);
			$this->inc_Stat("battleVictories", 1);
			
			if ($this->Level() >= ($mLevel - 2)) {
				$this->inc_Stat("battleWorthy", 1);
			}
			
			$lootGold = $explore['loot_gold'] + $gold;
			$lootCommon = $explore['loot_common'] + $common;
			$lootRare = $explore['loot_rare'] + $rare;
			
			query("UPDATE explore SET event_category = '', event_specific = '', loot_gold = '{$lootGold}', loot_common = '{$lootCommon}', loot_rare = '{$lootRare}' WHERE id = '{$eid}'");
			query("UPDATE battle SET status = 'victory', finished = NOW() WHERE id = '{$bid}'");
			query("UPDATE heroes SET current_battle = '' WHERE id = '{$hid}'");
		}
		
		function Defeat() {
			$hid = $this->ID();
			$eid = $this->get_ExploreID();
			$bid = $this->get_BattleID();
			
			$explore = $this->detail_Explore($eid);
			
			$lootGold = round( percentOf($explore['loot_gold'], self::BATTLE_GOLD_FRACTION) );
			$lootCommon = round( percentOf($explore['loot_common'], self::BATTLE_ORE_FRACTION) );
			$lootRare = round( percentOf($explore['loot_rare'], self::BATTLE_ORE_FRACTION) );
			
			$defeatGold = $this->inc_Loot('gold', $lootGold);
			$defeatCommon = $this->inc_Loot('ore_common', $lootCommon);
			$defeatRare = $this->inc_Loot('ore_rare', $lootRare);
			
			$this->inc_Stat('gatherGold', $defeatGold);
			$this->inc_Stat('gatherCommon', $defeatCommon);
			$this->inc_Stat('gatherRare', $defeatRare);
			
			$this->inc_Stat("battleTotal", 1);
			$this->inc_Stat("battleDefeats", 1);
			
			query("UPDATE explore SET loot_gold = '{$lootGold}', loot_common = '{$lootCommon}', loot_rare = '{$lootRare}', status = 'defeat', finished = NOW() WHERE id = '{$eid}'");
			query("UPDATE battle SET status = 'defeat', finished = NOW() WHERE id = '{$bid}'");
			query("UPDATE heroes SET current_battle = '', current_explore = '' WHERE id = '{$hid}'");
		}
		
		# QUEST #
		
		function Gather($drid = '', $did = '') {
			if (empty($did)) { $did = $this->get_DungeonID(); }
			
			if (empty($drid)) {	
				$drops = array();
			
				foreach($this->quest_log[$did]["quests"]["gather"]["target"] as $drid=>$target) {
					$actual = $this->quest_log[$did]["quests"]["gather"]["actual"][$drid];
					
					$d = $this->detail_Drop($drid);
					
					array_push($drops, array( "id" => $drid, "name" => $d["name"], "pic" => $d["pic"], "target" => $target, "actual" => $actual ));
				}

				return $drops;				
			} else {
				if ( array_key_exists($drid, $this->quest_log[$did]["quests"]["gather"]["target"]) ) {
					$target = $this->quest_log[$did]["quests"]["gather"]["target"][$drid];
					$actual = $this->quest_log[$did]["quests"]["gather"]["actual"][$drid];
					
					return $actual < $target ? true : false;
				} else {
					return false;
				}			
			}
		}
			
			function inc_Drop($drid) {
				$did = $this->get_DungeonID();
				
				$this->quest_log[$did]["quests"]["gather"]["actual"][$drid]++;
				
				$need = $this->quest_log[$did]["quests"]["gather"]["target"][$drid] - $this->quest_log[$did]["quests"]["gather"]["actual"][$drid];
				
				return array(
					"target" => $this->quest_log[$did]["quests"]["gather"]["target"][$drid],
					"actual" => $this->quest_log[$did]["quests"]["gather"]["actual"][$drid],
					"need" => $need
				);				
			}			

				function has_GatherCompleted($did = '') {
					if (empty($did)) { $did = $this->get_DungeonID(); }
					
					if ($this->quest_log[$did]["quests"]["gather"]["completed"] == 1) { return "already complete"; }
					
					$complete = true;
					
					foreach($this->quest_log[$did]["quests"]["gather"]["target"] as $drid=>$target) {
						$actual = $this->quest_log[$did]["quests"]["gather"]["actual"][$drid];
						
						if ($actual < $target) { $complete = false; }
					}
					
					if ($complete) {
						$this->quest_log[$did]["quests"]["gather"]["completed"] = 1;
						return "complete";
					}
					
					return false;
				}
			
				function detail_Drop($drid) {
					$drop = query("SELECT * FROM drops WHERE id = '{$drid}'");
					return mysql_fetch_assoc($drop);
				}

		function Mark($floor, $did = '') {
			if (empty($did)) { $did = $this->get_DungeonID(); }
			
			if ($this->quest_log[$did]["quests"]["mark"]["completed"] == 1) { return false; }

			$target_floor = $this->quest_log[$did]["quests"]["mark"]["target"]["floor"];
			
			$search_chance = 0;
			
			if ($floor >= $target_floor) { $search_chance = $search_chance + 15 + ($floor - $target_floor); }
			
			return chance($search_chance) ? $this->quest_log[$did]["quests"]["mark"]["target"]["mark"] : false;
		}
		
			function has_MarkCompleted($mid = '', $did = '') {
				if (empty($did)) { $did = $this->get_DungeonID(); }
				
				if($this->quest_log[$did]["quests"]["mark"]["completed"] == 1) { return "already complete"; }
				
				if ($this->quest_log[$did]["quests"]["mark"]["target"]["mark"] == $mid) {
					$this->quest_log[$did]["quests"]["mark"]["completed"] = 1;
					return "complete";
				}
				
				return false;
			}
			
		function Depth($max_floor = '', $did = '') {
			if (empty($did)) { $did = $this->get_DungeonID(); }
			
			if ($this->quest_log[$did]["quests"]["depth"]["completed"] == 1) { return "already complete"; }
			
			if ($max_floor >= $this->quest_log[$did]["quests"]["depth"]["target"]["floor"]) {
				$this->quest_log[$did]["quests"]["depth"]["completed"] = 1;
				return "complete";
			}
			
			return false;
		}
			
		function get_QuestRank($did = '') {
			if (empty($did)) { $did = $this->get_DungeonID(); }
			return $this->quest_log[$did]["rank"];
		}
		
			function get_QuestRankComplete($did = '') {
				if (empty($did)) { $did = $this->get_DungeonID(); }
					
				$completed = 0;
					
				foreach($this->quest_log[$did]["quests"] as $quest) {
					if ($quest["completed"] == 1) { $completed++; }
				}
				
				return $completed == self::QUESTS_PER_RANK ? true : false;
			}
			
			function get_QuestRankStatus($did = '') {
				if (empty($did)) { $did = $this->get_DungeonID(); }
				
				$completed = 0;
				$status = array( "complete" => 0, "overall" => self::QUESTS_PER_RANK );
				
				foreach($this->quest_log[$did]["quests"] as $quest) {
					if ($quest["completed"] == 1) { $status['complete']++; }
				}			
				
				return $status;
			}
		
		function load_Quests($did, $rank) {
			$this->quest_log[$did]["rank"] = $rank;
			
			$quests = query("SELECT id, quest_type, target FROM quests WHERE dungeon_id = '{$did}' AND quest_rank = '{$rank}'");
			
			while ($quest = mysql_fetch_assoc($quests)) {
				$target = json_decode($quest["target"], true);
				$actual = array();
			
				if ($quest["quest_type"] == "gather") {
					foreach ($target as $key=>$val) { $actual[$key] = "0"; }
				}
				
				$this->quest_log[$did]["quests"][$quest["quest_type"]] = array( "id" => $quest["id"], "completed" => 0, "target" => $target, "actual" => $actual );
			}
		}
		
		function detail_Quest($qid) {
			$quest = query("SELECT * FROM quests WHERE id = '{$qid}'");
			return mysql_fetch_assoc($quest);
		}
		
			function list_Quests($did = '') {
				if (empty($did)) { $did = $this->get_DungeonID(); }
				
				$quests = array();

				foreach($this->quest_log[$did]["quests"] as $quest) {
					$q = $this->detail_Quest($quest["id"]);
					
					array_push($quests, array( "id" => $q["id"], "type" => $q["quest_type"], "title" => $q["title"], "description" => $q["description"], "completed" => $quest["completed"] ) );
				}
				
				return $quests;
			}
			
		function get_QuestRewards($did = '') {
			$this->inc_Stat('questComplete', 1);
		
			if (empty($did)) { $did = $this->get_DungeonID(); }
			
			$rank = $this->get_QuestRank($did);

			$reward_exp = round( (eq_MonsterExp( $this->Level() ) * max( 1, (($rank * $did) / 3) )) * 2 );
			$reward_gold = round( self::QUEST_GOLD_REWARD * max(1, (round( ($rank * $did) / 2)) ) );
			$reward_common = rand(1, $rank);
			$reward_rare = $did;
			
			$exp = $this->inc_Exp($reward_exp);
			$gold = $this->inc_Loot('gold', $reward_gold);
			$ore_common = $this->inc_Loot('ore_common', $reward_common);
			$ore_rare = $this->inc_Loot('ore_rare', $reward_rare);
			
			$this->inc_Stat('gatherGold', $gold);
			$this->inc_Stat('gatherCommon', $ore_common);
			$this->inc_Stat('gatherRare', $ore_rare);
			
			return array( "exp" => $exp, "gold" => $gold, "ore_common" => $ore_common, "ore_rare" => $ore_rare );
		}
		
		# GENERAL #
		
		function ID() {
			return $this->id;
		}
		
			function get_ExploreID() {
				$hid = $this->ID();
				
				$result = query("SELECT current_explore FROM heroes WHERE id = '{$hid}'");
				$hero = mysql_fetch_assoc($result);
				return $hero["current_explore"];
			}
			
				function get_DungeonID() {
					$eid = $this->get_ExploreID();
					
					$result = query("SELECT dungeon_id FROM explore WHERE id = '{$eid}'");
					$explore = mysql_fetch_assoc($result);
					return $explore["dungeon_id"];
				}
			
			function get_BattleID() {
				$hid = $this->ID();
				
				$result = query("SELECT current_battle FROM heroes WHERE id = '{$hid}'");
				$hero = mysql_fetch_assoc($result);
				return $hero["current_battle"];
			}
		
		function Name() {
			return $this->name;
		}
		
		function Level() {
			return $this->level;
		}
		
		function Job() {
			return $this->job;
		}
		
		function Gender() {
			return $this->gender;
		}
		
		function Pronoun() {
			return $this->Gender() == "m" ? "his" : "her";
		}
		
		function Emote() {
			switch($percent = $this->Health('percent')) {
				case $percent < 25:
					return "sad";
					break;
				case $percent > 75:
					return "happy";
					break;
				default:
					return "normal";
			}
		}
		
		function Health($method = '') {
			if (empty($method)) { return $this->health; }
			if ($method == 'percent') { return $this->health / $this->get_MaxHealth() * 100; }
		}
					
			function inc_Health($amt, $percent = '') {
				$diff = $this->get_MaxHealth() - $this->Health();
				
				if ($percent) {	$amt = round( percentOf($this->get_MaxHealth(), $amt) ); }

				$amt = min($amt, $diff);
				$this->health += $amt;
				
				return $amt;
			}
			
			function dec_Health($amt, $percent = '') {
				if ($percent) {	$amt = round( percentOf($this->get_MaxHealth(), $amt) ); }
				
				$amt = min($amt, $this->Health());
				$this->health -= $amt;
				
				return $amt;				
			}
			
				function get_MaxHealth($base = '') {
					$h = eq_MaxHealth($this->Level());
					
					if (empty($base)) { $h += percentOf($h, $this->get_EquipBonus('armor', 'minor')); }
					
					return round($h);
				}
				
		function Exp($method = '') {
			if (empty($method)) { return $this->exp; }
			if ($method == 'percent') { return $this->exp / $this->get_MaxExp() * 100; }
		}
			
			function inc_Exp($amt) {
				if ($this->Level() < self::MAX_LEVEL) {
					$amt += round( percentOf($amt, $this->get_EquipBonus('weapon', 'minor')) );
				} else {
					$amt = 0;
				}
				
				$this->exp += $amt;
				
				return $amt;
			}

				function get_MaxExp() {
					$e = eq_MaxExp($this->Level());
					
					return round($e);
				}

				function has_Leveled() {
					$leveled = 0;
					
					while ($this->Exp() >= $this->get_MaxExp()) {
						$this->exp -= $this->get_MaxExp();
						$this->level += 1;
						$this->inc_Loot('vouchers', 1);
						$this->health = $this->get_MaxHealth();
						$leveled++;
					}
					
					return $leveled;
				}
					
		function Power() {
			$p = eq_Stat($this->Level());
			eval("\$p += percentOf(\$p, self::" . strtoupper($this->Job()) . "_POWER_BOOST);");
			return round($p);
		}
		
		function Speed() {
			$s = eq_Stat($this->Level());			
			eval("\$s += percentOf(\$s, self::" . strtoupper($this->Job()) . "_SPEED_BOOST);");
			return round($s);
		}
		
		function Armor() {
			$a = eq_Stat($this->Level());
			eval("\$a += percentOf(\$a, self::" . strtoupper($this->Job()) . "_ARMOR_BOOST);");
			return round($a);
		}
		
		function Score() {
			$score = 0;
			
			# GENERAL #
				$score += ($this->Level() - 1) * self::SCORE_LEVEL;
			
			# INVENTORY #
				$score += ( ($this->Equip('weapon', 'base') - 1) + ($this->Equip('armor', 'base') - 1) + ($this->Equip('trinket', 'base') - 1) ) * self::SCORE_EQUIP_BASE;
				$score += ( $this->Equip('weapon', 'major') + $this->Equip('armor', 'major') + $this->Equip('trinket', 'major') ) * self::SCORE_EQUIP_MAJOR;
				$score += ( $this->Equip('weapon', 'minor') + $this->Equip('armor', 'minor') + $this->Equip('trinket', 'minor') ) * self::SCORE_EQUIP_MINOR;
			
			# EXPLORE #
				$score += ( $this->get_QuestRank(1) - 1 ) * self::SCORE_CELLAR_RANK;
				$score += ( $this->get_QuestRank(2) - 1 ) * self::SCORE_MARSHES_RANK;
				$score += ( $this->get_QuestRank(3) - 1 ) * self::SCORE_LABYRINTH_RANK;
			
			# COMBAT #
				$score += $this->Stat('battleWorthy') * self::SCORE_BATTLE_WORTHY;
				
			return $score;
		}
			
		# ABILITIES #
		
		function Abilities() {
			return array_keys($this->abilities);
		}
		
			function has_Ability($aid) {
				if (array_key_exists($aid, $this->abilities)) {
					return $this->abilities[$aid];
				} else {
					return 0;
				}
			}
			
			function detail_Ability($aid) {
				$ability = query("SELECT * FROM abilities WHERE id = '{$aid}'");
				return mysql_fetch_assoc($ability);
			}
			
		# PERKS #
				
		function Perks() {
			return array_keys($this->perks);
		}
			
			function inc_Perk($pid) {
				$this->perks[$pid]++;
				return 1;
			}
					
				function has_Perk($pid)	{
					if (array_key_exists($pid, $this->perks)) {
						return $this->perks[$pid];
					} else {
						return 0;
					}
				}
				
				function can_IncreasePerk($pid) {
					return $this->perks[$pid] < self::TRAIN_PERK_MAXRANK ? true : false;
				}

				function detail_Perk($pid) {
					$perk = query("SELECT * FROM perks WHERE id = '{$pid}'");
					return mysql_fetch_assoc($perk);
				}
			
		# EQUIP #
		
		function Equip($e, $stat) {
			return $this->equipment[$e][$stat];
		}
		
			function inc_Equip($e, $stat) {
				$this->equipment[$e][$stat]++;
				return 1;
			}

				function detail_Equip($e) {
					$equip = query("SELECT * FROM {$e} WHERE job = '{$this->Job()}' AND rank = '{$this->Equip($e, 'base')}'");
					return mysql_fetch_assoc($equip);
				}
			
				function get_EquipRating($e) {
					switch($e) {
						case "weapon":
							$result = query("SELECT min, max FROM weapon WHERE job = '{$this->Job()}' AND rank = '{$this->Equip('weapon', 'base')}'");
							$w = mysql_fetch_assoc($result);
							$p = $this->Power();
							$b = $this->Equip('weapon', 'major');
							
							$min = $w["min"] + $p + $b;
							$max = $w["max"] + $p + $b;
							
							return array( "min" => $min, "max" => $max );
							break;
							break;
						case "trinket":
							$result = query("SELECT rating FROM trinket WHERE job = '{$this->Job()}' AND rank = '{$this->Equip($e, 'base')}'");
							$s = mysql_fetch_assoc($result);
							$s = $s["rating"];
							$s += $this->Speed();
							$s += $this->Equip($e, 'major');
							
							return $s;
							break;
						case "armor":
							$result = query("SELECT rating FROM armor WHERE job = '{$this->Job()}' AND rank = '{$this->Equip($e, 'base')}'");
							$a = mysql_fetch_assoc($result);
							$a = $a["rating"];
							$a += $this->Armor();
							$a += $this->Equip($e, 'major');
							
							return $a;
					}
				}
				
				function get_EquipBonus($e, $stat) {
					$rank = $this->Equip($e, $stat);
					eval("\$amt = \$rank * self::ENCHANT_" . strtoupper($stat) . "_BOOST;");
					return $amt;
				}
				
				function get_EquipNeed($e) {
					return $this->equipment[$e]["need"];
				}
				
					function dec_EquipNeed($e) {
						$this->equipment[$e]["need"]--;
						return 1;
					}
					
						function reset_EquipNeed($e) {
							$this->equipment[$e]["need"] = self::EQUIP_NEED;
						}
						
				function get_EquipBaseName($e) {
					$details = $this->detail_Equip($e);
					return $details["name"];
				}
		
				function get_EquipBonusName($e, $type) {
					$rank = floor( $this->Equip($e, $type) / self::ENCHANT_WORTH );
					
					$table = $type == "minor" ? "suffixes" : "prefixes";
					
					if ($rank > 0) {
						if ($rank > self::ENCHANT_MAXNAME) { $rank = self::ENCHANT_MAXNAME; }
					
						$result = query("SELECT name FROM $table WHERE equip = '$e' AND rank = '$rank'");
						$fix = mysql_fetch_assoc($result);
						return $fix["name"];
					} else {
						return false;
					}			
				}
				
				function get_EquipRarity($e) {
					$minorBonusRank = $this->Equip($e, 'minor');
					$majorBonusRank = $this->Equip($e, 'major');
					
					$rarity = "equip-common";
					
					if ($minorBonusRank >= self::ENCHANT_WORTH || $majorBonusRank >= self::ENCHANT_WORTH) {
						$rarity = "equip-uncommon";
						if ($minorBonusRank >= (self::ENCHANT_WORTH * 2) || $majorBonusRank >= (self::ENCHANT_WORTH * 2)) {
							$rarity = "equip-rare";
							if ($minorBonusRank >= (self::ENCHANT_WORTH * 3) && $majorBonusRank >= (self::ENCHANT_WORTH * 3)) {
								$rarity = "equip-epic";
								if ($minorBonusRank >= (self::ENCHANT_WORTH * 5) && $majorBonusRank >= (self::ENCHANT_WORTH * 5)) {
									$rarity = "equip-legendary";
								}
							}
						}
					}
					
					return $rarity;
				}
		
		# LOOT #
		
		function Loot($i) {
			return $this->loot[$i];
		}
		
			function inc_Loot($i, $amt) {
				if ($i == "gold") {
					$amt += round( percentOf($amt, $this->get_EquipBonus('trinket', 'minor')) );
				}
				$this->loot[$i] += $amt;
				return $amt;
			}
			
			function dec_Loot($i, $amt) {
				$this->loot[$i] -= $amt;
				return $amt;
			}
			
		# STATS #
		
		function Stat($i) {
			if (!isset($this->stats[$i])) {
				return 0;
			}
			return $this->stats[$i];
		}
		
			function inc_Stat($i, $amt) {
				if (!isset($this->stats[$i])) {
					$this->stats[$i] = 0;
				}
				$this->stats[$i] += $amt;
				return $amt;
			}
			
				function set_Stat($i, $amt) {
					$this->stats[$i] = $amt;
					return $amt;
				}
		
		# SYSTEM #
		
		function __construct() {
			$this->id = 0;
			$this->name = '';
			$this->job = '';
			$this->gender = '';
			
			$this->level = 1;
			$this->health = 0;
			$this->exp = 0;
			
			$this->equipment = array(
				"weapon" => 	array("base" => 1, "major" => 0, "minor" => 0, "need" => self::EQUIP_NEED),
				"armor" => 		array("base" => 1, "major" => 0, "minor" => 0, "need" => self::EQUIP_NEED),
				"trinket" => 	array("base" => 1, "major" => 0, "minor" => 0, "need" => self::EQUIP_NEED)
			);
			
			$this->loot = array(
				"gold" => 		10,
				"vouchers" => 	1,
				"ore_common" =>	5, 
				"ore_rare" => 	0
			);			
			
			$this->abilities = array();
			$this->perks = array();
			
			$this->quest_log = array(
				"1" => array("rank" => 0, "quests" => array()),
				"2" => array("rank" => 0, "quests" => array()),
				"3" => array("rank" => 0, "quests" => array())
			);
			
			$this->stats = array();
		}
		
			function create($hid, $name, $job, $gender) {
				$this->id = $hid;
				$this->name = $name;
				$this->job = $job;
				$this->gender = $gender;
				
				$this->health = $this->get_MaxHealth();
				
				switch($job)
				{
					case "warrior":
						$this->abilities = array(1 => 15, 2 => 15);
						$this->perks = array(1 => 1, 2 => 1, 3 => 1);
						break;
					
					case "rogue":
						$this->abilities = array(3 => 15, 4 => 15);
						$this->perks = array(4 => 1, 5 => 1, 8 => 1);
						break;
					
					case "mage":
						$this->abilities = array(5 => 15, 6 => 15);
						$this->perks = array(6 => 1, 7 => 1, 9 => 1);
						break;
				}
				
				$this->load_Quests(1, 1);
				$this->load_Quests(2, 1);
				$this->load_Quests(3, 1);
				
				$this->inc_Stat('gatherGold', 10);
				$this->inc_Stat('gatherCommon', 5);
			}
				
				function load($hid) {
					$result = query("SELECT json FROM heroes WHERE id = '{$hid}'");
					$loadHero = mysql_fetch_assoc($result);
					$this->from_json($loadHero["json"]);
				}		
				
				function save() {
					$id = $this->ID();
					$level = $this->Level();
					$score = $this->Score();
					$json = $this->to_json();
					
					query("UPDATE heroes SET level = '{$level}', score='{$score}', json='{$json}' WHERE id = '{$id}'");
				}	
					
					function from_json($json) {
						$t = json_decode($json, true);
						
						$this->id = $t["id"];
						$this->name = $t["name"];
						$this->job = $t["job"];
						$this->gender = $t["gender"];
						
						$this->level = $t["level"];
						$this->health = $t["health"];
						$this->exp = $t["exp"];
						
						$this->equipment = $t["equipment"];
						$this->loot = $t["loot"];
						
						$this->abilities = $t["abilities"];
						$this->perks = $t["perks"];
						
						$this->quest_log = $t["quest_log"];
						
						$this->stats = $t["stats"];
					}
			
					function to_json() {
						return json_encode($this);
					}

	}
?>