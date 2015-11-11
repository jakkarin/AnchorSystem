<?php import('layouts/header', $data['title']); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-3 hidden-xs hidden-sm">
			<?php widget('loginBox'); ?>
		</div>
		<div class="col-sm-12 col-md-9">
			<h2 class="page-header" style="margin-top:0;"><?= $data['title'] ?></h2>
			<div id="contents"><?= $data['content'] ?></div>
			<div class="row">
				<div class="col-xs-12">
				<?php if (in_array(auth('id'), explode(',', $data['readIn']))): ?>
					<button class="btn btn-default" disabled>รับทราบแล้ว</button>
				<?php else: ?>
					<button id="ack" class="btn btn-primary">รับทราบแล้ว</button>
					<script type="text/javascript"> 
						var web_url = '<?= url('') ?>';
						$('#ack').click(function() {
							$.ajax({
								url: web_url + 'p/a/know',
								type: 'post',
								data: { token:'<?= base64_encode($data['id']) ?>',csrf_token:'<?= csrf_token() ?>' },
								success: function(code) {
									if (code === '1') {
										$('#ack').attr('disabled', '')
											.attr('class', 'btn btn-default')
											.attr('id', '');
									}
								}
							});
						});
					</script>
				<?php endif; ?>
				<button class="btn btn-info" onclick="fb_share()"><i class="glyphicon glyphicon-share"></i> Post on Facebook</button>
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
							url: "p/n/<?= $data['id'] ?>",
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
				</div>
			</div>
		</div>
	</div>
</div>
<?php import('layouts/footer'); ?>