<?php
/*************************************************************************************

  Copyright notice

  cmCalendar Module v1 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2009
  cmCalendar Module v1.2 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2012

  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS.

   (c) 2002-2012 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.

*************************************************************************************/
// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------

//specific functions for the frontend
 function cm_combinedParser($string, $charset='utf-8', $allowed_tags='') {

	$string = html_parser($string);
	$string = clean_replacement_tags($string, $allowed_tags);

	$string = str_replace('&nbsp;', ' ', $string);

	$string = decode_entities($string);
	$string = cleanUpSpecialHtmlEntities($string);

	if(!empty($string) && PHPWCMS_CHARSET != $charset) {
		$string = makeCharsetConversion($string, PHPWCMS_CHARSET, $charset);
	} else {
		$string = html_specialchars($string);
	}

	return $string;
}

function html_parser($string) {
	// parse the $string and replace all possible
	// values with $replace
	
	if(trim($string) == '') {
		return $string;	
	}
	
	$string = render_bbcode_basics($string, '');

	// page TOP link
	$search[0]		= '/\[TOP\](.*?)\[\/TOP\]/is';
	$replace[0]		= '<a href="#top" class="phpwcmsTopLink">$1</a>';

	// internal Link to article ID
	$search[1]		= '/\[ID (\d+)\](.*?)\[\/ID\]/s';
	$replace[1]		= '<a href="index.php?aid=$1" class="phpwcmsIntLink">$2</a>';

	// external Link (string)
	$search[2]		= '/\[EXT (.*?)\](.*?)\[\/EXT\]/s';
	$replace[2]		= '<a href="$1" target="_blank" class="phpwcmsExtLink">$2</a>';

	// internal Link (string)
	$search[3]		= '/\[INT (.*?)\](.*?)\[\/INT\]/s';
	$replace[3]		= '<a href="$1" class="phpwcmsIntLink">$2</a>';

	// random GIF Image
	$search[4]		= '/\{RANDOM_GIF:(.*?)\}/';
	$replace[4]		= '<img src="img/random_image.php?type=0&imgdir=$1" border="0" alt="" />';

	// random JPEG Image
	$search[5]		= '/\{RANDOM_JPEG:(.*?)\}/';
	$replace[5]		= '<img src="img/random_image.php?type=1&amp;imgdir=$1" border="0" alt="" />';

	// random PNG Image
	$search[6]		= '/\{RANDOM_PNG:(.*?)\}/';
	$replace[6]		= '<img src="img/random_image.php?type=2&amp;imgdir=$1" border="0" alt="" />';

	// insert non db image standard
	$search[7]		= '/\{IMAGE:(.*?)\}/';
	$replace[7]		= '<img src="picture/$1" border="0" alt="" />';

	// insert non db image left
	$search[8]		= '/\{IMAGE_LEFT:(.*?)\}/';
	$replace[8]		= '<img src="picture/$1" border="0" align="left" alt="" />';

	// insert non db image right
	$search[9]		= '/\{IMAGE_RIGHT:(.*?)\}/';
	$replace[9]		= '<img src="picture/$1" border="0" align="right" alt="" />';

	// insert non db image center
	$search[10]		= '/\{IMAGE_CENTER:(.*?)\}/';
	$replace[10]		= '<div align="center"><img src="picture/$1" border="0" alt="" /></div>';

	// insert non db image right
	$search[11]	 	= '/\{SPACER:(\d+)x(\d+)\}/';
	$replace[11] 	= '<img src="img/leer.gif" border="0" width="$1" height="$2" alt="" />';

	// RSS feed link 
	$search[13]		= '/\[RSS (.*?)\](.*?)\[\/RSS\]/s';
	$replace[13]	= '<a href="feeds.php?feed=$1" target="_blank" class="phpwcmsRSSLink">$2</a>';

	// back Link (string)
	$search[14]		= '/\[BACK\](.*?)\[\/BACK\]/i';
	$replace[14] 	= '<a href="#" target="_top" title="go back" onclick="history.back();return false;" class="phpwcmsBackLink">$1</a>';

	// random Image Tag
	$search[15]		= '/\{RANDOM:(.*?)\}/e';
	$replace[15]	= 'get_random_image_tag("$1");';

	// span or div style
	$search[16]		= '/\[(span|div)_style:(.*?)\](.*?)\[\/style\]/s';
	$replace[16]	= '<$1 style="$2">$3</$1>';

	// span or div class
	$search[17]		= '/\[(span|div)_class:(.*?)\](.*?)\[\/class\]/s';
	$replace[17]	= '<$1 class="$2">$3</$1>';

	// anchor link
	$search[22]		= '/\{A:(.*?)\}/is';
	$replace[22]	= '<a name="$1" class="phpwcmsAnchorLink"></a>';

	// this parses an E-Mail Link without subject (by Florian, 21-11-2003)
	$search[23]     = '/\[E{0,1}MAIL (.*?)\](.*?)\[\/E{0,1}MAIL\]/is';
	$replace[23]    = '<a href="mailto:$1" class="phpwcmsMailtoLink">$2</a>';

	// this tags out a Mailaddress with an predifined subject (by Florian, 21-11-2003)
	$search[24]     = '/\[MAILSUB (.*?) (.*?)\](.*?)\[\/MAILSUB\]/is';
	$replace[24]    = '<a href="mailto:$1?subject=$2" class="phpwcmsMailtoLink">$3</a>';

	$search[26]     = '/\<br>/i';
	$replace[26]    = '<br />';

	// create "make bookmark" javascript code
	$search[27]     = '/\[BOOKMARK\s{0,}(.*)\](.*?)\[\/BOOKMARK\]/is';
	$replace[27]    = '<a href="#" onclick="return BookMark_Page(\'$1\');" title="$1" class="phpwcmsBookmarkLink">$2</a>';

	// ABBreviation
	$search[28]		= '/\[abbr (.*?)\](.*?)\[\/abbr\]/is';
	$replace[28]	= '<abbr title="$1">$2</abbr>';

	$search[29]		= '/\[dfn (.*?)\](.*?)\[\/dfn\]/is';
	$replace[29]	= '<dfn title="$1">$2</dfn>';

	$search[34]		= '/\[blockquote (.*?)\](.*?)\[\/blockquote\]/is';
	$replace[34]	= '<blockquote cite="$1">$2</blockquote>';

	$search[35]		= '/\[acronym (.*?)\](.*?)\[\/acronym\]/is';
	$replace[35]	= '<acronym title="$1">$2</acronym>';

	$search[36]		= '/\[ID (.*?)\](.*?)\[\/ID\]/s';
	$replace[36]	= '<a href="index.php?$1" class="phpwcmsIntLink">$2</a>';

	$search[49]     = '/\[E{0,1}MAIL\](.*?)\[\/E{0,1}MAIL\]/is';
	$replace[49]    = '<a href="mailto:$1" class="phpwcmsMailtoLink">$1</a>';

	$string = preg_replace($search, $replace, $string);
	$string = str_replace('&#92;&#039;', '&#039;', $string);
	$string = str_replace('&amp;quot;', '&quot;', $string);
	return $string;
}


