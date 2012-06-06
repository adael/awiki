<?php

/**
 * @property WikiPage $WikiPage
 * @property WikiMenu $WikiMenu
 * @property SearchComponent $Search
 */
class WikiPagesController extends WikiAppController {

	public $components = array(
		'Paginator',
		'Wiki.Search',
	);
	public $layout = "Wiki.wiki";
	public $uses = array(
		'Wiki.WikiPage',
		'Wiki.WikiMenu'
	);

	function index() {
		$this->Search->record();
		$this->paginate = array(
			'WikiPage' => array(
				'limit' => 20,
				'conditions' => $this->Search->conditions(array(
					array('title', 'like'),
					array('locked', '='),
				)),
			),
		);
		$this->set('WikiPages', $this->paginate('WikiPage'));
	}

	function autocomplete() {
		$search = Set::get($this->request->query, 'term');
		$rows = $this->WikiPage->find('list', array(
			'fields' => array('alias', 'title'),
			'conditions' => array(
				'alias LIKE' => "%{$search}%",
				'title LIKE' => "%{$search}%",
			),
			'limit' => 15,
			));
		$items = array();
		foreach($rows as $value => $label){
			$items[] = compact('value', 'label');
		}
		$this->response->charset();
		$this->response->type("application/json");
		$this->response->body(json_encode($items));
		return $this->response;
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

	/**
	 * Ajax preview for MarkItUp!
	 */
	function ajax_preview() {
		$this->layout = 'Wiki.preview';
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
		$this->layout = 'Wiki.preview';
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
			// For security send only the needed fields
			$this->WikiPage->set(array(
				'title' => $this->request->data['WikiPage']['title'],
				'content' => &$this->request->data['WikiPage']['content'],
			));
			$success = $this->WikiPage->save();
			if($success){
				# $this->_saveMenuPin();
				$this->redirect(array('action' => 'view', $alias));
			}
		}
		$this->request->data = $page;
		$this->set('alias', $alias);
	}

	function ajax_live_edit($alias = null) {
		$this->viewClass = 'Json';
		$this->set('_serialize', array('success', 'message', 'errors'));

		if(!$alias || !($page = $this->WikiPage->findByAlias($alias))){
			$this->set(array(
				'success' => false,
				'message' => array(__('Page not found')),
			));
			return;
		}

		// Check content to prevent looping with index
		if(!empty($page['WikiPage']['locked']) && !empty($page['WikiPage']['content'])){
			$this->set(array(
				'success' => false,
				'message' => __('This page is locked'),
			));
			return;
		}

		$this->WikiPage->create($page);

		if(isset($this->request->data['title'])){
			$this->WikiPage->set('title', $this->request->data['title']);
		}

		if(isset($this->request->data['content'])){
			$this->WikiPage->set('content', $this->request->data['content']);
		}

		$success = $this->WikiPage->save();
		$this->set(array(
			'success' => $success,
			'message' => ($success ? __('Page saved') : __('Problems found')),
			'errors' => $this->WikiPage->validationErrors,
		));
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
		$page = $this->WikiPage->findByAlias($alias);
		if(!$page){
			$this->Session->setFlash(__('Page not found'));
			$this->redirect(array('action' => 'index'));
		}
		$this->WikiPage->create($page);
		if($this->WikiPage->delete()){
			$this->Session->setFlash(__('The page has been deleted'));
		}else{
			$this->Session->setFlash(join($this->WikiPage->validationErrors));
		}
		$this->redirect(array('action' => 'index'));
	}

//	private function _saveMenuPin() {
//		if (!empty($this->request->data['WikiMenu']['pin'])) {
//			$this->WikiMenu->create();
//			$this->WikiMenu->set(array(
//				'id' => $this->request->data['WikiMenu']['id'],
//				'title' => $success['WikiPage']['title'],
//				'link' => $success['WikiPage']['alias'],
//				'class' => $this->request->data['WikiMenu']['class'],
//			));
//			$this->WikiMenu->save();
//		} elseif (!empty($this->request->data['WikiMenu']['id'])) {
//			$this->WikiMenu->delete($this->request->data['WikiMenu']['id']);
//		}
//		$this->Session->setFlash("The page has been saved");
//	}
}
