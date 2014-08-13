<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";

	include "../classes/Hero.php";
	include "../classes/Glance.php";
	
	$dungeon_id = decode($_GET["dungeon"]);
	
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	$dungeon_name = array( 1 => "The Cellar", 2 => "The Marshes", 3 => "The Labyrinth" );
	
	if ($hero->get_QuestRankComplete($dungeon_id) && $hero->get_QuestRank($dungeon_id) < 10)
	{
		$rank = $hero->get_QuestRank($dungeon_id);
		$rank++;
		$hero->load_Quests($dungeon_id, $rank);
	}
	
	$quests = $hero->list_Quests($dungeon_id);
	
	$hero->save();

	include "../includes/header.php";
?>

<div id="explore_entrance" data-role="page">
	<div data-role="header">
		<h1>&nbsp;</h1>
	</div>
	<div data-role="content" style="<?php bg("dungeons/dungeon_{$dungeon_id}-0"); ?> background-position: top center; background-repeat: no-repeat; background-color: black;">
		<div class="top" style="height: 200px;">
			<div class="section white" style="<?php bg('general/explore'); ?>"><?php echo $dungeon_name[$dungeon_id]; ?>&nbsp;&nbsp;<span class="size_-1">Entrance</span></div>
			<div class="log_header white" style="<?php bg('quests/quest'); ?>">Rank <span style="font-size: 25px;"><?php echo $hero->get_QuestRank($dungeon_id); ?></span> Quests</div>
			<div class="log">
				<?php foreach ($quests as $quest) { ?>
					<div class="white <?php if ($quest["completed"] == 1) { echo "strike"; } ?>" style="<?php bg("quests/{$quest["type"]}-{$quest["completed"]}"); ?>"><?php echo $quest["title"]; ?></div>
				<?php } ?>
			</div>
		</div>
		<div class="dungeon_actions">
			<a href="/explore/travel.php?type=<?php echo encode('start'); ?>&dungeon=<?php echo encode($dungeon_id); ?>" rel="external" class="action small" data-role="button" style="<?php bg("general/advance"); ?>">
				<div class="label">Enter</div>
			</a>
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
			<?php $questStatus = $hero->get_QuestRankStatus($dungeon_id); ?>
			<a href="/explore/quests.php?dungeon=<?php echo encode($dungeon_id); ?>" data-rel="dialog" data-transition="slideup" data-role="button" data-icon="star">Quests (<?php echo $questStatus['complete']; ?>/<?php echo $questStatus['overall']; ?>)</a>
		</div>
	</div>
</div>