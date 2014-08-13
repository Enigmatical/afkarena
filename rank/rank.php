<?php
	include "../includes/functions.php";
	
	$heroes = query("SELECT id, name, job, level, gender, score FROM heroes WHERE score > 0 ORDER BY score DESC LIMIT 25");
	$warriors = query("SELECT id, name, job, level, gender, score FROM heroes WHERE score > 0 AND job = 'warrior' ORDER BY score DESC LIMIT 25");
	$rogues = query("SELECT id, name, job, level, gender, score FROM heroes WHERE score > 0 AND job = 'rogue' ORDER BY score DESC LIMIT 25");
	$mages = query("SELECT id, name, job, level, gender, score FROM heroes WHERE score > 0 AND job = 'mage' ORDER BY score DESC LIMIT 25");
	
	include "../includes/header.php";
?>

<div id="home_rankings" data-role="page">
	<div data-role="header">
		<h1>Leaderboards</h1>
		<?php if (isset($_GET["from"])) { ?>
			<a href="/lobby/main.php" rel="external" data-icon="arrow-l" data-theme="a" class="ui-btn-left" data-role="button">Back</a>
		<?php } else { ?>
			<a href="/" rel="external" data-icon="arrow-l" data-theme="a" class="ui-btn-left" data-role="button">Back</a>		
		<?php } ?>
		<div class="ui-navbar ui-navbar-noicons">
			<ul class="ui-grid-c">
				<li class="ui-block-a"><div class="ui-btn ui-btn-up-a ui-btn-active" onclick="switchStatus(this, 'overall');"><span class="ui-btn-inner">Overall</span></div></li>
				<li class="ui-block-b"><div class="ui-btn ui-btn-up-a" onclick="switchStatus(this, 'warrior');"><span class="ui-btn-inner">Warriors</span></div></li>
				<li class="ui-block-c"><div class="ui-btn ui-btn-up-a" onclick="switchStatus(this, 'rogue');"><span class="ui-btn-inner">Rogues</span></div></li>
				<li class="ui-block-d"><div class="ui-btn ui-btn-up-a" onclick="switchStatus(this, 'mage');"><span class="ui-btn-inner">Mages</span></div></li>
			</ul>
		</div>
	</div>
	<div data-role="content" style="min-height: 333px;">
		<div id="overall_tab" class="status_tab">
			<div class="section" style="<?php bg('general/hero_wins'); ?>">Top Heroes</div>
			<div class="tab_content">
				<ol class="rankings">
					<?php while($hero = mysql_fetch_assoc($heroes)) { 
						$heroLink = isset($_GET["from"]) ? "/status.php?hid=" . encode($hero["id"]) . "&from=leaderlobby" : "/status.php?hid=" . encode($hero["id"]);
					?>
						<li style="<?php bg('heroes/' . $hero["job"] . '-' . $hero["gender"] . '_small'); ?>" class="<?php echo $hero["job"]; ?>"><a href="<?php echo $heroLink; ?>" rel="external"><span class="size_2 bold"><?php echo $hero["name"]; ?></span>, <span class="size_-1">Level <?php echo $hero["level"]; ?> <?php echo ucfirst($hero["job"]); ?></span> <span class="size_2 value bold"><?php echo $hero["score"]; ?></span></a></li>
					<?php } ?>
				</ol>
			</div>
		</div>
		<div id="warrior_tab" style="display: none;" class="status_tab">
			<div class="section" style="<?php bg('general/armor'); ?>">Top Warriors</div>
			<div class="tab_content">
				<ol class="rankings">
					<?php while($hero = mysql_fetch_assoc($warriors)) { 
						$heroLink = isset($_GET["from"]) ? "/status.php?hid=" . encode($hero["id"]) . "&from=leaderlobby" : "/status.php?hid=" . encode($hero["id"]);					
					?>
						<li style="<?php bg('heroes/' . $hero["job"] . '-' . $hero["gender"] . '_small'); ?>" class="<?php echo $hero["job"]; ?>"><a href="<?php echo $heroLink; ?>" rel="external"><span class="size_2 bold"><?php echo $hero["name"]; ?></span>, <span class="size_-1">Level <?php echo $hero["level"]; ?> <?php echo ucfirst($hero["job"]); ?></span> <span class="size_2 value bold"><?php echo $hero["score"]; ?></span></a></li>
					<?php } ?>
				</ol>
			</div>
		</div>
		<div id="rogue_tab" style="display: none;" class="status_tab">
			<div class="section" style="<?php bg('general/speed'); ?>">Top Rogues</div>
			<div class="tab_content">
				<ol class="rankings">
					<?php while($hero = mysql_fetch_assoc($rogues)) { 
						$heroLink = isset($_GET["from"]) ? "/status.php?hid=" . encode($hero["id"]) . "&from=leaderlobby" : "/status.php?hid=" . encode($hero["id"]);					
					?>
						<li style="<?php bg('heroes/' . $hero["job"] . '-' . $hero["gender"] . '_small'); ?>" class="<?php echo $hero["job"]; ?>"><a href="<?php echo $heroLink; ?>" rel="external"><span class="size_2 bold"><?php echo $hero["name"]; ?></span>, <span class="size_-1">Level <?php echo $hero["level"]; ?> <?php echo ucfirst($hero["job"]); ?></span> <span class="size_2 value bold"><?php echo $hero["score"]; ?></span></a></li>
					<?php } ?>
				</ol>
			</div>
		</div>
		<div id="mage_tab" style="display: none;" class="status_tab">
			<div class="section" style="<?php bg('general/power'); ?>">Top Mages</div>
			<div class="tab_content">
				<ol class="rankings">
					<?php while($hero = mysql_fetch_assoc($mages)) { 
						$heroLink = isset($_GET["from"]) ? "/status.php?hid=" . encode($hero["id"]) . "&from=leaderlobby" : "/status.php?hid=" . encode($hero["id"]);					
					?>
						<li style="<?php bg('heroes/' . $hero["job"] . '-' . $hero["gender"] . '_small'); ?>" class="<?php echo $hero["job"]; ?>"><a href="<?php echo $heroLink; ?>" rel="external"><span class="size_2 bold"><?php echo $hero["name"]; ?></span>, <span class="size_-1">Level <?php echo $hero["level"]; ?> <?php echo ucfirst($hero["job"]); ?></span> <span class="size_2 value bold"><?php echo $hero["score"]; ?></span></a></li>
					<?php } ?>
				</ol>
			</div>
		</div>
	</div>
	<div data-role="footer"></div>
</div>