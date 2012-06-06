<div class="page-header">
	<h1><?= __('Manage menus') ?></h1>
</div>
<?php
App::uses('WikiMenuButtonRenderer', 'Wiki.Lib/Ui/');

$columns = array(
	array(
		'name' => 'WikiMenu.caption',
		'text' => __('Caption'),
	),
	array(
		'name' => 'WikiMenu.type',
		'text' => __('Type'),
		'map' => $WikiMenuTypes,
	),
	array(
		'name' => 'WikiMenu.order',
		'text' => __('Order'),
		'td' => array('align' => 'center'),
	),
	array(
		'text' => __('Link'),
		'value' => function($col, $row){
			if($row['WikiMenu']['type'] === 'page'){
				return $row['WikiMenu']['page_alias'];
			}elseif($row['WikiMenu']['type'] === 'link'){
				return $row['WikiMenu']['link_url'];
			}else{
				return '-';
			}
		},
	),
	array(
		'text' => __('Actions'),
		'td' => array('align' => 'left', 'nowrap' => 'nowrap'),
		'element' => 'Wiki.WikiMenu/index/datagrid_actions',
	),
);

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