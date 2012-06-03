<?php

class WikiMenu extends WikiAppModel {

	public $order = 'WikiMenu.order';
	public $actsAs = array(
		'Tree',
	);

	function beforeValidate($options = array()) {
		$this->validate = array(
			'id' => array(
				'allowEmpty' => true,
				'rule' => 'numeric',
				'message' => __('Invalid id'),
			),
			'title' => array(
				'required' => true,
				'allowEmpty' => false,
				'rule' => 'notEmpty',
				'message' => __('Title is required'),
			),
			'link' => array(
				'required' => true,
				'allowEmpty' => false,
				'rule' => 'notEmpty',
				'message' => __('Link is required'),
			),
			'link_type' => array(
				'required' => true,
				'allowEmpty' => false,
				'rule' => array('inList', array_keys($this->getLinkTypes())),
				'message' => __('Invalid link type'),
			),
			'order' => array(
				'rule' => 'numeric',
				'message' => __('Invalid order'),
			),
		);

		// Default link type
		if(!isset($this->data[$this->alias]['link_type'])){
			$this->set('link_type', 'page');
		}

		// Remove invalid chars from link if link_type is page
		if($this->data[$this->alias]['link_type'] == 'page'){
			$this->set('link', WikiUtil::encode_alias($this->data[$this->alias]['link']));
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
	function getLinkTypes() {
		return array(
			'page' => __('Page'),
			'folder' => __('Folder'),
			'internal' => __('Internal'),
			'external' => __('External'),
		);
	}

}