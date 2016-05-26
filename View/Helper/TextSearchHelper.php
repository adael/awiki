<?php

class TextSearchHelper extends AppHelper
{

    public function extractSearchResults(&$content, $words, $padding)
    {
        // Pattern for search words with proximity
        $prox = "/" . implode(".{0,{$padding}}", $words) . "/i";
        $contentLength = strlen($content);

        $snippets = array();

        if (preg_match($prox, $content, $matches, PREG_OFFSET_CAPTURE)) {
            // matches[0] is array(keyword, position)
            $snippets[] = $matches[0];
        } else {
            $offset = 0;
            foreach ($words as $word) {
                $pos = stripos($content, $word, $offset);
                if ($pos !== false) {
                    $snippets[] = array($word, $pos);
                    $offset = $pos + strlen($word);
                }
            }
        }

        $out = array();
        foreach ($snippets as $k => $entry) {

            list($word, $position) = $entry;

            $s = "";

            $inicio = $position - $padding;
            if ($inicio > 0) {
                $s .= " ...";
            } else {
                $inicio = 0;
            }

            $length = strlen($word) + ($padding * 2);

            $snippet = substr($content, $inicio, $length);
            $matchedWords = array();

            $patWords = '\\b' . join('\\b|\\b', $words) . '\\b';
            preg_match_all('/' . $patWords . '/i', $snippet, $matches);
            $snippet = preg_replace('/(' . $patWords . ')/i', '<u>\\1</u>', $snippet);
            $matchedWords = $matches[0];

            $s .= $snippet;

            if ($inicio + $length < $contentLength) {
                $s .= "... ";
            }

            $out[] = array('text' => $s, 'matchedWords' => $matchedWords);
        }
        return $out;
    }

}
