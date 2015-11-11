
<?php import('layouts/header', 'Global News'); ?>
<?php widget('topnav'); ?>
<link rel="stylesheet" type="text/css" href="<?= asset('assets/summernote/summernote.css') ?>">
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-3">
			<?php import('admin/menu'); ?>
		</div>
		<div class="col-sm-8 col-md-9">
			<a href="<?= url('admin/p/write'); ?>" class="btn btn-primary">Wirte News</a>
			<hr/>
			<div class="list-group">
			<?php foreach ($data as $value): ?>
				<div id="li<?= $value['id'] ?>" class="list-group-item">
					<div class="btn-group">
						<a href="<?= url('admin/p/write/' . $value['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
						<a href="javascript:void(0);" onclick="del('<?= $value['id'] ?>')" class="btn btn-sm btn-danger">Delete</a>
					</div>
					&nbsp <?= $value['title'] ?>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var url = '<?= url('admin/p') ?>';
	function del(id) {
		$.ajax({
			url: url + 'destroy',
			type: 'POST',
			data: { id:id,csrf_token: '<?= csrf_token() ?>' },
			success: function() {
				$('#li' + id).fadeOut(function() {
					this.remove();
				});
			}
		});
	}
</script>
<?php import('layouts/footer'); ?>