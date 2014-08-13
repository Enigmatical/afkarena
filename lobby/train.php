<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";

	include "../classes/Hero.php";
	include "../classes/Glance.php";
	
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	include "../includes/header.php";
?>

<div id="lobby_train" data-role="page">
	<div data-role="header">
		<h1>&nbsp;</h1>
	</div>
	<div data-role="content">
		<div class="top">
			<div class="section" style="<?php bg('general/train'); ?>">Train</div>
			<?php 
				$perks = $hero->Perks();
				
				foreach ($perks as $perk) { 
					$details = $hero->detail_Perk($perk);

					$action = array(
						"id" 		=> 	"train_{$perk}_button",
						"href"		=>	"/train/process.php?pid=" . encode($perk),
						"external"	=>	true,
						"disabled"	=> 	false,
						"name"		=>	"{$details["name"]}<span class=\"size_-1\" style=\"margin-left: 10px;\">Rank</span> <span class=\"size_0\">{$hero->has_Perk($perk)}</span>",
						"desc"		=>	"{$details["description"]}",
						"cost"		=>	"<div class=\"voucher\">1</div>",
						"pic"		=>	"perks/{$perk}"
					);
					
					if ($hero->Loot("vouchers") < 1) { $action["disabled"] = true; }
					if ($hero->has_Perk($perk) >= $_CONFIG["MAX_PERK_RANK"]) { $action["disabled"] = true; }
				
					include "../includes/action_button.php";
				} 
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