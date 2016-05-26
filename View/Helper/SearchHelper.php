<?php

/**
 * @property SessionHelper $Session
 */
class SearchHelper extends Helper
{

    public $key = null;
    public $helpers = array('Session');

    public function __construct(View $View, $settings = array())
    {
        parent::__construct($View, $settings);
        $this->key = $settings['key'];
    }

    /**
     * Retrieves a search value
     * @param string $fieldName
     * @param mixed $default
     * @return mixed
     */
    public function get($fieldName, $default = '')
    {
        $v = $this->Session->read("{$this->key}.{$fieldName}");
        if ($v === null) {
            return $default;
        } else {
            return $v;
        }
    }

}
