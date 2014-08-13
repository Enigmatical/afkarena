<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";

	include "../classes/Hero.php";
	include "../classes/Glance.php";
		
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);

    $equip = new stdClass();

	include "../includes/header.php";
?>

<div id="lobby_forge" data-role="page">
	<div data-role="header">
		<h1>&nbsp;</h1>
	</div>
	<div data-role="content">
		<div class="top">
			<div class="section" style="<?php bg('general/forge'); ?>">Forge</div>
			<h3>Weapon</h3>
				<?php
					$equip->type = "weapon";

                    $equip->link = new stdClass();
					$equip->link->type = "";
					$equip->link->href = "/lobby/forge_options.php?type=weapon";
	
					include "../includes/equip.php";
				?>
			<h3>Armor</h3>
				<?php
					$equip->type = "armor";

                    $equip->link = new stdClass();
					$equip->link->type = "";
					$equip->link->href = "/lobby/forge_options.php?type=armor";
	
					include "../includes/equip.php";
				?>
			<h3>Trinket</h3>
				<?php
					$equip->type = "trinket";

                    $equip->link = new stdClass();
					$equip->link->type = "";
					$equip->link->href = "/lobby/forge_options.php?type=trinket";
	
					include "../includes/equip.php";
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