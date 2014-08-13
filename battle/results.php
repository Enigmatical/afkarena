<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	include "../classes/Glance.php";
	
	$type = $_GET['type'];
	
	if ($type == "victory")
	{
		header("Location:/explore/dungeon.php");
		exit;
	}
	
	if (isset($_GET["tolobby"]))
	{
		$tolobby = $_GET["tolobby"];
	} else {
		$tolobby = false;
	}
	
	$PreHero = new Hero();
	$PreHero->load($_SESSION["hero_id"]);
	
	$PreHero->level -= 1;
	
	$PostHero = new Hero();
	$PostHero->load($_SESSION["hero_id"]);
	
	include "../includes/header.php";
?>

<div id="battle_levelup" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>&nbsp;</h1>
		<?php if ($tolobby) { ?>
			<a id="continueButton" href="/lobby/main.php" rel="external" data-icon="arrow-r" data-theme="e" class="ui-btn-right" data-role="button">Lobby</a>
		<?php } else { ?>
			<a id="continueButton" href="/explore/dungeon.php" rel="external" data-icon="arrow-r" data-theme="b" class="ui-btn-right" data-role="button">Continue</a>		
		<?php } ?>
	</div>
	<div data-role="content" style="background-color: #fdf294;">
		<div class="top">
			<div class="section" style="<?php bg('general/level_up'); ?>">Level Up</div>
			<div class="log_header" style="<?php bg('general/exp'); ?>">Level <span style="font-size: 25px;"><?php echo $PostHero->Level(); ?></span> <?php echo ucfirst($PostHero->Job()); ?></div>
			<div class="log dark">
				<div style="<?php bg('battle/icon-health'); ?>">+<?php echo $PostHero->get_MaxHealth() - $PreHero->get_MaxHealth(); ?> Max Health <span class="size_-1">(<?php echo $PostHero->get_MaxHealth(); ?>)</span></div>
				<?php if ($PostHero->Power() > $PreHero->Power()) { ?>
					<div style="<?php bg('battle/icon-power'); ?>">+<?php echo $PostHero->Power() - $PreHero->Power(); ?> Power <span class="size_-1">(<?php echo $PostHero->Power(); ?>)</span></div>
				<?php } ?>
				<?php if ($PostHero->Speed() > $PreHero->Speed()) { ?>
					<div style="<?php bg('battle/icon-speed'); ?>">+<?php echo $PostHero->Speed() - $PreHero->Speed(); ?> Speed <span class="size_-1">(<?php echo $PostHero->Speed(); ?>)</span></div>
				<?php } ?>
				<?php if ($PostHero->Armor() > $PreHero->Armor()) { ?>
					<div style="<?php bg('battle/icon-armor'); ?>">+<?php echo $PostHero->Armor() - $PreHero->Armor(); ?> Armor <span class="size_-1">(<?php echo $PostHero->Armor(); ?>)</span></div>
				<?php } ?>
				<div style="<?php bg('spoils/voucher'); ?>">+1 Training Voucher</div>
			</div>
		</div>
		<?php
			$glance = new Glance();
			$glance->hero($PostHero);
			
			$hero = $PostHero;
			
			include "../includes/glance.php";
		?>
	</div>
	<div data-role="footer">
	</div>
</div>