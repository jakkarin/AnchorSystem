<div id="side-menu" class="list-group">
	<a href="<?= url('ledger') ?>" class="list-group-item">หน้าแรก</a>
	<a href="<?= url('ledger/add') ?>" class="list-group-item">เพิ่มรายการ</a>
	<a href="<?= url('ledger/summary') ?>" class="list-group-item">สรุปรายการ</a>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var links = $('#side-menu').find('a');
		$.each(links, function(index, value) {
			if (value.href === location.href) {
				value.className = 'list-group-item active';
				return false;
			}
		});
	});
</script>