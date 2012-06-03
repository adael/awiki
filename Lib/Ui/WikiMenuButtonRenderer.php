<?php

App::uses('WikiDatagridCellRenderer', 'Wiki.Lib/Ui/');

class WikiMenuButtonRenderer extends WikiDatagridCellRenderer {

	function prepare($col, $row) {
		$out = $this->Html->link('', array('action' => 'edit', $row['WikiMenu']['id']), array(
			'class' => 'icon-16-Write',
			'title' => __('Edit menu'),
			));
		$out .= " ";
		$out .= $this->Html->link('', array('action' => 'delete', $row['WikiMenu']['id']), array(
			'class' => 'icon-16-Trash',
			'title' => __('Delete menu'),
			));
		if($row['WikiMenu']['link_type'] == 'page'){
			$out .= " ";
			$out .= $this->Html->link('', array('action' => 'edit', $row['WikiMenu']['link']), array(
				'class' => 'icon-16-Write2',
				'title' => __('Edit page'),
				));
		}
		return $out;
	}

}