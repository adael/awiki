<div class="btn-group">
	<a href="<?= $this->Html->url(array('action' => 'edit', $row['WikiMenu']['id'])) ?>"
	   class="btn btn-mini">
		<i class="icon-pencil"></i>
		<?= __('Edit') ?>
	</a>
	<button
		type="button"
		class="btn btn-mini"
		data-confirm="<?= __('Delete this menu') ?>"
		data-url="<?= $this->Html->url(array('action' => 'delete', $row['WikiMenu']['id'])) ?>"
		title="<?= __('Delete menu') ?>">
		<i class="icon-trash"></i>
	</button>

	<?php if($row['WikiMenu']['type'] == 'page'): ?>
		<a href="<?= $this->Html->url(array('controller' => 'WikiPages', 'action' => 'view', $row['WikiMenu']['page_alias'])) ?>"
		   class="btn btn-mini">
			<i class="icon-file"></i>
			<?= __('View page') ?>
		</a>
	<?php elseif($row['WikiMenu']['type'] == 'link'): ?>
		<a href="<?= $this->Html->url($row['WikiMenu']['link_url']) ?>"
		   class="btn btn-mini"
		   target="_blank">
			<i class="icon-globe"></i>
		</a>
	<?php endif; ?>
</div>