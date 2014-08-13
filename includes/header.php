<?php
	if(!isset($_SESSION)) { session_start(); }
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no" />
	<title>AFK Arena</title>
	<link rel="apple-touch-icon" href="/images/general/a.png" />
	<link rel="stylesheet" type="text/css" href="/jquery_mobile/jquery.mobile-1.0a2.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/game.css" />
	<script type="text/javascript" src="/jquery_mobile/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="/jquery_mobile/jquery.mobile-1.0a2.min.js"></script>
	<script type="text/javascript" src="/js/game.js"></script>
	<script type="text/javascript">
		$.mobile.loadingMessage = false;
		$.mobile.allowCrossDomainPages = true;
	</script>
	<script type="text/javascript">
		if ('standalone' in navigator && !navigator.standalone && (/iphone|ipod|ipad/gi).test(navigator.platform) && (/Safari/i).test(navigator.appVersion)) {
			document.write('<link rel="stylesheet" href="/add2home/add2home.css">');
			document.write('<script type="application/javascript" src="/add2home/add2home.js"><\/script>');
		}
	</script>
</head>
<body>