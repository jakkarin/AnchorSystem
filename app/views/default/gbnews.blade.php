<?php import('layouts/header', preg_replace('/<[A-Za-z\=\.\ \"\-]+>.*<\/[A-Za-z]+>/', '', $data['title'])); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-3 hidden-xs hidden-sm">
			<?php widget('loginBox'); ?>
		</div>
		<div class="col-sm-12 col-md-9">
			<h2 class="page-header" style="margin-top:0;"><?= preg_replace('/<[A-Za-z\=\.\ \"\-]+>.*<\/[A-Za-z]+>/', '', $data['title']) ?></h2>
			<div id="contents" style="margin-bottom:20px;"><?= $data['content'] ?></div>
			<button class="btn btn-info" onclick="fb_share()"><i class="glyphicon glyphicon-share"></i> Post on Facebook</button>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= asset('assets/js/hash.js') ?>"></script>
<script type="text/javascript">
	$('head').append('<style type="text/css"> #contents img { max-width: 100%; } </style>');
	function fb_share() {
		var web_url = '<?= url('') ?>';
		var title = $('.page-header').html().replace(/^\ /g, '');
		var contents = $('#contents').html();
		var images = contents.match(/<img [A-z0-9\;\_\-\.\=\"\:\/\ \%]+>/g);
		var image;
		if (images) { image = images[0].match(/(http|https):\/\/(.*)\.[A-Za-z1-9]+/g)[0]; }
		else { image = null; }
		var data = {
			url: "p/gbn/<?= $data['id'] ?>",
			title: title,
			image: image
		};
		var json = JSON.stringify(data);
		if (json) {
			FB.ui({
				method: 'share',
				href: web_url + 'api/share/' + base64('encode', json),
			}, function(response){});
		}
	}
</script>
<?php import('layouts/footer'); ?>