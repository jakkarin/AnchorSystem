<?php import('layouts/header', 'สมาชิก'); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-3 hidden-xs">
			<?php widget('loginBox'); ?>
		</div>
		<div class="col-sm-8 col-md-9">
			<div class="row">
			<?php foreach ($data as $key => $value): ?>
				<div class="col-xs-6 col-md-4 col-lg-3 text-center">
				<?php if (is_null($value['avatar'])): ?>
					<img class="img-circle" src="<?= asset('assets/img/no-avatar.jpg') ?>" style="width: 140px; height: 140px;">
				<?php else: ?>
					<img class="img-circle" src="<?= content('users/avatars/' . $value['avatar']) ?>" data-holder-rendered="true" style="width: 140px; height: 140px;">
				<?php endif; ?>
					<p style="margin-top:10px;">
						<a href="<?= url('user/i/' . $value['id']) ?>"><?= $value['firstname'] ?></a>
						<br/><?= $value['nickname'] ?> ( <?= position($value['role_id']) ?> )
						<br/>
				<?php if (role_check(1)): ?>
					<?php if ($value['active'] === '1'): ?>
						<span class="label label-success">ยืนยันแล้ว</span>
					<?php else: ?>
						<span class="label label-danger">ยังไม่ได้ยืนยัน</span>
					<?php endif; ?>
				<?php endif; ?>
					</p>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<?php import('layouts/footer'); ?>