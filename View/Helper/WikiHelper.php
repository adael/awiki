<?php

/**
 * @property HtmlHelper $Html
 */
class WikiHelper extends AppHelper {

	public $helpers = array('Html');

	/**
	 * Process wiki page content for formating with markdown and create links
	 * @param string $content
	 * @param array $options
	 * 		links: true for replacing links
	 * 		parser: to choose the parser
	 */
	function render_content(&$content, array $options = array()) {

		$options = array_merge(array('links' => true, 'parser' => 'markdown'), $options);

		switch($options['parser']){
			case 'markdown':
				App::import('Vendor', 'Wiki.Markdown/markdown');
				$content = Markdown($content);
				break;
		}

		if($options['links']){
			$pat = '/\[([' . WikiUtil::WIKI_PAGE_ALIAS_ALLOWED_CHARS . ']+)\]/iU';
			$content = preg_replace_callback($pat, array($this, '__link_callback'), $content);
		}

		echo $content;
	}

	/**
	 * callback for preg_replace_callback
	 * @param array $matches
	 * @return string to replace with matches
	 */
	function __link_callback($matches) {
		return $this->Html->link($matches[1], array(
				'controller' => 'wiki_pages',
				'action' => 'view',
				WikiUtil::encode_alias($matches[1])
			));
	}

	function generateMenuLink($menu) {
		switch($menu['link_type']){
			case 'folder':
				return $this->Html->link($menu['title'], '#', array(
						'class' => 'dropdown-toggle',
						'data-toggle' => 'dropdown'
					));
			case 'page':
				return $this->__pageLink($menu);
			case 'internal':
				return $this->__urlLink($menu);
			case 'external':
				return $this->__urlLink($menu, true);
		}
	}

	private function __pageLink($menu) {
		$options = array('target' => '_self');
		if(isset($this->_View->viewVars['alias'])){
			if($this->_View->viewVars['alias'] === $menu['link']){
				$options['class'] = 'active';
			}
		}
		return $this->Html->link($menu['title'], array('controller' => 'wiki_pages', 'action' => 'view', $menu['link']), $options);
	}

	private function __urlLink($menu, $external = false) {
		$options = array('target' => '_self');
		if($external){
			$options['target'] = '_blank';
		}
		return $this->Html->link($menu['title'], $menu['link'], $options);
	}

}