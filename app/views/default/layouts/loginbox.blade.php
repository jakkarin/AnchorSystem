<div class="text-center">
<?php if (empty(user('avatar'))): ?>
	<img class="avatar img-circle" src="<?= asset('assets/img/no-avatar.jpg') ?>" style="width: 140px; height: 140px;">
<?php else: ?>
	<img class="avatar img-circle" src="<?= content('users/avatars/' . user('avatar')) ?>" style="width: 140px; height: 140px;">
<?php endif; ?>
	<br /><?= auth('username') ?>
	<br /><?= auth('email') ?>
<?php if (role_check(0)): ?>
	<hr />
	<p>
		<select id="ch_major" class="form-control input-sm">
		<?php foreach ($data as $value): ?>
			<option value="<?= $value['id'] ?>" <?= (user('major') === $value['id'])?'selected':''; ?>><?= $value['name'] ?></option>
		<?php endforeach; ?>
		</select>
		<script type="text/javascript">
			$('#ch_major').change(function(e) {
				$.ajax({
					url: '<?= url('admin/chMajor') ?>',
					type: 'post',
					data: { mid: e.target.value, csrf_token: '<?= csrf_token() ?>' },
					success: function() { location.reload(); }
				});
			});
		</script>
	</p>
<?php endif; ?>
</div>