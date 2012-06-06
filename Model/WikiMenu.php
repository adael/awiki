<?php

class WikiMenu extends WikiAppModel {

	public $order = 'WikiMenu.order';
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
			'message' => 'Invalid order',
		),
	);

	function beforeValidate($options = array()) {

		// Default type
		if(!isset($this->data[$this->alias]['type'])){
			$this->set('type', 'page');
		}

		// Remove invalid chars from link if link_type is page
		if($this->data[$this->alias]['type'] === 'page'){
			$this->set('page_alias', WikiUtil::encode_alias($this->data[$this->alias]['page_alias']));
			if(empty($this->data[$this->alias]['page_alias'])){
				$this->invalidate('page_alias', '');
			}
		}

		if(!$this->id && empty($this->data[$this->alias]['order'])){
			$order = $this->field('ifnull(max(order), 0) + 1');
			$this->set('order', $order);
		}

		return parent::beforeValidate($options);
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