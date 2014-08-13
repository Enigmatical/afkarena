<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	if (isset($_GET["dungeon"]))
	{
		$dungeon_id = decode($_GET["dungeon"]);
	} else {
		$dungeon_id = $hero->get_DungeonID();
	}
	
	$quests = $hero->list_Quests($dungeon_id);
	$drops = $hero->Gather(null, $dungeon_id);
	
	include "../includes/header.php";
?>

<div id="explore-quests" data-role="page">
	<div data-role="header">
		<h1>Quest Log</h1>
	</div>
	<div data-role="content">
		<div class="log_header" style="<?php bg('quests/quest'); ?>"><span class="size_2">Rank</span> <?php echo $hero->get_QuestRank($dungeon_id); ?> <span class="size_2">Quests</span></div>
		<div class="log dark">
			<?php foreach ($quests as $quest) { ?>
				<div class="<?php if ($quest["completed"] == 1) { echo "strike"; } ?>" style="<?php bg("quests/{$quest["type"]}-{$quest["completed"]}"); ?>"><?php echo $quest["title"]; ?></div>
				<?php if ($quest["completed"] == 0) { 
						if ($quest["type"] == "gather") { ?>
							<?php foreach ($drops as $drop) { ?>
								<div class="details" style="margin-left: 52px; <?php bg($drop["pic"]); ?>"><span class="size_1 bold"><?php echo $drop["actual"]; ?></span> / <?php echo $drop["target"]; ?> x <?php echo $drop["name"]; ?></div>
							<?php } ?>
						<?php } else { ?>
								<div class="details"><?php echo $quest["description"]; ?></div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
	<div data-role="footer">
	</div>
</div>