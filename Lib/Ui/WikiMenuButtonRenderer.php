<?php

App::uses('WikiDatagridCellRenderer', 'Wiki.Lib/Ui/');

class WikiMenuButtonRenderer extends WikiDatagridCellRenderer {

	function prepare($col, $row) {
		$out = $this->Html->link('', '/wiki_menu/edit/' . $row['Menu']['id'], array(
			'class' => 'icon-16 Write',
			'title' => __('Edit menu'),
				));
		$out .= $this->Html->link('', '/wiki_menu/delete/' . $row['Menu']['id'], array(
			'class' => 'icon-16 Trash',
			'title' => __('Delete menu'),
				));
		if($row['Menu']['link_type'] == 'page'){
			$out .= $this->Html->link('', '/wiki/edit/' . $row['Menu']['link'], array(
				'class' => 'icon-16 Write2',
				'title' => __('Edit page'),
					));
		}
		return $out;
	}

}