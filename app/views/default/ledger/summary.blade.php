<?php import('layouts/header', 'สรุป'); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-9">
			<table id="table" class="table table-hover"></table>
		</div>
		<div class="col-md-3">
			<?php import('ledger/menu'); ?>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= asset('assets/js/ledger.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#table');
		var raw = '<?= json_encode($data) ?>';
		if (raw !== 'null') {
			var json = JSON.parse(raw);
			var sum = 0;
			$.each(json, function(index, value) {
				var html = '<thead><tr><th width="1"></th><th colspan="4">' + mouth(index) + '</th><tr></thead><tbody>';
				$.each(value, function(i2, v2) {
					var arr = v2.split(':|');
					html += '<tr>';
					$.each(arr, function(i3, v3) {
						if (i3 === 0) {
							html += '<td>' + type(v3) + '</td>';
						} else if (i3 === 2) {
							sum = (arr[0] === '1') ? (sum - parseInt(v3)) : (sum + parseInt(v3));
							html += '<td>' + v3 + '</td>';
						} else {
							html += '<td>' + v3 + '</td>';	
						}
					});
					html += '</tr>';
				});
				html += '</tbody>';
				table.append(html);
			});
			table.append('<tr><td colspan="2"></td><td colspan="3">' + sum + '</td></tr>');
		} else {
			table.append('<div class="alert alert-info">ยังไม่มีข้อมูล</div>');
		}
	});
</script>
<?php import('layouts/footer'); ?>