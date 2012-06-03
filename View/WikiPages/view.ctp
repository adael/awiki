<?php
extract($page['WikiPage'], EXTR_REFS);
$this->Html->css('Wiki./lib/highlight/styles/default.css', 'stylesheet', array('inline' => false));
$this->Html->script('Wiki./lib/highlight/highlight.pack', array('inline' => false));
echo $this->Html->scriptBlock("
	hljs.tabReplace = '    ';
	hljs.initHighlightingOnLoad();
");

echo $this->element('Wiki.WikiPages/fold_menu');
?>
<div class="content-body">
	<div class='page-header'>
		<h1><?php echo $title ?></h1>
	</div>
	<?php
	$this->Wiki->render_content($content);
	?>
</div>

<hr/>

<div class='well' style="padding: 9px;">
	<?php
	$bytes = WikiUtil::format_bytes($content_length, 'array');
	$bytes = $bytes['rounded'] . "<b>" . $bytes['unit'] . "</b>";
	printf(__('Word count: %s.'), $content_numwords);
	printf(__('Size: %s. Last modified %s'), $bytes, strftime("%c", strtotime($modified)));
	?>
</div>