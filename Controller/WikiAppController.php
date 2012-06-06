<?php

/**
 * @property WikiMenu $WikiMenu
 */
class WikiAppController extends AppController {

	public $components = array(
		'Session',
		'DebugKit.Toolbar'
	);
	public $helpers = array('Form', 'Js', 'Wiki.Wiki', 'Wiki.WikiDatagrid');

	public function beforeRender() {
		#$this->__sendMainMenu();
	}

	protected function _checkNamed($k) {
		return !empty($this->request->params['named'][$k]);
	}

	protected function _setNamed($k, $v) {
		$this->request->params['named'][$k] = $v;
	}

	protected function _getNamed($k) {
		return isset($this->request->params['named'][$k]) ? $this->request->params['named'][$k] : null;
	}

	private function __sendMainMenu() {
		if(!isset($this->WikiMenu)){
			$this->loadModel('WikiMenu');
		}

		$root_ids = $this->WikiMenu->find('list', array(
			'conditions' => array(
				'parent_id' => null,
				'show_in_navbar' => true,
			),
			));
		$root_ids = array_keys($root_ids);
		$root_children_ids = $this->WikiMenu->find('list', array(
			'conditions' => array(
				'parent_id' => $root_ids,
				'show_in_navbar' => true,
			),
			'limit' => 10,
			));
		$root_children_ids = array_keys($root_children_ids);
		$menus = $this->WikiMenu->find('threaded', array(
			'fields' => array('id', 'title', 'link', 'link_type'),
			'conditions' => array('id' => array_merge($root_ids, $root_children_ids)),
			));

		$this->set('MainWikiMenu', $menus);
	}

}

