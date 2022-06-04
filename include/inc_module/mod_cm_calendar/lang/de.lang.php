<?php
/*************************************************************************************

  Copyright notice

  cmCalendar Module v1 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2009
  cmCalendar Module v1.2 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2012

  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS.

   (c) 2002-2012 Oliver Georgi (oliver@phpwcms.de) // All rights reserved.

*************************************************************************************/
//English

// first define main language vars
$BLM['backend_menu']		     	= 'cmCalendar';

//module section
$BLM['listing_title']			    = 'cmCalendar';
//tabs
$BLM['tab_cal']	              = 'Kalender';
$BLM['tab_events']	          = 'Events';
$BLM['tab_cp']	              = '&Uuml;bersicht';
$BLM['tab_lang']	            = 'Sprache';
$BLM['tab_about']	            = '?';

//cal

$BLM['delete_entry']          = 'l&ouml;schen';
$BLM['create_new_cal']        = 'neuen Kalender hinzuf&uuml;gen';


$BLM['cm_cal']                = 'Kalender';
$BLM['cal_name']              = 'Kalender';

//events

$BLM['delete_entry']          = 'l&ouml;schen';
$BLM['delete_entryset']       = 'Set l&ouml;schen';
$BLM['create_new_events']     = 'neuen Event hinzuf&uuml;gen';
$BLM['show_olddates']         = 'alte Eintr&auml;ge';

$BLM['cm_events']             = 'Event';
$BLM['events_name']           = 'Event';
$BLM['entry_date']            = 'Datum';
$BLM['entry_time']            = 'Zeit';
$BLM['entry_span']            = 'Spanne';
$BLM['entry_title']           = 'Titel';
$BLM['entry_location']        = 'Ort';
$BLM['entry_descr']           = 'Beschreibung';
$BLM['entry_artlnk']          = 'Artikellink';
$BLM['entry_cal']             = 'Kalender';
$BLM['entry_dateformat']      = 'd.m.Y';
$BLM['entry_opendate']        = 'Datum offen';
$BLM['entry_opendate1']       = '(prov. Datum trotzdem erforderlich! Nur mit Anzahl Tage: 1 verwenden! Anzeige: z.B. \'im Oktober\')';
$BLM['entry_multi']           = 'CTRL + Click f&uuml;r Mehrfach- auswahl';
$BLM['entry_seedescr']        = 'Beschreibung Vorschau';
$BLM['entry_incal1']          = 'in';
$BLM['entry_incal2']          = 'Kalendern';
$BLM['sheduleOptions']        = 'Wiederholungsoptionen';
$BLM['singleEvent']           = 'Einzelner Event';
$BLM['singleEvent_instruct']  = 'wird nicht wiederholt.';
$BLM['weekly']                = 't&auml;glich';
$BLM['weekly_instruct']       = 'jeden';
$BLM['weekly_instruct2']       = '. Tag (7 f&uuml;r w&ouml;chentlich) bis';
$BLM['monthly']               = 'monatlich';
$BLM['monthly_instructWeekday'] = 'nach Wochentag bis<br />(z.B. "jeden 2. Dienstag")';
$BLM['monthly_instructDate']  = 'nach Datum bis<br />(z.B. "jeden 5. des Monats")';
$BLM['entry_set']             = 'Set';
$BLM['teaser_txt']            = 'Teaser';
$BLM['entry_uid']             = 'Termin Besitzer';

//cp
$BLM['cm_cp_update']          ='Update';
$BLM['cm_cp_nofile']          ='Keinen Content-Part f&uuml;r Plugin cmCalendar gefunden';
$BLM['cm_cp_actcals']         ='Aktive Kalender:';
$BLM['cm_cp_nosel']           ='keine ausgew&auml;hlt';
$BLM['delete_entry']          ='l&ouml;schen';
$BLM['cm_cp_rss']             ='Zeige Feed';
$BLM['cm_cp_title']           ='&Uuml;bersicht zu Kalender Content-Parts in der Website';

