<?php

echo $this->Html->link('', array('action' => 'edit', $row['WikiMenu']['id']), array(
	'class' => 'icon-16-Write',
	'title' => __('Edit menu'),
));

echo " ";

echo $this->Html->link('', array('action' => 'delete', $row['WikiMenu']['id']), array(
	'class' => 'icon-16-Trash',
	'title' => __('Delete menu'),
	'data-confirm' => __('Delete this menu?'),
));

if($row['WikiMenu']['type'] == 'page'){
	echo " ";
	echo $this->Html->link('', array('action' => 'edit', $row['WikiMenu']['page_alias']), array(
		'class' => 'icon-16-Write2',
		'title' => __('Edit page'),
	));
}elseif($row['WikiMenu']['type'] == 'link'){
	echo " ";
	echo $this->Html->link('', $row['WikiMenu']['link_url'], array(
		'target' => '_blank',
		'class' => 'icon-16-Link',
		'title' => __('Go to menu'),
	));
}