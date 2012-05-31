<?php

App::uses('WikiDatagridCellRenderer', 'Wiki.Lib/Ui/');

class WikiMenuButtonRenderer extends WikiDatagridCellRenderer {

	function prepare($col, $row) {
		$out = $this->Html->link('', '/wiki/menus/edit/' . $row['WikiMenu']['id'], array(
			'class' => 'icon-16 Write',
			'title' => __('Edit menu'),
				));
		$out .= $this->Html->link('', '/wiki/menus/delete/' . $row['WikiMenu']['id'], array(
			'class' => 'icon-16 Trash',
			'title' => __('Delete menu'),
				));
		if($row['WikiMenu']['link_type'] == 'page'){
			$out .= $this->Html->link('', '/wiki/pages/edit/' . $row['WikiMenu']['link'], array(
				'class' => 'icon-16 Write2',
				'title' => __('Edit page'),
					));
		}
		return $out;
	}

}