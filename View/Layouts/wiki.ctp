<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>AdaWiki2</title>
		<link rel="stylesheet/less" type="text/css" href="<?= $this->Html->url('/wiki/css/wiki.less') ?>">
		<?php
		echo $this->Html->script('Wiki./lib/less-1.3.0.min.js');

		#echo $this->Html->css('Wiki./lib/bootstrap/css/bootstrap.min.css');
		echo $this->Html->css('Wiki./css/sprites/icons-16');

		echo $this->Html->script('Wiki./lib/jquery.min.js');
		#echo $this->Html->script('Wiki./lib/bootstrap/js/bootstrap.min.js');

		echo $this->Html->script('Wiki./js/wiki.js');
		echo $scripts_for_layout;
		?>
	</head>
	<body>
		<?php
		echo $this->Session->flash();

		// IE Advise
		if(isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){
			echo $this->element('wiki.noie_advise');
		}
		?>
		<div class="page-wrapper">
			<?php
			echo $this->Html->link($this->Html->image('Wiki./img/AdaWiki2.png', array('alt' => 'AdaWiki2 - The Wiki')), '/wiki/', array(
				'escape' => false,
				'class' => 'page-logo',
			));
			?>
			<div class="page-menu">
				<div class="main-menu">
					<?php
					if(!empty($mainmenu)){
						foreach($mainmenu as $_menuitem){
							$_menuitem = $_menuitem['WikiMenu'];
							$_active = '';
							$_target = '_self';
							switch($_menuitem['link_type']){
								case 'page':
									$_link = "/wiki/pages/view/{$_menuitem['link']}";
									if(isset($alias) && $_menuitem['link'] == $alias){
										$_active = ' active';
									}
									break;
								case 'internal':
									$_link = $this->Html->url($_menuitem['link']);
									break;
								case 'external':
									$_link = $_menuitem['link'];
									$_target = '_blank';
									break;
							}
							echo $this->Html->link($_menuitem['title'], $_link, array(
								'class' => $_menuitem['class'] . $_active,
								'target' => $_target,
							));
						}
					}
					?>
				</div>

				<div class="page-menu-credits">
					<p>
						<a href="http://www.cakephp.org" target="_blank">
							<?php
							echo $this->Html->image('cake.icon.png', array(
								'alt' => __('Powered by CakePHP'),
								'target' => '_blank',
							));
							echo $this->Html->image('cake.power.gif', array(
								'alt' => __('Powered by CakePHP'),
								'target' => '_blank',
							));
							?>
						</a>
					</p>
					<p>
						<a href="http://www.axialis.com/free/icons" target="_blank">Icons</a> by <a href="http://www.axialis.com" target="_blank">Axialis Team</a>
					</p>
					<p>
						<a href="http://code.google.com/p/sexybuttons/" target="_blank">Buttons by Richard Davies</a>
					</p>
					<p>
						<?php
						$_s = $this->Html->image('Wiki./img/lesscss.png', array(
							'alt' => __('Powered by Lesscss'),
								));
						echo $this->Html->link($_s, "http://lesscss.org/", array(
							'target' => '_blank',
							'escape' => false,
						));
						?>
					</p>
				</div>
			</div>
			<div class='page-content'>
				<?php echo $content_for_layout ?>
			</div>
			<div class='page-footer'>
				<div class="page-footer-options">
					<?php
					if(isset($alias) && $this->request->params['controller'] == 'wiki' && $this->request->params['action'] == 'index'){
						echo $this->Html->link(__('Print this page'), '/wiki/pages/printView/' . $alias, array(
							'class' => 'wiki-print-page',
						));
						echo " - ";
						echo __('Font:');
						echo '<a href="#" id="font-bigger">A</a> / <a href="#" id="font-smaller">a</a> / <a href="#" id="font-normal">' . __('Normal') . '</a>';
					}
					?>
				</div>
				<div class="page-footer-credits">
					<?php echo __("AdaWiki2 by ") ?> <a href="mailto:adaelxp@gmail.com">Carlos Gant</a>
				</div>
			</div>
		</div>
	</body>
</html>