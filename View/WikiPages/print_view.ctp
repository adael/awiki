<h1><?= $title ?></h1>
<?php
if(!empty($content)){
	$this->Wiki->render_content($content, array('links' => false));
}