<?php
	include "../includes/security.php";

	include "../includes/functions.php";
	include "../includes/class-functions.php";
 
	include "../classes/Hero.php";
	include "../classes/Glance.php";
		
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	if ($hero->get_BattleID())
	{
		header("Location:/battle/engage.php");
		exit;
	}	
	
	if ($hero->get_ExploreID())
	{
		header("Location:/explore/dungeon.php");
		exit;
	}
	
	include "../includes/header.php";
?>

<div id="lobby" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>&nbsp;</h1>
		<a href="/account/main.php" rel="external" data-icon="arrow-l" data-theme="e" class="ui-btn-left" data-role="button">Quit</a>
	</div>
	<div data-role="content">
		<div class="top">
			<div class="section" style="<?php bg("general/day"); ?>">Lobby</div>
			<a id="explore_button" class="action" href="explore.php?" data-role="button" style="<?php bg('general/explore'); ?>">
				<div class="label">Explore</div>
			</a>
			<a id="train_button" class="action" href="train.php?" data-role="button" style="<?php bg('general/train'); ?>">
				<div class="label">Train</div>
			</a>
			<a id="forge_button" class="action" href="forge.php?" data-role="button" style="<?php bg('general/forge'); ?>">
				<div class="label">Forge</div>
			</a>
			<a id="mend_button" class="action" href="mend.php?" data-role="button" style="<?php bg('general/mend'); ?>">
				<div class="label">Mend</div>
			</a>
			<div class="spacer"></div>
			<a id="status_button" class="action" href="/status.php?from=lobby&hid=<?php echo encode($_SESSION["hero_id"]); ?>" rel="external" data-role="button" style="<?php bg('general/exp'); ?>">
				<div class="label">Status</div>
			</a>
		</div>
		<?php
			$glance = new Glance();
			$glance->general($hero);
			
			include "../includes/glance.php";
		?>
	</div>
	<div data-role="footer">
		<div class="footer-left">
			<a href="/rank/rank.php?from=lobby" rel="external" data-role="button" data-icon="grid">Boards</a>				
		</div>
		<div class="footer-right">
			<a href="/rank/ladder.php" data-rel="dialog" data-transition="slideup" data-role="button" data-icon="grid">Ladder</a>		
		</div>
	</div>
</div>