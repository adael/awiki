<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Awiki</title>
		<?php
		echo $this->Html->css('/wiki/css/preview');
		echo $this->Html->css('/wiki/lib/bootstrap/css/bootstrap.min.css');
		echo $scripts_for_layout;
		?>
	</head>
	<body>
		<?php echo $content_for_layout ?>
	</body>
</html>