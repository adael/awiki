<?php

class WikiPage extends WikiAppModel {

	public $hasOne = array(
		'WikiMenu' => array(
			'className' => 'Wiki.WikiMenu',
			'foreignKey' => false,
			'conditions' => 'WikiMenu.page_alias = WikiPage.alias',
		),
	);

	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'alias' => array(
				'rule' => '/^[' . WikiUtil::WIKI_PAGE_ALIAS_ALLOWED_CHARS . ']+$/',
				'message' => 'Invalid page alias',
			),
			'title' => array(
				'rule' => 'notEmpty',
				'message' => 'Title cannot be empty',
			),
		);
	}

	function beforeValidate($options = array()) {
		if($this->valueEmpty('alias')){
			$this->set('alias', Inflector::slug($this->value('title')));
		}
		$n = $this->find('count', array(
			'conditions' => array(
				'alias' => $this->value('alias'),
				'id !=' => $this->id,
			),
			));
		if($n){
			$this->invalidate('alias', __('El alias %s ya existe indique otro', $alias));
		}
		return parent::beforeValidate($options);
	}

	function beforeSave($options = array()) {
		if($this->valueEmpty('alias')){
			$this->set('alias', Inflector::slug($this->value('alias')));
		}
		if(!$this->valueEmpty('content')){
			$this->set('content_length', strlen($this->value('content')));
			$this->set('content_numwords', WikiUtil::str_word_count_utf8($this->value('content')));
		}

		if($this->id){
			$oldAlias = $this->field('alias');
			if($oldAlias && $oldAlias !== $this->value('alias')){
				$this->WikiMenu->updateAll(array('page_alias' => $this->value('alias')), array(
					'page_alias' => $oldAlias,
				));
			}
		}

		return parent::beforeSave($options);
	}

	function beforeDelete($cascade = true) {
		if($this->field('internal')){
			$this->invalidate('internal', __("You cannot delete this page because it's a system page"));
			return false;
		}
		return parent::beforeDelete($cascade);
	}

	function setPageLock($alias, $locked) {
		return $this->updateAll(compact('locked'), compact('alias'));
	}

	function embedPages(&$page) {
		$matches = null;
		$n = preg_match_all('/\{\#([' . WikiUtil::WIKI_PAGE_ALIAS_ALLOWED_CHARS . ']+)\#\}/', $page[$this->alias]['content'], $matches);
		if($n){
			$res = $this->find('list', array(
				'fields' => array('alias', 'content'),
				'conditions' => array('alias' => $matches[1]),
				'limit' => 25, # prevent flooding and stupidity
				));
			if(!empty($res)){
				for($i = 0; $i < $n; $i++){
					$key = $matches[0][$i];
					$alias = $matches[1][$i];
					$page[$this->alias]['content'] = str_replace($key, isset($res[$alias]) ? $res[$alias] : '', $page[$this->alias]['content']);
				}
			}
		}
	}

}