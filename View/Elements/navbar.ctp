<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<?php
			$img = $this->Html->image('/wiki/img/awiki_46x20.png', array('alt' => __('AdaWiki 2', true)));
			echo $this->Html->link($img, '/wiki/', array(
				'escape' => false,
				'class' => 'brand',
			));

			if(!empty($MainWikiMenu)){
				$this->Wiki->renderMainMenu($MainWikiMenu);
			}
			?>

			<div class="pull-right">
				<form class="navbar-search pull-left" method="get" action="<?= $this->Html->url(array('controller' => 'wiki_pages', 'action' => 'search')) ?>">
					<input name="q" type="text" class="search-query span2" placeholder="<?= __('Search') ?>" value="<?= @$this->params->query['q'] ?>">
				</form>

				<ul class="nav">
					<li class="dropdown">
						<a href="#"
						   class="dropdown-toggle"
						   data-toggle="dropdown">
							Page
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
							<li><a href="#"><i class="icon-trash"></i> Delete</a></li>
							<li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
							<li class="divider"></li>
							<li><a href="#"><i class="i"></i> Make admin</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#"
						   class="dropdown-toggle"
						   data-toggle="dropdown">
							Site
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
							<li><a href="#"><i class="icon-trash"></i> Delete</a></li>
							<li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
							<li class="divider"></li>
							<li><a href="#"><i class="i"></i> Make admin</a></li>
						</ul>
					</li>
				</ul>


			</div>





		</div>
	</div>
</div>

