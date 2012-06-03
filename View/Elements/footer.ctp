<div class="container">

	<div class="row">

		<div class="span8">
			<?php echo __("AdaWiki2 by ") ?> <a href="mailto:adaelxp@gmail.com">Carlos Gant</a>
			|
			<?php
			echo '<a href="http://www.cakephp.org" target="_blank">';

			echo $this->Html->image('cake.icon.png', array(
				'alt' => __('Powered by CakePHP'),
				'target' => '_blank',
			));
			echo $this->Html->image('cake.power.gif', array(
				'alt' => __('Powered by CakePHP'),
				'target' => '_blank',
			));
			echo '</a>';
			?>
			|
			<a href="http://www.axialis.com/free/icons" target="_blank">Icons</a> by <a href="http://www.axialis.com" target="_blank">Axialis Team</a>
		</div>

		<div class="span4">
			<?php
			if(isset($alias) && $this->request->params['controller'] == 'wiki_pages' && $this->request->params['action'] == 'view'){
				echo $this->Html->link(__('Print this page'), array('action' => 'print_view', $alias), array(
					'class' => 'wiki-print-page',
				));
				echo " - ";
				echo __('Font:');
				echo '<a href="#" id="font-bigger">A</a> / <a href="#" id="font-smaller">a</a> / <a href="#" id="font-normal">' . __('Normal') . '</a>';
			}
			?>
		</div>

	</div>

</div>