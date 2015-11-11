<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $arg['1'] ?></title>
	<link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= asset('assets/css/app.css') ?>">
	<script type="text/javascript" src="<?= asset('assets/js/jquery-2.1.4.min.js') ?>"></script>
	<script type="text/javascript" src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</head>
<body>
<div style="margin-top:15px;"></div>
<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId	: 'your facebook app id',
			xfbml	: true,
			version	: 'v2.5'
		});
	};
	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>