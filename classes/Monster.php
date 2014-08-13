<?php
	class Monster {
		
		# CONSTANTS #
		
		const
			
			# HEALTH #
			HEALTH_PORTION =			18,		//Percentage of the Hero's Max Health (At a specific Level)
			HEALTH_VARIATION =			10,		//Percentage of variation between High and Low Health (Applied After)
			
				# TIER #
				TIER1_HEALTH =			0,		//Percentage Boost of Base Health
				TIER2_HEALTH =			5,		//Percentage Boost of Base Health
				TIER3_HEALTH =			5,		//Percentage Boost of Base Health
				TIER4_HEALTH =			10,		//Percentage Boost of Base Health
				TIER5_HEALTH =			10,		//Percentage Boost of Base Health
			
				# TYPE #
				MINION_HEALTH =			0,		//Percentage Boost of Base Health (Minion)
				FIEND_HEALTH =			5,		//Percentage Boost of Base Health (Fiend)
				NOTORIOUS_HEALTH =		5,		//Percentage Boost of Base Health (Notorious)
				TYRANT_HEALTH =			10,		//Percentage Boost of Base Health (Tyrant)
			
				# RANK #
				RANK0_HEALTH =			0,		//Percentage Boost of Base Health (Normal)
				RANK1_HEALTH =			3,		//Percentage Boost of Base Health (Dire)
				RANK2_HEALTH =			6,		//Percentage Boost of Base Health (Vile)
				RANK3_HEALTH =			9,		//Percentage Boost of Base Health (Enraged)
				RANK4_HEALTH =			12,		//Percentage Boost of Base Health (Ancient)
				
			# DAMAGE #
			DAMAGE_PORTION =			6,		//Percentage of the Hero's Max Health (At a specific Level)
			DAMAGE_VARIATION =			10,		//Percentage of variation between High and Low Damage (Applied After)
			
				# TIER #
				TIER1_DAMAGE =			0,		//Percentage Boost of Base Damage
				TIER2_DAMAGE =			5,		//Percentage Boost of Base Damage
				TIER3_DAMAGE =			5,		//Percentage Boost of Base Damage
				TIER4_DAMAGE =			10,		//Percentage Boost of Base Damage
				TIER5_DAMAGE =			10,		//Percentage Boost of Base Damage
			
				# TYPE #
				MINION_DAMAGE =			0,		//Percentage Boost of Base Damage (Minion)
				FIEND_DAMAGE =			5,		//Percentage Boost of Base Damage (Fiend)
				NOTORIOUS_DAMAGE =		5,		//Percentage Boost of Base Damage (Notorious)
				TYRANT_DAMAGE =			10,		//Percentage Boost of Base Damage (Tyrant)
				
			
				# RANK #
				RANK0_DAMAGE =			0,		//Percentage Boost of Base Damage (Normal)
				RANK1_DAMAGE =			5,		//Percentage Boost of Base Damage (Dire)
				RANK2_DAMAGE =			10,		//Percentage Boost of Base Damage (Vile)
				RANK3_DAMAGE =			15,		//Percentage Boost of Base Damage (Enraged)
				RANK4_DAMAGE =			20,		//Percentage Boost of Base Damage (Ancient)
				
			# LOOT #
			GOLD_PORTION =				15,		//Percentage of Max Damage used as Gold
			ORE_PER_LEVEL =				5,		//One Common Ore for Every # Levels (Chance to Drop)
			RANK_TYPE_EXP =				5,		//Multiplier (Rank + Type * #)% Exp Increase
			
				# EXP REWARD #
				MINION_EXP =			0,		//Additional Exp % Reward
				FIEND_EXP =				10,		//Additional Exp % Reward
				NOTORIOUS_EXP =			20,		//Additional Exp % Reward
				TYRANT_EXP =			30,		//Additional Exp % Reward					
			
				# COMMON ORE CHANCE #
				MINION_ORE =			10,		//Chance to Find Some Ore!
				FIEND_ORE =				20,		//Chance to Find Some Ore!
				NOTORIOUS_ORE =			30,		//Chance to Find Some Ore!
				TYRANT_ORE =			40,		//Chance to Find Some Ore!				
				
				# RARE ORE CHANCE #
				MINION_RARE =			0,		//Chance to Find Some Ore!
				FIEND_RARE =			0,		//Chance to Find Some Ore!
				NOTORIOUS_RARE =		1,		//Chance to Find Some Ore!
				TYRANT_RARE =			3;		//Chance to Find Some Ore!
				
		
		# VARIABLES #
		
		public
			
			# GENERAL #
			$id,								//Monster's ID
			$name,								//Monster's Name
			$pic,								//Monster's Picture
			
			# SPECIFICS #
			$tier,								//Monster's Challenge Tier
			$type,								//Monster's Type (Minion, Fiend, Tyrant, Notorious)
			$rank,								//Monster's Rank (Normal, Dire, Vile, Enraged, Ancient)
			
			# VITALS #
			$level,								//Monster's Level
			$max_health,							//Monster's Max Health
			$health,							//Monster's Health
			
			# DAMAGE #
			$min_damage,						//Monster's Lower Damage Number
			$max_damage,						//Monster's Higher Damage Number
			
			# ABILITIES #
			$abilities,							//Monster's Abilities
			
			# REWARDS #
			$exp,								//Monster's EXP Worth
			$loot,								//Monster's Loot Rewards
			$drops;								//Monster's Quest Drops

		
		# GENERAL #
		
		function ID() {
			return $this->id;
		}
		
		function Name() {
			return $this->name;
		}
		
			function get_FullName() {
				$rank_names = array("", "Dire ", "Vile ", "Enraged ", "Ancient ");
				return $rank_names[$this->rank] . $this->name;
			}
		
		function Pronoun() {
			return "its";
		}		
		
		function Tier() {
			return $this->tier;
		}
		
		function Type() {
			return $this->type;
		}
		
		function Rank() {
			return $this->rank;
		}		
		
		function Level() {
			return $this->level;
		}
		
		function Health($method = '') {
			if (empty($method)) { return $this->health; }
			if ($method == 'percent') { return round( ($this->health / $this->MaxHealth()) * 100 ); }
		}
		
		function MaxHealth() {
			return $this->max_health;
		}		
			
			function inc_Health($amt, $percent = '') {
				$diff = $this->get_MaxHealth() - $this->Health();
				
				if ($percent) {	$amt = round( percentOf($this->MaxHealth(), $amt) ); }

				$amt = min($amt, $diff);
				$this->health += $amt;
				
				return $amt;
			}
			
			function dec_Health($amt, $percent = '') {
				if ($percent) {	$amt = round( percentOf($this->MaxHealth(), $amt) ); }
				
				$amt = min($amt, $this->Health());
				$this->health -= $amt;
				
				return $amt;				
			}
				
				function set_MaxHealth() {
					$portion = (self::HEALTH_PORTION);
					eval("\$portion += self::" . strtoupper($this->Type()) . "_HEALTH;");
					eval("\$portion += self::TIER" . $this->Tier() . "_HEALTH;");
					eval("\$portion += self::RANK" . $this->Rank() . "_HEALTH;");
					
					$high = round( percentOf(eq_MaxHealth($this->Level()), $portion) + $this->Level() );
					$low = round( percentOf(eq_MaxHealth($this->Level()), $portion) + $this->Level() );
					
					$high += percentOf($high, self::HEALTH_VARIATION);
					$low -= percentOf($low, self::HEALTH_VARIATION);
					
					$h = rand( round($high), round($low));
					
					$h = max(1, $h);
					
					$this->health = $h;
					$this->max_health = $h;
				}
				
		function Damage() {
			return rand($this->min_damage, $this->max_damage);
		}
		
			function set_Damage() {
				$portion = (self::DAMAGE_PORTION);
				eval("\$portion += self::" . strtoupper($this->Type()) . "_DAMAGE;");
				eval("\$portion += self::TIER" . $this->Tier() . "_DAMAGE;");
				eval("\$portion += self::RANK" . $this->Rank() . "_DAMAGE;");
				
				$high = percentOf(eq_MaxHealth($this->Level()), $portion) + $this->Level();
				$low = percentOf(eq_MaxHealth($this->Level()), $portion) + $this->Level();
				
				$high += percentOf($high, self::DAMAGE_VARIATION);
				$low -= percentOf($low, self::DAMAGE_VARIATION);

				$this->max_damage = max(1, round($high));
				$this->min_damage = max(1, round($low));
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
			
			function set_Abilities() {
				$abilities = query("SELECT ability_id, chance FROM monsterabilities WHERE monster_id = '{$this->ID()}'");
				
				if (mysql_num_rows($abilities) > 0) {
					while($ability = mysql_fetch_assoc($abilities)) {
						$this->abilities[$ability["ability_id"]] = $ability["chance"];
					}
				}
			}
			
		# LOOT #
		
		function Loot($i) {
			return $this->loot[$i];
		}
		
			function set_Exp() {
				$base = eq_MonsterExp($this->Level());
				
				eval("\$type_boost = self::" . strtoupper($this->Type()) . "_EXP;");
				
				$base += percentOf( $base, ( ($this->Rank() + $this->Tier()) * self::RANK_TYPE_EXP ) );
				$base += percentOf( $base, $type_boost );
				
				$this->exp = round( $base );
			}
		
			function set_Loot() {
				$this->loot["gold"] = round( percentOf($this->max_damage, self::GOLD_PORTION) );
				
				$ore_rolls = floor( $this->Level() / self::ORE_PER_LEVEL );
				$ore_rolls += $this->Tier();
				$ore_rolls += $this->Rank();
				
				eval("\$common_chance = self::" . strtoupper($this->Type()) . "_ORE;");
				eval("\$rare_chance = self::" . strtoupper($this->Type()) . "_RARE;");
				
				for($o = 0; $o < $ore_rolls; $o++) {
					if (chance($rare_chance)) { $this->loot["ore_rare"]++; }
					else if (chance($common_chance)) { $this->loot["ore_common"]++; }
				}
			}
			
			function set_Drops() {
				$drops = query("SELECT drop_id, chance FROM monsterdrops WHERE monster_id = '{$this->ID()}'");
				
				if (mysql_num_rows($drops) > 0) {
					while($drop = mysql_fetch_assoc($drops)) {
						if(chance($drop["chance"])) {
							array_push($this->drops, $drop["drop_id"]);
						}
					}
				}
			}
	
		# SYSTEM #
		
		function __construct() {
			$this->id = 0;
			$this->name = "";
			$this->pic = "";
			
			$this->tier = 0;
			$this->type = "";
			$this->rank = 0;
			
			$this->level = 0;
			$this->max_health = 0;
			$this->health = 0;
			
			$this->min_damage = 0;
			$this->max_damage = 0;
			
			$this->abilities = array();
			
			$this->exp = 0;
			$this->loot = array( "gold" => 0, "ore_common" => 0, "ore_rare" => 0 );
			$this->drops = array();
		}
		
			function random($level, $tier, $type, $rank) {
				$randomMonster = query("SELECT id, name, tier, pic FROM monsters WHERE variant = 'normal' AND tier = '{$tier}' ORDER BY RAND() LIMIT 1");
				
				$monster = mysql_fetch_assoc($randomMonster);
				
				$this->id = $monster["id"];
				$this->name = $monster["name"];
				$this->pic = $monster["pic"];
				
				$this->tier = $monster["tier"];
				$this->type = $type;
				$this->rank = $rank;
				
				$this->level = $level;
				
				$this->set_MaxHealth();
				$this->set_Damage();
				$this->set_Abilities();
				$this->set_Exp();
				$this->set_Loot();
				$this->set_Drops();
			}
			
			function specific($mid, $level, $type) {
				$specificMonster = query("SELECT id, name, tier, pic FROM monsters WHERE id = '{$mid}'");
				
				$monster = mysql_fetch_assoc($specificMonster);
				
				$this->id = $monster["id"];
				$this->name = $monster["name"];
				$this->pic = $monster["pic"];
				
				$this->tier = $monster["tier"];
				$this->type = $type;
				$this->rank = 1;
				
				$this->level = $level;
				
				$this->set_MaxHealth();
				$this->set_Damage();
				$this->set_Abilities();
				$this->set_Exp();
				$this->set_Loot();
				$this->set_Drops();		
			}
		
				function load($bid) {
					$battle = query("SELECT monster FROM battle WHERE id = '{$bid}'");
					$monster = mysql_fetch_assoc($battle);
					
					$this->from_json($monster["monster"]);
				}
				
					function from_json($json)
					{
						$t = json_decode($json, true);
						
						$this->id = $t["id"];
						$this->name = $t["name"];
						$this->pic = $t["pic"];
						
						$this->tier = $t["tier"];
						$this->type = $t["type"];
						$this->rank = $t["rank"];
						
						$this->level = $t["level"];
						$this->max_health = $t["max_health"];
						$this->health = $t["health"];
						
						$this->min_damage = $t["min_damage"];
						$this->max_damage = $t["max_damage"];
						
						$this->abilities = $t["abilities"];
						
						$this->exp = $t["exp"];
						$this->loot = $t["loot"];
						$this->drops = $t["drops"];
					}
					
					function to_json()
					{
						return json_encode($this);
					}
	}
?>