function international_date_format($language="EN", $format="Y/m/d", $date_now=0) {
	// formats the given date
	// for the specific language
	// use the normal date format options

	if(!$format) {
		$format = "Y/m/d";
	}
	if(!intval($date_now)) {
		$date_now = time();
	}
	if($language == "EN" || !$language) {
		return date($format, $date_now);
	} else {
		$lang_include = PHPWCMS_ROOT.'/include/inc_lang/date/'.substr(strtolower($language), 0, 2).'.date.lang.php';
		if(is_file($lang_include)) {

			include($lang_include);
			$date_format_function = array (	"a" => 1, "A" => 1, "B" => 1, "d" => 1, "g" => 1, "G" => 1,
									"h" => 1, "H" => 1, "i" => 1, "I" => 1, "j" => 1, "m" => 1,
									"n" => 1, "s" => 1, "t" => 1, "T" => 1, "U" => 1, "w" => 1,
									"Y" => 1, "y" => 1, "z" => 1, "Z" => 1,
									"D" => 0, "F" => 0, "l" => 0, "M" => 0, "S" => 0
								   );

			$str_length = strlen($format); $date = "";
			for($i = 0; $i < $str_length; $i++) $date_format[$i] = substr($format, $i, 1);
			foreach($date_format as $key => $value) {
				if(isset($date_format_function[$value])) {
					if($date_format_function[$value]) {
						$date .= date($value, $date_now);
					} else{
						switch($value) {
							case "D":	$date .= $weekday_short[ intval(date("w", $date_now)) ]; break; //short weekday name
							case "l":	$date .= $weekday_long[ intval(date("w", $date_now)) ]; break; //long weekday name
							case "F":	$date .= $month_long[ intval(date("n", $date_now)) ]; break; //long month name
							case "M":	$date .= $month_short[ intval(date("n", $date_now)) ]; break; //long month name
							case "S":	$date .= ""; break;
						}
					}
				} else {
					$date .= $value;
				}
			}

		} else {
			$date = date($format, $date_now);
		}
	}
	return $date;
}


