<?php
	if(!isset($_SESSION)) { session_start(); }

	if (!isset($_SESSION["user_id"]))
	{
		header("Location:/");
	}

	include "../includes/config.php";
	include "../includes/functions.php";
	
	$job = $_GET["job"];
?>

<?php if ($job == "warrior") { 
	/* RETALIATE and PUMMEL */
	$abilities = "SELECT id, name, pic, description FROM abilities WHERE id = '1' OR id = '2' ORDER BY name";
	/* DETERMINED and RESILIENT and CHARISMATIC */
	$perks = "SELECT id, name, pic, description FROM perks WHERE id = '1' OR id = '2' OR id = '3' ORDER BY name";
?>
	<div class="job_text color-armor" style="<?php bg('general/armor'); ?>">
		The <b>Warrior</b> is a deadly mixture of raw power and impenetrable toughness.<br />Utilizing his massive axe to deliver <b>Crushing</b> blows, the <b>Warrior</b> makes up for his lack of speed with heavy, usually lethal, attacks.
	</div>
<?php } ?>
<?php if ($job == "rogue") { 
	/* AMBUSH and BLIND */
	$abilities = "SELECT id, name, pic, description FROM abilities WHERE id = '3' OR id = '4' ORDER BY name";
	/* OPPORTUNIST and ELUSIVE and CHARISMATIC */
	$perks = "SELECT id, name, pic, description FROM perks WHERE id = '4' OR id = '5' OR id = '8' ORDER BY name";
?>
	<div class="job_text color-speed" style="<?php bg('general/speed'); ?>">
		The <span class="bold">Rogue</span> is as fast as she is deadly.<br />Swinging her handblades with speed, the <b>Rogue</b> can deliver multiple <b>Chain Attacks</b> that decimate the enemy before it can react.
	</div>
<?php } ?>
<?php if ($job == "mage") { 
	/* ENGULF and CHILL */
	$abilities = "SELECT id, name, pic, description FROM abilities WHERE id = '5' OR id = '6' ORDER BY name";
	/* DEMOLITIONIST and PERCEPTIVE and CHARISMATIC */
	$perks = "SELECT id, name, pic, description FROM perks WHERE id = '6' OR id = '7' OR id = '9' ORDER BY name";
?>
	<div class="job_text color-power" style="<?php bg('general/power'); ?>">
		The <span class="bold">Mage</span> is the epitome of the glass cannon.<br />From the start of the fight, he can use his <b>Boosted Power</b> to decimate the enemy, keeping charged through <b>Flare Ups</b> through out the fight.
	</div>
<?php } ?>

<div class="spacer" style="height: 20px;"></div>
<div id="details_radio" data-role="controlgroup" data-type="horizontal" style="width: 209px; margin: 0 auto;" class="ui-corner-all ui-controlgroup ui-controlgroup-horizontal">
	<div class="ui-radio">
		<div style="font-size: 12px;" data-theme="c" class="ui-btn ui-btn-active ui-corner-left ui-btn-up-c" onclick="show(this, 'abilities');">
			<span class="ui-btn-inner ui-corner-left">
				<span class="ui-btn-text">Abilities</span>
			</span>
		</div>
	</div>
	<div class="ui-radio">
		<div style="font-size: 12px;" data-theme="c" class="ui-btn ui-corner-right ui-controlgroup-last ui-btn-up-c" onclick="show(this, 'perks');">
			<span class="ui-btn-inner ui-corner-right ui-controlgroup-last">
				<span class="ui-btn-text">&nbsp;&nbsp;Perks&nbsp;&nbsp;</span>
			</span>
		</div>
	</div>
</div>
<div id="abilities">
	<?php
		$results = query($abilities);

		while ($row = mysql_fetch_assoc($results)) {
	?>
		<a href="#" data-role="button" class="action no-btn ui-btn ui-btn-corner-all ui-shadow ui-btn-up-c" style="<?php bg("{$row['pic']}"); ?>" data-theme="c"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text">
			<div class="name"><?php echo $row['name']; ?></div>
			<div class="desc"><?php echo $row['description']; ?></div>
		</span></span></a>		
	<?php
		}
	?>
</div>
<div id="perks" style="display: none;">
	<?php
		$results = query($perks);
		
		while ($row = mysql_fetch_assoc($results)) {
	?>
		<a href="#" data-role="button" class="action no-btn ui-btn ui-btn-up-c ui-btn-corner-all ui-shadow" style="<?php bg("{$row['pic']}"); ?>" data-theme="c"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text">
			<div class="name"><?php echo $row['name']; ?></div>
			<div class="desc"><?php echo $row['description']; ?></div>						
		</span></span></a>	
	<?php
		}
	?>
</div>