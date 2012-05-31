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
	var $helpers = array('Js', 'Form', 'Wiki.WikiDatagrid', 'Wiki.Wiki');
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

	function view($alias = 'index') {
		$page = $this->WikiPage->findByAlias($alias);
		if(!$page || empty($page['WikiPage']['content'])){
			$this->redirect(array('action' => 'edit', $alias));
		}

		// Support for including other page contents with {#page_alias#}
		$this->WikiPage->embedPages($page);

		$this->set(compact('alias', 'page'));
	}

	function preview() {
		$this->layout = 'Wiki.print';
		$this->set('content', $this->request->data);
	}

	function printView($alias) {
		$page = $this->WikiPage->findByAlias($alias);
		if(!$page){
			$this->redirect('/');
		}
		$this->set(array(
			'alias' => $alias,
			'content' => $page['WikiPage']['content'],
			'title' => $page['WikiPage']['title'],
		));
		$this->layout = 'Wiki.print';
	}

	function edit($alias = null) {

		$page = $this->WikiPage->findByAlias($alias);

		// Check content to prevent looping with index
		if(!empty($page['WikiPage']['locked']) && !empty($page['WikiPage']['content'])){
			$this->Session->setFlash(__('This page is locked'));
			$this->redirect("/wiki/pages/view/$alias");
		}

		if(!empty($this->request->data)){
			$this->WikiPage->create($page); // actually is not creating (cakephp bad syntax here)
			// For security only sends the fields needed
			$this->WikiPage->set(array(
				'alias' => $alias,
				'title' => $this->request->data['WikiPage']['title'],
				'content' => &$this->request->data['WikiPage']['content'],
			));
			$success = $this->WikiPage->save();
			if($success){
				if(!empty($this->request->data['WikiMenu']['pin'])){
					$this->WikiMenu->create();
					$this->WikiMenu->set(array(
						'id' => $this->request->data['WikiMenu']['id'],
						'title' => $success['WikiPage']['title'],
						'link' => $success['WikiPage']['alias'],
						'class' => $this->request->data['WikiMenu']['class'],
					));
					$this->WikiMenu->save();
				}elseif(!empty($this->request->data['WikiMenu']['id'])){
					$this->WikiMenu->delete($this->request->data['WikiMenu']['id']);
				}
				$this->Session->setFlash("The page has been saved");
				$this->redirect(array('action' => 'view', $alias));
			}
		}
		$this->request->data = $page;
		$menuAssociated = $this->WikiMenu->find('first', array('conditions' => array('link' => $alias, 'link_type' => 'page')));
		if(!empty($menuAssociated)){
			$this->request->data['WikiMenu'] = $menuAssociated['WikiMenu'];
			$this->request->data['WikiMenu']['pin'] = true;
		}

		$this->set('alias', $alias);
		$this->set('classes', $this->WikiMenu->getClasses());
	}

	function lock($alias = null) {
		$this->WikiPage->setPageLock($alias, 1);
		$this->Session->setFlash(__('The page has been locked'));
		$this->redirect($this->referer());
	}

	function unlock($alias = null) {
		$this->WikiPage->setPageLock($alias, 0);
		$this->Session->setFlash(__('The page has been unlocked'));
		$this->redirect($this->referer());
	}

	function delete($alias = null) {
		if(!empty($this->request->data)){
			$this->WikiPage->create($this->request->data);
			if($this->WikiPage->delete()){
				$this->Session->setFlash(__('The page has been deleted'));
			}else{
				$this->Session->setFlash(join($this->WikiPage->validationErrors));
			}
			$this->redirect('/wiki/pages/index');
		}else{
			$page = $this->WikiPage->findByAlias($alias);
			if(!$page){
				$this->Session->setFlash(__('Page not found'));
				$this->redirect('/wiki/pages/index');
			}
			$this->request->data = $page;
		}
	}

}
