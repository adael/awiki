<div class="page-header">
	<h1><?= __('Manage menus') ?></h1>
</div>
<form method="post" class="well form-inline">
	<div class="pull-left">
		<input type="text" name="search[caption]" value="<?= $this->Search->get('caption') ?>" placeholder="<?= __('Search by title') ?>" />
		<?php
		echo $this->Form->input('search.type', array(
			'div' => false,
			'label' => false,
			'value' => $this->Search->get('type'),
			'options' => array('' => __('Search by type')) + $WikiMenuTypes,
		));
		?>
	</div>
	<div class="btn-group pull-right">
		<input class="btn btn-small btn-primary" type="submit" value="<?= __('Search') ?>"/>
		<input class="btn btn-small" type="submit" name="search[reset]" value="<?= __('Reset') ?>"/>
	</div>
</form>
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
		'text' => __('Page alias or Link'),
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
		'td' => array('align' => 'left', 'width' => 180, 'nowrap' => 'nowrap'),
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
<hr/>
<a href="<?= $this->Html->url(array('action' => 'add')) ?>" class="btn">
	<i class="icon-cus-add"></i>
	<?= __('Add menu'); ?>
</a>

<div class="modal fade hide" id="WikiMenuDeleteDialog" style="display: none;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3><?= __('Attention:') ?></h3>
	</div>
	<div class="modal-body">
		<p><?= __('Do you want to delete this menu?') ?></p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-danger" data-action="delete"><?= __('Delete') ?></a>
		<a href="#" class="btn" data-dismiss="modal"><?= __('Cancel') ?></a>
	</div>
</div>

<script>require(["wiki/menu/index"]);</script>