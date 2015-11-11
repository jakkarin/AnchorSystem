<?php import('layouts/header', 'ระบบบัญชีรายรับรายจ่าย'); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div class="row" id="contents"></div>
		</div>
		<div class="col-md-3">
			<?php import('ledger/menu'); ?>
		</div>
	</div>
	<input type="hidden" id="count" value="1">
</div>
<script type="text/javascript" src="<?= asset('assets/js/charts.js') ?>"></script>
<script type="text/javascript" src="<?= asset('assets/js/ledger.js') ?>"></script>
<script type="text/javascript">
	var raw = '<?= $data ?>';
	if (raw !== 'null') {
		var data = JSON.parse(raw);
		Chart.defaults.global.responsive = true;
		$.each(data, function(index, value) {
			var input_count = $('#count');
			var count = parseInt(input_count.val()) + 1;
			input_count.val(count);
			var html = '<div class="col-md-6"><div class="panel panel-info"><div class="panel-heading">' + mouth(index) + ' :  ' + value['0']['label'] + ' ' + value['0']['value'] + ' บาท</div><div class="panel-body"><canvas id="charts' + count + '"></canvas></div></div></div>';
			$('#contents').append(html);
			var ctx = document.getElementById('charts' + input_count.val()).getContext("2d");	
			new Chart(ctx).Doughnut(value);
		});	
	} else {
		$('#contents').append('<div class="col-md-12"><div class="alert alert-info">ยังไม่มีข้อมูล</div></div>');
	}
</script>
<?php import('layouts/footer'); ?>