//language
$BLM['create_new_lang']       = 'neue Frontend Sprache';
$BLM['cm_lang_lang']          = 'Sprache';
//edit
$BLM['lang_name']             = 'Sprache';
$BLM['lang_sys']              = 'miles/km';
$BLM['lang_cale']             = 'Kalender';
$BLM['lang_date']             = 'Datum';
$BLM['lang_span']             = 'Spanne';
$BLM['lang_span_exmpl']       = 'Bsp: Dauer # Tage';
$BLM['lang_titl']             = 'Titel';
$BLM['lang_time']             = 'Zeit';
$BLM['lang_loca']             = 'Ort';
$BLM['lang_desc']             = 'Beschreibung';
$BLM['lang_noen']             = 'keine Eintr&auml;ge gefunden';
$BLM['lang_noca']             = 'keinen Kalender gefunden';
$BLM['lang_dateformat']       = 'Datumsformat';
$BLM['lang_prnt']             = 'Drucken';
$BLM['lang_ical']             = 'iCalendar';
$BLM['lang_artl']             = 'Artikellink';
$BLM['lang_slct']             = 'Auswahl';
$BLM['lang_undf']             = 'undefiniertes Datum';
$BLM['lang_undf_exmpl']       = 'Bsp: im #(ersetzt durch Monat)';

$BLM['lang_slct_all']         = 'alle';
$BLM['lang_slct_am']          = 'aktueller Monat';
$BLM['lang_slct_ay']          = 'aktuelles Jahr';
$BLM['lang_slct_nm']          = 'n&auml;chsten Monat';
$BLM['lang_slct_nm_exmpl']    = 'Bsp: n&auml;chste # Monate';
$BLM['lang_slct_ny']          = 'n&auml;chstes Jahr';
$BLM['lang_slct_ny_exmpl']    = 'Bsp: n&auml;chste # Jahre';
$BLM['lang_slct_lm']          = 'letzte Monate';
$BLM['lang_slct_lm_exmpl']    = 'Bsp: letzte # Monate';

// language pack titles
$BLM['lang_jan']               = "Januar";
$BLM['lang_feb']               = "Februar";
$BLM['lang_mar']               = "M&auml;rz";
$BLM['lang_apr']               = "April";
$BLM['lang_may']               = "Mai";
$BLM['lang_jun']               = "Juni";
$BLM['lang_jul']               = "July";
$BLM['lang_aug']               = "August";
$BLM['lang_sep']               = "September";
$BLM['lang_oct']               = "Oktober";
$BLM['lang_nov']               = "November";
$BLM['lang_dec']               = "Dezember";

$BLM['lang_mon']               = "Montag";
$BLM['lang_tue']               = "Dienstag";
$BLM['lang_wed']               = "Mittwoch";
$BLM['lang_thu']               = "Donnerstag";
$BLM['lang_fri']               = "Freitag";
$BLM['lang_sat']               = "Samstag";
$BLM['lang_sun']               = "Sonntag";

$BLM['lang_exist']             = "Sprache existiert schon!";
$BLM['delete_lang']            = "Sprache l&ouml;schen: ";

