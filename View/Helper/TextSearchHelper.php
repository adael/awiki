<?php

class TextSearchHelper extends AppHelper {

	function extractSearchResults(&$content, $words, $padding) {
		// Pattern for search words with proximity
		$prox = "/" . implode(".{0,{$padding}}", $words) . "/i";
		$contentLength = strlen($content);

		$snippets = array();

		if(preg_match($prox, $content, $matches, PREG_OFFSET_CAPTURE)){
			// matches[0] is array(keyword, position)
			$snippets[] = $matches[0];
		}else{
			foreach($words as $word){
				$snippets[] = array($word, stripos($content, $word));
			}
		}

		$s = "";
		foreach($snippets as $entry){

			list($word, $position) = $entry;

			$inicio = $position - $padding;
			if($inicio > 0){
				$s .= " ...";
			}else{
				$inicio = 0;
			}

			$length = strlen($word) + ($padding * 2);

			$snippet = substr($content, $inicio, $length);

			foreach($words as $_w){
				$snippet = str_ireplace($_w, "<u>{$_w}</u>", $snippet);
			}

			$s .= $snippet;

			if($inicio + $length < $contentLength){
				$s .= "... ";
			}
		}
		return $s;
	}

}