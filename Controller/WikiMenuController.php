<?php

/**
 * @property WikiMenu $WikiMenu
 */
class WikiMenuController extends WikiAppController {

	public $components = array('Paginator');
	public $layout = 'wiki';
	public $uses = array('Wiki.WikiMenu');

	function index() {
		$this->paginate = array(
			'WikiMenu' => array(
				'order' => 'order',
				'limit' => 4,
			),
		);
		$this->set('WikiMenus', $this->paginate('WikiMenu'));
		$this->set('linkTypes', $this->WikiMenu->getLinkTypes());
	}

	function add() {
		$this->edit();
		$this->render('edit');
	}

	function edit($id = null) {
		if(!empty($this->request->data)){
			$this->WikiMenu->create();
			$this->WikiMenu->set($this->request->data);
			$success = $this->WikiMenu->save();
			if($success){
				$this->Session->setFlash(__('The menu has been saved'));
				if($success['WikiMenu']['link_type'] == 'page'){
					$this->redirect(array('action' => 'view', $success['WikiMenu']['link']));
				}else{
					$this->redirect(array('action' => 'index'));
				}
			}
		}
		$this->request->data = $this->WikiMenu->findById($id);
		$this->set('linkTypes', $this->WikiMenu->getLinkTypes());
	}

	function delete($id = null) {
		if(!empty($this->request->data)){
			$this->WikiMenu->create($this->request->data);
			$this->WikiMenu->delete();
			$this->Session->setFlash(__('The menu has been deleted'));
			$this->redirect(array('action' => 'index'));
		}else{
			$this->WikiMenu->id = $id;
			if(!$this->WikiMenu->exists()){
				$this->Session->setFlash(__('Menu not found'));
				$this->redirect(array('action' => 'index'));
			}
			$this->request->data = $this->WikiMenu->read();
		}
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

	function recover() {
		$this->WikiMenu->recover();
		$this->flash(__('Menu has been recoved', true), array('action' => 'index'));
	}

}