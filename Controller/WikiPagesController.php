<?php

/**
 * @property WikiPage $WikiPage
 * @property WikiMenu $WikiMenu
 */
class WikiPagesController extends AppController {

	var $uses = array(
		'Wiki.WikiPage',
		'Wiki.WikiMenu'
	);
	var $helpers = array('Form', 'Wiki.WikiDatagrid');
	var $components = array('Paginator');
	var $layout = "Wiki.wiki";

	function beforeRender() {
		$this->set('mainmenu', $this->WikiMenu->find('all', array(
					'fields' => array('title', 'link', 'link_type', 'class'),
					'order' => 'order')));
	}

	function index() {
		$this->paginate = array(
			'WikiPage' => array(
				'limit' => 20,
			),
		);
		$this->set('WikiPages', $this->paginate('WikiPage'));
	}

	function view($alias = null) {
		$page = $this->Page->findByAlias($alias);
		if(!$page || empty($page['Page']['content'])){
			$this->redirect(array('action' => 'edit', $alias));
		}

		// Support for including other page contents with {#page_alias#}
		$this->Page->embedPages($page);

		$this->helpers[] = 'Wiki';
		$this->helpers[] = 'Js';
		$this->set(compact('alias', 'page'));
	}

	function preview() {
		$this->helpers[] = 'Wiki';
		$this->layout = 'Wiki.print';
		$this->set('content', $this->request->data);
	}

	function printView($alias) {
		$page = $this->Page->findByAlias($alias);
		if(!$page){
			$this->redirect('/');
		}
		$this->set(array(
			'alias' => $alias,
			'content' => $page['Page']['content'],
			'title' => $page['Page']['title'],
		));
		$this->layout = 'Wiki.print';
	}

	function edit($alias = null) {
		$page = $this->Page->findByAlias($alias);

		// Check content to prevent looping with index
		if(!empty($page['Page']['locked']) && !empty($page['Page']['content'])){
			$this->Session->setFlash(__('This page is locked'));
			$this->redirect("/wiki/view/$alias");
		}

		if(!empty($this->request->data)){
			$this->Page->create($page); // actually is not creating (cakephp bad syntax here)
			// For security only sends the fields needed
			$this->Page->set(array(
				'alias' => $alias,
				'title' => $this->request->data['Page']['title'],
				'content' => &$this->request->data['Page']['content'],
			));
			$success = $this->Page->save();
			if($success){
				if(!empty($this->request->data['Menu']['pin'])){
					$this->Menu->create();
					$this->Menu->set(array(
						'id' => $this->request->data['Menu']['id'],
						'title' => $success['Page']['title'],
						'link' => $success['Page']['alias'],
						'class' => $this->request->data['Menu']['class'],
					));
					$this->Menu->save();
				}elseif(!empty($this->request->data['Menu']['id'])){
					$this->Menu->delete($this->request->data['Menu']['id']);
				}
				$this->Session->setFlash("The page has been saved");
				$this->redirect(array('action' => 'view', $alias));
			}
		}
		$this->request->data = $page;
		$menuAssociated = $this->Menu->find('first', array('conditions' => array('link' => $alias, 'link_type' => 'page')));
		if(!empty($menuAssociated)){
			$this->request->data['Menu'] = $menuAssociated['Menu'];
			$this->request->data['Menu']['pin'] = true;
		}

		$this->set('alias', $alias);
		$this->set('classes', $this->Menu->getClasses());
	}

	function lock($alias = null) {
		$this->Page->setPageLock($alias, 1);
		$this->Session->setFlash(__('The page has been locked'));
		$this->redirect($this->referer());
	}

	function unlock($alias = null) {
		$this->Page->setPageLock($alias, 0);
		$this->Session->setFlash(__('The page has been unlocked'));
		$this->redirect($this->referer());
	}

	function delete($alias = null) {
		if(!empty($this->request->data)){
			$this->Page->create($this->request->data);
			if($this->Page->delete()){
				$this->Session->setFlash(__('The page has been deleted'));
			}else{
				$this->Session->setFlash(join($this->Page->validationErrors));
			}
			$this->redirect('/wiki/index');
		}else{
			$page = $this->Page->findByAlias($alias);
			if(!$page){
				$this->Session->setFlash(__('Page not found'));
				$this->redirect('/wiki/index');
			}
			$this->request->data = $page;
		}
	}

}
