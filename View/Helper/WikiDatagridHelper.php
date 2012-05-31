<?php

App::uses('WikiDatagridCellRenderer', 'Wiki.Lib/Ui/');

class WikiDatagridHelper extends AppHelper {

	var $helpers = array('Html');

	function render($columns, $rows) {
		$defaultRenderer = null;
		echo "<table class='list'>";
		echo "<thead>";
		foreach($columns as $col){
			echo $this->Html->tag('th', $col['text'], @$col['th']);
		}
		echo "</thead>";
		echo "<tbody>";
		foreach($rows as $row){
			echo "<tr>";
			foreach($columns as $col){
				if(!empty($col['renderer'])){
					$value = $col['renderer']->render($col, $row);
				}else{
					if(!$defaultRenderer){
						$defaultRenderer = new WikiDatagridCellRenderer($this->Html);
					}
					$value = $defaultRenderer->render($col, $row);
				}
			}
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}

}
