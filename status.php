<?php
	include "./includes/config.php";
	include "./includes/functions.php";
	include "./includes/class-functions.php";

	include "./classes/Hero.php";
	include "./classes/Glance.php";

	$hid = decode($_GET["hid"]);
	
	$hero = new Hero();
	$hero->load($hid);

    $equip = new stdClass();
    $equip->link = new stdClass();
	
	$powerRating = $hero->get_EquipRating('weapon');

	include "./includes/header.php";
?>

<div id="lobby_status" data-role="page">
	<div data-role="header">
		<h1><?php echo $hero->Name(); ?></h1>
		<?php if (isset($_GET["from"]) && $_GET["from"] == "lobby") { ?>
			<a href="/lobby/main.php" rel="external" data-icon="arrow-l" data-theme="a" class="ui-btn-left" data-role="button">Back</a>
		<?php } else if (isset($_GET["from"]) && $_GET["from"] == "leaderlobby") { ?>
			<a href="/rank/rank.php?from=lobby" rel="external" data-icon="arrow-l" data-theme="a" class="ui-btn-left" data-role="button">Back</a>
		<?php } else { ?>
			<a href="/rank/rank.php" rel="external" data-icon="arrow-l" data-theme="a" class="ui-btn-left" data-role="button">Back</a>			
		<?php } ?>
		<div class="ui-navbar ui-navbar-noicons">
			<ul class="ui-grid-c">
				<li class="ui-block-a"><div class="ui-btn ui-btn-up-a ui-btn-active" onclick="switchStatus(this, 'general');"><span class="ui-btn-inner">General</span></div></li>
				<li class="ui-block-b"><div class="ui-btn ui-btn-up-a" onclick="switchStatus(this, 'wealth');"><span class="ui-btn-inner">Inventory</span></div></li>
				<li class="ui-block-c"><div class="ui-btn ui-btn-up-a" onclick="switchStatus(this, 'explore');"><span class="ui-btn-inner">Explore</span></div></li>
				<li class="ui-block-d"><div class="ui-btn ui-btn-up-a" onclick="switchStatus(this, 'battle');"><span class="ui-btn-inner">Combat</span></div></li>
			</ul>
		</div>
	</div>
	<div data-role="content" style="min-height: 333px;">
		<div id="general_tab" class="status_tab">
			<div class="section" style="<?php bg('heroes/' . $hero->Job() . '-' . $hero->Gender() . '_small'); ?>">General</div>
			<div class="tab_content">
				<h3>Vitals</h3>
				<div class="log dark">
					<div style="<?php bg('general/level_up'); ?>">Level <span class="value"><?php echo "{$hero->Level()}, " . ucfirst($hero->Job()); ?></span></div>
					<div style="<?php bg('battle/icon-health'); ?>">Health <span class="value"><?php echo "{$hero->Health()} / {$hero->get_MaxHealth()}" ; ?></span></div>
					<div style="<?php bg('general/exp'); ?>">EXP <span class="value"><?php echo round($hero->Exp('percent'), 1) . " %"; ?></span></div>
				</div>
				<h3>Ratings</h3>
				<div class="log dark">
					<div style="<?php bg('battle/icon-power'); ?>">Power <span class="value"><?php echo "{$powerRating['min']}&minus;{$powerRating['max']} Damage"; ?></span></div>
					<div style="<?php bg('battle/icon-speed'); ?>">Speed <span class="value"><?php echo "{$hero->get_EquipRating('trinket')}"; ?></span></div>
					<div style="<?php bg('battle/icon-armor'); ?>">Armor <span class="value"><?php echo "{$hero->get_EquipRating('armor')}"; ?></span></div>
				</div>
				<h3>Perks</h3>
				<div class="log dark">
					<?php
						$perks = $hero->Perks();
						foreach($perks as $perk) {
							$d = $hero->detail_Perk($perk);
					?>
						<div style="<?php bg($d["pic"]); ?>"><?php echo $d["name"]; ?> <span class="value">Rank <?php echo $hero->has_Perk($perk); ?></span></div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
		<div id="wealth_tab" style="display: none;" class="status_tab">
			<div class="section" style="<?php bg('general/spoils'); ?>">Inventory</div>
			<div class="tab_content">
				<h3>Equipment</h3>
				<?php
					$equip->type = "weapon";
					$equip->link->type = "";
					$equip->link->href = "";
	
					include "./includes/equip.php";
				?>
				<?php
					$equip->type = "armor";
					$equip->link->type = "";
					$equip->link->href = "";
	
					include "./includes/equip.php";
				?>
				<?php
					$equip->type = "trinket";
					$equip->link->type = "";
					$equip->link->href = "";
	
					include "./includes/equip.php";
				?>
				<h3>Wealth (Overall)</h3>
				<div class="log dark">	
					<div style="<?php bg('spoils/gold'); ?>">Gold <span class="value"><?php echo "{$hero->Loot('gold')} ({$hero->Stat('gatherGold')})"; ?></span></div>
					<div style="<?php bg('spoils/iron'); ?>">Iron Ore <span class="value"><?php echo "{$hero->Loot('ore_common')} ({$hero->Stat('gatherCommon')})"; ?></span></div>
					<div style="<?php bg('spoils/cobalt'); ?>">Cobalt Ore <span class="value"><?php echo "{$hero->Loot('ore_rare')} ({$hero->Stat('gatherRare')})"; ?></span></div>
				</div>
			</div>
		</div>
		<div id="explore_tab" style="display: none;" class="status_tab">
			<div class="section" style="<?php bg('general/explore'); ?>">Explore</div>
			<div class="tab_content">
				<h3>Travel (Per Dungeon)</h3>
				<div class="log dark">
					<?php
						$cellarTravel = $hero->Stat('dungeonTravel') > 0 ? round(($hero->Stat('dungeon-1Travel')/$hero->Stat('dungeonTravel')) * 100, 1) : 0;
						$marshesTravel = $hero->Stat('dungeonTravel') > 0 ? round(($hero->Stat('dungeon-2Travel')/$hero->Stat('dungeonTravel')) * 100, 1) : 0;
						$labyrinthTravel = $hero->Stat('dungeonTravel') > 0 ? round(($hero->Stat('dungeon-3Travel')/$hero->Stat('dungeonTravel')) * 100, 1) : 0;
					?>
					<div style="<?php bg('quests/depth-0') ?>">Total <span class="value"><?php echo $hero->Stat('dungeonTravel'); ?> Steps</span></div>
					<div style="<?php bg('general/minion'); ?>">The Cellar <span class="value"><?php echo $cellarTravel; ?> %</span></div>
					<div style="<?php bg('general/fiend'); ?>">The Marshes <span class="value"><?php echo $marshesTravel; ?> %</span></div>
					<div style="<?php bg('general/tyrant'); ?>">The Labyrinth <span class="value"><?php echo $labyrinthTravel; ?> %</span></div>
				</div>
				<h3>Quests</h3>
				<div class="log dark">
					<div style="<?php bg('quests/quest'); ?>">Total <span class="value"><?php echo $hero->Stat('questComplete'); ?> / 90</span></div>
					<div style="<?php bg('general/minion'); ?>">The Cellar <span class="value">Rank <?php echo $hero->get_QuestRank('1'); ?></span></div>
					<div style="<?php bg('general/fiend'); ?>">The Marshes <span class="value">Rank <?php echo $hero->get_QuestRank('2'); ?></span></div>
					<div style="<?php bg('general/tyrant'); ?>">The Labyrinth <span class="value">Rank <?php echo $hero->get_QuestRank('3'); ?></span></div>
				</div>
			</div>
		</div>
		<div id="battle_tab" style="display: none;" class="status_tab">
			<div class="section" style="<?php bg('general/battle') ?>">Combat</div>
			<div class="tab_content">
				<h3>Battles</h3>
				<div class="log dark">
					<?php
						$victoryPercent = $hero->Stat('battleTotal') > 0 ? round(($hero->Stat('battleVictories')/$hero->Stat('battleTotal')) * 100, 1) : 0;
					?>
					<div style="<?php bg('general/battle'); ?>">Total <span class="value"><?php echo $hero->Stat('battleTotal'); ?></span></div>
					<div style="<?php bg('general/hero_wins'); ?>">Victory/Defeat Ratio <span class="value"><?php echo $victoryPercent; ?> %</span></div>
				</div>
				<h3>Specific</h3>
				<div class="log dark">
					<div style="<?php bg('general/minion'); ?>">Minions Defeated <span class="value"><?php echo $hero->Stat('defeatMinion'); ?></span></div>
					<div style="<?php bg('general/fiend'); ?>">Fiends Defeated <span class="value"><?php echo $hero->Stat('defeatFiend'); ?></span></div>
					<div style="<?php bg('general/tyrant'); ?>">Tyrants Defeated <span class="value"><?php echo $hero->Stat('defeatTyrant'); ?></span></div>
				</div>
			</div>
		</div>
	</div>
	<div data-role="footer">
	</div>
</div>