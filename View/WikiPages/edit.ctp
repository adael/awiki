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
		'label' => false,
		'placeholder' => __('Title'),
		'class' => 'span10',
		'default' => Inflector::humanize($alias),
	));

	echo $this->Form->input('content', array(
		'label' => false,
		'placeholder' => __('Page content'),
		'class' => 'span10',
		'id' => 'txtContentEdit',
		'rows' => '15',
	));

	echo $this->Form->input('alias', array(
		'label' => __('Alias'),
		'class' => 'span5',
		'div' => array('class' => 'input-append'),
		'readonly' => true,
		'onblur' => '$(this).prop(\'readonly\', true);',
		'after' => '<a href="#" onclick="$(this).prev(\'input\').prop(\'readonly\', false).select().focus();" class="btn"><i class="icon-edit"></i></a>',
	));
	?>
	<div class="form-actions form-actions-custom">
		<?= $this->Html->link('<i class = "icon-chevron-left"></i> ', array('action' => 'view', $alias), array('class' => 'btn btn-large', 'escape' => false)) ?>
		<button type="submit" class="btn btn-large btn-success"><?php echo __('Save '); ?></button>
	</div>
	<?= $this->Form->end(); ?>
</fieldset>