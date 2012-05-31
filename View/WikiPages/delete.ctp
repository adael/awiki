<?php
echo $this->Html->tag('h1', __('Are you sure you wan to delete this page?'));
echo $this->Form->create(array('class' => 'big-form'));
echo $this->Form->hidden('id');
echo $this->Form->input('title', array(
	'label' => __('Title'),
	'size' => 50,
));
?>
<div style="text-align: right;">
	<a href="<?php echo $this->Html->url('/wiki/pages/index') ?>" class="sexybutton sexysimple sexylarge">
		<span class="cancel"><?php echo __('Cancel'); ?></span>
	</a>
	<button type="submit" class="sexybutton sexysimple sexylarge">
		<span class="delete"><?php echo __('Delete'); ?></span>
	</button>
</div>
<?php
echo $this->Form->end();