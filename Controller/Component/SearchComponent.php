<?php

/**
 * @property Controller $_controller
 */
class SearchComponent extends Component {

	public $components = array('Session');
	private $_controller;
	public $key = null;

	function initialize(Controller $controller) {
		parent::initialize($controller);
		$this->_controller = $controller;
		if($this->key === null){
			$this->key = "search.{$this->_controller->name}.{$this->_controller->action}";
		}
	}

	function beforeRender(Controller $controller) {
		parent::beforeRender($controller);
		$this->_controller->helpers['Wiki.Search'] = array(
			'key' => $this->key,
		);
	}

	/**
	 * Records user search for this controller/action
	 */
	function record() {
		if(($search = $this->_controller->request->data('search'))){
			if(Set::get($search, 'reset')){
				$this->Session->delete($this->key);
				$this->_controller->redirect(array());
			}
			$this->Session->write($this->key, $search);
			$this->_controller->redirect(array());
		}
	}

	/**
	 * Retrieves search for this controller/action
	 * @param array $fields
	 * @return null|array
	 */
	function conditions($fields = null) {
		if(($search = $this->Session->read($this->key))){
			if($fields === null){
				return $search;
			}
			$conditions = array();
			foreach($fields as $field){
				list($field, $operator) = $field;
				if(strpos($field, '.') === false){
					$dbfield = "{$this->_controller->modelClass}.{$field}";
				}else{
					$dbfield = $field;
				}

				if(!($v = Set::get($search, $field))){
					$v = Set::get($search, $dbfield);
				}

				if($v){
					if(strcasecmp($operator, 'like') === 0){
						$v = "%{$v}%";
					}
					$conditions["{$field} {$operator}"] = $v;
				}
			}
			return $conditions;
		}
		return null;
	}

}