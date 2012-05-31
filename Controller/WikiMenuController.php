<?php

/**
 * @property WikiMenu $WikiMenu
 */
class WikiMenuController extends AppController {

	var $uses = array('Wiki.WikiMenu');
	var $layout = 'wiki';
	var $helpers = array('Wiki.WikiDatagrid');

	function beforeRender() {
		$menus = $this->WikiMenu->find('all', array(
			'fields' => array('title', 'link', 'link_type', 'class'),
			'order' => 'order',
				));
		$this->set('mainmenu', $menus);
	}

	function index() {
		$this->paginate['order'] = 'order';
		$this->set('items', $this->paginate('Menu'));
		$this->set('classes', $this->WikiMenu->getClasses());
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
					$this->redirect('/wiki/pages/view/' . $success['WikiMenu']['link']);
				}else{
					$this->redirect(array('action' => 'index'));
				}
			}
		}
		$this->request->data = $this->WikiMenu->findById($id);
		$this->set('classes', $this->WikiMenu->getClasses());
		$this->set('linkTypes', $this->WikiMenu->getLinkTypes());
	}

	function delete($id = null) {
		if(!empty($this->request->data)){
			$this->WikiMenu->create($this->request->data);
			$this->WikiMenu->delete();
			$this->Session->setFlash(__('The menu has been deleted'));
			$this->redirect('/wiki/menus/index');
		}else{
			$this->WikiMenu->id = $id;
			if(!$this->WikiMenu->exists()){
				$this->Session->setFlash(__('Menu not found'));
				$this->redirect('/wiki/menus/index');
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

}