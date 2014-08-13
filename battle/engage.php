<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";

	include "../classes/Hero.php";
	include "../classes/Monster.php";
	include "../classes/Glance.php";
	
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	if (!$hero->get_BattleID())
	{
		if ($hero->get_ExploreID())
		{
			header("Location:/explore/dungeon.php");
			exit;
		} else {
			header("Location:/lobby/main.php");
			exit;
		}
	}	
	
	$explore = $hero->detail_Explore();
	
	$monster = new Monster();
	$monster->load($hero->get_BattleID());
	
	include "../includes/header.php";
?>

<script type="text/javascript" src="/jquery_mobile/jquery-ui-1.8.12.effects.min.js"></script>
<script type="text/javascript" src="/jquery_mobile/jquery-timers.js"></script>
<script type="text/javascript" src="/js/battle.js"></script>


<div id="battle_engage" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>&nbsp;</h1>
		<a id="levelUpButton" style="display: none;" href="/battle/results.php?type=levelup" data-icon="arrow-r" data-theme="e" class="ui-btn-right" data-role="button">Level Up</a>
		<a id="victoryButton" style="display: none;" href="/battle/results.php?type=victory" rel="external" data-icon="arrow-r" data-theme="b" class="ui-btn-right" data-role="button">Victory</a>
		<a id="defeatButton" style="display: none;" href="/explore/results.php?eid=<?php echo $hero->get_ExploreID(); ?>" rel="external" data-icon="arrow-r" data-theme="b" class="ui-btn-right" data-role="button">Defeat</a>		
	</div>
	<div data-role="content" style="<?php bg("dungeons/dungeon_{$explore['dungeon_id']}-{$explore['streak']}"); ?> background-color: black; background-repeat: no-repeat; background-position: top center;">
		<div class="top" style="height: 258px;">
			<div class="section white" style="<?php bg('general/battle'); ?>">Battle</div>
			<?php
				$glance = new Glance();
				$glance->monster($monster);
				
				include "../includes/glance.php";
			?>
			<div id="monster_status" class="status_bar">
				<div class="buff"></div>
				<div class="debuff"></div>
			</div>
			<div id="quest_log" style="display: none;"></div>
			<div id="results_log" style="display: none;">
				<div class="log_header white" style="<?php bg('general/spoils'); ?>">Rewards</div>
				<div class="log">
					<div id="loot_exp" class="white" style="display: none; <?php bg('general/exp'); ?>">+<span id="gained_exp"></span> EXP</div>
					<div id="loot_gold" class="white" style="<?php bg('spoils/gold'); ?>">+<span id="gained_gold"></span> Gold <span class="size_-1">(loot)</span></div>
					<div id="loot_common" class="white" style="display: none; <?php bg('spoils/iron'); ?>">+<span id="gained_common"></span> Iron Ore <span class="size_-1">(loot)</span></div>
					<div id="loot_rare" class="white" style="display: none; <?php bg('spoils/cobalt'); ?>">+<span id="gained_rare"></span> Cobalt Ore <span class="size_-1">(loot)</span></div>
				</div>
			</div>
			<div id="battle_log">
				<div id="beginQueue" class="action" data-role="button" style="<?php bg('general/battle'); ?> margin-top: 40px; opacity: 0.0;">
					<div class="label">Attack!</div>
				</div>
			</div>
		</div>
		<div id="hero_status" class="status_bar">
			<div class="buff"></div>
			<div class="debuff"></div>
		</div>
		<?php
			$glance = new Glance();
			$glance->hero($hero);

			include "../includes/glance.php";
		?>
	</div>
	<div data-role="footer">
	</div>
</div>

<script type="text/javascript">
	$('#battle_engage').bind('pageshow', function() {
		$('#beginQueue').animate({ 'opacity' : 1 });
		$('#beginQueue').bind('click', function() {
			processBattle();
		});
		
		<?php if ($monster->Type() == "notorious") { ?>
			notoriousName();
		<?php } ?>
	});
</script>