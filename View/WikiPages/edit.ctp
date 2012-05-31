<?php
/* @var $html HtmlHelper */
$this->Html->css('/js/markitup/markitup/skins/simple/style', 'stylesheet', array('inline' => false));
$this->Html->css('/js/markitup/markitup/sets/markdown/style', 'stylesheet', array('inline' => false));
$this->Html->script('markitup/markitup/jquery.markitup', array('inline' => false));
$this->Html->script('markitup/markitup/sets/markdown/set', array('inline' => false));

$this->Html->scriptBlock("	$(document).ready(function(){
		mySettings.previewParserPath = '{$this->request->webroot}/wiki/preview';
		$('#txtContentEdit').markItUp(mySettings).focus();
	});", array('inline' => false));

/* @var $form FormHelper */
echo $this->Form->create(null, array(
	'url' => "/" . $this->request->params['url']['url'],
	'class' => 'big-form',
));

echo $this->Form->error('id');
echo $this->Form->error('alias');

echo $this->Form->input('title', array(
	'label' => __('Title'),
	'class' => 'caption',
	'size' => 50,
	'default' => ucfirst(str_replace('_', ' ', $alias)),
));

echo $this->Form->input('content', array(
	'label' => __('Content'),
	'class' => 'caption',
	'id' => 'txtContentEdit',
	'rows' => '15',
	'cols' => '80',
));

echo $this->Form->hidden('Menu.id');

echo $this->Form->input('Menu.pin', array(
	'label' => __('Pin in site menu'),
	'type' => 'checkbox',
	'onclick' => '$("#menuStyleDiv").toggle(this.checked)',
));
echo $this->Form->input('Menu.class', array(
	'label' => __('Menu style'),
	'options' => $classes,
	'div' => array(
		'id' => 'menuStyleDiv',
		'style' => !empty($this->request->data['Menu']['pin']) ? '' : 'display: none;',
	),
));
?>
<div style="text-align: right;">
	<button type="submit" class="sexybutton sexysimple sexylarge"><span class="save"><?php echo __('Save'); ?></span></button>
</div>
<?php
echo $this->Form->end();