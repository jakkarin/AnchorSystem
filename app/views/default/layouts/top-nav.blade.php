<div class="container">
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?= url('') ?>">Anchor System</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li <?= is_active('') ?>><a href="<?= url('') ?>">หน้าแรก <span class="sr-only">(current)</span></a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				<?php if (empty(auth())): ?>
					<li <?= is_active('auth/signin') ?>><a href="<?= url('auth/signin') ?>">Login</a></li>
					<li <?= is_active('auth/register') ?>><a href="<?= url('auth/register') ?>">Register</a></li>
				<?php else:?>
					<li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= auth('username') ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li <?= is_active('user') ?>><a href="<?= url('user') ?>">Profile Setting</a></li>
							<li <?= is_active('ledger') ?>><a href="<?= url('ledger') ?>">Ledger</a></li>
							<li><a href="<?= url('auth/signout') ?>">SignOut</a></li>
						</ul>
					</li>
				<?php endif;?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</div>