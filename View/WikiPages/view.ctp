<?php
extract($page['WikiPage'], EXTR_REFS);
$this->Html->css('Wiki./lib/highlight/styles/default.css', 'stylesheet', array('inline' => false));
$this->Html->script('Wiki./lib/highlight/highlight.pack', array('inline' => false));
echo $this->Html->scriptBlock("
	hljs.tabReplace = '    ';
	hljs.initHighlightingOnLoad();
");
?>
<div class="content-body">
	<div class='page-header'>
		<h1><?php echo $title ?></h1>
	</div>
	<?php
	$this->Wiki->render_content($content);
	?>
</div>

<hr />

<div>
	<?php
	$bytes = WikiUtil::format_bytes($content_length, 'array');
	$bytes = $bytes['rounded'] . $bytes['unit'];
	$lastModified = strftime("%c", strtotime($modified));
	echo __('Word count:');
	echo " <b>" . $content_numwords . "</b>. ";
	echo __('Size:');
	echo " <b>{$bytes}</b>. ";
	echo __('Last modified:');
	echo " <b>{$lastModified}</b>.";
	?>

	<div class="pull-right">
		<div class="btn-group">

			<?php if(!$page['WikiPage']['locked']): ?>
				<a class="btn"
				   href="<?= $this->Html->url(array('action' => 'edit', $alias)); ?>"
				   title="<?= __('Edit page'); ?>">
					<i class="icon-pencil"></i>
					<span><?= __('Edit') ?></span>
				</a>
				<a class="btn"
				   href="<?= $this->Html->url(array('action' => 'lock', $alias)); ?>"
				   title="<?= __('Lock page'); ?>">
					<i class="icon-lock"></i>
					<span><?= __('Lock') ?></span>
				</a>
			<?php endif; ?>

			<a class="btn" target="_blank"
			   href="<?= $this->Html->url(array('action' => 'print_view', $alias)); ?>"
			   title="<?= __('Print page'); ?>">
				<i class="icon-print"></i>
				<span><?= __('Print') ?></span>
			</a>

		</div>
	</div>

</div>