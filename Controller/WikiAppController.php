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
	public $uses = array('Wiki.WikiMenu');

	public function beforeRender() {
		$this->__sendMainMenu();
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
		$menu = $this->WikiMenu->find('all', array('conditions' => array('parent_id' => 0)));
		$menu = Set::combine($menu, '{n}.WikiMenu.id', '{n}.WikiMenu');
		$submenu = $this->WikiMenu->find('all', array('conditions' => array('parent_id' => array_keys($menu))));
		$submenu = Set::combine($submenu, '{n}.WikiMenu.id', '{n}.WikiMenu');
		// create nested structure (only one level)
		$MainMenu = array();
		foreach($menu as $menuId => $menuItem){
			foreach($submenu as $subMenuItem){
				if(intval($subMenuItem['parent_id']) === intval($menuId)){
					$menuItem['children'][] = $subMenuItem;
				}
			}
			$MainMenu[] = $menuItem;
		}
		$this->set('MainMenu', $MainMenu);
	}

}

