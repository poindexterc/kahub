<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 *
 * Projectname .......... Multibyte Keyword Generator
 * Version .............. 1.2
 * Last modified ........ 2010-08-14
 * Author(s) ............ Peter Kahl, www.dezzignz.com <bf91da40_AT_gmail.com>
 *                        Ver Pangonilo <smp_AT_itsp.info>
 * Copyright (c) ........ 2009 Peter Kahl
 *                        2006 Ver Pangonilo
 *                        All Rights Reserved
 *
 * Other contributors ... Vasilich <vasilich_AT_grafin.kiev.ua>
 *
 * Class URL .... http://www.phpclasses.org/browse/package/5771.html
 *
 *
 *
 * GNU General Public License (Version 2, June 1991)
 * ===============================================================
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 *
 *
 * DESCRIPTION:
 * ===============================================================
 * This class is based in large part on the "Automatic Keyword
 * Generator" class by Ver Pangonilo
 * (http://www.phpclasses.org/browse/package/3245.html) with
 * additional improvements and functional enhancements, among them
 * being better word segmentation and ability to handle multibyte
 * strings.
 *
 * This class automatically generates META Keywords for your web
 * pages based on the contents of a text string. This eliminates
 * the tedious process of thinking what the best keywords are.
 * The main principle of this method is the number of occurrences
 * of single words or multiple words in a text string.
 *
 * The string supplied to this class SHOULD contain HTML tags and
 * punctuations. Advantage is taken from the presence of line
 * breaks and punctuations to more accurately guess the best
 * multiple word keyphrases.
 *
 * This Multibyte Keyword Generator will automatically create
 * single word keywords, 2-word and 3-word keyphrases. All
 * keywords and keyphrases are filtered to remove common (useless)
 * words. Common words are defined within the class and can be
 * associated with specific language.
 *
 * This class is highly configurable. One can use minimal
 * settings and rely on defaults. Alternatively, one can choose
 * to obtain ANY combination of final result: 1-word keywords,
 * 2-word keyphrases, 3-word keyphrases. Each option can be
 * disabled. For example, one can configure this class to obtain
 * only 1-word keywords, or only 2-word keyphrases, or only
 * 3-word keyphrases, or all, or any combination.
 *
 * This class is capable of handling multilingual texts and
 * multibyte strings.
 *
 * This class is capable of handling all European languages and is
 * likely to handle many others as well. You may need to define
 * common (useless) words for your own language if not already
 * part of this class.
 *
 * Please READ the attached documentation for examples of usage at
 * http://www.phpclasses.org/browse/package/5771.html .
 *
 *
 *
 * CHANGE LOG:
 * ===============================================================
 * 0.9 ..... Peter Kahl, 2009-11-05
 * 1.0 ..... Peter Kahl, 2010-01-19: Improved function
 * removeDuplicateKw() to better handle deletion of duplicate
 * plural words (English), such as "class" and "classes".
 * 1.1 ..... Peter Kahl, 2010-01-19: Changed the function
 * array_one_dim() to array_flatten().
 * 1.2 ..... Peter Kahl, 2010-08-14: Improved regular expressions in
 * function html2txt().
 *
 *
 */


////////////////////////////////////////////////////////////////////////////////////////////////////////

class autokeyword {

	//declare variables
	var $contents;
	var $encoding;
	var $lang;
	var $ignore; // array; languages to ignore

	//the generated keywords
	var $keywords;

	//minimum word length for inclusion into the single word metakeys
	var $wordLengthMin;
	var $wordOccuredMin;

	//minimum word length for inclusion into the 2-word phrase metakeys
	var $word2WordPhraseLengthMin;
	var $phrase2WordLengthMinOccur;

	//minimum word length for inclusion into the 3-word phrase metakeys
	var $word3WordPhraseLengthMin;

	//minimum phrase length for inclusion into the 2-word phrase metakeys
	var $phrase2WordLengthMin;
	var $phrase3WordLengthMinOccur;

	//minimum phrase length for inclusion into the 3-word phrase metakeys
	var $phrase3WordLengthMin;


	///////////////////////////////////////////////////////////////////////////////////////

	function autokeyword ($params) {

		// language or default language; if not defined
		if (!isset($params['lang'])) $this->lang = 'en';
		else $this->lang = strtolower($params['lang']); // case insensitive

		// multibyte internal encoding
		if (!isset($params['encoding'])) $this->encoding = 'UTF-8';
		else $this->encoding = strtoupper($params['encoding']); // case insensitive
		mb_internal_encoding($this->encoding);

		// languages to ignore
		if (isset($params['ignore']) && is_array($params['ignore'])) $this->ignore = $params['ignore']; // array of language codes
		else $this->ignore = false;

		// clean up input string; break along punctuations; explode into array
		if ($this->ignore !== false && in_array($this->lang, $this->ignore)) $this->contents = false; // language to be ignored
		else $this->contents = $this->process_text($params['content']);

		////////////////////////////////////////////////////////

		//--------- LOAD THE PARAMETERS AND DEFAULTS ---------//

		////////////////////////////////////////////////////////
		// single keyword
		if (isset($params['min_word_length'])) { // value 0 means disable
			$this->wordLengthMin  = $params['min_word_length'];
		}
		else {
			// if not set, use this default
			$this->wordLengthMin = 5;
		}

		if (isset($params['min_word_occur'])) {
			$this->wordOccuredMin = $params['min_word_occur'];
			}
		else {
			// if not set, use this default
			$this->wordOccuredMin = 3;
			}

		////////////////////////////////////////////////////////
		// 2-word keyphrase
		if (isset($params['min_2words_length']) && $params['min_2words_length'] == 0) { // value 0 means disable
			$this->word2WordPhraseLengthMin  = false;
		}
		elseif (isset($params['min_2words_length']) && $params['min_2words_length'] !== 0) {
			$this->word2WordPhraseLengthMin  = $params['min_2words_length'];
			$this->phrase2WordLengthMin      = $params['min_2words_phrase_length'];
			$this->phrase2WordLengthMinOccur = $params['min_2words_phrase_occur'];
		}
		else {
			// if not set, use these defaults
			$this->word2WordPhraseLengthMin  = 4;
			$this->phrase2WordLengthMin      = 8;
			$this->phrase2WordLengthMinOccur = 3;
		}

		////////////////////////////////////////////////////////
		// 3-word keyphrase
		if (isset($params['min_3words_length']) && $params['min_3words_length'] == 0) { // value 0 means disable
			$this->word3WordPhraseLengthMin  = false;
		}
		elseif (isset($params['min_3words_length']) && $params['min_3words_length'] !== 0) {
			$this->word3WordPhraseLengthMin  = $params['min_3words_length'];
			$this->phrase3WordLengthMin      = $params['min_3words_phrase_length'];
			$this->phrase3WordLengthMinOccur = $params['min_3words_phrase_occur'];
		}
		else {
			// if not set, use these defaults
			$this->word3WordPhraseLengthMin  = 4;
			$this->phrase3WordLengthMin      = 12;
			$this->phrase3WordLengthMinOccur = 3;
		}

		////////////////////////////////////////////////////////
	}


	///////////////////////////////////////////////////////////////////////////////////////

	function get_keywords () {

		if ($this->contents === false) return '';

		$onew_arr = $this->parse_words();

		$twow_arr = $this->parse_2words();

		$thrw_arr = $this->parse_3words();

		// remove 2-word phrases if same single words exist
		if ($onew_arr !== false && $twow_arr !== false) {
			$cnt = count($onew_arr);
			for ($i = 0; $i < $cnt-1; $i++) {
				foreach ($twow_arr as $key => $phrase) {
					if ($onew_arr[$i] .' '. $onew_arr[$i+1] === $phrase) unset($twow_arr[$key]);
				}
			}
		}

		// remove 3-word phrases if same single words exist
		if ($onew_arr !== false && $thrw_arr !== false) {
			$cnt = count($onew_arr);
			for ($i = 0; $i < $cnt-2; $i++) {
				foreach ($thrw_arr as $key => $phrase) {
					if ($onew_arr[$i] .' '. $onew_arr[$i+1] .' '. $onew_arr[$i+2] === $phrase) unset($thrw_arr[$key]);
				}
			}
		}

		// remove duplicate ENGLISH plural words
		if ($this->lang == 'en') {
			if ($onew_arr !== false) {
				$cnt = count($onew_arr);
				for ($i = 0; $i < $cnt-1; $i++) {
					for ($j = $i+1; $j < $cnt; $j++) {
						if (array_key_exists($i, $onew_arr) && array_key_exists($j, $onew_arr)) {
							if ($onew_arr[$i].'s' == $onew_arr[$j]) unset($onew_arr[$j]);
							if (array_key_exists($j, $onew_arr)) {
								if ($onew_arr[$i] == $onew_arr[$j].'s') unset($onew_arr[$i]);
							}
						}
					}
				}
			}
		}

		// ready for output - implode arrays
		if ($onew_arr !== false) $onew_kw = implode(',', $onew_arr) .' ';
		else $onew_kw = '';

		if ($twow_arr !== false) $twow_kw = implode(',', $twow_arr) .' ';
		else $twow_kw = '';

		if ($thrw_arr !== false) $thrw_kw = implode(',', $thrw_arr) .' ';
		else $thrw_kw = '';

		$keywords = $onew_kw . $twow_kw . $thrw_kw;
		return rtrim($keywords, ' ');
	}


	///////////////////////////////////////////////////////////////////////////////////////

	function process_text ($str) {

		if (preg_match('/^\s*$/', $str)) return false;

		// strip HTML
		$str = $this->html2txt($str);

		//convert all characters to lower case
		$str = mb_strtolower($str, $this->encoding);

		// some cleanup
		$str = ' '. $str .' '; // pad that is necessary
		$str = preg_replace('#\ [a-z]{1,2}\ #i', ' ', $str); // remove 2 letter words and numbers
		$str = preg_replace('#[0-9\,\.:]#', '', $str); // remove numerals, including commas and dots that are part of the numeral
		$str = preg_replace("/([a-z]{2,})'s/", '\\1', $str); // remove only the 's (as in mother's)
		$str = str_replace('-', ' ', $str); // remove hyphens (-)

		////////////////////////////////////////////////////////

		//----------------- IGNORE WORDS LIST ----------------//

		////////////////////////////////////////////////////////
		// add, remove, edit as needed
		// make sure that paths are correct and necessary files are uploaded to your server
		if ($this->lang == 'en') {
			require_once(dirname(__FILE__) .'/common-words_en.php');
		}
		elseif ($this->lang == 'cs') {
			require_once(dirname(__FILE__) .'/common-words_cs.php');
		}
		elseif ($this->lang == 'de') {
			require_once(dirname(__FILE__) .'/common-words_de.php');
		}

		if (isset($common)) {
			foreach ($common as $word) $str = str_replace(' '.$word.' ', ' ', $str);
			unset($common);
		}

		// replace multiple whitespaces
		$str = preg_replace('/\s\s+/', ' ', $str);
		$str = trim($str);

		if (preg_match('/^\s*$/', $str)) return false;

		////////////////////////////////////////////////////////

		//----------------- WORD SEGMENTATION ----------------//

		////////////////////////////////////////////////////////
		// break along paragraphs, punctuations
		$arrA = explode("\n", $str);
		foreach ($arrA as $key => $value) {
			if (strpos($value, '.') !== false) $arrB[$key] = explode('.', $value);
			else $arrB[$key] = $value;
		}
		$arrB = $this->array_flatten($arrB);
		unset($arrA);
		foreach ($arrB as $key => $value) {
			if (strpos($value, '!') !== false) $arrC[$key] = explode('!', $value);
			else $arrC[$key] = $value;
		}
		$arrC = $this->array_flatten($arrC);
		unset($arrB);
		foreach ($arrC as $key => $value) {
			if (strpos($value, '?') !== false) $arrD[$key] = explode('?', $value);
			else $arrD[$key] = $value;
		}
		$arrD = $this->array_flatten($arrD);
		unset($arrC);
		foreach ($arrD as $key => $value) {
			if (strpos($value, ',') !== false) $arrE[$key] = explode(',', $value);
			else $arrE[$key] = $value;
		}
		$arrE = $this->array_flatten($arrE);
		unset($arrD);
		foreach ($arrE as $key => $value) {
			if (strpos($value, ';') !== false) $arrF[$key] = explode(';', $value);
			else $arrF[$key] = $value;
		}
		$arrF = $this->array_flatten($arrF);
		unset($arrE);
		////////////////////////////////////////////////

		return $arrF;
	}


	///////////////////////////////////////////////////////////////////////////////////////
	//single words
	function parse_words () {

		if ($this->wordLengthMin === 0) return false; // 0 means disable

		$str = implode(' ', $this->contents);
		$str = $this->stripPunctuations($str);

		// create an array out of the site contents
		$s = explode(' ', $str);

		// iterate inside the array
		foreach($s as $key => $val) {
			if (mb_strlen($val, $this->encoding) >= $this->wordLengthMin) $k[] = $val;
		}

		if (!isset($k)) return false;

		// count the words; this is the real magic!
		$k = array_count_values($k);

		return $this->occure_filter($k, $this->wordOccuredMin);
	}


	///////////////////////////////////////////////////////////////////////////////////////
	// 2-word phrases
	function parse_2words () {

		if ($this->word2WordPhraseLengthMin === false) return false; // 0 means disable

		foreach ($this->contents as $key => $str) {
			$str = $this->stripPunctuations($str);
			$arr[$key] = explode(' ', $str); // 2-dimensional array
		}

		$z = 0; // key of the 2-word array
		$lines = count($arr);
		for ($a = 0; $a < $lines; $a++) {
			$words = count($arr[$a]);
			for ($i = 0; $i < $words-1; $i++) {
				if ((mb_strlen($arr[$a][$i], $this->encoding) >= $this->word2WordPhraseLengthMin) && (mb_strlen($arr[$a][$i+1], $this->encoding) >= $this->word2WordPhraseLengthMin)) {
					$y[$z] = $arr[$a][$i] ." ". $arr[$a][$i+1];
					$z++;
				}
			}
		}

		if (!isset($y)) return false;

		// count the words; this is the real magic!
		$y = array_count_values($y);

		return $this->occure_filter($y, $this->phrase2WordLengthMinOccur);
	}


	///////////////////////////////////////////////////////////////////////////////////////
	// 3-word phrases
	function parse_3words () {

		if ($this->word3WordPhraseLengthMin === false) return false; // 0 means disable

		foreach ($this->contents as $key => $str) {
			$str = $this->stripPunctuations($str);
			$arr[$key] = explode(' ', $str); // 2-dimensional array
		}

		$z = 0; // key of the 3-word array
		$lines = count($arr);
		for ($a = 0; $a < $lines; $a++) {
			$words = count($arr[$a]);
			for ($i = 0; $i < $words-2; $i++) {
				if ((mb_strlen($arr[$a][$i], $this->encoding) >= $this->word3WordPhraseLengthMin) && (mb_strlen($arr[$a][$i+1], $this->encoding) >= $this->word3WordPhraseLengthMin) && (mb_strlen($arr[$a][$i+2], $this->encoding) >= $this->word3WordPhraseLengthMin)) {
					$y[$z] = $arr[$a][$i] ." ". $arr[$a][$i+1] ." ". $arr[$a][$i+2];
					$z++;
				}
			}
		}

		if (!isset($y)) return false;

		// count the words; this is the real magic!
		$y = array_count_values($y);

		return $this->occure_filter($y, $this->phrase3WordLengthMinOccur);
	}


	///////////////////////////////////////////////////////////////////////////////////////

	function occure_filter ($array, $min) {
		$cnt = 0;
		foreach ($array as $word => $occured) {
			if ($occured >= $min) {
				$new[$cnt] = $word;
				$cnt++;
			}
		}
		if (isset($new)) return $new;
		return false;
	}


	///////////////////////////////////////////////////////////////////////////////////////
	// converts any-dimensional to 1-dimensional array

	function array_flatten($array, $flat = false) {
		if (!is_array($array) || empty($array)) return '';
		if (empty($flat)) $flat = array();

		foreach ($array as $key => $val) {
			if (is_array($val)) $flat = $this->array_flatten($val, $flat);
			else $flat[] = $val;
		}

		return $flat;
	}

	///////////////////////////////////////////////////////////////////////////////////////

	function html2txt ($str) {
		if ($str == '') return '';
		$str = preg_replace("#(</p>\s*<p>|</div>\s*<div>|</li>\s*<li>|</td>\s*<td>|<br>|<br\ ?/>)#i", "\n", $str); // we use \n to segment words
		$str = preg_replace("#(\n){2,}#", "\n", $str); // replace multiple with single line breaks
		$str = strip_tags($str);
		$unwanted = array('"', '“', '„', '<', '>', '/', '*', '[', ']', '+', '=', '#');
		$str = str_replace($unwanted, ' ', $str);
		$str = preg_replace('/&nbsp;/i', ' ', $str); // remove &nbsp;
		$str = preg_replace('/&[a-z]{2,5};/i', '', $str); // remove &trade;  &copy;
		$str = preg_replace('/\s\s+/', ' ', $str); // replace multiple white spaces
		return trim($str);
	}

	///////////////////////////////////////////////////////////////////////////////////////

	function stripPunctuations ($str) {
		if ($str == '') return '';
		// edit as needed
		$punctuations = array('"', "'", '’', '˝', '„', '`', '.', ',', ';', ':', '+', '±', '-', '_', '=', '(', ')', '[', ']', '<', '>', '{', '}', '/', '\\', '|', '?', '!', '@', '#', '%', '^', '&', '§', '$', '¢', '£', '€', '¥', '*', '~', '。','，','、','；','：','？','！','…','—','·','ˉ','ˇ','¨','‘','’','“','”','々','～','‖','∶','＂','＇','｀','｜','〃','〔','〕','〈','〉','《','》','「','」','『','』','．','〖','〗','【','】','（','）','［','］','｛','｝');
		$str = str_replace($punctuations, ' ', $str);
		return preg_replace('/\s\s+/', ' ', $str);
	}

	///////////////////////////////////////////////////////////////////////////////////////

	function removeDuplicateKw ($str) {
		if ($str == '') return $str;
		$str = trim(mb_strtolower($str));
		$kw_arr = explode(',', $str); // array
		foreach ($kw_arr as $key => $val) {
			$kw_arr[$key] = trim($val);
			if ($kw_arr[$key] == '') unset($kw_arr[$key]);
		}
		$kw_arr = array_unique($kw_arr);
		// remove duplicate ENGLISH plural words
		if ($this->lang == 'en') {
			$cnt = count($kw_arr);
			for ($i = 0; $i < $cnt; $i++) {
				for ($j = $i+1; $j < $cnt; $j++) {
					if (array_key_exists($i, $kw_arr) && array_key_exists($j, $kw_arr)) {
						if ($kw_arr[$i].'s' == $kw_arr[$j]) unset($kw_arr[$j]);
						elseif ($kw_arr[$i] == $kw_arr[$j].'s') unset($kw_arr[$i]);
						//--------------
						elseif (preg_match('#ss$#', $kw_arr[$j])) {
							if ($kw_arr[$i] === $kw_arr[$j].'es') unset($kw_arr[$i]); // addresses VS address
						}
						elseif (preg_match('#ss$#', $kw_arr[$i])) {
							if ($kw_arr[$i].'es' === $kw_arr[$j]) unset($kw_arr[$j]); // address VS addresses
						}
						//---------------
					}
					$kw_arr = array_values($kw_arr);
				}
				$kw_arr = array_values($kw_arr);
			}
		}
		// job is done!
		return implode(' ', $kw_arr);
	}

	///////////////////////////////////////////////////////////////////////////////////////
}

////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
