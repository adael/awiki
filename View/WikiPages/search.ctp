<div class="page-header">
	<h1><?= __('Search results') ?></h1>
</div>

<?php if(empty($results)): ?>

	<blockquote>
		<p>Your search did not match any page</p>
		<small>The wiki search system</small>
	</blockquote>

<?php else: ?>

	<?php foreach($results as $page): ?>
		<h2><?= $this->Html->link($page['WikiPage']['title'], array('action' => 'view', $page['WikiPage']['alias'])) ?></h2>
		<p>
			<?php
			$content = strip_tags($page['WikiPage']['content']);
			$snippets = $this->TextSearch->extractSearchResults($content, $words, 40);
			foreach($snippets as $snippet){
				echo $this->Html->tag('span', $snippet['text'], array(
					'title' => __('Matched words: %s', join(', ', $snippet['matchedWords'])),
					'class' => "hover-highlight"
				));
			}
			?>
		</p>
	<?php endforeach; ?>

<?php endif; ?>