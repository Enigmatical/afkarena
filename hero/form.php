<?php
	if(!isset($_SESSION)) { session_start(); }

	if (!isset($_SESSION["user_id"]))
	{
		header("Location:/");
	}

	include "../includes/config.php";
	include "../includes/functions.php";

	include "../includes/header.php";
?>

<!-- HERO: FORM, Choose Job -->
<div id="jobs" data-role="page">
	<div data-role="header" data-nobackbtn="true">
		<h1>Create</h1>
		<a href="/account/main.php" rel="external" data-icon="arrow-l" class="ui-btn-left">Back</a>
		<a href="#gender" data-icon="arrow-r" class="ui-btn-right">Next</a>
	</div>
	<div data-role="content">
		<input type="hidden" id="job_showing" value="" />
		<input type="hidden" id="details_showing" value="abilities" />
		<h3>Choose a Job</h3>
		<div id="jobs_radio" data-role="controlgroup" data-type="horizontal" style="width: 312px; margin: 0 auto;">
			<input type="radio" name="job" id="job_warrior" value="warrior" checked="checked" />
			<label for="job_warrior" style="width: 103px; font-size: 14px;" onclick="get_job('warrior');">Warrior</label>
			
			<input type="radio" name="job" id="job_rogue" value="rogue" />
			<label for="job_rogue" style="width: 103px; font-size: 14px;" onclick="get_job('rogue');">Rogue</label>
			
			<input type="radio" name="job" id="job_mage" value="mage" />
			<label for="job_mage" style="width: 103px; font-size: 14px;" onclick="get_job('mage');">&nbsp;Mage&nbsp;</label>			
		</div>
		<div class="spacer"></div>
		<div id="jobs_description"></div>
	</div>
	<div data-role="footer">
	</div>
</div>

<!-- HERO: FORM, Choose Gender & Name -->
<div id="gender" data-role="page">
	<div data-role="header">
		<h1>Create</h1>
	</div>
	<div data-role="content">
		<h3>Choose a Gender</h3>
		<div id="job_genders" class="job_genders" data-role="controlgroup" data-type="horizontal" style="width: 295px; margin: 0 auto;">
			<input type="radio" name="gender" id="gender_m" value="m" checked="checked" />
			<label id="label_m" for="gender_m" style="text-align: center;"></label>
			<input type="radio" name="gender" id="gender_f" value="f" />
			<label id="label_f" for="gender_f" style="text-align: center;"></label>
		</div>
		<div class="spacer"></div>
		<h3>Choose a Name</h3>
		<input type="text" name="name" id="name" value="" maxlength="12" placeholder="3-12 letters, no spaces" />
		<div class="spacer"></div>
		<a data-role="button" href="#" class="action" onclick="submit_createForm();" style="<?php bg("general/plus"); ?>">Create</a>
	</div>
	<div data-role="footer">
	</div>
</div>

<form id="create_form" action="/hero/process.php?" method="post">
	<input type="hidden" id="create_job" name="create_job" value="" />
	<input type="hidden" id="create_gender" name="create_gender" value="" />
	<input type="hidden" id="create_name" name="create_name" value="" />
</form>

<script type="text/javascript">
	get_job('warrior');
</script>

<?php
	include "../includes/footer.php";
?>