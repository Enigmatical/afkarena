<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";

	include "../classes/Hero.php";
	include "../classes/Glance.php";
		
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);

	include "../includes/header.php";
?>

<div id="lobby_explore" data-role="page">
	<div data-role="header">
		<h1>&nbsp;</h1>
	</div>
	<div data-role="content">
		<div class="top">
			<div class="section" style="<?php bg('general/explore'); ?>">Explore</div>			
			
			<h3>Dungeon</h3>
			<a href="/explore/entrance.php?dungeon=<?php echo encode("1"); ?>" class="action" rel="" data-role="button" style="<?php bg('general/minion'); ?>">
				<div class="name">The Cellar</div>
				<div class="desc">Dark, damp, and located just under the Arena</div>
			</a>
			
			<?php if ($hero->Level() < 15) { ?>
				<div class="action disabled" data-role="button" style="<?php bg('general/fiend'); ?>">
					<div class="name">The Marshes</div>
					<div class="desc">Available at Hero Level 15</div>
				</div>	
			<?php } else { ?>
				<a href="/explore/entrance.php?dungeon=<?php echo encode("2"); ?>" class="action" rel="" data-role="button" style="<?php bg('general/fiend'); ?>">
					<div class="name">The Marshes</div>
					<div class="desc">Muddy expanse crawling with devious fiends</div>
				</a>		
			<?php } ?>
			
			<?php if ($hero->Level() < 30) { ?>
				<div class="action disabled" data-role="button" style="<?php bg('general/tyrant'); ?>">
					<div class="name">The Labyrinth</div>
					<div class="desc">Available at Hero Level 30</div>
				</div>
			<?php } else { ?>
				<a href="/explore/entrance.php?dungeon=<?php echo encode("3"); ?>" class="action" rel="" data-role="button" style="<?php bg('general/tyrant'); ?>">
					<div class="name">The Labyrinth</div>
					<div class="desc">Fabled for its immense size and powerful tyrants</div>
				</a>			
			<?php } ?>
			
			<?php /*
			<h3>Arena</h3>
			<?php if ($hero->vital_Level() < 75) { ?>
				<div class="action disabled" data-role="button" style="<?php bg('general/battle'); ?>">
					<div class="name">The Ring</div>
					<div class="desc">Available at Hero Level 75</div>
				</div>			
			<?php } else { ?>
				<a href="#" class="action" data-role="button" style="<?php bg('general/battle'); ?>">
					<div class="name">The Ring</div>
					<div class="desc">Face off against another powerful Hero</div>
				</a>
			<?php } ?>
			*/ ?>
		</div>
		<?php
			$glance = new Glance();
			$glance->general($hero);
			
			include "../includes/glance.php";
		?>
	</div>
	<div data-role="footer">
	</div>
</div>