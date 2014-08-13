<?php
	if(!isset($_SESSION)) { session_start(); }

	if (!isset($_SESSION["user_id"]))
	{
		header("Location:/");
	}

	include "../includes/config.php";
	include "../includes/functions.php";
	include "../includes/class-functions.php";
	
	include "../classes/Hero.php";
	
	$job = $_POST["create_job"];
	$gender = $_POST["create_gender"];
	$name = $_POST["create_name"];
	
	$name = strtolower($name);
	$name = ucfirst($name);
	
	//Check to see if hero already exists
	
	$rows = query("SELECT name FROM heroes WHERE name = '{$name}'");
	
	$name_error = 0;
	$exists_error = 0;
	
	//Check to see if Name is VALID
	if (!preg_match("/^[a-zA-Z]{3,12}$/", $name)) {
		$name_error = 1;
	} elseif (mysql_num_rows($rows) > 0) {
		$exists_error = 1;
	}
?>
<?php if ($name_error == 1 || $exists_error == 1) { ?>		
	<div id="whoops" data-role="page">
		<div data-role="header">
			<h1>Whoops!</h1>
		</div>
		<div data-role="content">
			<div class="block error">
				<div class="italic">We encountered some errors : </div>
				<br />
				<?php if ($name_error == 1) { ?>
					<div class="italic">&raquo; <span class="bold size_1">Hero Name</span> is invalid.</div>
				<?php } elseif ($exists_error == 1) { ?>
					<div class="italic">&raquo; <span class="bold size_1">Hero Name</span> is not available.</div>				
				<?php } ?>
				<br />
				<div class="italic">Please go <span class="bold">Back</span>, and try again.</div>
			</div>
		</div>
		<div data-role="footer">
		</div>
	</div>
<?php } else { ?>
	<?php
		$hid = uniqid();
	
		$hero = new Hero();
		$hero->create($hid, $name, $job, $gender);
		$json = $hero->to_json();
	
		//Create new Hero record
		query("INSERT INTO heroes (id, user_id, name, job, level, gender, status, score, json, created) VALUES ('{$hid}', '{$_SESSION["user_id"]}', '$name', '$job', '1', '$gender', '', '0', '$json', NOW())");
	?>

	<div id="success" data-role="page">
		<div data-role="header" data-nobackbtn="true">
			<h1>Success!</h1>
		</div>
		<div data-role="content">
			<div class="block success">
				<div class="size_1 bold">Your New Hero is Ready!</div>
				<br />
				<div class="italic"><span class="bold"><?php echo $name; ?></span> has been successfully created.</div>
			</div>
			<div class="spacer"></div>
			<a href="/account/main.php" rel="external" class="action" data-role="button" style="<?php bg('general/key'); ?>"><div class="label">Return to Your Heroes</div></a>
		</div>
		<div data-role="footer">
		</div>
	</div>
<?php } ?>