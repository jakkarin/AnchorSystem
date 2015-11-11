<?php import('layouts/header', auth('username')); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<?php widget('loginBox'); ?>
		</div>
		<div class="col-md-9">
			<style type="text/css">
				.cover {
					height: 200px;
					position:relative;
					background-repeat: no-repeat;
					background-position: center;
				}
				.cover-menu {
					color:#333;
					background:rgba(255,255,255,0.6);
					position:absolute;
					left:0;
					bottom:0;
					z-index:2;
					width: 100%;
				}
				.cover-menu > li > a {
					color:#222;
					font-weight: bold;
					border-radius: 0 !important;
				}
				.cover-menu > li.active > a {
					background:rgba(0,0,0,0.6) !important;
					border-right:none !important;
					border-left:none !important;
					border-bottom:none !important;
					border-top: 1px solid #444 !important;
					color: #fff !important;
				}
				.tab-pane { background-color: #f6f6f6;padding: 10px; }
				.progress {margin: 0;width:100%;border-radius: 0;}
			</style>
			<script type="text/javascript">
				var index = '<?= url('') ?>';
				var content = '<?= content('') ?>';
			</script>
			<!-- Nav tabs -->
			<div class="cover" style="<?= ! empty(user('cover')) ? 'background-image:url(' . content('users/covers/' . user('cover')) . ');' : 'background-color:#333;'; ?>">
				<ul class="nav nav-tabs cover-menu" role="tablist">
					<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
					<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
					<li role="presentation"><a href="#avatar" aria-controls="avatar" role="tab" data-toggle="tab">Avatar</a></li>
					<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
				</ul>
			</div>
			<div id="cover-progress" class="progress" style="display:none;">
				<div id="cover-progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div>
			</div>
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="home">
					<table class="table" style="background:#fff;">
						<tbody>
							<tr>
								<td width="100"><b>Name</b></td>
								<td><?= user('firstname') ?> <?= user('lastname') ?> ( <?= user('nickname') ?> )</td>
							</tr>
							<tr>
								<td><b>facebook</b></td>
								<td><?= user('facebook') ?></td>
							</tr>
							<tr>
								<td><b>Line</b></td>
								<td><?= user('line') ?></td>
							</tr>
							<tr>
								<td><b>Phone</b></td>
								<td><?= user('phone') ?></td>
							</tr>
							<tr>
								<td><b>Created at</b></td>
								<td><?= date('D, d M Y', strtotime(auth('created_at'))) ?></td>
							</tr>
							<tr>
								<td><b>Signature</b></td>
								<td id="signature"><?= user('signature') ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="profile">
					<form id="cover" action="<?= url('user/e/cover') ?>" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label for="cover">อัพโหลดรูปปก</label>
							<input id="input-cover" type="file" name="cover" requried>
							<p class="help-block">ภาพควรมีขนาด 900 x 200 px.</p>
							<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
							<button id="btn-cover" class="btn btn-sm btn-success">อัพโหลด</button>
						</div>
					</form>
					<script type="text/javascript">
						$('#cover').submit(function(e) {
							e.preventDefault();
							if ($('#input-cover').val() !== '') {
								var formData = new FormData($(this)[0]);
								$.ajax({
									url: index + 'user/e/cover',
									type: 'post',
									contentType: false,
									processData: false,
									async: true,
									cache: false,
									data: formData,
									beforeSend: function(XMLHttpRequest) {
										$('#btn-cover').fadeOut();
									},
									xhr: xhr_progress,
									success: function() {
										$('#btn-cover').fadeIn();
										var img_src = content + 'users/covers/<?= auth('id') ?>.jpg?' + new Date().getTime();
										$('.cover').attr('style','background-image:url(' + img_src + ');');
									}
								});
							}
						});
					</script>
					<form id="user_detail">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="firstname">Firstname :</label>
									<input type="text" name="firstname" class="form-control" value="<?= user('firstname') ?>" placeholder="ชื่อต้น" required>
								</div>
								<div class="form-group">
									<label for="nickname">Nickname :</label>
									<input type="text" name="nickname" class="form-control" value="<?= user('nickname') ?>" placeholder="ชื่อเล่น" required>
								</div>
								<div class="form-group">
									<label for="facebook">FaceBook :</label>
									<input type="text" name="facebook" class="form-control" value="<?= user('facebook') ?>" placeholder="เฟสบุ๊ก ใส่ข้อมูลที่สามารถค้นหาได้">
								</div>
								<div class="form-group">
									<label for="phone">Phone :</label>
									<input type="text" name="phone" class="form-control" value="<?= user('phone') ?>" placeholder="เบอร์โทรศัพท์ที่สามารถติดต่อได้">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="lastname">Lastname :</label>
									<input type="text" name="lastname" class="form-control" value="<?= user('lastname') ?>" placeholder="นามสกุบ" required>
								</div>
								<div class="form-group">
									<label for="line">Line :</label>
									<input type="text" name="line" class="form-control" value="<?= user('line') ?>" placeholder="id line">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="signature">Signature :</label>
									<textarea rows="6" name="signature" class="form-control" placeholder="สามารถใช้ html css bootstrap ได้ ไม่อนุญาติให้ใช้ javascript"><?= user('signature') ?></textarea>
									<p class="help-block">วิธีใช้ html bootstrap แทรกรูป แทรก Youtube click</p>
								</div>
								<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
								<button id="user_detail_submit" class="btn btn-info" style="width:100%;" disabled>Submit</button>
							</div>
						</div>
					</form>
					<script type="text/javascript">
						$('#user_detail').change(function() {
							$('#user_detail_submit').prop('disabled', false);
						});
						$('#user_detail').submit(function(e) {
							e.preventDefault();
							var formData = $(e.target).serializeArray();
							$.ajax({
								url: index + 'user/e/user_detail',
								type: 'post',
								data: formData,
								xhr: xhr_progress,
								success: function() {
									$('#user_detail_submit').prop('disabled', true);
									$('#signature').html(e.target[7].value);
								}
							});
						});
					</script>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="avatar">
					<link rel="stylesheet" href="<?= asset('assets/jcrop/css/jquery.Jcrop.min.css') ?>">
					<script type="text/javascript" src="<?= asset('assets/jcrop/js/jquery.Jcrop.min.js') ?>"></script>
					<form id="form-avatar" enctype="multipart/form-data">
						<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
						<div class="input-avatar">
							<label for="avatar">Avatar input</label>
							<input type="file" name="avatar" id="avatar">
							<p class="help-block">อัพโหลดแล้วปรับขนาดรูปภาพประจำตัว.</p>
						</div>
						<div id="avatar-body" style="display:none;">
							<div class="button-box btn-group">
								<button type="submit" class="btn btn-primary" id="submit-avatar"><i class="glyphicon glyphicon-ok"></i></button>
								<button type="button" class="btn btn-danger" onclick="cancelAvatar();" id="cancel-avatar"><i class="glyphicon glyphicon-remove"></i></button>
							</div>
							<div id="pre-avatar-body"></div>
							<input type="hidden" id="x" name="x" value="">
							<input type="hidden" id="y" name="y" value="">
							<input type="hidden" id="w" name="w" value="">
							<input type="hidden" id="h" name="h" value="">
						</div>
					</form>
					<script type="text/javascript">
						$('input#avatar').change(function() {
							if ($(this).val() !== '') {
								var input = this;
								$('#cover-progress').fadeIn(function() {
									$('#cover-progress-bar').attr('style', 'width:100%');
								});
								$('.input-avatar').fadeOut(function() {
									if (input.files && input.files[0]) {
										var reader = new FileReader();
										reader.onload = function(e) {
											$('#pre-avatar-body').html('<img id="pre-avatar" src="' + e.target.result + '" />')
											.ready(function() {
												$('#cover-progress').fadeOut(function() {
													$('#avatar-body').fadeIn(function() {
														$('#cover-progress-bar').attr('style', 'width:0%');
														var img = new Image();
														img.src = $('img#pre-avatar').attr('src');
														$('img#pre-avatar').Jcrop({
															onChange: setAxis,
															onSelect: setAxis,
															aspectRatio:1,
															trueSize:[img.width,img.height]
														});
													});
												});
											});
										}
										reader.readAsDataURL(input.files[0]);
									}

								});
							}
						});
						$('#form-avatar').submit(function(e) {
							e.preventDefault();
							var formData = new FormData($(this)[0]);
							$.ajax({
								url: index + 'user/e/avatar',
								type: 'post',
								processData: false,
								async: true,
								cache: false,
								contentType: false,
								data: formData,
								beforeSend: function() {
									cancelAvatar();
								},
								xhr: xhr_progress,
								success: function() {
									var img_src = content + 'users/avatars/<?= auth('id') ?>.jpg?' + new Date().getTime();
									$('img.avatar').attr('src', img_src);
									$('#cover-progress').fadeOut();
									$('#cover-progress-bar').attr('style', 'width:0%');
								}
							});
						});
						function cancelAvatar() {
							$('#avatar-body').fadeOut(function() {
								$('.input-avatar').fadeIn();
								$('#pre-avatar-body').html('');
							});
						}
						function setAxis(ax) {
							$('#x').val(ax.x);
							$('#y').val(ax.y);
							$('#w').val(ax.w);
							$('#h').val(ax.h);
						}
					</script>
				</div>
				<?php $active = (auth('active') === '1') ? '<span class="label label-success">ยืนยันแล้ว</span>' : '<span class="label label-warning">ยังไม่ได้ทำการยืนยันอีเมลล์</span>'; ?>
				<div role="tabpanel" class="tab-pane fade" id="settings">
					<div class="panel panel-info">
						<div class="panel-heading">Email ผู้ใช้งาน</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Email : <?= $active ?></label>
								<input type="email" name="email" class="form-control" value="<?= auth('email') ?>" disabled>
							</div>
							<button class="btn btn-success" style="width:100%;" disabled>Change Email</button>
						</div>
					</div>
					<div class="panel panel-danger">
						<div class="panel-heading">เปลี่ยนแปลง รหัสผ่าน</div>
						<div class="panel-body">
						<form id="changePasswd">
							<div class="form-group">
								<label>Password :</label>
								<input type="password" id="passwd" class="form-control" placeholder="รหัสผ่านใหม่" required>
							</div>
							<div class="form-group">
								<label>Password Confirm :</label>
								<input type="password" id="pastoken" name="pastoken" class="form-control" placeholder="ยืนยันรหัสผ่าน" required>
							</div>
							<div class="form-group">
								<label>Old Password :</label>
								<input type="password" name="old_pass" class="form-control" placeholder="รหัสผ่านเก่า" required>
							</div>
							<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
							<button id="btn-chpass" class="btn btn-primary" style="width:100%;">Change Password</button>
						</form>
						<script type="text/javascript">
							$('#changePasswd').submit(function(e) {
								e.preventDefault();
								if ($('#passwd').val() === $('#pastoken').val()) {
									var formData = $(e.target).serializeArray();
									$.ajax({
										url: index + 'user/e/chpass',
										type: 'post',
										data: formData,
										beforeSend: function() {
											$('#btn-chpass').prop('disabled', true);
										},
										xhr: xhr_progress,
										success: function() {
											$('#btn-chpass').prop('disabled', false);
										}
									});
								}
							});
						</script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function xhr_progress() {
	var xhr = new window.XMLHttpRequest();
	xhr.upload.addEventListener('loadstart', function(e) {
		$('#cover-progress').fadeIn();
	}, false);
	xhr.upload.addEventListener("progress", function(e) {
		if (e.lengthComputable) {
			var percentComplete = Math.round((e.loaded / e.total) * 100);
			$('#cover-progress-bar').attr('style', 'width:' + percentComplete + '%');
		}
	}, false);
	xhr.upload.addEventListener("loadend", function(e) {
		$('#cover-progress').fadeOut(function() {
			$('#cover-progress-bar').attr('style', 'width:0%');
		});
	}, false);
	return xhr;
}
</script>
<?php import('layouts/footer'); ?>