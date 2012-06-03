<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<?php
			$img = $this->Html->image('/wiki/img/awiki_46x20.png', array('alt' => __('Awiki', true)));
			echo $this->Html->link($img, '/wiki/', array(
				'escape' => false,
				'class' => 'brand',
			));
			?>

			<ul class="nav nav-pills">
				<?php
				if(!empty($MainWikiMenu)){
					foreach($MainWikiMenu as $row){
						$menu = $row['WikiMenu'];
						echo $this->Html->tag('li', $this->Wiki->generateMenuLink($menu));
					}
				}
				?>
			</ul>

			<div class="pull-right">
				<form class="navbar-search pull-left" method="get" action="<?= $this->Html->url(array('controller' => 'wiki_pages', 'action' => 'search')) ?>">
					<input name="q" type="text" class="search-query span2" placeholder="<?= __('Search') ?>" value="<?= @$this->params->query['q'] ?>">
				</form>
				<ul class="nav nav-pills">
					<li class="dropdown">
						<a href="#"
						   class="dropdown-toggle"
						   data-toggle="dropdown">
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?= $this->Html->url(array('controller' => 'wiki_pages', 'action' => 'index')) ?>">
									<i class="icon-list"></i>
									<?= __('Manage pages') ?>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>