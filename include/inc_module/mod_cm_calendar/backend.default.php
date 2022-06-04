<?php 
/*************************************************************************************
   Copyright notice
   
   (c) 2002-2007 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.
 
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
*************************************************************************************

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


/*
 * module br_cm_calendar
 * =====================
 *
 * some defaults for modules: $phpwcms['modules'][$module]
 * store all related in here and holds some default values
 * ['path'], ['type'], ['name']
 * language values are store in $BL['modules'][$module] 
 * as defined in lang/en.lang.php
 * but maybe to keep default language file more lightweight
 * you can use own language definitions starting within this file
 *
 */

// first check if exists
if(isset($phpwcms['modules'][$module]['path'])) {
  //module default stuff
	// put translation back to have easier access to it - use it as relation
	$BLM = & $BL['modules'][$module];
	define('MODULE_HREF', 'phpwcms.php?'.get_token_get_string('csrftoken').'&amp;do=modules&amp;module='.$module);
	
  //get functions for module (backend nodule section only)
  include_once($phpwcms['modules'][$module]['path'].'inc/cm.functions.inc.php');
	include_once($phpwcms['modules'][$module]['path'].'inc/calendar.classes.php');
	$BE['HEADER']['module_calendar.css'] = '	<link href="'.$phpwcms['modules'][$module]['dir'].'template/css/backend.calendar.css" rel="stylesheet" type="text/css">';
  // first check if neccessary db exists
  // ceate main db table
  $sql = "CREATE TABLE IF NOT EXISTS `".DB_PREPEND."phpwcms_cmcalendar_categories` (
          `cm_cat_id` tinyint(4) NOT NULL auto_increment,
          `cm_cat_created` datetime NOT NULL,
          `cm_cat_changed` datetime NOT NULL,
          `cm_cat_name` varchar(255) NOT NULL default '',
          `cm_cat_status` int(1) NOT NULL default '0',
          PRIMARY KEY  (`cm_cat_id`)
          ) ENGINE=MyISAM"._dbGetCreateCharsetCollation();

  $data = _dbQuery("SHOW TABLES FROM `" . DB_PREPEND . $GLOBALS['phpwcms']['db_table'] . "` LIKE '%phpwcms_cmcalendar_categories'");

  if (!empty($data)) {

	$plugin = array();

	// load special backend CSS
	//$BE['HEADER'][] = '	<link href="include/inc_css/tabs.css" rel="stylesheet" type="text/css" />';

  //where to?
	$controller	= empty($_GET['controller']) ? 'cp' : strtolower($_GET['controller']);
	
	if(isset($_GET['edit'])) {
		$action	= 'edit';
	} elseif(isset($_GET['editset'])) {
		$action	= 'editset';
	} elseif(isset($_GET['update'])) {
		$action	= 'update';
	} elseif(isset($_GET['verify'])) {
		$action	= 'status';
	} elseif(isset($_GET['verifyset'])) {
		$action	= 'statusset';
	} elseif(isset($_GET['upload'])) {
		$action	= 'upload';		
	} elseif(isset($_GET['delete'])) {
		$action	= 'delete';
	} elseif(isset($_GET['deleteset'])) {
		$action	= 'deleteset';
  } else {
		$action		= '';
	}
	
		switch($controller) {
		case 'cal':	$controller	= 'cal';
    				break;
		case 'events':	$controller	= 'events';
						break;
		case 'cp':	$controller	= 'cp';
						break;
		case 'lang':	$controller	= 'lang';
						break;
		case 'about':	$controller	= 'about';
						break;
		default:		$controller	= 'cp';
	// some defaults - unset session vars
	//unset($_SESSION['detail_page'], $_SESSION['list_active'], $_SESSION['list_inactive'], $_SESSION['filter']);		
	}
	echo ("controller=$controller<br />action=$action");

		// processing
	if( $action ) {
		include_once($phpwcms['modules'][$module]['path'].'inc/processing.' . $controller . '.inc.php');
	}
	
	// header
	include_once($phpwcms['modules'][$module]['path'].'inc/tabs.inc.php');
	// listing
	if($action) {
		include_once($phpwcms['modules'][$module]['path'].'inc/'.$action.'.' . $controller . '.inc.php');
  } else {
		include_once($phpwcms['modules'][$module]['path'].'inc/listing.' . $controller . '.inc.php');
	}

  } else if (_dbQuery($sql, 'CREATE')) { //create table  

    $sql_cm = array();
    $sql_cm[1] = "CREATE TABLE IF NOT EXISTS `".DB_PREPEND."phpwcms_cmcalendar_events` (
      `cm_events_id` int(11) NOT NULL auto_increment,
      `cm_events_created` datetime NOT NULL,
      `cm_events_changed` datetime NOT NULL,
      `cm_events_date` date NOT NULL default '0000-00-00',
      `cm_events_span` int(11) NOT NULL default '1',
      `cm_events_time` varchar(100) NOT NULL default '',
      `cm_events_title` varchar(255) NOT NULL default '',
      `cm_events_category` int(11) NOT NULL default '0',
      `cm_events_image` text NOT NULL,
      `cm_events_location` varchar(100) NOT NULL default '',
      `cm_events_description` text NOT NULL,
      `cm_events_extrainfo` text NOT NULL,
      `cm_events_approved` tinyint(1) NOT NULL default '0',
      `cm_events_setid` int(11) NOT NULL default '0',
      `cm_events_userId` int(11) NOT NULL default '0',
      `cm_events_article` int(11) NOT NULL default '0',  
      `cm_events_dat_undef` tinyint(4) NOT NULL default '0',  
      `cm_events_allcals` varchar(255) NOT NULL default '',
      `cm_events_status` int(1) NOT NULL default '0',
      PRIMARY KEY  (`cm_events_id`)
      ) ENGINE=MyISAM"._dbGetCreateCharsetCollation();
    		
    $sql_cm[2] = "CREATE TABLE IF NOT EXISTS `".DB_PREPEND."phpwcms_cmcalendar_language` (
      `cm_lang_id` int(11) unsigned NOT NULL auto_increment,
      `cm_lang_status` int(1) NOT NULL default '0',
      `cm_lang_createdate` datetime NOT NULL default '0000-00-00 00:00:00',
      `cm_lang_changedate` datetime NOT NULL default '0000-00-00 00:00:00',
      `cm_lang_name` varchar(255) NOT NULL default '',
      `cm_lang_loc` varchar(255) NOT NULL default '',
      `cm_lang_sys` varchar(255) NOT NULL default '',
      `cm_lang_lang` text NOT NULL,
      PRIMARY KEY  (`cm_lang_id`)
       ) ENGINE=MyISAM"._dbGetCreateCharsetCollation();
    
    $lang_en = 'a:44:{s:12:"cm_lang_cale";s:8:"Calendar";s:12:"cm_lang_date";s:4:"Date";s:12:"cm_lang_span";s:15:"Duration # days";s:12:"cm_lang_titl";s:5:"Title";s:12:"cm_lang_time";s:4:"Time";s:12:"cm_lang_loca";s:8:"Location";s:12:"cm_lang_desc";s:11:"Description";s:12:"cm_lang_noen";s:16:"No entries found";s:12:"cm_lang_noca";s:17:"No calendar found";s:18:"cm_lang_dateformat";s:5:"d-m-Y";s:12:"cm_lang_prnt";s:5:"Print";s:12:"cm_lang_ical";s:9:"ICalendar";s:12:"cm_lang_artl";s:12:"Article link";s:12:"cm_lang_lbut";s:2:"<<";s:12:"cm_lang_rbut";s:2:">>";s:12:"cm_lang_bckl";s:4:"back";s:12:"cm_lang_lstl";s:6:"Detail";s:12:"cm_lang_slct";s:9:"Selection";s:12:"cm_lang_undf";s:4:"in #";s:16:"cm_lang_slct_all";s:11:"all entries";s:15:"cm_lang_slct_am";s:12:"actual month";s:15:"cm_lang_slct_ay";s:11:"actual year";s:15:"cm_lang_slct_nm";s:12:"next # month";s:15:"cm_lang_slct_ny";s:12:"next # years";s:15:"cm_lang_slct_lm";s:12:"last # month";s:11:"cm_lang_jan";s:7:"January";s:11:"cm_lang_feb";s:8:"February";s:11:"cm_lang_mar";s:5:"March";s:11:"cm_lang_apr";s:5:"April";s:11:"cm_lang_may";s:3:"May";s:11:"cm_lang_jun";s:4:"June";s:11:"cm_lang_jul";s:4:"July";s:11:"cm_lang_aug";s:6:"August";s:11:"cm_lang_sep";s:9:"September";s:11:"cm_lang_oct";s:7:"October";s:11:"cm_lang_nov";s:8:"November";s:11:"cm_lang_dec";s:8:"December";s:11:"cm_lang_mon";s:6:"Monday";s:11:"cm_lang_tue";s:7:"Tuesday";s:11:"cm_lang_wed";s:9:"Wednesday";s:11:"cm_lang_thu";s:8:"Thursday";s:11:"cm_lang_fri";s:6:"Friday";s:11:"cm_lang_sat";s:8:"Saturday";s:11:"cm_lang_sun";s:6:"Sunday";}';
    $lang_es = 'a:44:{s:12:"cm_lang_cale";s:10:"Calendario";s:12:"cm_lang_date";s:5:"Fecha";s:12:"cm_lang_span";s:16:"Duratión # dias";s:12:"cm_lang_titl";s:7:"Título";s:12:"cm_lang_time";s:4:"Hora";s:12:"cm_lang_loca";s:5:"Lugar";s:12:"cm_lang_desc";s:12:"Descriptión";s:12:"cm_lang_noen";s:14:"no hay eventos";s:12:"cm_lang_noca";s:28:"no existe ningún calendario";s:18:"cm_lang_dateformat";s:5:"d.m.Y";s:12:"cm_lang_prnt";s:8:"Imprimir";s:12:"cm_lang_ical";s:9:"iCalendar";s:12:"cm_lang_artl";s:12:"vea Articulo";s:12:"cm_lang_lbut";s:2:"<<";s:12:"cm_lang_rbut";s:2:">>";s:12:"cm_lang_bckl";s:5:"atras";s:12:"cm_lang_lstl";s:3:"mas";s:12:"cm_lang_slct";s:10:"Selección";s:12:"cm_lang_undf";s:4:"en #";s:16:"cm_lang_slct_all";s:5:"todos";s:15:"cm_lang_slct_am";s:10:"actual mes";s:15:"cm_lang_slct_ay";s:11:"actual ańo";s:15:"cm_lang_slct_nm";s:15:"proximo # meses";s:15:"cm_lang_slct_ny";s:15:"proximo # ańos";s:15:"cm_lang_slct_lm";s:15:"ultimos # meses";s:11:"cm_lang_jan";s:5:"Enero";s:11:"cm_lang_feb";s:7:"Febrero";s:11:"cm_lang_mar";s:5:"Marzo";s:11:"cm_lang_apr";s:5:"Abril";s:11:"cm_lang_may";s:4:"Mayo";s:11:"cm_lang_jun";s:5:"Junio";s:11:"cm_lang_jul";s:5:"Julio";s:11:"cm_lang_aug";s:6:"Agosto";s:11:"cm_lang_sep";s:10:"Septiembre";s:11:"cm_lang_oct";s:7:"Octubre";s:11:"cm_lang_nov";s:9:"Noviembre";s:11:"cm_lang_dec";s:9:"Diciembre";s:11:"cm_lang_mon";s:5:"Lunes";s:11:"cm_lang_tue";s:6:"Martes";s:11:"cm_lang_wed";s:10:"Miércoles";s:11:"cm_lang_thu";s:6:"Jueves";s:11:"cm_lang_fri";s:7:"Viernes";s:11:"cm_lang_sat";s:7:"Sábado";s:11:"cm_lang_sun";s:7:"Domingo";}';
    $lang_fr = 'a:44:{s:12:"cm_lang_cale";s:10:"Calendrier";s:12:"cm_lang_date";s:4:"Date";s:12:"cm_lang_span";s:14:"Durée # jours";s:12:"cm_lang_titl";s:5:"Titre";s:12:"cm_lang_time";s:5:"Temps";s:12:"cm_lang_loca";s:7:"Endroit";s:12:"cm_lang_desc";s:11:"Description";s:12:"cm_lang_noen";s:14:"aucune entrée";s:12:"cm_lang_noca";s:17:"aucune calendrier";s:18:"cm_lang_dateformat";s:5:"d.m.Y";s:12:"cm_lang_prnt";s:8:"Imprimer";s:12:"cm_lang_ical";s:9:"ICalendar";s:12:"cm_lang_artl";s:7:"Article";s:12:"cm_lang_lbut";s:2:"<<";s:12:"cm_lang_rbut";s:2:">>";s:12:"cm_lang_bckl";s:6:"retour";s:12:"cm_lang_lstl";s:6:"Detail";s:12:"cm_lang_slct";s:13:"Sélectionner";s:12:"cm_lang_undf";s:4:"en #";s:16:"cm_lang_slct_all";s:4:"tous";s:15:"cm_lang_slct_am";s:11:"Mois actuel";s:15:"cm_lang_slct_ay";s:15:"Année actuelle";s:15:"cm_lang_slct_nm";s:16:"prochaine # mois";s:15:"cm_lang_slct_ny";s:19:"prochaine # années";s:15:"cm_lang_slct_lm";s:15:"derniere # mois";s:11:"cm_lang_jan";s:7:"Janvier";s:11:"cm_lang_feb";s:8:"Février";s:11:"cm_lang_mar";s:4:"Mars";s:11:"cm_lang_apr";s:5:"Avril";s:11:"cm_lang_may";s:3:"Mai";s:11:"cm_lang_jun";s:4:"Juin";s:11:"cm_lang_jul";s:7:"Juillet";s:11:"cm_lang_aug";s:5:"Août";s:11:"cm_lang_sep";s:9:"Septembre";s:11:"cm_lang_oct";s:7:"Octobre";s:11:"cm_lang_nov";s:8:"Novembre";s:11:"cm_lang_dec";s:9:"Décembre";s:11:"cm_lang_mon";s:5:"Lundi";s:11:"cm_lang_tue";s:5:"Mardi";s:11:"cm_lang_wed";s:8:"Mercredi";s:11:"cm_lang_thu";s:5:"Jeudi";s:11:"cm_lang_fri";s:8:"Vendredi";s:11:"cm_lang_sat";s:6:"Samedi";s:11:"cm_lang_sun";s:8:"Dimanche";}';
    $lang_de = 'a:44:{s:12:"cm_lang_cale";s:8:"Kalender";s:12:"cm_lang_date";s:5:"Datum";s:12:"cm_lang_span";s:12:"Dauer # Tage";s:12:"cm_lang_titl";s:5:"Titel";s:12:"cm_lang_time";s:4:"Zeit";s:12:"cm_lang_loca";s:3:"Ort";s:12:"cm_lang_desc";s:12:"Beschreibung";s:12:"cm_lang_noen";s:24:"keine Einträge gefunden";s:12:"cm_lang_noca";s:23:"kein Kalender vorhanden";s:18:"cm_lang_dateformat";s:5:"d.m.Y";s:12:"cm_lang_prnt";s:7:"drucken";s:12:"cm_lang_ical";s:9:"ICalendar";s:12:"cm_lang_artl";s:11:"Artikellink";s:12:"cm_lang_lbut";s:2:"<<";s:12:"cm_lang_rbut";s:2:">>";s:12:"cm_lang_bckl";s:7:"zurück";s:12:"cm_lang_lstl";s:6:"Detail";s:12:"cm_lang_slct";s:7:"Auswahl";s:12:"cm_lang_undf";s:4:"im #";s:16:"cm_lang_slct_all";s:14:"alle Einträge";s:15:"cm_lang_slct_am";s:15:"aktueller Monat";s:15:"cm_lang_slct_ay";s:14:"aktuelles Jahr";s:15:"cm_lang_slct_nm";s:17:"nächste # Monate";s:15:"cm_lang_slct_ny";s:16:"nächste # Jahre";s:15:"cm_lang_slct_lm";s:15:"letzte # Monate";s:11:"cm_lang_jan";s:6:"Januar";s:11:"cm_lang_feb";s:7:"Februar";s:11:"cm_lang_mar";s:5:"März";s:11:"cm_lang_apr";s:5:"April";s:11:"cm_lang_may";s:3:"Mai";s:11:"cm_lang_jun";s:4:"Juni";s:11:"cm_lang_jul";s:4:"Juli";s:11:"cm_lang_aug";s:6:"August";s:11:"cm_lang_sep";s:9:"September";s:11:"cm_lang_oct";s:7:"Oktober";s:11:"cm_lang_nov";s:8:"November";s:11:"cm_lang_dec";s:8:"Dezember";s:11:"cm_lang_mon";s:6:"Montag";s:11:"cm_lang_tue";s:8:"Dienstag";s:11:"cm_lang_wed";s:8:"Mittwoch";s:11:"cm_lang_thu";s:10:"Donnerstag";s:11:"cm_lang_fri";s:7:"Freitag";s:11:"cm_lang_sat";s:7:"Samstag";s:11:"cm_lang_sun";s:7:"Sonntag";}';

    $sql_cm[3] = "INSERT INTO `".DB_PREPEND."phpwcms_cmcalendar_language` (`cm_lang_id`, `cm_lang_status`, `cm_lang_createdate`, `cm_lang_changedate`, `cm_lang_name`, `cm_lang_loc`, `cm_lang_sys`, `cm_lang_lang`) VALUES
      (1, 1, '2009-07-07 00:00:00', '2009-07-07 01:00:00', 'English', 'en', '1', '". $lang_en ."'),
      (2, 1, '2009-07-07 00:00:00', '2009-07-07 01:00:00', 'Spanish', 'es', '1', '". $lang_es ."'),
      (3, 1, '2009-07-07 00:00:00', '2009-07-07 01:00:00', 'French (France)', 'fr', '1', '". $lang_fr ."'),
      (4, 1, '2009-07-07 00:00:00', '2009-07-07 01:00:00', 'German (Germany)', 'de', '1', '". $lang_de ."')";


    $sql_error = array();

    //create db tables
    
    if(!_dbQuery($sql_cm[1], 'CREATE')) {
    
    	$sql_error[1] = '<p class="error">Error creating <b>phpwcms_cmcalendar_events</b> initial database table: '.@htmlentities(@mysql_error(), ENT_QUOTES, PHPWCMS_CHARSET).'</p>';
    
    }
    if(!_dbQuery($sql_cm[2], 'CREATE')) {
    
    	$sql_error[2] = '<p class="error">Error creating <b>phpwcms_cmcalendar_language</b> initial database table: '.@htmlentities(@mysql_error(), ENT_QUOTES, PHPWCMS_CHARSET).'</p>';
    
    }
    
    // insert default settings
    if(!isset($sql_error[2]) && !_dbQuery("SELECT COUNT(*) FROM ".DB_PREPEND."phpwcms_cmcalendar_language", 'COUNT')) {
    
    	@_dbQuery($sql_cm[3], 'INSERT');
    	if(@mysql_error()) {
    		$sql_error[3] = '<p class="error">Error inserting default <b>phpwcms_cmcalendar_language</b> entries: '.@htmlentities(@mysql_error(), ENT_QUOTES, PHPWCMS_CHARSET).'</p>';	
    	}
    }
      echo '<p class="title">cmCalendar setup</p>';      
      if(count($sql_error)) {
      	echo implode(LF, $sql_error);
      } else {
      echo '<p class="">cmCalendar setup successful. Please click the module link again to start working with the module!</p>';
      }
      
  } else { //not good
      	echo '<p>'.@htmlentities(@mysql_error(), ENT_QUOTES, PHPWCMS_CHARSET).'</p>';
  }
}
?>