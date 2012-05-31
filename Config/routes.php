<?php

Router::connect('/wiki/', array('plugin' => 'wiki', 'controller' => 'wiki_pages', 'action' => 'view'));
Router::connect('/wiki/pages/:action/*', array('plugin' => 'wiki', 'controller' => 'wiki_pages'));
Router::connect('/wiki/menus/:action/*', array('plugin' => 'wiki', 'controller' => 'wiki_menu'));
