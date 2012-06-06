<?php

/**
 * @property HtmlHelper $Html
 */
class WikiHelper extends AppHelper {

	public $helpers = array('Html');

	/**
	 * Copied from Controller
	 * (perhaps cakephp should to move this function (with $default functionality) into CakeRequest)
	 * Returns the referring URL for this request.
	 *
	 * @param string $default Default URL to use if HTTP_REFERER cannot be read from headers
	 * @param boolean $local If true, restrict referring URLs to local server
	 * @return string Referring URL
	 * @link http://book.cakephp.org/2.0/en/controllers.html#Controller::referer
	 */
	public function referer($default = null, $local = false) {
		if($this->request){
			$referer = $this->request->referer($local);
			if($referer == '/' && $default != null){
				return Router::url($default, true);
			}
			return $referer;
		}
		return '/';
	}

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
				Inflector::slug($matches[1])
			));
	}

	function generateMenuLink($menu) {
		switch($menu['type']){
			case 'nav':
				return $this->Html->link($menu['caption'] . ' <b class="caret"></b>', '#', array(
						'class' => 'dropdown-toggle',
						'data-toggle' => 'dropdown',
						'escape' => false,
					));
			case 'page':
				return $this->__pageLink($menu);
			case 'link':
				return $this->__urlLink($menu);
		}
	}

	private function __pageLink($menu) {
		$options = array('target' => '_self');
		if(isset($this->_View->viewVars['alias'])){
			if($this->_View->viewVars['alias'] === $menu['page_alias']){
				$options['class'] = 'active';
			}
		}
		return $this->Html->link($menu['caption'], array('controller' => 'wiki_pages', 'action' => 'view', $menu['page_alias']), $options);
	}

	private function __urlLink($menu, $external = false) {
		$options = array('target' => $menu['link_target']);
		return $this->Html->link($menu['caption'], $menu['link_url'], $options);
	}

}