//cp
$BLM['lang_calselect']         = 'Kalender ausw&auml;hlen...';
$BLM['template']               = 'Template';
$BLM['tpl']                    = 'Event Listing';
$BLM['cm_selection']           = 'Auswahl';
$BLM['cm_selection2']          = 'benutze [ALL][NEXT][ACTUAL][LAST][MONTH][YEAR][DEFAULT]<br />Bsp:<br />[ALL][DEFAULT]<br />[ACTUAL][MONTH]<br />[NEXT][3][MONTH]<br />[LAST][2][MONTH]';
$BLM['cal_view']               = 'Kalender Ansicht';
$BLM['cal_rt_1']               = 'Replacement Tag f&uuml;r die Kalender Ansicht ist {CM_CALENDAR}<br />Kann im Templates benutzt werden, wenn der aktuelle Content Part in der Seitenansicht sichtbar ist.';
$BLM['cal_rt_2']               = 'Um die Kalender Ansicht &uuml;berall in den Templates zu benutzen, speichern Sie den aktuellen Content Part in einer versteckten Kategorie und benutzen Sie das Replacement Tag';
$BLM['cal_rt_3']               = 'Die Anordnung mehrerer Kalendermonate steuern Sie per CSS';
$BLM['cal_rt_css']             = 'CSS Datei';
$BLM['cal_rt_opt']             = 'Optionen';
$BLM['cm_calrt_artlnk']        = 'Artikellinks aktivieren';
$BLM['cm_calrt_firstday']      = 'erster Tag der Woche';
$BLM['cm_calrt_ajax']          = 'activate AJAX';
$BLM['eventlist_print']        = 'Listing ausdrucken';
$BLM['eventlist_print1']       = 'Drucken-Link aktivieren';
$BLM['eventlist_print_img']    = 'Bild';
$BLM['eventlist_ical']         = 'ICalendar';
$BLM['eventlist_ical1']        = 'ICal-Link aktivieren';
$BLM['eventlist_ical_img']     = 'Bild';
$BLM['cm_calrt_actdays']       = 'Aktive Tage verlinken zu';
$BLM['eventlist_sort']         = 'Sortierung';
$BLM['eventlist_asc']          = 'aufsteigend';
$BLM['eventlist_desc']         = 'absteigend';
$BLM['no_art']                 = 'kein Artikel';
$BLM['teaser']                 = 'Teaser-Listing';
$BLM['teaser_lnk']             = 'Teaser linkt zu';
$BLM['teaser_anz1']            = 'n&auml;chste';
$BLM['teaser_anz2']            = 'Events';
$BLM['teaser_rt']              = 'Replacement Tag';
$BLM['teaser_anchor']          = 'Sprung zu Anker';
$BLM['cm_calrt_anchor']        = 'Sprung zu Anker';
$BLM['eventlist_start']        = 'beginne mit';
$BLM['eventlist_startdate1']   = 'aktueller/s Monat/Jahr';
$BLM['eventlist_startdate2']   = 'aktueller Tag';
$BLM['cal_rt_img_leftbut']     = 'Button nach links';
$BLM['cal_rt_img_rightbut']    = 'Button nach rechts';
$BLM['disabled']               = 'inaktiv';
$BLM['page_mini_cal']          = 'nur Monatsansicht';
$BLM['page_mini_cal2']         = 'Aktivieren Sie diese Option wenn per Default nur der aktuelle Monat oder der im Mini Kalender ausge&auml;hlte Monat angezeigt werden soll, wenn keine andere Auswahl gem&auml;ss obiger Liste aktiv ist.';
$BLM['calrt_showmonth']        = 'zeige';
$BLM['calrt_numbermonth']      = 'Monate';

$BLM['cm_rss_activate'] = 'aktiv';
$BLM['cm_rss_feed'] = 'RSS Feed';
$BLM['cm_rss_todelete'] = 'hier zum L&ouml;schen';
$BLM['cm_rss_title'] = 'Titel';
$BLM['cm_rss_descr'] = 'Beschreibung';
$BLM['cm_rss_number'] = 'Anzahl Feeds';
$BLM['cm_rss_fileex'] = 'Datei existiert (noch) nicht';

/*-- start ajax  --*/
$BLM['cal_rt_images']          = 'Links';
$BLM['cal_rt_img_backlink']    = 'Zur&uuml;ck Link';
$BLM['cal_rt_img_listinglink'] = 'Link zu Listing';
$BLM['cm_calrt_ajax_expl']     = '&Ouml;ffnet aktive Tage in einer Detailansicht innerhalb des Mini Kalenders. Links zu Listing und Artikel werden in dieser Detailansicht angezeigt. Das Template f&uuml;r die Detailansicht ist ajax_day.tmpl im Verzeichnis template/cntpart.';
$BLM['cm_calrt_ajax_txt']      = 'Nimm';
$BLM['cm_calrt_ajax_txt1']     = 'Teaser Text';
$BLM['cm_calrt_ajax_txt2']     = 'Beschreibung Text';
$BLM['cm_calrt_ajax_daydig']   = 'Anzahl Zeichen in Wochentagen';
/*-- end ajax  --*/

//overall use
$BLM['filtered_list']          = 'gefilterte Liste';
$BLM['show_all']               = 'zeige alle';
$BLM['delete_entry']           = 'l&ouml;sche Event:';
$BLM['no_entry']               = 'keine Eintr&auml;ge gefunden';
$BLM['delete']                 = 'l&ouml;schen';

?>