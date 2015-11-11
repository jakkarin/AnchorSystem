<?php import('layouts/header',$title); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<?php widget('loginBox'); ?>
		</div>
		<div class="col-md-9">
		<?php if (auth('active') === '1'): ?>
			<div class="row">
				<div class="col-sm-8 col-md-8">
					<div class="panel panel-info">
						<div class="panel-heading">ข่าวประกาศ</div>
						<div id="gbnews" class="list-group" style="display:none;"></div>
					</div>
					<div id="news_count" style="margin-bottom:6px;"></div>
					<div id="news" class="list-group" style="display:none;"></div>
				</div>
				<div class="col-sm-4 col-md-4">
				<?php if(role_check()): ?>
					<div class="well">
						<a href="<?= url('p/a/news') ?>" class="btn btn-sm btn-default">เพิ่มข่าว</a>
						<a href="<?= url('major/pictures') ?>" class="btn btn-sm btn-default">จัดการรูปภาพ</a>
					</div>
				<?php endif; ?>
					<div class="panel panel-primary">
						<div id="members-header" class="panel-heading">Management Group</div>
						<div id="members" class="list-group" style="display:none;"></div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				var url = '<?= url('') ?>';
				var content = '<?= content('') ?>';
				var asset = '<?= asset('assets') ?>';
				var user_id = '<?= auth('id') ?>';
				var text1 = ' จำนวนสูงสุดของโพสต์ในสาขา 15 โพสต์';
				$(document).ready(function() {
					getAll();
				});
				function getAll() {
					$.ajax({
						url: url + 'home/getJson',
						type: 'get',
						success: function(json) {
							var data = JSON.parse(json);
							getGbNews(data['gbnews']);
							getNews(data['news']);
							getUser(data['users']);
						}
					});
				}
				function getGbNews(data) {
					var gbnewsEl = $('#gbnews');
					gbnewsEl.fadeOut(function() {
						gbnewsEl.empty();
						if (data.length !== 0) {
							$.each(data, function(index, value) {
								var html = '<a href="' + url + 'p/gbn/' + value.id + '-' + (value.title).replace(/<[A-Za-z\=\.\ \"\-]+>.*<\/[A-Za-z]+>/g,'').replace(' ', '') + '" class="list-group-item">' + value.title + '</a>';
								gbnewsEl.append(html);
							});
							gbnewsEl.fadeIn();
						}
					});
				}
				function getNews(data) {
					var newsEl = $('#news');
					var news_countEl = $('#news_count');
					newsEl.fadeOut(function() {
						newsEl.empty();
						news_countEl.empty();
						news_countEl.html('<kbd>' + data.length + ' / 15</kbd><code>' + text1 + '</code>')
						if (data.length !== 0) {
							$.each(data, function(index, value) {
								var date = new Date(value.updated_at).toString().replace(/ ([0-9]+):([0-9]+):([0-9]+)(.*)/g, '');
								var read = '<span class="label label-danger">ยังไม่ได้อ่าน</span> ';
								if ($.inArray(user_id, value.readIn.split(',')) >= 0)
									read = '<span class="label label-success">อ่านแล้ว</span> ';
							<?php if (role_check()): ?>
								var html = '<div class="list-group-item"><div class="row"><a href="' + url + 'p/n/' + value.id + '-' + (value.title).replace(/<[A-Za-z\=\.\ \"\-]+>.*<\/[A-Za-z]+>/g,'').replace(' ', '-') + '" style="color:#666;"><div class="col-xs-8"><b>' + value.title + '</b><br/>' + read + date + '</div></a><div class="col-xs-4 text-right"><a href="' + url + 'p/e/news/' + value.id + '" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-edit"></i></a> <a href="javascript:void(0);" onclick="del(' + value.id + ');" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove-sign"></i></a></div></div></div>';
							<?php else: ?>
								var html = '<a href="' + url + 'p/n/' + value.id + '-' + (value.title).replace(' ', '-') + '" class="list-group-item"><b>' + value.title + '</b><br/>' + read + date + '</a>';
							<?php endif; ?>
								newsEl.append(html);
							});
						} else {
							var html = '<div class="list-group-item">ยังไม่มีข่าวใดๆ ในขณะนี้</div>';
							newsEl.append(html);
						}
						newsEl.fadeIn();
					});
				}
				function getUser(data) {
					var memberEl = $('div#members');
					memberEl.fadeOut(function() {
						memberEl.empty();
						memberEl.append('<a href="' + url + 'user/members" class="list-group-item">ดูสมาชิกทั้งหมด</a>');
						$.each(data, function(index, value) {
							if (value.avatar === null)
								var img = '<img class="img-circle" src="' + asset + '/img/no-avatar.jpg" style="width: 40px; margin-right:8px;">';
							else
								var img = '<img src="' + content + 'users/avatars/' + value.avatar + '" width="40" class="img-circle" style="margin-right:8px;" />';
							memberEl.append('<a href="' + url + 'user/i/' + value.id + '" target="_blank" class="list-group-item">' + img + value.firstname + ' ( ' + value.nickname + ' ) </li>');
						});
						memberEl.fadeIn();
					});
				}
				function del(id) {
					if (confirm('คุณต้องการที่จะลบหรือไม่?')) {
						$.ajax({
							url: url + 'p/e/del',
							type: 'post',
							data : { id: id, csrf_token: '<?= csrf_token() ?>' },
							success: function(json) {
								getAll();
							}
						});
					}
				}
			</script>
		<?php else: ?>
			<?php widget('InActive'); ?>
			<div class="alert alert-warning">
				<h3><i class="glyphicon glyphicon-bullhorn"></i> ประกาศ</h3><hr />
				<p>ขณะนี้คุณยังไม่สามารถใช้งานระบบได้ กรุณารอจนกว่าประธานสาขาของคุณจะตรวจสอบและรับเข้านะครับ</p>
				<p>ต้องขออภัยในความไม่สะดวก</p><hr />
			</div>
		<?php endif; ?>
		</div>
	</div>
</div>
<?php import('layouts/footer'); ?>