<?php import('layouts/header', 'สมาชิก'); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div class="row">
		<style type="text/css">
			.cover {
				height: 200px;
				position:relative;
				background-repeat: no-repeat;
				background-position: center;
			}
			div.avatar {
				position: absolute;
				top: 120px;
				right: 50px;
				z-index: 2;
			}
			@media(max-width: 767px) {
				div.avatar {
					position: absolute;
					top: 10%;
					right: 0;
					width: 100%;
					z-index: 2;
					text-align: center
				}
			}
			img.avatar {
				width: 150px;
				height: 150px;
				border: 5px solid #fff;
			}
			kbd, code {font-size: 100%;}
		</style>
		<div class="col-md-9">
			<div class="cover" style="<?= ! empty($user_detail['cover']) ? 'background-image:url(' . content('users/covers/' . $user_detail['cover']) . ');' : 'background-color:#333;'; ?>">
				<div class="avatar">
					<?php if (is_null($user_detail['avatar'])): ?>
						<img class="img-circle avatar" src="<?= asset('assets/img/no-avatar.jpg') ?>">
					<?php else: ?>
						<img class="img-circle avatar" src="<?= content('users/avatars/' . $user_detail['avatar']) ?>" data-holder-rendered="true">
					<?php endif; ?>
				</div>
			</div>
			<div style="background:#f6f6f6;">
				<table class="table" style="margin-bottom:0;">
					<tbody>
						<tr>
							<td width="100"><b>Name</b></td>
							<td><?= $user_detail['firstname'] ?> <?= $user_detail['lastname'] ?> ( <?= $user_detail['nickname'] ?> )</td>
						</tr>
						<tr>
							<td><b>facebook</b></td>
							<td><?= $user_detail['facebook'] ?></td>
						</tr>
						<tr>
							<td><b>Line</b></td>
							<td><?= $user_detail['line'] ?></td>
						</tr>
						<tr>
							<td><b>Phone</b></td>
							<td><?= $user_detail['phone'] ?></td>
						</tr>
					</tbody>
				</table>
				<div>
					<div style="background:#333333;color:#fff;">
						<samp style="padding:5px 10px"> Signature</samp>
						<button class="btn btn-sm btn-success" style="border-radius:0;" onclick="toggle()"> View Source code</button>
					</div>
					<div id="signature"><?= $user_detail['signature'] ?></div>
					<pre id="signature-code" ready="false" style="display:none;"></pre>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-info">
				<div class="panel-heading">User Information</div>
				<div class="panel-body">
					<b>Email : </b><?= $user['email'] ?> <br/>
					<b>username : </b><?= $user['username'] ?> <br/>
					<b>registed : </b><?= date('D, d/m/Y H:i:s', strtotime($user['created_at'])) ?> <br/>
				</div>
			</div>
		<?php if (role_check(1)): ?>
			<div class="btn-group" style="width:100%;">
				<?php $disabled = ($user['active'] === '1') ? 'disabled' : ''; ?>
				<button id="btn-allow" class="btn btn-success" style="width:50%;" onclick="mkAllow();" <?= $disabled ?>><i class="glyphicon glyphicon-ok"></i> Allow</button>
				<button id="btn-deny" class="btn btn-default" style="width:50%;" onclick="mkDeny();" <?= $disabled ?>><i class="glyphicon glyphicon-remove"></i> Deny</button>
				<script type="text/javascript">
					function mkAllow() {
						$.post('<?= url('user/e/allow') ?>', { id: <?= $user['id'] ?>, csrf_token:'<?= csrf_token() ?>' }, function() {
							$('#btn-allow').prop('disabled', true);
							$('#btn-deny').prop('disabled', true);
						});
					}
					function mkDeny() {
						if (confirm('คุณแน่ใจใช่ไหม ข้อมูลของ <?= $user_detail['nickname'] ?> จะหายหมดเลยนะ')) {
							$.get('<?= url('user/e/deny') ?>?id=<?= $user['id'] ?>');
						}
					}
				</script>
			</div>
		<?php endif; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	function toggle() {
		var sig = $('#signature');
		var code = $('#signature-code');
		if (code.attr('ready') === 'true') {
			code.fadeOut(function() {
				sig.fadeIn();
			}).attr('ready','false');
		} else {
			sig.fadeOut(function() {
				if (code.html() === '') {
					code.html(escapeHTML(sig.html())).attr('ready','true').fadeIn();
				} else {
					code.attr('ready','true').fadeIn();
				}
			});
		}
	}
	function escapeHTML(html) {
		return html.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
	}
</script>
<?php import('layouts/footer'); ?>