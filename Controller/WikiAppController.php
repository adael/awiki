<?php

class WikiAppController extends AppController {

	var $components = array('Session');

	function _checkNamed($k) {
		return !empty($this->request->params['named'][$k]);
	}

	function _setNamed($k, $v) {
		$this->request->params['named'][$k] = $v;
	}

	function _getNamed($k) {
		return isset($this->request->params['named'][$k]) ? $this->request->params['named'][$k] : null;
	}

}

