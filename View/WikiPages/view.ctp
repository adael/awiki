<?php
extract($page['Page'], EXTR_REFS);
$this->Html->css('/js/highlight/styles/default.css', 'stylesheet', array('inline' => false));
$this->Html->script('highlight/highlight.pack', array('inline' => false));
echo $this->Html->scriptBlock("
	hljs.tabReplace = '    ';
	hljs.initHighlightingOnLoad();
");
?>
<div class="wiki-page-buttons wiki-fold-menu">
	<?php
	if(!$locked){
		echo $this->Html->link($this->Html->tag('span', __('Edit this page')), '/wiki/edit/' . $alias, array(
			'class' => 'wiki-fold-button wiki-fold-edit',
			'escape' => false,
		));
		echo $this->Html->link($this->Html->tag('span', __('Lock page')), '/wiki/lock/' . $alias, array(
			'class' => 'wiki-fold-button wiki-fold-lock',
			'escape' => false,
		));
		echo $this->Html->link($this->Html->tag('span', __('Delete this page')), '/wiki/delete/' . $alias, array(
			'class' => 'wiki-fold-button wiki-fold-delete',
			'escape' => false,
		));
	}else{
		echo $this->Html->link($this->Html->tag('span', __('Unlock page')), '/wiki/unlock/' . $alias, array(
			'class' => 'wiki-fold-button wiki-fold-unlock',
			'escape' => false,
		));
	}
	echo $this->Html->link($this->Html->tag('span', __('Add menú')), '/wiki_menu/add', array(
		'class' => 'wiki-fold-button wiki-fold-add',
		'escape' => false,
	));
	echo $this->Html->link($this->Html->tag('span', __('Manage menú')), '/wiki_menu/index', array(
		'class' => 'wiki-fold-button wiki-fold-manage',
		'escape' => false,
	));
	echo $this->Html->link($this->Html->tag('span', __('Manage pages')), '/wiki/index', array(
		'class' => 'wiki-fold-button wiki-fold-pages',
		'escape' => false,
	));
	?>
	<br clear="all"/>
</div>

<div class="content-body">
	<div class='content-header'>
		<h1 class='caption'><?php echo $title ?></h1>
	</div>
	<?php
	$this->Wiki->render_content($content);
	?>
</div>

<hr/>
<div class='content-footer'>
	<?php
	$bytes = WikiUtil::format_bytes($content_length, 'array');
	$bytes = $bytes['rounded'] . "<b>" . $bytes['unit'] . "</b>";
	printf(__('Word count: %s.'), $content_numwords);
	printf(__('Size: %s. Last modified %s'), $bytes, strftime("%c", strtotime($modified)));
	?>
</div>