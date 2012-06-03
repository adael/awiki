<div class="wiki-page-buttons wiki-fold-menu">
	<?php
	if(!$page['WikiPage']['locked']){
		echo $this->Html->link($this->Html->tag('span', __('Edit this page')), array('action' => 'edit', $alias), array(
			'class' => 'wiki-fold-button wiki-fold-edit',
			'escape' => false,
		));
		echo $this->Html->link($this->Html->tag('span', __('Lock page')), array('action' => 'lock', $alias), array(
			'class' => 'wiki-fold-button wiki-fold-lock',
			'escape' => false,
		));
		echo $this->Html->link($this->Html->tag('span', __('Delete this page')), array('action' => 'delete', $alias), array(
			'class' => 'wiki-fold-button wiki-fold-delete',
			'escape' => false,
		));
	}else{
		echo $this->Html->link($this->Html->tag('span', __('Unlock page')), array('action' => 'unlock', $alias), array(
			'class' => 'wiki-fold-button wiki-fold-unlock',
			'escape' => false,
		));
	}
	echo $this->Html->link($this->Html->tag('span', __('Add menú')), array('controller' => 'wiki_menu', 'action' => 'add'), array(
		'class' => 'wiki-fold-button wiki-fold-add',
		'escape' => false,
	));
	echo $this->Html->link($this->Html->tag('span', __('Manage menú')), array('controller' => 'wiki_menu', 'action' => 'index'), array(
		'class' => 'wiki-fold-button wiki-fold-manage',
		'escape' => false,
	));
	echo $this->Html->link($this->Html->tag('span', __('Manage pages')), array('action' => 'add'), array(
		'class' => 'wiki-fold-button wiki-fold-pages',
		'escape' => false,
	));
	?>
	<br clear="all"/>
</div>