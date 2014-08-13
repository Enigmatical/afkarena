<?php
	include "./includes/config.php";
	include "./includes/functions.php";
	
	include "./includes/header.php"; 	
?>
<script type="text/javascript">
	var userid = localStorage.getItem("arenaUser");
	if (userid != null) {
		window.location.href = "/account/auto.php?u=" + userid;
	}
</script>


<!-- HOME -->
<div id="home" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>&nbsp;</h1>
		<a id="continueButton" style="display: none;" data-icon="arrow-r" class="ui-btn-right" data-theme="e">Continue</a>
	</div>
	<div data-role="content">
		<div id="logo"></div>
		<a href="/create/info.php" data-role="button" class="action" style="<?php bg("general/book"); ?>"><div class="label">Learn More About the Arena</div></a>
		<div class="spacer"></div>
		<a id="accessButton" href="/login/form.php" data-role="button" class="action" style="<?php bg("general/key"); ?>"><div class="label">Access Your Account</div></a>
		<a href="/rank/rank.php" rel="external" data-role="button" class="action" style="<?php bg("general/hero_wins"); ?>"><div class="label">Browse Leaderboards</div></a>
	</div>
	<div data-role="footer">
		<div class="footer-right">
			<a href="/about.php?" data-rel="dialog" data-transition="slideup" data-icon="info">About</a>
		</div>
		<div class="footer-left">
			<a href="/help/help.php?" data-icon="star">Help</a>
		</div>
	</div>
</div>

<?php include "./includes/footer.php"; ?>