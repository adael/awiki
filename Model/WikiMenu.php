<?php

class WikiMenu extends AppModel {

	/**
	 * @var array holds class list
	 */
	private $__classes;

	/**
	 * @var array holds link types
	 */
	private $__linkTypes;

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
			'class' => array(
				'rule' => array('inList', array_keys($this->getClasses())),
				'message' => __('Invalid class type'),
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

		return parent::beforeValidate($options);
	}

	/**
	 * Return available classes
	 * @return array
	 */
	function getClasses() {
		if(!$this->__classes){
			$this->__classes = array(
				'none' => __('None'),
				'silver' => __('Silver'),
				'blue' => __('Blue'),
				'gold' => __('Gold'),
				'green' => __('Green'),
				'red' => __('Red'),
				'pink' => __('Pink'),
			);
		}
		return $this->__classes;
	}

	/**
	 * Return available link types.
	 * @return array
	 */
	function getLinkTypes() {
		if(!$this->__linkTypes){
			$this->__linkTypes = array(
				'page' => __('Page'),
				'internal' => __('Internal'),
				'external' => __('External'),
			);
		}
		return $this->__linkTypes;
	}

}