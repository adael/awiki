<?php

class WikiPage extends WikiAppModel {

	function beforeValidate($options = array()) {

		$this->validate = array(
			'alias' => array(
				'rule' => '/^[' . WikiUtil::WIKI_PAGE_ALIAS_ALLOWED_CHARS . ']+$/',
				'message' => 'Invalid page alias',
			),
			'title' => array(
				'rule' => 'notEmpty',
				'message' => __('Title cannot be empty'),
			),
		);

		if(!empty($this->data[$this->alias]['alias'])){
			$this->set('alias', WikiUtil::encode_alias($this->data[$this->alias]['alias']));
		}

		return parent::beforeValidate($options);
	}

	function beforeSave($options = array()) {
		if(isset($this->data[$this->alias]['content'])){
			$this->set('content_length', strlen($this->data[$this->alias]['content']));
			$this->set('content_numwords', WikiUtil::str_word_count_utf8($this->data[$this->alias]['content']));
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
		$n = preg_match_all('/\{\#([' . WikiUtil::WIKI_PAGE_ALIAS_ALLOWED_CHARS . ']+)\#\}/', $page['WikiPage']['content'], $matches);
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
					$page['WikiPage']['content'] = str_replace($key, isset($res[$alias]) ? $res[$alias] : '', $page['WikiPage']['content']);
				}
			}
		}
	}

}