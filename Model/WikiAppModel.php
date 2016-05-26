<?php

class WikiAppModel extends AppModel
{

    public $recursive = -1;

    public function value($field, $default = null)
    {
        if (empty($this->data)) {
            trigger_error('Data is empty', E_USER_WARNING);
        }
        if (strpos($field, '.') === false) {
            $field = "{$this->alias}.{$field}";
        }
        $value = Hash::get($this->data, $field);
        if ($value === null) {
            $value = $default;
        }
        return $value;
    }

    public function valueEmpty($field)
    {
        $v = $this->value($field);
        return empty($v);
    }

}
