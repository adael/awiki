<?php

/**
 * @property WikiMenu $WikiMenu
 */
class WikiMenuController extends WikiAppController {

	public $components = array(
		'Paginator',
		'Wiki.Search',
	);
	public $layout = 'wiki';
	public $uses = array('Wiki.WikiMenu');

	function index() {
		$this->Search->record();
		$this->paginate = array(
			'WikiMenu' => array(
				'conditions' => $this->Search->conditions(array(
					array('caption', 'like'),
					array('type', '='),
				)),
				'order' => 'order',
				'limit' => 15,
			),
		);
		$this->set('WikiMenus', $this->paginate('WikiMenu'));
		$this->set('WikiMenuTypes', $this->WikiMenu->getTypes());
	}

	function add() {
		$alias = Set::get($this->request->params, 'named.alias');
		if($this->request->is('get') && $alias){
			$this->request->data = array('WikiMenu' => array(
					'caption' => Inflector::humanize($alias),
					'type' => 'page',
					'page_alias' => $alias,
				));
		}
		$this->edit();
		$this->render('edit');
	}

	function edit($id = null) {
		if($this->request->is('post') && !empty($this->request->data)){
			$this->WikiMenu->create();
			$this->WikiMenu->set($this->request->data);
			$success = $this->WikiMenu->save();
			if($success){
				$this->Session->setFlash(__('The menu has been saved'));
				if(!($r = $this->request->data('_action.redirect'))){
					$r = array('action' => 'index');
				}
				$this->redirect($r);
			}
		}elseif($id){
			$this->request->data = $this->WikiMenu->findById($id);
		}
		$this->set('WikiMenuTypes', $this->WikiMenu->getTypes());
		$this->set('RootMenus', $this->WikiMenu->find('list', array(
				'conditions' => array(
					'type' => 'nav'
				),
			)));
	}

	function delete($id = null) {
		$this->WikiMenu->id = $id;
		if(!$this->WikiMenu->exists()){
			$this->Session->setFlash(__('Menu not found'));
			$this->redirect(array('action' => 'index'));
		}
		if($this->WikiMenu->delete()){
			$this->Session->setFlash(__('The menu has been deleted'));
		}else{
			$this->Session->setFlash(join($this->WikiMenu->validationErrors));
		}
		$this->redirect(array('action' => 'index'));
	}

	function populate() {
		for($i = 0; $i < 100; $i++){
			$this->WikiMenu->create(array(
				'id' => $i + 100,
				'title' => "Menu " . $i,
				'link' => "menu_$i",
			));
			$this->WikiMenu->save();
		}
		die("End");
	}

}