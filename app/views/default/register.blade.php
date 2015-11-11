<?php import('layouts/header', 'สมัครสมาชิก'); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div style="background:url(<?= asset('assets/img/b6J0n3B.jpg') ?>) no-repeat;background-size:100%;">
	<div class="row">
		<div class="col-md-offset-3">
			<div class="col-md-8">
				<form class="well" style="margin-top:10px;" action="<?= url('auth/register') ?>" method="post">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label class="control-label" for="email">Email : </label>
								<input type="email" name="email" id="email" class="form-control" required>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label" for="username">Username : </label>
								<input type="text" name="username" id="username" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label" for="passwd">Password : </label>
								<input type="password" name="passwd" id="passwd" class="form-control" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label" for="passwd_con">Password Confrim : </label>
								<input type="password" name="passwd_con" id="passwd_con" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<select id="faculty" class="form-control">
										<option value="0">--กรุณาเลือก--</option>
									<?php if ( ! empty($faculty)): ?>
									<?php foreach ($faculty as $list): ?>
										<option value="<?= $list['id'] ?>"><?= $list['name'] ?></option>
									<?php endforeach; ?>
									<?php endif; ?>
									</select>
									<div id="major-box" class="input-group" style="display:none;">
										<select id="major" name="major" class="form-control"></select>
										<div class="input-group-btn">
											<button type="button" onclick="changefaculty();" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
										</div>
									</div>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label" for="firstname">Firstname : </label>
												<input type="text" name="firstname" id="firstname" class="form-control" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label" for="lastname">Lastname : </label>
												<input type="text" name="lastname" id="lastname" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label class="control-label" for="nickname">Nickname : </label>
												<input type="text" name="nickname" id="nickname" class="form-control" required>
											</div>
										</div>
										<div class="col-sm-8">
											<div class="form-group">
												<label class="control-label" for="birthday">Birthday : </label>
												<input type="text" name="birthday" id="birthday" class="form-control">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div style="height:130px;">
						<div id="captcha-box" class="row text-center" style="display:none;">
							<div id="captcha-img-box" class="col-sm-6">
								<img id="captcha-img" src="" width="100%"/>
								<button type="button" class="btn btn-default col-xs-12" onclick="getCaptcha();"><i class="glyphicon glyphicon-refresh"></i></button>
							</div>
							<div id="captcha-btn" class="col-sm-6"></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="<?= asset('assets/css/bootstrap-datetimepicker.min.css') ?>">
<script type="text/javascript" src="<?= asset('assets/js/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?= asset('assets/js/datepicker.th.js') ?>"></script>
<script type="text/javascript" src="<?= asset('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script type="text/javascript">
	var faculty_url = '<?= url('faculty/id') ?>';
	var captcha_url =  '<?= url('captcha/get') ?>';
	var check_user =  '<?= url('auth/checkExistUser') ?>';
</script>
<script type="text/javascript">
	$(function () {
		 $('#birthday').datetimepicker({
		 	defaultDate: '01/01/1996',
		 	viewMode: 'years',
		 	format: 'DD/MM/YYYY',
		 	locale: 'th'
		 });
		 getCaptcha();
	});
	$('form').submit(function(e) {
		var check = $('#passwd').val() !== $('#passwd_con').val();
		var check2 = $('#faculty').val() === '0';
		$('input#passwd').parent().attr('class','form-group');
		$('input#passwd_con').parent().attr('class','form-group');
		$('select#faculty').parent().attr('class','panel-heading');
		if (check) {
			e.preventDefault();
			setTimeout(function() {
				$('input#passwd').parent().attr('class','form-group has-error');
				$('input#passwd_con').parent().attr('class','form-group has-error');
			},200);
		} if (check2) {
			e.preventDefault();
			setTimeout(function() {
				$('select#faculty').parent().attr('class','panel-heading has-error');
			},200);
		} if ($('input#email').parent().attr('class') === 'form-group has-error') {
			e.preventDefault();
		}
	});
	$('#email').change(function(e) {
		$('input#email').parent().attr('class','form-group');
		$('label[for="email"]').html('Email :');
		$.ajax({
			url: check_user,
			type:'post',
			data: {
				email: e.target.value
			},
			success: function(code) {
				if (code === '0') {
					setTimeout(function() {
						$('input#email').parent().attr('class','form-group has-error');
						$('label[for="email"]').html('Email : อีเมลล์นี้มีผู้ใช้งานแล้ว');
					},200);
				};
			}
		});
	});
	$('#faculty').change(function(e) {
		if (e.target.value !== '0') {
			$('#faculty').fadeOut(function() {
				$.ajax({
					url: faculty_url + e.target.value + '?json=true',
					type: 'get',
					success: function(json) {
						var data = JSON.parse(json);
						$.each(data, function(index, value) {
							$('#major').append('<option value="' + value.id + '">' + value.name + '</option>');
						});
						$('#major-box').fadeIn();
					}
				});	
			});
		}
	});
	function getCaptcha() {
		$('#captcha-box').fadeOut(function() {
			$.ajax({
				url: captcha_url + 'true',
				type: 'get',
				success: function(data) {
					$('#captcha-img').attr('src', data);
					$.ajax({
						url: captcha_url,
						type: 'get',
						success: function(json) {
							var btns = JSON.parse(json);
							$('#captcha-btn').empty();
							$.each(btns, function(index, value) {
								$('#captcha-btn').append('<button type="submit" class="btn btn-default col-xs-6" name="captcha" value="' + value + '">' + value + '</button>');
							});
							$('#captcha-box').fadeIn();
						}
					});
				}
			});
		});
	}
	function changefaculty() {
		$('#major-box').fadeOut(function() {
			$('#major').empty();
			$('#faculty').fadeIn();
		});
	}
</script>
<?php import('layouts/footer'); ?>