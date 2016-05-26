<?php

class WikiMenu extends WikiAppModel
{

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

    public function beforeValidate($options = array())
    {
        $this->setDefaultType();
        $this->createAliasIfNeeded();
        return parent::beforeValidate($options);
    }

    public function beforeSave($options = array())
    {
        $this->prepareByType();
        $this->assignNextPosition();
        return parent::beforeSave($options);
    }

    public function getNextOrder()
    {
        return $this->field("ifnull(max({$this->alias}.order), 0) + 1", array());
    }

    public function setDefaultType()
    {
        if ($this->valueEmpty('type')) {
            $this->set('type', 'page');
        }
    }

    /**
     * Return available link types.
     * @return array
     */
    public function getTypes()
    {
        return array(
            'nav' => __('Navigation menu'),
            'page' => __('Page'),
            'link' => __('Link'),
        );
    }

    public function valid_types($check)
    {
        return array_key_exists(reset($check), $this->getTypes());
    }

    private function createAliasIfNeeded()
    {
        if ($this->value('type') === 'page' && $this->valueEmpty('page_alias')) {
            $alias = "";
            if (!$this->valueEmpty('parent_id')) {
                $alias .= $this->field('caption', array('id' => $this->value('parent_id')));
                $alias .= ".";
            }
            $alias .= $this->value('caption');
            $this->set('page_alias', $alias);
        }
    }

    private function prepareByType()
    {
        $type = $this->value('type');
        if ($type === 'page') {
            $this->set(array('link_url' => '', 'link_target' => ''));
            // Remove invalid chars from link if link_type is page
            $this->set('page_alias', Inflector::slug($this->value('page_alias')));
            if ($this->valueEmpty('page_alias')) {
                $this->invalidate('page_alias', '');
            }
        } elseif ($type === 'link') {
            $this->set(array('page_alias' => ''));
        } else {
            $this->set(array(
                'page_alias' => '',
                'link_url' => '',
                'link_target' => '',
                'parent_id' => '0',
            ));
        }
    }

    private function assignNextPosition()
    {
        if (!$this->id && $this->valueEmpty('order')) {
            $this->set('order', $this->getNextOrder());
        }
    }

}
