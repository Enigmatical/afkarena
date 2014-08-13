<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	include "../classes/Glance.php";
	
	$eid = $_GET["eid"];
	
	$quest = "";
	if (isset($_GET["quest"])) {
		$quest = $_GET["quest"];
	}
	
	$leveled = "";
	if (isset($_GET["leveled"])) {
		$leveled = $_GET["leveled"];
	}

	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	$explore = $hero->detail_Explore($eid);

	include "../includes/header.php";
?>

<div id="explore_results" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>&nbsp;</h1>
		<?php if ($leveled == 1) { ?>
			<a id="levelUpButton" href="/battle/results.php?tolobby=1" data-icon="arrow-r" data-theme="e" class="ui-btn-right" data-role="button">Level Up</a>
		<?php } else { ?>
			<a id="continueButton" href="/lobby/main.php" rel="external" data-icon="arrow-r" data-theme="e" class="ui-btn-right" data-role="button">Lobby</a>
		<?php } ?>
	</div>
	<div data-role="content" style="<?php bg("dungeons/dungeon_{$explore['dungeon_id']}-{$explore['streak']}"); ?> background-color: black; background-position: top center; background-repeat: no-repeat; overflow: hidden;">
		<div class="top">
			<?php if ($explore["status"] == "escape") { ?>
				<div class="section white" style="<?php bg("general/hero_wins"); ?>">Escaped!</div>
				<?php if ($explore["loot_gold"] > 0 || $explore["loot_common"] > 0 || $explore["loot_rare"] > 0) { ?>
					<div class="log_header white" style="<?php bg("general/spoils"); ?>">Loot Recovered</div>
				<?php } ?>
			<?php } else if ($explore["status"] == "defeat") { ?>
				<div class="section white" style="<?php bg("general/monster_wins"); ?>">Defeated...</div>
				<?php if ($explore["loot_gold"] > 0 || $explore["loot_common"] > 0 || $explore["loot_rare"] > 0) { ?>
					<div class="log_header white" style="<?php bg("general/spoils"); ?>">Loot Salvaged</div>
				<?php } ?>			
			<?php } ?>
			<div class="log">
				<?php if ($explore["loot_gold"]) { ?>
					<div class="white" style="<?php bg("spoils/gold"); ?>">+<?php echo $explore["loot_gold"]; ?> Gold</div>
				<?php } ?>
				<?php if ($explore["loot_common"]) { ?>
					<div class="white" style="<?php bg("spoils/iron"); ?>">+<?php echo $explore["loot_common"]; ?> Iron Ore</div>
				<?php } ?>
				<?php if ($explore["loot_rare"]) { ?>
					<div class="white" style="<?php bg("spoils/cobalt"); ?>">+<?php echo $explore["loot_rare"]; ?> Cobalt Ore</div>
				<?php } ?>
			</div>
			
			<?php 
				if ($quest)
				{
			?>
					<div class="log_header white" style="<?php bg("quests/depth-1"); ?>">Depth Complete!</div>
					<div class="log">
						<div class="white" style="<?php bg("general/exp"); ?>">+<?php echo $_GET["qexp"]; ?> EXP</div>
						<div class="white" style="<?php bg("spoils/gold"); ?>">+<?php echo $_GET["qgold"]; ?> Gold</div>
						<div class="white" style="<?php bg("spoils/iron"); ?>">+<?php echo $_GET["qiron"]; ?> Iron Ore</div>
						<div class="white" style="<?php bg("spoils/cobalt"); ?>">+<?php echo $_GET["qcobalt"]; ?> Cobalt Ore</div>
					</div>
			<?php 
				} 
			?>
		</div>
		<?php
			$glance = new Glance();
			$glance->general($hero);
			
			if ($explore["status"] == "escape")
			{
				$glance->emote = "happy";
			} else if ($explore["status"] == "defeat") {
				$glance->emote = "sad";
			}

			include "../includes/glance.php";
		?>
	</div>
	<div data-role="footer">
	</div>
</div>