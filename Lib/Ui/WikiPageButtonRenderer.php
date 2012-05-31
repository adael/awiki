<?php

App::uses('WikiDatagridCellRenderer', 'Wiki.Lib/Ui/');

class WikiPageButtonRenderer extends WikiDatagridCellRenderer {

	function prepare($col, $row) {
		$out = $this->Html->link('', '/wiki/pages/view/' . $row['WikiPage']['alias'], array(
			'class' => 'icon-16 Arrow2UpRight',
			'title' => __('View page'),
				));
		$out .= $this->Html->link('', '/wiki/pages/edit/' . $row['WikiPage']['alias'], array(
			'class' => 'icon-16 Write2',
			'title' => __('Edit page'),
				));

		if($row['WikiPage']['locked']){
			$out .= $this->Html->link('', '/wiki/pages/unlock/' . $row['WikiPage']['alias'], array(
				'class' => 'icon-16 green LockOpen',
				'title' => __('Unlock page'),
					));
		}else{
			$out .= $this->Html->link('', '/wiki/pages/lock/' . $row['WikiPage']['alias'], array(
				'class' => 'icon-16 grey Lock',
				'title' => __('Lock page'),
					));
		}

		$out .= $this->Html->link('', '/wiki/pages/delete/' . $row['WikiPage']['alias'], array(
			'class' => 'icon-16 red Trash',
			'title' => __('Delete paage'),
				));
		return $out;
	}

}