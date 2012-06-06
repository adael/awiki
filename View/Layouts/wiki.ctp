<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Awiki</title>
		<?php
		// css
		echo $this->Html->css('/wiki/lib/bootstrap/css/bootstrap.min.css');
		echo $this->Html->css('/wiki/css/main.css');
		echo $this->Html->css('/wiki/css/sprites/icons-16');
		echo $this->Html->css('/wiki/css/sprites/bootstrap-icon-cus');

		// At firt: requirejs and jquery
		echo $this->Html->script('/wiki/js/require-jquery.js', array(
			'data-main' => $this->Html->url('/wiki/js/main'),
		));

		// Rest of scripts
		echo $this->Html->script('/wiki/lib/bootstrap/js/bootstrap.min.js');
		echo $scripts_for_layout;
		?>
	</head>
	<body>
		<?= $this->element('Wiki.navbar') ?>
		<div class="page-wrapper">
			<div class="container">
				<?= $this->Session->flash(); ?>
				<?= $content_for_layout ?>
			</div>
		</div>
		<?= $this->element('Wiki.footer') ?>
	</body>
</html>