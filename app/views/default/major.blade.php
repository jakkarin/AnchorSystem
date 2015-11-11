<?php import('layouts/header', $data['title']); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-3">
			<?php widget('loginBox'); ?>
		</div>
		<div class="col-sm-8 col-md-9">
			<div class="list-group">
				<?php if (user('major') === $data['id']): ?>
					<div class="row">
						<div class="col-md-8">
							<div id="news" class="list-group" style="display:none;"></div>
						</div>
						<div class="col-md-4">
							<div class="well">
								<a href="<?= url('p/a/news') ?>" class="btn btn-sm btn-default">เพิ่มข่าว</a>
							</div>
						</div>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {
							var url = '<?= url('') ?>';
							$.ajax({
								url: '<?= url('p/getJson/news') ?>',
								type: 'get',
								success: function(json) {
									var data = JSON.parse(json);
									$.each(data, function(index, value) {
										$('div#news').append('<a href="' + url + 'p/n/' + value.id + '-' + value.title + '" class="list-group-item">' + value.title + '</a>');
									});
									$('div#news').fadeIn();
								}
							});
						});
					</script>
				<?php else: ?>
					<div class="alert alert-warning">คุณไม่ได้อยู่ในสาขาวิชานี้</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php import('layouts/footer'); ?>