<?php

App::uses('WikiDatagridCellRenderer', 'Wiki.Lib/Ui/');

class WikiDatagridHelper extends AppHelper
{

    public $helpers = array('Html');

    public function prepareRow($col, $row)
    {

        // Resolve value if is closure
        if (isset($col['value']) && $col['value'] instanceof Closure) {
            $value = $col['value']($col, $row);
        } elseif (!empty($col['element'])) {
            if (empty($col['element_data'])) {
                $col['element_data'] = array();
            }
            $col['element_data']['row'] = $row;
            $col['element_data']['col'] = $col;
            $value = $this->_View->element($col['element'], $col['element_data']);
        } elseif (isset($col['value'])) {
            $value = &$col['value'];
        } elseif (isset($col['name'])) {
            $value = Set::get($row, $col['name']);
        } else {
            $value = null;
        }

        if (empty($value) && !empty($col['default'])) {
            $value = &$col['default'];
        }

        if ($value === null && isset($col['onNull'])) {
            $value = &$col['onNull'];
        }

        if (isset($col['map']) && isset($col['map'][$value])) {
            $value = $col['map'][$value];
        }

        return $value;
    }

    /**
     * @param array $col
     * @param array $data
     */
    public function renderRow($col, $value)
    {
        echo $this->Html->tag('td', $value, isset($col['td']) ? $col['td'] : null);
    }

    public function render($columns, $rows, $tableOptions = array())
    {
        echo $this->Html->tag('table', null, $tableOptions);
        echo "<thead>";
        echo "<tr>";
        foreach ($columns as $col) {
            echo $this->Html->tag('th', $col['text'], @$col['th']);
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($columns as $col) {
                $value = $this->prepareRow($col, $row);
                $this->renderRow($col, $value);
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

}
