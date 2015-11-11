<?php import('layouts/header', 'จัดการรูปภาพ'); ?>
<?php widget('topnav'); ?>
<div class="container">
<style type="text/css">
	@media(max-width: 768px) {
		#lists > .image { width:33.33%; }
	}
	@media(min-width: 768px) {
		#lists > .image { width:33.33%; }
	}
	@media(min-width: 992px) {
		#lists > .image { width:16.66666667%; }
	}
	@media(min-width: 1200px) {
		#lists > .image { width:16.66666667%; }
	}
	.image {
		display: inline-block;
		position: relative;
	}
	.image img { width: 100%; }
	.cover {
		position: absolute;
		width: 100%;
		height: 100%;
		z-index: 2;
		opacity: 0;
		transition: all .2s ease-out;
		text-align: center;
		overflow: hidden;
	}
	.cover:hover {
		opacity: 1;
		background: rgba(0,0,0,0.8);
	}
	.btn-group {
		margin-top: 25%;
	}
	.loading {
		display: none;
		text-align: center;
		margin-top: 20px;
		margin-bottom: 20px;
	}
</style>
	<div class="row">
		<div class="col-sm-4 col-md-3">
			<?php widget('loginBox'); ?>
		</div>
		<div class="col-sm-8 col-md-9">
			<div class="progress">
				<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;"></div>
			</div>
			<div class="loading"><img src="<?= asset('assets/img/loading2.gif') ?>"></div>
			<div id="lists"></div>
			<script type="text/javascript">
				var web_url = '<?= url('') ?>';
				var content_url = '<?= content('major/' . user('major')) ?>';
				var json = '<?= $json ?>';
				var data = JSON.parse(json);
				var lists = $('#lists');
				var progress_bar = $('.progress-bar');
				var storeSize = 0;
				if (data.length > 0) {
					$.each(data, function( index , value ) {
						var thumbs = value.name.match(/[A-z0-9]+\./g)[0].replace(/\./,'');
						lists.append('<div class="image" id="i' + index + '"><div class="cover"><div class="btn-group"><a class="btn btn-cover btn-success glyphicon glyphicon-eye-open" href="' + content_url + '/' + value.name + '" target="_blank"></a><button class="btn btn-cover btn-danger glyphicon glyphicon-remove" onclick="del_img(' + index + ');"></button></div></div><img src="' + content_url + '/thumbs/' + thumbs + '.jpg"></div>');
						storeSize += (value.size / 1000);
					});
					progress_bar.attr('storesize', storeSize).attr('style','width:' + ((storeSize / 50000) * 100) + '%').html(Math.round(storeSize / 1000) + ' Mb.');
					function del_img(index) {
						var text = 'ลบภาพนี้ใช่หรือไม่ ?';
						if (confirm(text)) {
							var name = data[index].name.match(/[A-z0-9]+\./g)[0].replace(/\./,'');
							var size = parseInt(progress_bar.attr('storesize')) - (data[index].size / 1000);
							$.ajax({
								url: web_url + 'major/pictures/remove',
								type: 'POST',
								data: { name:name,pic:data[index].name,csrf_token:'<?= csrf_token() ?>' },
								beforeSend: function() {
									$('.loading').fadeIn();
								},
								success: function(code) {
									if (code == '1') {
										$('#i' + index).fadeOut(function() { this.remove(); });
										progress_bar.attr('storesize', size).attr('style','width:' + ((size / 50000) * 100) + '%').html(Math.round(size / 1000) + ' Mb.');
									} else {
										alert('Error.');
									}
									$('.loading').fadeOut();
								}
							});
						}
					}
				} else {
					lists.append('<div class="alert alert-info">ยังไม่มีรูปภาพในขณะนี้</div>');
				}
			</script>
		</div>
	</div>
</div>
<?php import('layouts/footer'); ?>