<?php
/* @var $html HtmlHelper */
$this->Html->css('Wiki./lib/markitup/markitup/skins/simple/style', 'stylesheet', array('inline' => false));
$this->Html->css('Wiki./lib/markitup/markitup/sets/markdown/style', 'stylesheet', array('inline' => false));
$this->Html->script('Wiki./lib/markitup/markitup/jquery.markitup', array('inline' => false));
$this->Html->script('Wiki./lib/markitup/markitup/sets/markdown/set', array('inline' => false));

$previewUrl = $this->Html->url(array('action' => 'preview'));
$this->Html->scriptBlock("	$(document).ready(function(){
		mySettings.previewParserPath = '{$previewUrl}';
		$('#txtContentEdit').markItUp(mySettings).focus();
	});", array('inline' => false));
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
		'label' => __('Title'),
		'class' => 'span8',
		'size' => 80,
		'default' => ucfirst(str_replace('_', ' ', $alias)),
	));

	echo $this->Form->input('content', array(
		'label' => __('Content'),
		'class' => 'span8',
		'id' => 'txtContentEdit',
		'rows' => '15',
		'cols' => '80',
	));

	echo $this->Form->input('Menu.id', array(
		'label' => __('Show in Menu'),
		'options' => $menuTree,
		'escape' => false,
	));
	?>
	<div class="form-actions">
		<button type="submit" class="btn btn-large"><i class="icon-16-Save"></i> <?php echo __('Save'); ?></button>
	</div>
	<?= $this->Form->end(); ?>
</fieldset>