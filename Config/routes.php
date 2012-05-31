<?php

Router::connect(
		'/wiki/*', array('plugin' => 'wiki', 'controller' => 'wiki_pages')
);