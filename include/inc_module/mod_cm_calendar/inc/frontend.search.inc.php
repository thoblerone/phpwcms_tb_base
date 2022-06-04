<?php
/*************************************************************************************

  Copyright notice

  cmCalendar Module v1 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2009
  cmCalendar Module v1.2 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2012

  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS.

   (c) 2002-2012 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.

*************************************************************************************/

// Module/Plug-in cmCalendar search class
class ModuleCmCalendarSearch {

	var $search_words			= array();
	var $search_result_entry	= 0;
	var $search_results			= array();
	var $search_highlight		= false;
	var $search_highlight_words	= false;
	var $search_wordlimit		= 0;
	var $ellipse_sign			= '&#8230;';

  var $plugin_cmcalendar_sresult_acontent = array(); //container array
  var $plugin_cmcalendar_active = array();  //[artid][array active cals in this article]
  var $plugin_cmcalendar_cals = array(); //all calendars
  var $plugin_cmcalendar_sresult = array(); //container articles

    //get the calendars from module
	function cmcalendar_get_cals() {
    $sql = "SELECT * FROM ".DB_PREPEND."phpwcms_cmcalendar_categories WHERE cm_cat_status=1";
    $this->plugin_cmcalendar_cals =  _dbQuery($sql);
  }

    //get the cals(ID) of calendars selected in any contentparts in any articles only when eventlisting
    //and set the $plugin_cmcalendar_active
    //it's not super perfect cause more or less the same thing is done in the standard search yet
	function cmcalendar_get_articles() {

 		$sql  = "SELECT article_id, article_cid, article_title, article_username, article_subtitle, ";
		$sql .= "article_summary, article_keyword, UNIX_TIMESTAMP(article_tstamp) AS article_date ";
		$sql .= "FROM ".DB_PREPEND."phpwcms_article ar ";
		$sql .= "LEFT JOIN ".DB_PREPEND."phpwcms_articlecat ac ON ";
		$sql .= "(ar.article_cid = ac.acat_id OR ar.article_cid = 0)";
		$sql .= " WHERE ";
		// limit to special structure IDs if not all
		if(count($content["search"]["start_at"])) {
			$sql .= 'ar.article_cid IN ('.implode(',', $content["search"]["start_at"]).')';
		} else {
			$sql .= "IF(ar.article_cid = 0, " . (empty($GLOBALS['indexpage']['acat_nosearch']) ? 1 : 0) .", 1)";
		}
		$sql .= " AND ac.acat_nosearch != 1 AND ac.acat_aktiv=1 AND ac.acat_public=1 AND ";
		if(!FEUSER_LOGIN_STATUS) {
			$sql .= "ac.acat_regonly=0 AND ";
		}
		$sql .= "ar.article_public=1 AND ar.article_aktiv=1 AND ar.article_deleted=0 AND ar.article_nosearch!=1 AND ";
		// enhanced IF statement by kh 2008/12/03
		$sql .= "IF((ar.article_begin < NOW() AND ar.article_end > NOW()) OR (ar.article_archive_status=1 AND ac.acat_archive=1), 1, 0) ";
		$sql .= "GROUP BY ar.article_id";
  	$this->plugin_cmcalendar_sresult = _dbQuery($sql);

      foreach($this->plugin_cmcalendar_sresult as $row) {
				// read article content for search
				$cm_art_sql  = "SELECT acontent_aid, acontent_type, acontent_form FROM ";
				$cm_art_sql .= DB_PREPEND."phpwcms_articlecontent WHERE acontent_aid=".$row["article_id"]." ";
				$cm_art_sql .= "AND acontent_module='br_cm_calendar' "; //only module cmCalendar
				$cm_art_sql .= "AND acontent_visible=1 AND acontent_trash=0 AND ";
				if( !FEUSER_LOGIN_STATUS ) {
					$cm_art_sql .= 'acontent_granted=0 AND ';
				}
				$cm_art_sql .= "acontent_type = 30"; //only modules
  	    $this->plugin_cmcalendar_sresult_acontent = _dbQuery($cm_art_sql);

          foreach ($this->plugin_cmcalendar_sresult_acontent as $artrow) {

            $artrow['acontent_form'] = @unserialize($artrow['acontent_form']);

            if ( $artrow['acontent_form']['eventlist'] == 1 ) { //only when eventlisting
              $plugin_cmcalendar_art = array();
                 foreach($this->plugin_cmcalendar_cals as $value_cal) {
                  if (in_array($value_cal['cm_cat_id'], $artrow['acontent_form']['cals'])){
                    array_push($plugin_cmcalendar_art, $value_cal['cm_cat_id']);
                  }
                 }

              //return array[article ID]array[#]int[cm_cat_id] - array() when no result
              $this->plugin_cmcalendar_active[$artrow['acontent_aid']] =  $plugin_cmcalendar_art;
            }

          }
      }

  }

