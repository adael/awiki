<?php
App::uses('WikiMenuButtonRenderer', 'Wiki.Lib/Ui/');

$columns = array(
	array(
		'name' => 'WikiMenu.title',
		'text' => __('Title'),
	),
	array(
		'name' => 'WikiMenu.link',
		'text' => __('Link'),
	),
	array(
		'name' => 'WikiMenu.link_type',
		'text' => __('Link type'),
		'map' => $linkTypes,
	),
	array(
		'name' => 'WikiMenu.order',
		'text' => __('Order'),
		'td' => array('align' => 'center'),
	),
	array(
		'text' => __('Actions'),
		'td' => array('align' => 'left', 'width' => '56'),
		'renderer' => new WikiMenuButtonRenderer($this->Html),
	),
);

echo $this->Html->tag('h1', __('Manage menus'));
$this->WikiDatagrid->render($columns, $WikiMenus, array(
	'width' => '100%',
	'class' => 'table table-striped table-outline',
));
?>
<hr/>
<div class='pagination pagination-centered cake-pagination'>
	<ul>
		<?php
		$params = $this->Paginator->params();

		if($params['prevPage']){
			echo $this->Paginator->prev('&laquo;', array(
				'tag' => 'li',
				'escape' => false
			));
		}
		echo $this->Paginator->numbers(array(
			'tag' => 'li',
			'first' => 1,
			'last' => 1,
			'separator' => false,
			'ellipsis' => false,
			'currentClass' => 'active',
		));
		if($params['nextPage']){
			echo $this->Paginator->next('&raquo;', array(
				'tag' => 'li',
				'escape' => false
			));
		}
		?>
	</ul>
</div>
<div class="form-actions">
	<a href="<?= $this->Html->url(array('action' => 'add')) ?>" class="btn">
		<i class="icon-cus-add"></i>
		<?= __('Add'); ?>
	</a>
</div>