<?php import('layouts/header', 'เพิ่มรายการ'); ?>
<?php widget('topnav'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-9">
			<form id="formnew" method="post">
				<button type="submit" class="btn btn-default">บันทึก <?= date('M m') ?></button>
				<hr />
				<div id="n1" class="form-group form-inline">
					<select name="n1[]" class="form-control">
						<option value="1" selected>รายจ่าย</option>
						<option value="2">รายรับ</option>
					</select>
					<input name="n1[]" type="text" class="form-control" placeholder="ชื่อรายการ" required />
					<input name="n1[]" type="number" class="form-control" placeholder="จำนวนเงิน" required/>
					<input name="n1[]" type="text" class="form-control" placeholder="หมายเหตุ" required/>
				</div>
				<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
			</form>
			<input type="hidden" id="ncount" value="1">
			<hr />
			<button id="addnew" class="btn btn-default">เพิ่ม</button>
		</div>
		<div class="col-md-3">
			<?php import('ledger/menu'); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#addnew').click(function() {
		var inputCount = $('#ncount');
		var count = parseInt(inputCount.val());
		inputCount.val(count + 1);
		var id = 'n' + (count + 1).toString();
		var html = '<div id="' + id + '" class="form-group form-inline"><select name="' + id + '[]" class="form-control"><option value="1" selected>รายจ่าย</option><option value="2">รายรับ</option></select> <input name="' + id + '[]" type="text" class="form-control" placeholder="ชื่อรายการ" required/> <input name="' + id + '[]" type="number" class="form-control" placeholder="จำนวนเงิน" required/> <input name="' + id + '[]" type="text" class="form-control" placeholder="หมายเหตุ" required/> <button type="button" class="btn btn-danger glyphicon glyphicon-remove" onclick="dele(\'' + id + '\');"></button></div>';
		$('#formnew').append(html);
	});
	function dele(id) {
		$('#' + id).fadeOut(function() {
			$(this).remove();
		});
	}
</script>
<?php import('layouts/footer'); ?>
