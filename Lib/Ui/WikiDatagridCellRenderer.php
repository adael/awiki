<?php

class WikiDatagridCellRenderer {

	protected $Html;

	function __construct($html) {
		$this->Html = $html;
	}

	function prepare($col, $row) {
		if(isset($col['value'])){
			$value = & $col['value'];
		}elseif(isset($col['name'])){
			$value = & fset::get($row, $col['name']);
		}else{
			$value = null;
		}

		if(empty($value) && !empty($col['default'])){
			$value = & $col['default'];
		}

		if($value === null && isset($col['onNull'])){
			$value = & $col['onNull'];
		}

		if(isset($col['map']) && isset($col['map'][$value])){
			$value = $col['map'][$value];
		}

		return $value;
	}

	/**
	 * @param array $col
	 * @param array $data
	 */
	function render($col, $row) {
		$value = $this->prepare($col, $row);
		echo $this->Html->tag('td', $value, isset($col['td']) ? $col['td'] : null);
	}

}