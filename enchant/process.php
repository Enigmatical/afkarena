<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";

	include "../classes/Hero.php";
	include "../classes/Glance.php";

	$item = $_GET['item'];
	$item = decode($item);
	
	$type = $_GET['type'];
	$type = decode($type);
	
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	$enchant = $hero->Enchant($item, $type);
	
	if ($enchant == false) { header("Location:/lobby/main.php"); } //Couldn't Afford Upgrade!
	
	$hero->save();
	
	$enchant_options = array(
		'weapon' =>		array( "major" => "Power", "minor" => "EXP" ),
		'armor' =>		array( "major" => "Armor", "minor" => "Health" ),
		'trinket' =>	array( "major" => "Speed", "minor" => "Gold" )
	);

	include "../includes/header.php";
?>

<div id="enchant_info" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>&nbsp;</h1>
		<a href="<?php echo $_SERVER["REQUEST_URI"]; ?>" rel="external" data-icon="refresh" class="ui-btn-left" data-theme="a">Again?</a>
		<a href="/lobby/main.php" rel="external" data-icon="arrow-r" class="ui-btn-right" data-theme="e">Lobby</a>
	</div>
	<div data-role="content">
		<div class="top sub">
			<div class="section" style="<?php bg('general/enchant'); ?>">Enchant <?php echo ucfirst($item); ?></div>
			<?php
				/* Shopkeeper Dialogue */
				$dialogues = array (
					"Impressed, hm?",
					"Just needed a bit of polishing!",
					"Admire that craftsmanship!"
				);
				
				$glance = new Glance();
				$glance->shopkeeper("smith", $dialogues[array_rand($dialogues)]);
				
				include "../includes/glance.php";
			?>
				<div class="spacer"></div>
				
				<div class="log dark">
					<div style="<?php bg("general/" . strtolower($enchant_options[$item][$type])); ?>">+<?php echo $enchant["boost"]; ?><?php if($type == "minor") { echo "%"; } ?> <?php echo $enchant_options[$item][$type]; ?></div>
				</div>
		</div>
		<?php
            $equip = new stdClass();
			$equip->type = $item;
		
			include "../includes/equip.php";
		?>
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