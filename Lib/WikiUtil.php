<?php

class WikiUtil {

	const WORD_COUNT_MASK = "/(\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*){4,}/u";
	const WIKI_PAGE_ALIAS_ALLOWED_CHARS = 'A-Za-z0-9\_';

	/**
	 *
	 * @param type $string
	 * @param type $format
	 * @return type
	 */
	public static function str_word_count_utf8($string, $format = 0) {
		switch($format){
			case 1:
				preg_match_all(self::WORD_COUNT_MASK, $string, $matches);
				return $matches[0];
			case 2:
				preg_match_all(self::WORD_COUNT_MASK, $string, $matches, PREG_OFFSET_CAPTURE);
				$result = array();
				foreach($matches[0] as $match){
					$result[$match[1]] = $match[0];
				}
				return $result;
		}
		return preg_match_all(self::WORD_COUNT_MASK, $string, $matches);
	}

	public static function format_bytes($bytes, $output = 'text') {
		$s = array('b', 'Kb', 'MB', 'GB', 'TB', 'PB');

		if($bytes != 0){
			$e = floor(log($bytes) / log(1024));
		}else{
			$e = 0;
		}

		$unit = $s[$e];

		if($e == 0){
			$rounded = $bytes;
		}else{
			$rounded = sprintf("%.2f", ($bytes / pow(1024, floor($e))));
		}

		if($output == 'array'){
			return array(
				'bytes' => $bytes,
				'unit' => $s[$e],
				'rounded' => $rounded,
			);
		}else{
			return "{$rounded}{$unit}";
		}
	}

}