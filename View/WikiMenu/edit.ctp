<?php
$this->Html->css('/wiki/css/jqueryui_custom_theme/jquery-ui-1.8.21.custom', null, array('inline' => false));
?>
<div class="page-header">
	<h1><?= $this->request->data('WikiMenu.id') ? __('Edit menu') : __('Create menu') ?></h1>
</div>
<fieldset>
	<?php
	echo $this->Form->create('WikiMenu', array(
		'url' => "/" . $this->request->url,
		'class' => 'big-form',
	));
	echo $this->Form->hidden('id');
	echo $this->Form->error('id');

	echo $this->Form->input('caption', array(
		'label' => __('Caption'),
		'size' => 50,
	));
	?>

	<div class="row">
		<div class="span3">
			<?php
			echo $this->Form->input('type', array(
				'label' => __('Type'),
				'options' => array('' => __('-')) + (array) $WikiMenuTypes,
			));
			?>
		</div>
		<div class="span4">
			<dl>
				<dt><?= __('Navigation menu') ?></dt>
				<dd><?= __('Indicates that menu shows in top navigation bar') ?></dd>
				<dt><?= __('Page') ?></dt>
				<dd><?= __('Indicates that menu links to wiki page') ?></dd>
				<dt><?= __('Link') ?></dt>
				<dd><?= __('Indicates that menu links to external page') ?></dd>
			</dl>
		</div>
	</div>

	<?php
	echo $this->Form->input('page_alias', array(
		'div' => array(
			'id' => 'divPageAlias',
			'style' => 'display: none;'
		),
		'data-source' => $this->Html->url(array(
			'controller' => 'WikiPages',
			'action' => 'autocomplete',
		)),
		'type' => 'text',
		'label' => __('Page alias'),
	));

	echo $this->Form->input('link_url', array(
		'div' => array(
			'id' => 'divLinkUrl',
			'style' => 'display: none;'
		),
		'type' => 'text',
		'label' => __('Link url'),
	));
	?>


	<div class="row">
		<div class="span1">
			<?php
			echo $this->Form->input('order', array(
				'label' => __('Order'),
				'type' => 'text',
				'class' => 'span1',
				'maxlength' => 10,
			));
			?>
		</div>
		<div class="span4">
			<dl>
				<dt><?= __('Order') ?></dt>
				<dd><?= __('Indicates the menu position order') ?></dd>
			</dl>
		</div>
	</div>

	<hr/>
	<a href="<?= $this->Html->url(array('action' => 'index')) ?>" class="btn btn-danger">
		<i class="icon-chevron-left icon-white"></i>
		<?= __('Cancel') ?>
	</a>

	<button type="submit" class="btn btn-success">
		<i class="icon-ok-sign icon-white"></i>
		<?= __('Save') ?>
	</button>

	<?= $this->Form->end(); ?>
</fieldset>
<?php
echo $this->Html->scriptBlock("require(['wiki/menu/edit'])");