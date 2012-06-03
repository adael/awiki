<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>AdaWiki2</title>
		<?php
		// Librerias
		echo $this->Html->script('Wiki./lib/jquery.min.js');

		echo $this->Html->script('Wiki./lib/bootstrap/js/bootstrap.min.js');
		echo $this->Html->css('Wiki./lib/bootstrap/css/bootstrap.min.css');
//		echo $this->Html->css('Wiki./lib/bootstrap/css/bootstrap-responsive.min.css');
		// Wiki
		echo $this->Html->css('Wiki./css/wiki.css');
		echo $this->Html->css('Wiki./css/sprites/icons-16');
		echo $this->Html->css('Wiki./css/fold-buttons.css');
		echo $this->Html->css('Wiki./css/sprites/bootstrap-icon-cus');

		echo $this->Html->script('Wiki./js/wiki.js');
		echo $scripts_for_layout;
		?>
	</head>
	<body>

		<?= $this->Session->flash(); ?>

		<?= $this->element('Wiki.navbar') ?>
		<div class="clearfix"></div>

		<div class="page-wrapper">
			<div class="container" style="position: relative;">
				<?= $content_for_layout ?>
			</div>
		</div>

		<div class="clearfix"></div>
		<?= $this->element('Wiki.footer') ?>

	</body>
</html>