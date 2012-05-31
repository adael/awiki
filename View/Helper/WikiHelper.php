<?php

class WikiHelper extends AppHelper {

	var $helpers = array('Html');

	/**
	 * @var HtmlHelper
	 */
	var $Html;

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
		return $this->Html->link($matches[1], "/wiki/pages/view/" . WikiUtil::encode_alias($matches[1]));
	}

}