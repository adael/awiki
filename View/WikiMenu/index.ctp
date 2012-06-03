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
		'td' => array('align' => 'left', 'nowrap' => 'nowrap'),
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
<?= $this->element('Wiki.pagination') ?>
<div class="form-actions">
	<a href="<?= $this->Html->url(array('action' => 'add')) ?>" class="btn">
		<i class="icon-cus-add"></i>
		<?= __('Add'); ?>
	</a>
</div>