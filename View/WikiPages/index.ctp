<?php

App::uses('WikiPageButtonRenderer', 'Wiki.Lib/Ui/');

$columns = array(
	array(
		'name' => 'Page.title',
		'text' => __('Title'),
	),
	array(
		'name' => 'Page.content_numwords',
		'text' => __('Num. Words'),
		'td' => array('align' => 'center'),
	),
	array(
		'name' => 'Page.content_length',
		'text' => __('Content length'),
		'td' => array('align' => 'center'),
	),
	array(
		'name' => 'Page.locked',
		'text' => __('Locked'),
		'td' => array('align' => 'center'),
	),
	array(
		'name' => 'Page.created',
		'text' => __('Created'),
		'td' => array('align' => 'center'),
	),
	array(
		'text' => __('Actions'),
		'td' => array('align' => 'left', 'width' => '56'),
		'renderer' => new WikiPageButtonRenderer($this->Html),
	),
);

echo $this->Html->tag('h1', __('Manage pages'));
$this->WikiDatagrid->render($columns, $WikiPages);
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
