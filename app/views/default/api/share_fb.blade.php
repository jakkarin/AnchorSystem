<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title ?></title>
	<meta property="og:title" content="<?= $title ?>" />
	<meta property="og:description" content="วันที่โพสต์ <?= date('D, d M Y') ?>" />
	<meta property="og:image" content="<?= is_null($image) ? asset('assets/img/preimg.jpg') : $image ?>" />
	<style type="text/css">
		html, body { margin: 0; min-height: 100%; }
		body {
			background-image: url(<?= asset('assets/img/bg.jpg') ?>);
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			background-size: -o-cover;
			background-size: -moz-cover;
			background-size: -webkit-cover;
			min-height: 100%;
		}
		#loading { margin: 15% auto 0 auto; text-align: center; color: #fff; }
		#loading img { max-width: 100%; }
	</style>
</head>
<body>
	<div id="loading"><img src=""></div>
	<script type="text/javascript">
		var web_url = '<?= url('') ?>';
		var loading = document.getElementById('loading');
		loading.innerHTML = '<img src="<?= asset('assets/img/loading.gif') ?>"><div><h3>โปรดรอสักครู่ ระบบกำลังจะพาท่านไปยังหน้าที่ท่านร้องขอ</h3></div>';
		setTimeout(function() {
			location.href = web_url + '<?= $url . '-' . $title ?>';
		},5000)
	</script>
</body>
</html>