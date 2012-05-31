<?php

echo $this->Form->create('Menu', array(
	'url' => "/" . $this->request->params['url']['url'],
	'class' => 'big-form',
));
echo $this->Form->hidden('id');
echo $this->Form->error('id');

echo $this->Form->input('title', array(
	'label' => __('Title'),
	'size' => 50,
));
echo $this->Form->input('link', array(
	'type' => 'text',
	'label' => __('Alias or link'),
));
echo $this->Form->input('link_type', array(
	'label' => __('Link type'),
	'after' => $this->Html->tag('p', __('Page: Alias for wiki page (invalid chars will be removed). Internal: for controllers or plugins. External: for links to other sites.')),
));
echo $this->Form->input('class', array(
	'label' => __('Style'),
));

echo $this->Form->input('order', array(
	'label' => __('Order'),
	'type' => 'text',
	'size' => 11,
	'maxlength' => 11,
));

echo "<div style='text-align: right;'>";
echo $this->Html->link($this->Html->tag('span', __('Cancel'), array('class' => 'cancel')), '/wiki_menu/index', array(
	'class' => 'sexybutton sexysimple sexylarge',
	'escape' => false,
));
echo " ";
echo '<button type="submit" class="sexybutton sexysimple sexylarge"><span class="save">' . __('Save') . '</span></button>';
echo "</div>";
echo $this->Form->end();