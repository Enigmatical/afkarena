<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";

	include "../classes/Hero.php";
	include "../classes/Glance.php";

	$type = $_GET['type'];	
	$type = decode($type);
	
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	if ($hero->Health('percent') == 100) { header("Location:/lobby/main.php"); }
	
	$before_Perc = $hero->Health('percent');
	$mend = $hero->mend($type);
	$after_Perc = $hero->Health('percent');
	
	$hero->save();

	include "../includes/header.php";
?>

<div id="mend_info" data-role="page">
	<div data-role="header" data-nobacktn="true">
		<h1>&nbsp;</h1>
		<a href="<?php echo $_SERVER["REQUEST_URI"]; ?>" rel="external" data-icon="refresh" class="ui-btn-left" data-theme="a">Again?</a>
		<a href="/lobby/main.php" rel="external" data-icon="arrow-r" class="ui-btn-right" data-theme="e">Lobby</a>
	</div>
	<div data-role="content">
		<div class="top">
			<div class="section" style="<?php bg('general/mend'); ?>">Mend <?php echo ucfirst($type); ?></div>			
			<?php
				/* Shopkeeper Dialogue */
				$dialogues = array (
					"See, looking better all ready!",
					"There you are, all patched up!",
					"I'll have you back up in a jiffy!"
				);		
			
				$glance = new Glance();
				$glance->shopkeeper("nurse", $dialogues[array_rand($dialogues)]);
				
				include "../includes/glance.php";
			?>
			<div class="spacer"></div>
			<div class="log dark">
				<div style="<?php bg('battle/icon-health'); ?>">+<?php echo $mend["boost"]; ?> Health</div>
			</div>
		</div>

		<?php
			$glance = new Glance();
			$glance->general($hero);
			$glance->id = "mend";
			$glance->bars->health->stop = $before_Perc;
			
			include "../includes/glance.php";
		?>
	</div>
	<div data-role="footer">
	</div>
	
	<script type="text/javascript">
		$('#mend_info').bind('pageshow', function() {
			$('#hero_healthbar').find('div.fill').animate({ width: '<?php echo $after_Perc; ?>%' });
		<?php if ($type == 'major') { ?>
			floatingCombat('#mend_info', 'hero', '+<?php echo $mend["boost"]; ?>', 'heal crit');
		<?php } else { ?>
			floatingCombat('#mend_info', 'hero', '+<?php echo $mend["boost"]; ?>', 'heal');
		<?php } ?>
		});
	</script>
</div>