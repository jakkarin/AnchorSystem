<div id="side-menu" class="list-group">
	<a href="<?= url('admin') ?>" class="list-group-item">Home</a>
	<a href="<?= url('admin/p/news') ?>" class="list-group-item">Add Global News</a>
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