<?php
	function query($q)
	{
		include "db_open.php";
			$results = mysql_query($q) or die("Unable to process query:\n{$q}\n\n" . mysql_error());
		include "db_close.php";
		
		return $results;
	}

	function percentOf($t, $p) {
		return $t * ($p * .01);
	}	

	function disp($value, $precision)
	{
		if ($value > $precision)
		{
			echo $precision;
		} else {
			echo $value;
		}
	}

	function encode ($value)
	{
		$value = $value . substr(time(), -5); 
		return base64_encode($value);
	}

	function decode ($value)
	{
		$value = base64_decode($value);
		return substr($value, 0, -5);
	}

	function bg($image)
	{
		echo "background-image: url('/images/{$image}.png');";
	}

	function chance($perc)
	{
		$roll = rand(1, 100);
		if ( ($roll >= 1 && $roll <= $perc) )
		{
			return true;
		} else {
			return false;
		}
	}

	function splitBuff($string)
	{
		$effect_temp = explode("|", $string);
		
		return array("type" => $effect_temp[0], "amount" => $effect_temp[1]);
	}
?>