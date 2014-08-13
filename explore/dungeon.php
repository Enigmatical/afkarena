<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	include "../classes/Glance.php";

	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	if (!$hero->get_ExploreID()) { header("Location:/lobby/main.php"); }
	
	$explore = $hero->detail_Explore();
	
	$dungeon_name = array( 1 => "The Cellar", 2 => "The Marshes", 3 => "The Labyrinth" );
	
	$hero->save();
	
	include "../includes/header.php";
?>

<div id="dungeon_info" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>&nbsp;</h1>
	</div>
	<div data-role="content" style="<?php bg("dungeons/dungeon_{$explore['dungeon_id']}-{$explore['streak']}"); ?> background-position: top center; background-repeat: no-repeat; background-color: black;">
		<div class="top" style="height: 185px;">
			<div class="section white" style="<?php bg('general/explore'); ?>"><?php echo $dungeon_name[$explore['dungeon_id']]; ?>&nbsp;&nbsp;<span class="size_-1">FLOOR <?php echo $explore['floor']; ?></span></div>
			<div class="dungeon_floor">
				<?php if ($explore["event_category"] != "streak" && $explore["event_category"] != "") { ?>
					<div class="type" style="<?php bg("dungeons/{$explore['event_category']}_{$explore['event_specific']}"); ?>"></div>
				<?php } else { ?>
					<div class="type"></div>
				<?php } ?>
				<div class="size_2 bold center"><?php echo ucfirst($explore["event_category"]); ?></div>
				
				<?php if ($explore["event_category"] == "battle") { ?>
					<?php if ($explore["event_specific"] == "notorious") { ?>
						<div class="size_0 center"><?php echo $hero->Name(); ?> encounters a <span class="bold">Notorious Monster</span>!</div>
					<?php } else { ?>
						<div class="size_0 center"><?php echo $hero->Name(); ?> encounters a <span class="bold"><?php echo strtoupper($explore["event_specific"]); ?></span>!</div>					
					<?php } ?>
				<?php } ?>
				
				<?php if ($explore["event_category"] == "treasure") { ?>
					<?php if ($explore["event_specific"] == "gold") { ?>
						<div class="size_0 center"><?php echo $hero->Name(); ?> finds <span class="bold"><?php echo $explore["event_details"]; ?> GOLD</span>!</div>
					<?php } ?>
					<?php if ($explore["event_specific"] == "common") { ?>
						<div class="size_0 center"><?php echo $hero->Name(); ?> finds <span class="bold"><?php echo $explore["event_details"]; ?> IRON ORE</span>!</div>
					<?php } ?>
					<?php if ($explore["event_specific"] == "health") { ?>
						<div class="size_0 center"><?php echo $hero->Name(); ?> recovers <span class="bold"><?php echo $explore["event_details"]; ?> HEALTH</span>!</div>
					<?php } ?>
					<?php if ($explore["event_specific"] == "rare") { ?>
						<div class="size_0 center"><?php echo $hero->Name(); ?> finds <span class="bold"><?php echo $explore["event_details"]; ?> COBALT ORE</span>!</div>
					<?php } ?>
				<?php } ?>
				
				<?php if ($explore["event_category"] == "trap") { ?>
					<?php if ($explore["event_details"] <= 0) { ?>
							<div class="size_0 center"><?php echo $hero->Name(); ?> swifly dodges the ambush!</div>
					<?php } else { ?>
							<div class="size_0 center"><?php echo $hero->Name(); ?> takes <span class="bold"><?php echo $explore["event_details"]; ?> DAMAGE</span>!</div>
					<?php } ?>
				<?php } ?>
				
				<?php if ($explore["event_category"] == "streak") { ?>
					<div class="size_0 center"><?php echo $hero->Name(); ?> has entered a <span class="bold"><?php echo strtoupper($explore["event_specific"]); ?> STREAK</span>!</div>
				<?php } ?>
				
			</div>
		</div>
		<div class="dungeon_spoils" style="color: white; text-shadow: 1px 1px #000;" class="size_-1 bold">
			LOOT GATHERED
			<?php if ($explore['loot_rare'] > 0) { ?>
				<div class="spoil size_0 bold" style="<?php bg("spoils/cobalt"); ?>">+<?php echo $explore['loot_rare']; ?></div>
			<?php } ?>
			<?php if ($explore['loot_common'] > 0) { ?>
				<div class="spoil size_0 bold" style="<?php bg("spoils/iron"); ?>">+<?php echo $explore['loot_common']; ?></div>
			<?php } ?>
			<div class="spoil size_0 bold" style="<?php bg("spoils/gold"); ?>">+<?php echo $explore['loot_gold']; ?></div>
		</div>
		<div class="dungeon_actions">
			<?php if ($explore["event_category"] == "battle") { ?>
				<a href="/battle/begin.php" rel="external" class="action small" data-role="button" style="<?php bg("general/confront"); ?>">
					<div class="label">Confront</div>
				</a>
			<?php } else { ?>
				<a href="/explore/travel.php?type=<?php echo encode('advance'); ?>" rel="external" class="action small" data-role="button" style="<?php bg("general/advance"); ?>">
					<div class="label">Advance</div>
				</a>
				<a href="/explore/travel.php?type=<?php echo encode('retreat'); ?>" rel="external" class="action small" data-role="button" style="<?php bg("general/retreat"); ?>">
					<?php if ($explore["floor"] > $_CONFIG["EXPLORE_RETREAT_STEP"]) { ?>
						<div class="label">Retreat</div>
					<?php } else { ?>
						<div class="label">Escape</div>
					<?php } ?>
				</a>
			<?php } ?>
		</div>
		<?php
			$glance = new Glance();
			$glance->general($hero);
			$glance->id = "dungeon";
			
			include "../includes/glance.php";
		?>
	</div>
	<div data-role="footer">
		<div class="footer-right">
			<?php $questStatus = $hero->get_QuestRankStatus(); ?>
			<?php if ($hero->get_QuestRankComplete()) { ?>
				<a href="/explore/quests.php" data-rel="dialog" data-transition="slideup" data-role="button" data-icon="star" data-theme="e">Quests (<?php echo $questStatus['complete']; ?>/<?php echo $questStatus['overall']; ?>)</a>				
			<?php } else { ?>
				<a href="/explore/quests.php" data-rel="dialog" data-transition="slideup" data-role="button" data-icon="star">Quests (<?php echo $questStatus['complete']; ?>/<?php echo $questStatus['overall']; ?>)</a>
			<?php } ?>
		</div>
	</div>
</div>