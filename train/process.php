<?php
	include "../includes/security.php";

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	include "../classes/Glance.php";

	$pid = $_GET['pid'];
	$pid = decode($pid);
	
	$hero = new Hero();
	$hero->load($_SESSION["hero_id"]);
	
	$train = $hero->train($pid);
	
	if ($train == false) { header("Location:/lobby/main.php"); }
	
	$details = $hero->detail_Perk($pid);
	
	$hero->save();
	
	include "../includes/header.php";
?>

<div id="train_info" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>&nbsp;</h1>
		<a href="<?php echo $_SERVER["REQUEST_URI"]; ?>" rel="external" data-icon="refresh" class="ui-btn-left" data-theme="a">Again?</a>
		<a href="/lobby/main.php" rel="external" data-icon="arrow-r" class="ui-btn-right" data-theme="e">Lobby</a>
	</div>
	<div data-role="content">
		<div class="top sub">
			<div class="section" style="<?php bg('general/train'); ?>">Train</div>		
			<?php
				/* Shopkeeper Dialogue */
				$dialogues = array (
					"Soon you'll be training me!",
					"Gotta stay one step ahead, right?",
					"Excellent session!"
				);
				
				$glance = new Glance();
				$glance->shopkeeper("trainer", $dialogues[array_rand($dialogues)]);
				
				include "../includes/glance.php";
			?>
			<div class="spacer"></div>
			<div class="log dark">
				<div style="<?php bg($details["pic"]); ?>">+1 Rank to <?php echo $details["name"]; ?> Perk</div>
			</div>
		</div>
		<div class="action no-btn" data-role="button" style="<?php bg($details["pic"]); ?>">
			<div class="name"><?php echo $details["name"]; ?><span class="size_-1" style="margin-left: 10px;">Rank</span> <span class="size_0"><?php echo $hero->has_Perk($pid); ?></span></div>
			<div class="desc"><?php echo $details["description"]; ?></div>
		</div>
		<?php
			$glance = new Glance();
			$glance->general($hero);
			$glance->id = "train";
			
			include "../includes/glance.php";
		?>
	</div>
	<div data-role="footer">
	</div>
</div>