<?php 
	include "../includes/functions.php"; 
?>

<!-- CREATE: FORM -->
<div id="create" data-role="page">
	<div data-role="header">
		<h1>Create</h1>
	</div>
	<div data-role="content">
		<form id="create_form" method="post" action="/create/process.php">
			<h3>Email Address</h3>
			<input type="email" name="login" id="login" value="" maxlength="35" placeholder="you@example.com" />
			<h3>Password</h3>
			<input type="password" name="password" id="password" value="" maxlength="15" placeholder="6-15 alphanumeric characters" />
			<div class="spacer"></div>
			<a href="#" class="action" data-role="button" onclick="$('#create_form').submit();" style="<?php bg("general/key"); ?>"><div class="label">Create</div></a>
		</form>
	</div>
	<div data-role="footer">
	</div>
</div>