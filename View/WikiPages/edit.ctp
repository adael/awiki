<?php
/* @var $this View */
$this->Html->css('/wiki/css/wiki_markitup_theme/style', 'stylesheet', array('inline' => false));
$this->Html->css('/wiki/lib/markitup/markitup/sets/markdown/style', 'stylesheet', array('inline' => false));
$this->Html->script('/wiki/lib/markitup/markitup/jquery.markitup', array('inline' => false));
$this->Html->script('/wiki/lib/markitup/markitup/sets/markdown/set', array('inline' => false));
?>
<div class="page-header">
	<h1><?= __('Editing') ?>: <?= ($this->request->data('WikiPage.title') ? : __('New page')) ?></h1>
</div>
<fieldset>
	<?php
	/* @var $form FormHelper */
	echo $this->Form->create(null, array(
		'url' => "/" . $this->request->url,
	));

	echo $this->Form->error('id');
	echo $this->Form->error('alias');

	echo $this->Form->input('title', array(
		'label' => false,
		'placeholder' => __('Title'),
		'class' => 'span12',
		'default' => Inflector::humanize($alias),
	));
	echo $this->Form->input('content', array(
		'id' => 'txtContentEdit',
		'data-preview-url' => $this->Html->url(array('action' => 'ajax_preview')),
		'label' => false,
		'placeholder' => __('Page content'),
		'class' => 'span12',
		'rows' => '15',
	));
	echo $this->Form->input('alias', array(
		'label' => __('Alias (is obtained automatically from the title)'),
		'class' => 'span5',
		'div' => array('class' => 'input-append'),
		'readonly' => true,
		'onblur' => '$(this).prop(\'readonly\', true);',
		'after' => '<a href="#" onclick="$(this).prev(\'input\').prop(\'readonly\', false).select().focus();" class="btn"><i class="icon-edit"></i></a>',
	));

	echo $this->Form->input('tags', array(
		'label' => __('Tags (use semicolon ";" to separate tags)'),
		'class' => 'span5',
	));
	?>

	<hr/>

	<a href="<?= $this->Wiki->referer(array('action' => 'view', $alias)) ?>" class="btn btn-danger">
		<i class="icon-chevron-left icon-white"></i>
		<?= __('Cancel') ?>
	</a>

	<button type="submit" class="btn btn-success">
		<i class="icon-ok-sign icon-white"></i>
		<?= __('Save '); ?>
	</button>

	<?= $this->Form->end(); ?>
</fieldset>
<script>require(["wiki/page/edit"]);</script>
