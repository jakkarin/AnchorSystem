<?php import('layouts/header', 'Global News'); ?>
<?php widget('topnav'); ?>
<link rel="stylesheet" type="text/css" href="<?= asset('assets/summernote/summernote.css') ?>">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-3">
			<?php import('admin/menu'); ?>
		</div>
		<div class="col-sm-8 col-md-9">
			<form id="create" action="<?= url('admin/p/news') ?>" method="post">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="แสดงหน้าแรกหรือไม่">
							<?php if (empty($news)): ?>
								<input type="checkbox" name="active">
							<?php else: ?>
								<input type="checkbox" name="active" <?= $news['active'] ? 'checked' : ''; ?>>
							<?php endif; ?>
						</span>
						<input type="text" id="title" name="title" value="<?= empty($news['title']) ? '' : spchar($news['title']); ?>" placeholder="ชื่อหัวข้อ ข่าว" class="form-control" required/>
					</div>
				</div>
				<div class="form-group">
					<label for="content">Content :</label>
					<textarea title="content" id="content" name="content" class="form-control" placeholder="เนื้อหาข่าว" rows="15" required><?= empty($news['content']) ? '' : $news['content']; ?></textarea>
					<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
					<button class="btn btn-success" style="width:100%"><i class="fa fa-check-circle"></i> Submit</button>
				</div>
			<?php if( ! empty($news['id'])): ?>
				<input type="hidden" name="id" value="<?= $news['id'] ?>">
				<input type="hidden" name="action" value="update">
			<?php endif; ?>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= asset('assets/summernote/summernote.min.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#content').summernote({
			height: 300,
			minHeight: null,
			maxHeight: null,
			focus: true,
		});
	});
</script>
<?php import('layouts/footer'); ?>