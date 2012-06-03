<?php

/**
 * @property WikiPage $WikiPage
 * @property WikiMenu $WikiMenu
 */
class WikiPagesController extends WikiAppController {

	public $components = array('Paginator');
	public $layout = "Wiki.wiki";
	public $uses = array(
		'Wiki.WikiPage',
		'Wiki.WikiMenu'
	);

	function index() {
		$this->paginate = array(
			'WikiPage' => array(
				'limit' => 20,
			),
		);
		$this->set('WikiPages', $this->paginate('WikiPage'));
	}

	function search() {
		$search = preg_replace('/[^a-z0-9 \._\-\+]/i', '', (string) @$this->request->query['q']);
		$search = trim($search);
		$words = explode(' ', $search);
		$words = array_filter($words);
		$search = "*" . implode('* ', $words) . "*";
		$this->paginate = array(
			'WikiPage' => array(
				'conditions' => array(
					"MATCH (title,content) AGAINST ('{$search}' IN BOOLEAN MODE)"
				),
				'limit' => 10,
			),
		);
		$this->set('results', $this->paginate('WikiPage'));
		$this->set('words', $words);
		$this->helpers[] = "Wiki.TextSearch";
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

	function print_view($alias) {
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
			$this->redirect(array('action' => 'view', $alias));
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
		$this->request->data['WikiMenu'] = $this->WikiMenu->find('first', array('conditions' => array('link' => $alias, 'link_type' => 'page')));
		$this->set('menuTree', $this->WikiMenu->generateTreeList(null, null, null, '&nbsp;&nbsp;&nbsp;'));

		$this->set('alias', $alias);
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
			$this->redirect(array('action' => 'index'));
		}else{
			$page = $this->WikiPage->findByAlias($alias);
			if(!$page){
				$this->Session->setFlash(__('Page not found'));
				$this->redirect(array('action' => 'index'));
			}
			$this->request->data = $page;
		}
	}

}
