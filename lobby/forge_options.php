<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";

	include "../classes/Hero.php";
	include "../classes/Glance.php";
	
	$type = $_GET["type"];
		
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	$forge_options = array(
		'weapon' => 	array( "forge" => "Power", "major" => "Power", "minor" => "EXP" ),
		'armor' =>		array( "forge" => "Armor", "major" => "Armor", "minor" => "Health" ),
		'trinket' =>	array( "forge" => "Speed", "major" => "Speed", "minor" => "Gold" ) 
	);
	
	include "../includes/header.php";
?>	

<div id="lobby_forgeOptions" data-role="page">
	<div data-role="header">
		<h1>&nbsp;</h1>
	</div>
	<div data-role="content">
		<div class="top">
			<div class="section" style="<?php bg('general/forge'); ?>">Forge <?php echo ucfirst($type); ?></div>
			<?php 
				if ($hero->can_IncreaseEquip($type)) { 			
				
					echo "<h3>Forge</h3>";

					if ($hero->get_EquipNeed($type) == 0) {
						$nextEquip = $hero->detail_NextForge($type);
					
						$action = array(
							"id" 		=> 	"forge_new_button",
							"href"		=>	"/forge/process.php?item=" . encode($type),
							"external"	=>	true,
							"disabled"	=> 	false,
							"name"		=>	"New " . ucfirst($type),
							"desc"		=>	"Dramatically boosts {$forge_options[$type]["forge"]}",
							"cost"		=>	"<div class=\"gold\">{$hero->cost_Forge($type, 'forge')}</div>",
							"pic"		=>	"{$nextEquip["pic"]}"
						);		

						if ($hero->Loot("gold") < $hero->cost_Forge($type, 'forge')) { $action["disabled"] = true; }
					} else {
						$action = array(
							"id" 		=> 	"forge_new_button",
							"href"		=>	"",
							"external"	=>	false,
							"disabled"	=> 	true,
							"name"		=>	"New " . ucfirst($type),
							"desc"		=>	"Available after {$hero->get_EquipNeed($type)} more Enchantments",
							"cost"		=>	"",
							"pic"		=>	"$type/{$hero->Job()}-question"
						);					
					}
					
					include "../includes/action_button.php";
				} 
			?>
			
			<h3>Enchant</h3>
			
			<?php 
				if ($hero->get_EquipNeed($type) == 0 && $hero->can_IncreaseEquip($type)) {
					$action = array(
						"id" 		=> 	"minor_enchant_button",
						"href"		=>	"",
						"external"	=>	false,
						"disabled"	=> 	true,
						"name"		=>	"Enchant {$forge_options[$type]["minor"]}",
						"desc"		=>	"Available after forging New " . ucfirst($type),
						"cost"		=>	"",
						"pic"		=>	strtolower("general/{$forge_options[$type]["minor"]}")
					);					
				} else {
					$action = array(
						"id" 		=> 	"minor_enchant_button",
						"href"		=>	"/enchant/process.php?item=" . encode($type) . "&type=" . encode('minor'),
						"external"	=>	true,
						"disabled"	=> 	false,
						"name"		=>	"Enchant {$forge_options[$type]["minor"]}",
						"desc"		=>	"Boosts {$forge_options[$type]["minor"]}",
						"cost"		=>	"<div class=\"ore_common\">{$hero->cost_Forge($type, 'minor')}</div>",
						"pic"		=>	strtolower("general/{$forge_options[$type]["minor"]}")
					);

					if ($hero->Loot('ore_common') < $hero->cost_Forge($type, 'minor')) { $action["disabled"] = true; }
				}
				
				include "../includes/action_button.php";

				if ($hero->get_EquipNeed($type) == 0 && $hero->can_IncreaseEquip($type)) {
					$action = array(
						"id" 		=> 	"major_enchant_button",
						"href"		=>	"",
						"external"	=>	false,
						"disabled"	=> 	true,
						"name"		=>	"Enchant {$forge_options[$type]["major"]}",
						"desc"		=>	"Available after forging New " . ucfirst($type),
						"cost"		=>	"",
						"pic"		=>	strtolower("general/{$forge_options[$type]["major"]}")
					);					
				} else {
					$action = array(
						"id" 		=> 	"major_enchant_button",
						"href"		=>	"/enchant/process.php?item=" . encode($type) . "&type=" . encode('major'),
						"external"	=>	true,
						"disabled"	=> 	false,
						"name"		=>	"Enchant {$forge_options[$type]["major"]}",
						"desc"		=>	"Boosts {$forge_options[$type]["major"]}",
						"cost"		=>	"<div class=\"ore_rare\">{$hero->cost_Forge($type, 'major')}</div>",
						"pic"		=>	strtolower("general/{$forge_options[$type]["major"]}")
					);	

					if ($hero->Loot('ore_rare') < $hero->cost_Forge($type, 'major')) { $action["disabled"] = true; }
				}
				
				include "../includes/action_button.php";
			?>
		</div>
		<?php
			$glance = new Glance();
			$glance->general($hero);
			
			include "../includes/glance.php";
		?>
	</div>
	<div data-role="footer">
	</div>
</div>