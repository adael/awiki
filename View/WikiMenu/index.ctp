<?php

App::uses('WikiMenuButtonRenderer', 'Wiki.Lib/Ui/');

$columns = array(
	array(
		'name' => 'Menu.title',
		'text' => __('Title'),
	),
	array(
		'name' => 'Menu.link',
		'text' => __('Link'),
	),
	array(
		'name' => 'Menu.link_type',
		'text' => __('Link type'),
		'map' => $linkTypes,
	),
	array(
		'name' => 'Menu.class',
		'text' => __('Class'),
		'map' => $classes,
	),
	array(
		'name' => 'Menu.order',
		'text' => __('Order'),
		'td' => array('align' => 'center'),
	),
	array(
		'text' => __('Actions'),
		'td' => array('align' => 'left', 'width' => '56'),
		'renderer' => new WikiMenuButtonRenderer($this->Html),
	),
);

echo $this->Html->tag('h1', __('Manage menus'));
$this->WikiDatagrid->render($columns, $items);
?>
<hr/>
<div class='pagination'>
	<?php
	if($this->Paginator->hasPrev()){
		echo $this->Paginator->prev($this->Html->image('icons/axialis/web20/rounded/Grey/16x16/Arrow2 Left.png'), array('escape' => false));
	}
	echo $this->Paginator->numbers();
	if($this->Paginator->hasNext()){
		echo $this->Paginator->next($this->Html->image('icons/axialis/web20/rounded/Grey/16x16/Arrow2 Right.png'), array('escape' => false));
	}
	?>
</div>