function clean_replacement_tags($text = '', $allowed_tags='<a><b><i><strong>') {
	// strip out special replacement tags
//	$text = render_PHPcode($text);
	$text = str_replace('<td>', '<td> ', $text);
	$text = strip_tags($text, $allowed_tags);
	$text = str_replace('|', ' ', $text);
	
	$search = array(
				'/\{.*?\}/si',
				'/\[ID.*?\/ID\]/si',
				'/(\s+)/i',
				'/\[img=(\d+)(.*?){0,1}\](.*?)\[\/img\]/i',
				'/\[img=(\d+)(.*?){0,1}\]/i',
				'/\[download=(.*?)\/\]/i',
				'/\[download=(.*?)\](.*?)\[\/download\]/is',
        '/\[PHP.*?\/PHP\]/si',
					);
					
	$replace = array(
				'',
				'',
				' ',
				'$3',
				'',
				'',
				'$2',
        ''
					);
	
	$text = preg_replace($search, $replace, $text);

	return trim($text);
}


function parse_cnt_urlencode($value) {
	// replace tag by value
	return preg_replace_callback('/\[URLENCODE\](.*?)\[\/URLENCODE\]/s', 'render_urlencode', $value);
}

function render_urlencode($match) {
	if(is_array($match) && isset($match[1])) {
		$match = $match[1]; 
	}
	return rawurlencode(decode_entities($match));
}

function render_cnt_date($text='', $date, $livedate=NULL, $killdate=NULL) {
	// render date by replacing placeholder tags by value
	$date = is_numeric($date) ? intval($date) : now();
	$text = preg_replace('/\{DATE:(.*?) lang=(..)\}/e', 'international_date_format("$2","$1","'.$date.'")', $text);
	$text = preg_replace('/\{DATE:(.*?)\}/e', 'date("$1",'.$date.')', $text);
	if(intval($livedate)) {
		$text = preg_replace('/\{LIVEDATE:(.*?) lang=(..)\}/e', 'international_date_format("$2","$1","'.$livedate.'")', $text);
		$text = preg_replace('/\{LIVEDATE:(.*?)\}/e', 'date("$1",'.$livedate.')', $text);
	}
	if(intval($killdate)) {
		$text = preg_replace('/\{KILLDATE:(.*?) lang=(..)\}/e', 'international_date_format("$2","$1","'.$killdate.'")', $text);
		$text = preg_replace('/\{KILLDATE:(.*?)\}/e', 'date("$1",'.$killdate.')', $text);
	}
	return preg_replace('/\{NOW:(.*?) lang=(..)\}/e', 'international_date_format("$2","$1","'.now().'")', $text);
}

function sanitize_replacement_tags( $string, $rt='', $bracket=array('{}', '[]') ) {
	if( $string === '' ) return '';
	if( is_string($bracket) ) {
		$bracket = array($bracket);
	}
	$tag = array();
	if($rt === '') {
		$tag[] = array('.*?', '.*?');
	} elseif( is_array($rt) ) {
		foreach($rt as $value) {
			$value = trim($value);
			if($value === '') continue;
			$tag[] = array($value . '.*?', $value);
		}
	} elseif( is_string($rt) ) {
		$rt = trim($rt);
		if($rt) {
			$tag[] = array($rt . '.*?', $rt);
		}
	}
	if( is_array($bracket) && count($bracket) && count($tag) ) {
		foreach($bracket as $value) {
			if(strlen($value) < 2) continue;
			$prefix = preg_quote($value{0});
			$suffix = preg_quote($value{1});
			foreach($tag as $row) {
				$string = preg_replace('/' . $prefix . $row[0] . $suffix . '(.*?)' . $prefix . '\/' . $row[1] . $suffix . '/si', '$1', $string);
			}
		}
	}
	return $string;
}

?>