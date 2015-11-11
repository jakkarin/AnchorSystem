<?php import('layouts/header', 'Edit : ' . $data['title']); ?>
<?php widget('topnav'); ?>
<link rel="stylesheet" type="text/css" href="<?= asset('assets/summernote/summernote.css') ?>">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-3">
			<?php widget('loginBox'); ?>
		</div>
		<div class="col-sm-8 col-md-9">
			<form action="<?= url('p/e/news') ?>" method="post">
				<div class="form-group">
					<label for="title">Title :</label>
					<div class="input-group">
						<span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="ล้างข้อมูลการเข้าชม">
							<input type="checkbox" name="c_readIn">
						</span>
						<input type="text" id="title" name="title" placeholder="ชื่อหัวข้อ ข่าว" class="form-control" value="<?= spchar($data['title']) ?>" required/>
					</div>
				</div>
				<div class="form-group">
					<label for="content">Content :</label>
					<textarea title="content" id="content" name="content" class="form-control" placeholder="เนื้อหาข่าว" rows="15" required><?= $data['content'] ?></textarea>
					<input type="hidden" name="token" value="<?= base64_encode($data['id']) ?>">
					<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
					<button class="btn btn-success" style="width:100%"><i class="fa fa-check-circle"></i> Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= asset('assets/summernote/summernote.min.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var web_url = '<?= url('') ?>';
		$('#content').summernote({
			height: 300,
			minHeight: null,
			maxHeight: null,
			focus: true,
			onImageUpload: function(files, editor, welEditable) {
				sendFile(files[0], editor, welEditable);
			}
		}).ready(function() {
			$('.note-editor').prepend('<div class="pre-loader"></div>');
		});
		function sendFile(file, editor, welEditable) {
			data = new FormData();
			data.append('image', file);
			data.append('csrf_token','<?= csrf_token() ?>');
			$.ajax({
				data: data,
				type: 'POST',
				url: web_url +  'api/upload',
				cache: false,
				contentType: false,
				processData: false,
				async: true,
				beforeSend: function() {
					$('.pre-loader').fadeIn();
				},
				success: function(json) {
					data = JSON.parse(json);
					console.log(data);
					console.log(editor);
					if (data.code == 1)
						$('#content').summernote('insertImage', data.data);
					else if (data.code != 0)
						alert(data.data);
					$('.pre-loader').fadeOut();
				}
			});
		}
	});
</script>
<?php import('layouts/footer'); ?>