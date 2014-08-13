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

<div id="lobby_mend" data-role="page">
	<div data-role="header">
		<h1>&nbsp;</h1>
	</div>
	<div data-role="content">
		<div class="top">
			<div class="section" style="<?php bg('general/mend'); ?>">Mend</div>
			
			<?php
				$action = array(
					"id" 		=> 	"mend_minor_button",
					"href"		=>	"/mend/process.php?type=" . encode('minor'),
					"external"	=>	true,
					"disabled"	=> 	false,
					"name"		=>	"Minor",
					"desc"		=>	"Restores some lost Health",
					"cost"		=>	"<div class=\"gold\">{$hero->cost_Mend("minor")}</div>",
					"pic"		=>	"general/minor"
				);
				
				if ($hero->Loot("gold") < $hero->cost_Mend("minor") || $hero->Health('percent') == 100) { $action["disabled"] = true; }
			
				include "../includes/action_button.php";

				$action = array(
					"id" 		=> 	"mend_major_button",
					"href"		=>	"/mend/process.php?type=" . encode('major'),
					"external"	=>	true,
					"disabled"	=> 	false,
					"name"		=>	"Major",
					"desc"		=>	"Completely restores lost Health",
					"cost"		=>	"<div class=\"gold\">{$hero->cost_Mend("major")}</div>",
					"pic"		=>	"general/major"
				);
				
				if ($hero->Loot("gold") < $hero->cost_Mend("major") || $hero->Health('percent') == 100) { $action["disabled"] = true; }
			
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