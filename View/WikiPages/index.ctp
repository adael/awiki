<div class="page-header">
	<h1><?= __('Manage pages') ?></h1>
</div>
<form method="post" class="well form-inline">
	<div class="pull-left">
		<input type="text" name="search[title]" value="<?= $this->Search->get('title') ?>" placeholder="<?= __('Search by title') ?>" />
		<label class="checkbox">
			<input type="checkbox" name="search[locked]" <?= $this->Search->get('locked') ? 'checked' : '' ?> />
			<?= __('Locked') ?>
		</label>
	</div>
	<div class="btn-group pull-right">
		<input class="btn btn-small btn-primary" type="submit" value="<?= __('Search') ?>"/>
		<input class="btn btn-small" type="submit" name="search[reset]" value="<?= __('Reset') ?>"/>
	</div>
</form>
<?php
App::uses('WikiPageButtonRenderer', 'Wiki.Lib/Ui/');

$columns = array(
	array(
		'name' => 'WikiPage.title',
		'text' => __('Title'),
	),
	array(
		'name' => 'WikiPage.content_numwords',
		'text' => __('Num. Words'),
		'td' => array('align' => 'center'),
	),
	array(
		'name' => 'WikiPage.content_length',
		'text' => __('Content length'),
		'td' => array('align' => 'center'),
	),
	array(
		'name' => 'WikiPage.locked',
		'text' => __('Locked'),
		'td' => array('align' => 'center'),
		'map' => array(
			0 => '-',
			1 => __('Yes'),
		),
	),
	array(
		'name' => 'WikiPage.created',
		'text' => __('Created'),
		'td' => array('align' => 'center'),
	),
	array(
		'text' => __('Actions'),
		'td' => array('align' => 'left', 'nowrap', 'width' => 90),
		'element' => 'Wiki.WikiPages/index/datagrid_actions',
	),
);
$this->WikiDatagrid->render($columns, $WikiPages, array(
	'width' => '100%',
	'class' => 'table table-striped table-outline'
));
?>
<hr/>
<?= $this->element('Wiki.pagination') ?>
<div class="form-actions">
	<a href="<?= $this->Html->url(array('action' => 'edit')) ?>" class="btn">
		<i class="icon-cus-add"></i>
		<?= __('Add'); ?>
	</a>
</div>

<div class="modal hide" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Confirm deletion</h3>
	</div>
	<div class="modal-body">
		<p>{}</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		<a href="#" class="btn btn-primary">Save changes</a>
	</div>
</div>