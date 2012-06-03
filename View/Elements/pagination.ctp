<div class='pagination pagination-centered cake-pagination'>
	<ul>
		<?php
		$params = $this->Paginator->params();
		if($params['prevPage']){
			echo $this->Paginator->prev('&laquo;', array(
				'tag' => 'li',
				'escape' => false
			));
		}
		echo $this->Paginator->numbers(array(
			'tag' => 'li',
			'first' => 1,
			'last' => 1,
			'separator' => false,
			'ellipsis' => false,
			'currentClass' => 'active',
		));
		if($params['nextPage']){
			echo $this->Paginator->next('&raquo;', array(
				'tag' => 'li',
				'escape' => false
			));
		}
		?>
	</ul>
</div>