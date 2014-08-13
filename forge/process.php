<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";

	include "../classes/Hero.php";
	include "../classes/Glance.php";

	$item = $_GET['item'];
	$item = decode($item);
	
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	$forge = $hero->forge($item);
	
	if ($forge == false) { header("Location:/lobby/main.php"); }
	
	$hero->save();
	
	$forge_options = array(
		'weapon' =>		'power',
		'armor' =>		'armor',
		'trinket' =>	'speed'
	);

	include "../includes/header.php";
?>

<div id="enchant_info" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>&nbsp;</h1>
		<a href="/lobby/main.php" rel="external" data-icon="arrow-r" class="ui-btn-right" data-theme="e">Lobby</a>
	</div>
	<div data-role="content">
		<div class="top">
			<div class="section" style="<?php bg('general/forge'); ?>">Forge <?php echo ucfirst($item); ?></div>
			<?php
				/* Shopkeeper Dialogue */
				$dialogues = array (
					"More Power, Har-har-har!",
					"Now that's what I'm talking about!",
					"Aye, she's a beaut', ain't she?"
				);
				
				$glance = new Glance();
				$glance->shopkeeper("smith", $dialogues[array_rand($dialogues)]);
				
				include "../includes/glance.php";
			?>
			<div class="spacer"></div>
			<?php
                $equip = new stdClass();
				$equip->type = $item;
				$equip->link->type = "";
				$equip->link->href = "";
			
				include "../includes/equip.php";
			?>			
		</div>

		<?php
			$glance = new Glance();
			$glance->general($hero);
			$glance->id = "enchant";
			
			include "../includes/glance.php";
		?>
	</div>
	<div data-role="footer">
	</div>
</div>