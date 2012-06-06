<?php

class WikiMenu extends WikiAppModel {

	public $order = 'WikiMenu.order';
	public $displayField = 'caption';
	public $validate = array(
		'id' => array(
			'allowEmpty' => true,
			'rule' => 'numeric',
			'message' => 'Invalid id',
		),
		'caption' => array(
			'required' => true,
			'allowEmpty' => false,
			'rule' => 'notEmpty',
			'message' => 'caption is required',
		),
		'type' => array(
			'required' => true,
			'allowEmpty' => false,
			'rule' => 'valid_types',
			'message' => 'Invalid menu type',
		),
		'order' => array(
			'rule' => 'numeric',
			'required' => false,
			'allowEmpty' => true,
			'message' => 'Invalid order',
		),
	);

	function beforeValidate($options = array()) {

		// Default type
		if($this->valueEmpty('type')){
			$this->set('type', 'page');
		}

		$type = $this->value('type');

		if($type === 'page' && $this->valueEmpty('page_alias')){
			$alias = "";
			if(!$this->valueEmpty('parent_id')){
				$alias .= $this->field('caption', array('id' => $this->value('parent_id')));
				$alias .= ".";
			}
			$alias .= $this->value('caption');
			$this->set('page_alias', $alias);
		}

		return parent::beforeValidate($options);
	}

	function beforeSave($options = array()) {

		$type = $this->value('type');

		if($type === 'page'){
			$this->set(array('link_url' => '', 'link_target' => ''));
			// Remove invalid chars from link if link_type is page
			$this->set('page_alias', Inflector::slug($this->value('page_alias')));
			if($this->valueEmpty('page_alias')){
				$this->invalidate('page_alias', '');
			}
		}elseif($type === 'link'){
			$this->set(array('page_alias' => ''));
		}else{
			$this->set(array(
				'page_alias' => '',
				'link_url' => '',
				'link_target' => '',
				'parent_id' => '0'
			));
		}

		if(!$this->id && $this->valueEmpty('order')){
			$this->set('order', $this->getNextOrder());
		}
		return parent::beforeSave($options);
	}

	function getNextOrder() {
		return $this->field("ifnull(max({$this->alias}.order), 0) + 1", array());
	}

	/**
	 * Return available link types.
	 * @return array
	 */
	function getTypes() {
		return array(
			'nav' => __('Navigation menu'),
			'page' => __('Page'),
			'link' => __('Link'),
		);
	}

	function valid_types($check) {
		return array_key_exists(reset($check), $this->getTypes());
	}

}