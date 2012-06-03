<?php

App::uses('WikiDatagridCellRenderer', 'Wiki.Lib/Ui/');

class WikiPageButtonRenderer extends WikiDatagridCellRenderer {

	function prepare($col, $row) {
		$out = $this->Html->link('', array('action' => 'view', $row['WikiPage']['alias']), array(
			'class' => 'icon-16-Arrow2UpRight',
			'title' => __('View page'),
			));
		$out .= " ";
		$out .= $this->Html->link('', array('action' => 'edit', $row['WikiPage']['alias']), array(
			'class' => 'icon-16-Write2',
			'title' => __('Edit page'),
			));
		if($row['WikiPage']['locked']){
			$out .= " ";
			$out .= $this->Html->link('', array('action' => 'unlock', $row['WikiPage']['alias']), array(
				'class' => 'icon-16-LockOpen icon-16-green',
				'title' => __('Unlock page'),
				));
		}else{
			$out .= " ";
			$out .= $this->Html->link('', array('action' => 'lock', $row['WikiPage']['alias']), array(
				'class' => 'icon-16-Lock icon-16-grey',
				'title' => __('Lock page'),
				));
		}

		$out .= " ";
		$out .= $this->Html->link('', array('action' => 'delete', $row['WikiPage']['alias']), array(
			'class' => 'icon-16-Trash icon-16-red',
			'title' => __('Delete paage'),
			));
		return $out;
	}

}