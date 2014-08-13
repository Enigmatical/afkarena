<?php 	
	if(!isset($_SESSION)) { session_start(); }

	if (!isset($_SESSION["user_id"]))
	{
		header("Location:/");
	}
	
	include "../includes/config.php";
	include "../includes/functions.php";
	
	$heroes = query("SELECT * FROM heroes WHERE user_id = '{$_SESSION["user_id"]}' ORDER BY level DESC, name ASC");
		
	include "../includes/header.php"; 
?>

<script type="text/javascript">
	localStorage.setItem("arenaUser", "<?php echo encode($_SESSION["user_id"]); ?>");
</script>

<!-- ACCOUNT PAGE -->
<div id="heroes" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>Heroes</h1>
		<a href="/logout.php" rel="external" data-icon="arrow-l" data-theme="e" onclick="localStorage.removeItem('arenaUser');">Logout</a>
	</div>
	<div data-role="content">
		<div id="delete_overlay" class="overlay" style="display: none;"></div>
		<div id="delete_content" class="overlay_content" style="display: none;">
			<div class="message"></div>
			<div class="options">
				<div class="yes_btn">Yes</div>
				<div class="no_btn" onclick="close_overlay('delete');">No</div>
			</div>
		</div>
		<?php if (mysql_num_rows($heroes) < $_CONFIG["MAX_HEROES"]) { ?>
			<a data-role="button" href="/hero/form.php" rel="external" class="action" style="<?php bg("general/plus"); ?>"><div class="label">Create a New Hero</div></a>
			<div class="spacer" style="margin: 8px 0px;"></div>
		<?php } ?>
		<?php 
			if (mysql_num_rows($heroes) > 0) {
				while ($hero = mysql_fetch_assoc($heroes)) {
					$encode_id = encode($hero["id"]);
		?>
					<a data-role="button" href="#" class="action heroes" style="<?php bg("heroes/{$hero["job"]}-{$hero["gender"]}_small"); ?>"> 
						<div class="delete_btn" onclick="confirm_action('delete', 'Are you sure you wish to<br /><span class=\'bold size_1\'>Delete <?php echo $hero["name"]; ?></span>?', '/hero/delete.php?hid=<?php echo $encode_id; ?>');"></div>
						<div class="label" onclick="window.location.href='/hero/set.php?hid=<?php echo $encode_id; ?>';">
							<span class="bold size_1"><?php echo $hero["name"]; ?></span><span class="size_-1">, Level</span>
							<span class="bold size_1"><?php echo $hero["level"]; ?></span>
							<span class="size_-1"><?php echo ucfirst($hero["job"]); ?></span>
						</div>							
					</a>
		<?php 
				}
			} 
		?>
	</div>
	<div data-role="footer">
		<?php /*
		<div data-role="navbar">
			<ul>
				<li><a id="heroes_btn" href="#" class="active">Heroes</a></li>
				<li><a id="settings_btn" href="#settings">Settings</a></li>
			</ul>
		</div>
		*/ ?>
	</div>
</div>

<?php

/*

<div id="settings" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>Settings</h1>
		<a href="/logout.php" rel="external" data-icon="arrow-l" data-theme="e">Logout</a>
	</div>
	<div data-role="content">
		User ID: <?php echo $_SESSION["user_id"]; ?>
	</div>
	<div data-role="footer" data-position="fixed" style="height: 33px; margin-top: 6px;">
		<div data-role="navbar">
			<ul>
				<li><a id="heroes_btn" href="#heroes" data-back="true">Heroes</a></li>
				<li><a id="settings_btn" href="#" class="active">Settings</a></li>
			</ul>
		</div>
	</div>
</div>

*/

?>

<?php include "../includes/footer.php" ?>