    //get the search result from db cmCalendar entries
    //for each result in each eventlisting in each article
    //meaning when acalendar entry appears in two eventlsitings it will appear in two search results as well
	function search() {
	
		if(count($this->search_words)==0) {
			return NULL;
		} else {
			$this->search_words = implode('|', $this->search_words);
		}

    foreach($this->plugin_cmcalendar_active as $activekey => $activevalue) {

        $plugin_cmcalendar_events = array();
        $calsarray = array();
      //prepare sql for different calendars
        foreach($activevalue as $val) {
            $calsarray[] = "cm_events_allcals LIKE '%|".intval($val)."|%'";
      	}
        $wherequery = (count($calsarray)) ? " AND (".implode(' OR ', $calsarray).")" : "";

        $plugin_cmcalendar_events["sql"]  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_events WHERE ';
      	$plugin_cmcalendar_events["sql"] .= "cm_events_status = 1";
      	$plugin_cmcalendar_events["sql"] .= " AND (cm_events_date) >= (CURDATE())";
      	$plugin_cmcalendar_events["sql"] .= $wherequery;
      	$plugin_cmcalendar_events["sql"] .= " ORDER BY cm_events_date ASC";
      	$plugin_cmcalendar_events["data"] = _dbQuery($plugin_cmcalendar_events["sql"]);

        foreach($plugin_cmcalendar_events["data"] as $value) {
		
    			$s_result	= array();
          $s_text = $value['cm_events_title'] .' '. $value['cm_events_location'] .' '. $value['cm_events_extrainfo'] .' '. $value['cm_events_description'];
					$s_text = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $s_text); // strip all <script> Tags
    			$s_text		= str_replace( array('~', '|', ':', 'http', '//', '_blank', '&nbsp;') , ' ', $s_text );
    			$s_text		= clean_replacement_tags($s_text, '');
    			$s_text		= remove_unsecure_rptags($s_text);
    			$s_text		= cleanUpSpecialHtmlEntities($s_text);
			
          preg_match_all('/'.$this->search_words.'/is', $s_text, $s_result );

          $s_count	= 0; //set search_result to 0
          foreach($s_result as $svalue) {
  				  $s_count += count($svalue);
          }
          //format date as in template_default
    		  $pluginformatdate = '{DATE:'.$template_default['date']['short'].' lang='.substr(strtoupper(cm_detect_lang()), 0, 2).'}';
          $plugindatestrrepl = render_date($pluginformatdate, strtotime($value['cm_events_date']), 'DATE');
			
			    if($s_count) {

            $id = $this->search_result_entry;

            $s_title  = $value['cm_events_title'];
            $s_title  = html_specialchars($s_title) . ' ' . $plugindatestrrepl . ' ' . $value['cm_events_location'] ;

            $s_text   = trim($s_text);
            $s_text   = getCleanSubString($s_text, $this->search_wordlimit, $this->ellipse_sign, 'word');
            $s_text   = html_specialchars($s_text);

            $this->search_results[$id]["id"]	= $value['cm_events_id'];
            $this->search_results[$id]["cid"]	= 0;
            $this->search_results[$id]["rank"]	= $s_count;
            $this->search_results[$id]["title"]	= $this->search_highlight ? highlightSearchResult($s_title, $this->search_highlight_words) : $s_title;
            $this->search_results[$id]["user"]	= '';
            $this->search_results[$id]['query']	= 'aid='.$activekey;

            if($this->search_highlight) {
            	$s_text = highlightSearchResult($s_text, $this->search_highlight_words);
            }
            $this->search_results[$id]["text"]	= $s_text;

            $this->search_result_entry++;
          }
        }
    }

  }

}
?>