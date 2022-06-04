<?php
/*************************************************************************************
   Copyright notice

   (c) 2002-2008 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.

   This script is part of PHPWCMS. The PHPWCMS web content management system is
   free software; you can redistribute it and/or modify it under the terms of
   the GNU General Public License as published by the Free Software Foundation;
   either version 2 of the License, or (at your option) any later version.

   The GNU General Public License can be found at http://www.gnu.org/copyleft/gpl.html
   A copy is found in the textfile GPL.txt and important notices to the license
   from the author is found in LICENSE.txt distributed with these scripts.

   This script is distributed in the hope that it will be useful, but WITHOUT ANY
   WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
   PARTICULAR PURPOSE.  See the GNU General Public License for more details.

   This copyright notice MUST APPEAR in all copies of the script!
*************************************************************************************/

// Module/Plug-in Userdetail / Personel search class

class ModuleUserSearch {

	var $search_words			= array();
	var $search_result_entry	= 0;
	var $search_results			= array();
	var $search_highlight		= false;
	var $search_highlight_words	= false;
	var $search_wordlimit		= 0;
	var $ellipse_sign			= '&#8230;';

	function search() {

		if(count($this->search_words)==0) {
			return NULL;
		} else {
			$this->search_words = implode('|', $this->search_words);

		}



		$sql  = 'SELECT *, ';
		$sql .= 'CONCAT(';
		$sql .= "	detail_firstname, ";
		$sql .= "	detail_lastname, ";
		$sql .= "	detail_tag, ";
		$sql .= "	detail_text1, ";
		$sql .= "	detail_text2, ";
		$sql .= "	detail_text3, ";
		$sql .= "	detail_text4, ";
		$sql .= "	detail_text5, ";
		$sql .= "	detail_varchar1, ";
		$sql .= "	detail_varchar2, ";
		$sql .= "	detail_varchar3, ";
		$sql .= "	detail_varchar4, ";
		$sql .= "	detail_varchar5 ";

		$sql .= ') AS detail_search ';
		$sql .= 'FROM '.DB_PREPEND.'phpwcms_userdetail WHERE detail_aktiv =1';


		// echo $sql;
		$data = _dbQuery($sql) or die (mysql_error());



		foreach($data as $value) {

			$entry['detail_notes'] = unserialize($value['detail_notes']);


			$output_text = $value['detail_text1'] .  LF . $value['detail_text2'] . LF . $value['detail_text3'] . LF . $value['detail_text4'] . LF . $value['detail_text5'];



			$s_result	= array();
			$s_text		= $value['detail_search'];
			$s_text		= str_replace( array('~', '|', ':', 'http', '//', '_blank', '&nbsp;') , ' ', $s_text );

			$s_title  = $value['detail_title']."&nbsp;";
			$s_title.= $value['detail_firstname']."&nbsp;".$value['detail_lastname']."";

			$s_title  = html_specialchars($s_title);


			$s_text		= clean_replacement_tags($s_text, '');
			$s_text		= remove_unsecure_rptags($s_text);
			$s_text		= cleanUpSpecialHtmlEntities($s_text);

			$output_text		= clean_replacement_tags($output_text, '');
			$output_text		= remove_unsecure_rptags($output_text);
			$output_text		= cleanUpSpecialHtmlEntities($output_text);

			preg_match_all('/'.$this->search_words.'/is', $s_text, $s_result );

			$s_count	= 0; //set search_result to 0
			foreach($s_result as $svalue) {
				$s_count += count($svalue);
			}






			if($s_count) {



				$id = $this->search_result_entry;



				$s_text   = trim($s_text);
				$s_text   = getCleanSubString($s_text, $this->search_wordlimit, $this->ellipse_sign, 'word');
				$s_text   = html_specialchars($s_text);

				$this->search_results[$id]["id"]	= $data['detail_id'];
				$this->search_results[$id]["cid"]	= 0;
				$this->search_results[$id]["rank"]	= $s_count;
				$this->search_results[$id]["title"]	= $this->search_highlight ? highlightSearchResult($s_title, $this->search_highlight_words) : $s_title;
				$this->search_results[$id]["date"]	= $value['detail_birthday'];
				$this->search_results[$id]["user"]	= '';
				$this->search_results[$id]['query']	=
				'index.php?'.$entry['detail_notes']['user_alias'].'&amp;detail_id='.$value['detail_id'].'&amp;detail_title='.$value['detail_title'];

				if($this->search_highlight) {
					$output_text = highlightSearchResult($output_text, $this->search_highlight_words);
				}
				$this->search_results[$id]["text"]	= $output_text;

				$this->search_result_entry++;
			}
		}
	}

}


?>