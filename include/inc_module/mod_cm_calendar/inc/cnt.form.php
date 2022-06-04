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

// cmCalendar module content part

// current module vars are stored in $phpwcms['modules'][$content["module"]]
// var to modules path: $phpwcms['modules'][$content["module"]]['path']

// before you can use module content part vars check if value is valid and what you are expect
// when defining modules vars it is always recommend to name t "modulename_varname".

define('PATH_IMG_BACKEND', $phpwcms['modules'][$content["module"]]['dir'].'img/');
include_once($phpwcms['modules'][$content["module"]]['path'].'inc/cm.functions.inc.php');
include_once ('include/inc_lib/news.inc.php');
//mootools
$mootools_more = array(
        'Fx/Fx.Elements',
        'Fx/Fx.Accordion',
        'Fx/Fx.Slide',
        'Fx/Fx.Sort',

        'Drag/Drag',
        'Drag/Drag.Move',
        'Drag/Sortables'
);

//compatibility to phpcms prior to 1.4.7
if (!defined('PHPWCMS_VERSION') || !isset($phpwcms["release"]) ||  $phpwcms["release"] < '1.4.7') {
			unset($GLOBALS['BE']['HEADER']['mootools.js']);
			$GLOBALS['BE']['HEADER']['mootools-1.2-core.js'] = getJavaScriptSourceLink(TEMPLATE_PATH.'lib/mootools/mootools-1.2-core-yc.js');

			if(is_array($mootools_more) && count($mootools_more)) {
				array_unshift($mootools_more, 'Core/More');
				foreach($mootools_more as $item) {
					$name = 'mootools-more-'.$item;
					if(empty($GLOBALS['BE']['HEADER'][$name]) && is_file(PHPWCMS_TEMPLATE.'lib/mootools/more/'.$item.'.js')) {
						$GLOBALS['BE']['HEADER'][$name] = getJavaScriptSourceLink(TEMPLATE_PATH.'lib/mootools/more/'.$item.'.js');
					}
				}
			}
	$GLOBALS['phpwcms']['mootools_mode'] = '1.2';
} else {
initMootools('1.2', $mootools_more);
}

//presettings for all vars
$content['cm_calendar_default'] = array(
  'cals' => array(),
  'template' => '',
  'cm_selection' => '',
  'calrt_css' => '',
  'cm_calrt_artlnk' => 0,
  'cm_calrt_ajax' => 0,
  'cm_calrt_firstday' => 1,
  'eventlist_css' => '',
  'eventlist_print' => 0,
  'eventlist_print_img' => '0.gif',
  'eventlist_ical' => 0,
  'eventlist_ical_img' => '0.gif',
  'eventlist' => 1,
  'cm_calrt' => 0,
  'cm_events_article' => 0,
  'cm_calrt_actdays' => 0,
  'eventlist_asc' => 1,
  'teaserlist' => 0,
  'teaser_anz' => 3,
  'teaser_asc' => 1,
  'cm_teaser_article' => 0,
  'teaser_tpl' => '',
  'teaser_css' => '',
  'teaser_lnk' => 0,
  'teaser_anchor' => 0,
  'cm_calrt_anchor' => 0,
  'eventlist_startdate' => 1,
  'cal_rt_img_leftbut' => '0.gif',
  'cal_rt_img_rightbut' => '0.gif',
  'page_mini_cal' => 0,
  'calrt_number' => 1,
/*-- rss feed --*/
  'cm_rss_active' => 0,
  'cm_rss_title' => '',
  'cm_rss_descr' => '',
  'cm_rss_number' => '',
/*-- start ajax  --*/
  'cm_calrt_ajax' => 0,
  'cm_calrt_ajax_txt' => 1,
  'cm_calrt_ajax_daydig' => 1,
  'cal_rt_img_backlink' => '0.gif',
  'cal_rt_img_listinglink' => '0.gif'
/*-- end ajax  --*/
);

$content['cm_calendar'] = isset($content['cm_calendar']) ? array_merge($content['cm_calendar_default'], $content['cm_calendar']) : $content['cm_calendar_default'];

if(empty($content['cm_calendar']['cals'])) {
	$content['cm_calendar']['cals'] = array();
}

//header additions
$BE['HEADER'][] = '<link rel="stylesheet" type="text/css" href="include/inc_module/mod_cm_calendar/template/msdropdown/dd.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="include/inc_module/mod_cm_calendar/template/msdropdown/js/jquery.dd.js"></script>';

?>
<!-- top spacer - seperate from title/subtitle section -->
<tr><td colspan="2" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
<!-- start selection fields -->
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;"><?php echo $BL['modules'][$content["module"]]['lang_cale'] ?>:&nbsp;</td>
  <td style="padding-bottom:3px;">
  
  <table border="0" cellpadding="0" cellspacing="0" summary="">
	<tr>
		<td><div style="width:400px;"><div style="float:left;width:300px;" id="points">
<?php
    //get all entries
/*    
    [cm_cat_id] => 8
    [cm_cat_created] => 1970-01-01 01:33:29
    [cm_cat_changed] => 1970-01-01 01:33:29
    [cm_cat_name] => kalender
    [cm_cat_status] => 1
*/  
    $sql  = "SELECT * FROM ".DB_PREPEND."phpwcms_cmcalendar_categories  WHERE cm_cat_status != 9 ORDER BY cm_cat_name";
		$catgry = _dbQuery($sql);

    $k=0;
    $cal_list  = '';
		  foreach($catgry as $value) {
        $cal_list  .= '	<option value="'.$value['cm_cat_id'].'"';
        if (in_array($value['cm_cat_id'], $content['cm_calendar']['cals'])) {
          $cal_list  .= ' selected="selected"';
        }
				$cal_list .= '>'.htmlspecialchars($value['cm_cat_name']);
        if ($value['cm_cat_status']==0)  $cal_list .= ' ['.$BL['modules'][$content['module']]['disabled'].']';
        $cal_list .= '</option>'.LF;
			  $k++;
      }
  
    if($k>20) $k=20;
		
?>
		<select name="cals[]" size="<?php echo $k; ?>" multiple class="f11 listrow" id="cals" style="width: 300px">
    <?php echo $cal_list; ?></select></div>
    <div style="float:left;padding:2px;">
		<a href="#cat_anchor2" onclick="document.getElementById('cals').size=document.getElementById('cals').size-2"><img src="img/button/minus_11x11.gif" border="0" alt="-" width="11" height="11"></a><a href="#cat_anchor2" onclick="document.getElementById('cals').size=document.getElementById('cals').size+2"><img src="img/button/add_11x11.gif" border="0" alt="+" width="11" height="11"></a>
		</div></div><div style="clear:both;"></div>
    </td>
	</tr>
	</table></td>
</tr>
<!-- end selection field -->
<!-- little space -->
<tr><td colspan="2" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
<!-- end space -->
<!-- start event listing -->
<tr>
  <td colspan="2" align="left" valign="top" class="chatlist" style="">
    <div class="chatlist" style="position:relative;width:100%;height:30px;">
      <div style="float:left;width:5%;vertical-align:middle;">
        <input type="radio" style="height:20px;" name="eventlist" value="1" id="R20_1" <?php if ($content['cm_calendar']['eventlist']==1) echo"checked='checked' "; ?> />
      </div>
      <div class="" id="toggler1" style="position:relative;float:left;width:95%;height:30px;background-color:#F3F5F8;">
        <label for="R20_1" class="toggle" style="cursor:pointer;display:block;">
          <span class="" style="float:left;width:6%;height:30px;">
            <img style="padding:8px 0 8px 8px;" src="<?php echo $phpwcms['modules'][$content["module"]]['dir'].'img/application_view_list.gif' ?>" alt="entries listing" title="entries listing" />
          </span >
          <span class="chatlist" style="float:left;width:94%;line-height:30px;">
            <?php echo $BL['modules'][$content["module"]]['tpl'] ?>
          </span >
        </label>
      </div>
    </div>
  </td>
</tr>
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<!-- start event template -->

<tr>
  <td colspan="2" valign="top">
    <div class="element" style="width:100%;">
      <table border="0" cellpadding="0" cellspacing="0" summary="" width="100%">

<tr>
  <td width="15%" align="right" valign="top" class="chatlist" style="width:90px;padding-top:3px;"><?php echo $BL['modules'][$content["module"]]['template'] ?>:&nbsp;</td>
	<td><select name="template" id="template" class="f11b">
<?php
	
	echo '<option value="">'.$BL['be_admin_tmpl_default'].'</option>'.LF;

  $tmpllist = get_tmpl_files($phpwcms['modules'][$content["module"]]['dir'].'template/cntpart');
  if(is_array($tmpllist) && count($tmpllist)) {
  	foreach($tmpllist as $val) {
  		$selected_val = (isset($content['cm_calendar']["template"]) && $val == $content['cm_calendar']["template"]) ? ' selected="selected"' : '';
  		$val = html_specialchars($val);
  		echo '	<option value="' . $val . '"' . $selected_val . '>' . $val . '</option>' . LF;
  	}
  }

?>				  
		</select>&nbsp;<span class="chatlist">(/mod_cm_calendar/template/cntpart)</span></td>
</tr>
<!-- end event template -->
<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
<!-- start event css -->
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;"><?php echo $BL['modules'][$content["module"]]['cal_rt_css'] ?>:&nbsp;</td>
	<td><select name="eventlist_css" id="eventlist_css" class="f11b"><?php
	
	echo '<option value="">'.$BL['be_admin_tmpl_default'].'</option>'.LF;

  $csslist = get_tmpl_files($phpwcms['modules'][$content["module"]]['dir'].'template/css','css');
  if(is_array($csslist) && count($csslist)) {
  	foreach($csslist as $valcss) {
  		$selected_css = (isset($content['cm_calendar']["eventlist_css"]) && $valcss == $content['cm_calendar']["eventlist_css"]) ? ' selected="selected"' : '';
  		$valcss = html_specialchars($valcss);
  		echo '	<option value="' . $valcss . '"' . $selected_css . '>' . $valcss . '</option>' . LF;
  	}
  }
?>				  
		</select>&nbsp;<span class="chatlist">(/mod_cm_calendar/template/css)</span></td>
</tr>
<!-- end event css -->
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
<!-- start selection field -->
<tr>
  <td align="right" valign="top" class="chatlist" ><?php echo $BL['modules'][$content["module"]]['cm_selection']; ?>:&nbsp;</td>
  <td valign="top"><table border="0" cellpadding="0" cellspacing="0" summary="">
	<tr><td colspan="2"><textarea rows="5" name="cm_selection" cols="30" class='msgtext' id='cm_selection' style='width:150px'><?php echo $content['cm_calendar']['cm_selection']; ?></textarea></td>
  <td valign="top"><div style="float:left;font-size: 7pt;margin-left:5px;"><?php echo $BL['modules'][$content["module"]]['cm_selection2']; ?></div></td>
	</tr>
<tr><td colspan="3" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>	
	 <tr>
	<td width="20" valign="top" ><input type="checkbox" style="vertical-align:middle;" name="page_mini_cal" value="1" id="R72_1" <?php if ($content['cm_calendar']['page_mini_cal']==1) echo"checked='checked'"; ?> /></td>
  <td valign="top" ><label for="R72_1"><?php echo $BL['modules'][$content["module"]]['page_mini_cal']; ?></label>&nbsp;</td>
  <td><div style="font-size:7pt;margin-left:5px;"><?php echo $BL['modules'][$content["module"]]['page_mini_cal2']; ?></div></td>
  </tr>	
	
	</table></td>
</tr>
<!-- end selection field -->
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
<tr><td>&nbsp;</td><td class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
<!-- start options -->
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;"><?php echo $BL['modules'][$content["module"]]['cal_rt_opt'] ?>:&nbsp;</td>
	<td><table border="0" cellpadding="0" cellspacing="0" summary="">
      <tr>
        <td colspan="2"><?php echo $BL['modules'][$content["module"]]['eventlist_start']; ?>&nbsp;&nbsp;
        <input name="eventlist_startdate" id="R14_3" value="1" type="radio" <?php if ($content['cm_calendar']['eventlist_startdate']==1) echo"checked='checked' "; ?> class=""><label for="R14_3"><?php echo $BL['modules'][$content["module"]]['eventlist_startdate1']; ?></label>&nbsp;
        <input name="eventlist_startdate" id="R14_4" value="2" type="radio" <?php if ($content['cm_calendar']['eventlist_startdate']==2) echo"checked='checked' "; ?> class=""><label for="R14_4"><?php echo $BL['modules'][$content["module"]]['eventlist_startdate2']; ?></label></td>
      </tr></table>
  </td>
</tr>
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;">&nbsp;</td>
	<td><table border="0" cellpadding="0" cellspacing="0" summary="">
      <tr>
        <td colspan="2"><?php echo $BL['modules'][$content["module"]]['eventlist_sort']; ?>&nbsp;&nbsp;
        <input name="eventlist_asc" id="R15_3" value="1" type="radio" <?php if ($content['cm_calendar']['eventlist_asc']==1) echo"checked='checked' "; ?> class=""><label for="R15_3"><?php echo $BL['modules'][$content["module"]]['eventlist_asc']; ?></label>&nbsp;
        <input name="eventlist_asc" id="R15_4" value="2" type="radio" <?php if ($content['cm_calendar']['eventlist_asc']==2) echo"checked='checked' "; ?> class=""><label for="R15_4"><?php echo $BL['modules'][$content["module"]]['eventlist_desc']; ?></label></td>
      </tr></table>
  </td>
</tr>
<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;">&nbsp;</td>
	<td><table border="0" cellpadding="0" cellspacing="0" summary="">
  	 <tr>
      <td width="20"><input type="checkbox" style="vertical-align:middle;" name="eventlist_print" value="1" id="R22_1" <?php if ($content['cm_calendar']['eventlist_print']==1) echo"checked='checked'"; ?> /></td>
      <td><label for="R22_1"><?php echo $BL['modules'][$content["module"]]['eventlist_print1']; ?></label>&nbsp;&nbsp;&nbsp;</td>
      <td><select name="eventlist_print_img" id="eventlist_print_img" style="width:200px;" class="f11b"><?php

    echo '      <option value="0.gif">'.$BL['be_admin_tmpl_default'].'</option>'.LF;
    $csslist = get_tmpl_files($phpwcms['modules'][$content["module"]]['dir'].'template/img','jpg,gif,png');
    if(is_array($csslist) && count($csslist)) {
    	foreach($csslist as $valcss) {
    		$selected_css = (isset($content['cm_calendar']["eventlist_print_img"]) && $valcss == $content['cm_calendar']["eventlist_print_img"]) ? ' selected="selected"' : '';
    		$valcss = html_specialchars($valcss);
    		if ($valcss != '0.gif') echo '      <option value="' . $valcss . '"' . $selected_css . ' title="'.$phpwcms['modules'][$content["module"]]['dir'].'template/img/'.$valcss.'">' . $valcss . '</option>' . LF;
    	}
    }
?>    </select></td>
    </tr>
    <tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
  	<tr>
    	<td width="20"><input type="checkbox" style="vertical-align:middle;" name="eventlist_ical" value="1" id="R22_2" <?php if ($content['cm_calendar']['eventlist_ical']==1) echo"checked='checked'"; ?> /></td>
      <td><label for="R22_2"><?php echo $BL['modules'][$content["module"]]['eventlist_ical1']; ?></label>&nbsp;&nbsp;&nbsp;</td>
      <td><select name="eventlist_ical_img" id="eventlist_ical_img" style="width:200px;" class="f11b"><?php

  	echo '     <option value="0.gif">'.$BL['be_admin_tmpl_default'].'</option>'.LF;

    $csslist = get_tmpl_files($phpwcms['modules'][$content["module"]]['dir'].'template/img','jpg,gif,png');
    if(is_array($csslist) && count($csslist)) {
    	foreach($csslist as $valcss) {
    		$selected_css = (isset($content['cm_calendar']["eventlist_ical_img"]) && $valcss == $content['cm_calendar']["eventlist_ical_img"]) ? ' selected="selected"' : '';
    		$valcss = html_specialchars($valcss);
    		if ($valcss != '0.gif') echo '      <option value="' . $valcss . '"' . $selected_css . ' title="'.$phpwcms['modules'][$content["module"]]['dir'].'template/img/'.$valcss.'">' . $valcss . '</option>' . LF;
    	}
    }
?>      </select></td>
    </tr>
    <tr><td colspan="2"></td><td><span class="chatlist">(/mod_cm_calendar/template/img)</span></td></tr>
    </table>
  </td>
</tr>
<!-- end options -->
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
<tr><td>&nbsp;</td><td class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
<!-- start rss -->
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;"><?php echo $BL['modules'][$content["module"]]['cm_rss_feed'] ?>:&nbsp;</td>
	<td><table border="0" cellpadding="0" cellspacing="0" summary="">
  	 <tr>
      <td align="right" class="chatlist">&nbsp;</td>
      <td><input type="checkbox" style="vertical-align:middle;" name="cm_rss_active" value="1" id="R92_1" <?php is_checked($content['cm_calendar']['cm_rss_active'], 1) ?> />
      <label for="R92_1" class="chatlist"><?php echo $BL['modules'][$content["module"]]['cm_rss_activate'] ?></label></td>
    </tr>
  	 <tr>
      <td align="right" class="chatlist">&nbsp;</td>
      <td class="chatlist"><?php
if (file_exists(PHPWCMS_ROOT.'/content/rss/feed-calendar-'.$content['aid'].'-'.$content['id'].'.xml')) {

echo '(/content/rss/feed-calendar-'.$content['aid'].'-'.$content['id'].'.xml)&nbsp;<a href="phpwcms.php?do=modules&module=br_cm_calendar">'.$BL['modules'][$content["module"]]['cm_rss_todelete'].'</a>';
} else {

echo $BL['modules'][$content["module"]]['cm_rss_fileex'];
}
 ?>
</td>
    </tr>
    <tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
  	 <tr>
      <td align="right" class="chatlist"><?php echo $BL['modules'][$content["module"]]['cm_rss_title'] ?>:&nbsp;</td>
      <td><input type="text" maxlength="255" name="cm_rss_title" value="<?php echo $content['cm_calendar']['cm_rss_title']; ?>" class="f11b" style="width:300px;" />
          </td>
    </tr>
    <tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
  	 <tr>
      <td align="right" class="chatlist" valign="top"><?php echo $BL['modules'][$content["module"]]['cm_rss_descr'] ?>:&nbsp;</td>
      <td><textarea rows="4" name="cm_rss_descr" cols="30" class='msgtext' id='cm_rss_descr' style='width:300px'><?php echo $content['cm_calendar']['cm_rss_descr']; ?></textarea></td>
    </tr>
    <tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
    <tr>
      <td align="right" class="chatlist">&nbsp;</td>
      <td><input type="text" maxlength="3" name="cm_rss_number" value="<?php echo $content['cm_calendar']['cm_rss_number']; ?>" class="f11b" style="width:50px;" /><span class="chatlist">&nbsp;<?php echo $BL['modules'][$content["module"]]['cm_rss_number'] ?></span></td>
    </tr>
    <tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
    </table>

  </td>
</tr>
<!-- end rss -->

      </table>
    </div>
  </td>
</tr>
<!-- end event listing -->

<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<tr><td colspan="2" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>

<!-- start teaser listing -->
<tr>
  <td colspan="2" align="left" valign="top" class="chatlist" style="">
    <div style="position:relative;width:100%;height:30px;">
      <div style="float:left;width:5%;vertical-align:middle;">
        <input type="radio" style="height:20px;" name="eventlist" value="2" id="R30_1" <?php if ($content['cm_calendar']['eventlist'] == 2) echo "checked='checked'"; ?> />
      </div>
      <div class="" id="toggler2" style="position:relative;float:left;width:95%;height:30px;background-color:#F3F5F8;">
        <label for="R30_1" class="toggle" style="cursor:pointer;display:block;">
          <span class="" style="float:left;width:6%;height:30px;">
            <img style="padding:8px 0 8px 8px;" src="<?php echo $phpwcms['modules'][$content["module"]]['dir'].'img/application_split.gif' ?>" alt="teaser listing" title="teaser listing" />
          </span >
          <span  class="chatlist" style="float:left;width:64%;line-height:30px;">
            <?php echo $BL['modules'][$content["module"]]['teaser'] ?>
          </span >
        </label>
        <div style="float:right;width:30%;line-height:30px;">
          <?php echo $BL['modules'][$content["module"]]['teaser_anz1']; ?>
            &nbsp;<input type="text" name="teaser_anz" value="<?php echo $content['cm_calendar']["teaser_anz"]; ?>" class="f11b width30">&nbsp;&nbsp;
          <?php echo $BL['modules'][$content["module"]]['teaser_anz2']; ?>&nbsp;
        </div>
      </div>
    </div>
  </td>
</tr>
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<!-- start teaser template -->

<tr>
  <td colspan="2" valign="top">
    <div class="element" style="width:100%;">
      <table border="0" cellpadding="0" cellspacing="0" summary="" width="100%">

<tr>
  <td width="15%" align="right" valign="top" class="chatlist" style="padding-top:3px;"><?php echo $BL['modules'][$content["module"]]['template'] ?>:&nbsp;</td>
	<td><select name="teaser_tpl" id="teaser_tpl" class="f11b"><?php
	
	echo '     <option value="">'.$BL['be_admin_tmpl_default'].'</option>'.LF;
  $tmpllist = get_tmpl_files($phpwcms['modules'][$content["module"]]['dir'].'template/cntpart');
  if(is_array($tmpllist) && count($tmpllist)) {
  	foreach($tmpllist as $val) {
  		$selected_val = (isset($content['cm_calendar']["template"]) && $val == $content['cm_calendar']["teaser_tpl"]) ? ' selected="selected"' : '';
  		$val = html_specialchars($val);
  		echo '      <option value="' . $val . '"' . $selected_val . '>' . $val . '</option>' . LF;
  	}
  }
?>      </select> <span class="chatlist">(/mod_cm_calendar/template/cntpart)</span></td>
</tr>
<!-- end teaser template -->
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<!-- start teaser css -->
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;"><?php echo $BL['modules'][$content["module"]]['cal_rt_css'] ?>:&nbsp;</td>
	<td><select name="teaser_css" id="teaser_css" class="f11b"><?php
	
	echo '     <option value="">'.$BL['be_admin_tmpl_default'].'</option>'.LF;

  $csslist = get_tmpl_files($phpwcms['modules'][$content["module"]]['dir'].'template/css','css');
  if(is_array($csslist) && count($csslist)) {
  	foreach($csslist as $valcss) {
  		$selected_css = (isset($content['cm_calendar']["eventlist_css"]) && $valcss == $content['cm_calendar']["teaser_css"]) ? ' selected="selected"' : '';
  		$valcss = html_specialchars($valcss);
  		echo '      <option value="' . $valcss . '"' . $selected_css . '>' . $valcss . '</option>' . LF;
  	}
  }
?>      </select> <span class="chatlist">(/mod_cm_calendar/template/css)</span></td>
</tr>
<!-- end teaser css -->
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<!-- start teaser options -->
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;"><?php echo $BL['modules'][$content["module"]]['cal_rt_opt'] ?>:&nbsp;</td>
	<td><table border="0" cellpadding="0" cellspacing="0" summary="">
      <tr>
        <td colspan="2"><?php echo $BL['modules'][$content["module"]]['eventlist_sort']; ?>&nbsp;&nbsp;
        <input name="teaser_asc" id="R35_3" value="1" type="radio" <?php if ($content['cm_calendar']['teaser_asc']==1) echo"checked='checked' "; ?> class=""><label for="R35_3"><?php echo $BL['modules'][$content["module"]]['eventlist_asc']; ?></label>&nbsp;
        <input name="teaser_asc" id="R35_4" value="2" type="radio" <?php if ($content['cm_calendar']['teaser_asc']==2) echo"checked='checked' "; ?> class=""><label for="R35_4"><?php echo $BL['modules'][$content["module"]]['eventlist_desc']; ?></label></td>
      </tr></table>
  </td>
</tr>
<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;">&nbsp;</td>
	<td><table border="0" cellpadding="0" cellspacing="0" summary="">
	 <tr>
	<td width="20"><input type="checkbox" style="vertical-align:middle;" name="teaser_lnk" value="1" id="R32_1" <?php if ($content['cm_calendar']['teaser_lnk']==1) echo"checked='checked'"; ?> /></td>
  <td><label for="R32_1"><?php echo $BL['modules'][$content["module"]]['teaser_lnk']; ?></label>&nbsp;&nbsp;&nbsp;</td>
  <td><?php echo cmShowArticles($content['cm_calendar']['cm_teaser_article'],'cm_teaser_article',$BL['modules'][$content["module"]]['no_art'],150); ?></td>
  <td width="20"><input type="checkbox" style="vertical-align:middle;" name="teaser_anchor" value="1" id="R32_8" <?php if ($content['cm_calendar']['teaser_anchor']==1) echo"checked='checked'"; ?> /></td>
  <td><label for="R32_8"><?php echo $BL['modules'][$content["module"]]['teaser_anchor']; ?></label></td>
    </tr>
    <tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td><td colspan="3"></td></tr>
    </table>
  </td>
</tr>
<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;">&nbsp;</td>
	<td><span style="font-size: 7pt;"><?php echo $BL['modules'][$content["module"]]['teaser_rt']; ?>: <?php echo '{SHOW_CONTENT:CP,'.$content['id'].'}'; ?></span></td>
</tr>
<!-- end teaser options -->

      </table>
    </div>
  </td>
</tr>
<!-- end teaser listing -->

<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<tr><td colspan="2" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>

<!-- start minicalendar view  -->
<tr>
  <td colspan="2" align="left" valign="top" class="chatlist" style="">
    <div style="position:relative;width:100%;height:30px;">
      <div style="float:left;width:5%;vertical-align:middle;">
        <input type="radio" style="height:20px;" name="eventlist" value="3" id="R20_2" <?php if ($content['cm_calendar']['eventlist']==3) echo"checked='checked'"; ?> />
      </div>
      <div class="" id="toggler3" style="position:relative;float:left;width:95%;height:30px;background-color:#F3F5F8;">
        <label for="R20_2" class="toggle" style="cursor:pointer;display:block;">
          <span class="" style="float:left;width:6%;height:30px;">
            <img style="padding:8px 0 8px 8px;" src="<?php echo $phpwcms['modules'][$content["module"]]['dir'].'img/calendar.gif' ?>" alt="calendar replacement tag" title="calendar replacement tag" />
          </span >
          <span  class="chatlist" style="float:left;width:64%;line-height:30px;">
            <?php echo $BL['modules'][$content["module"]]['cal_view'] ?>
          </span >
        </label>
        <div style="float:right;width:30%;line-height:30px;"><?php
$value = "<select name=\"calrt_number\">\n";
	for ($i=1; $i<=12; $i++) {
		$value .= "<option value=\"$i\"";
		if ($i == $content['cm_calendar']['calrt_number'])
			$value .= "selected='selected'";
		$value .= ">$i</option>\n";
	}
	$value .= "</select>\n";
      echo $BL['modules'][$content["module"]]['calrt_showmonth'].' '.$value.' '.$BL['modules'][$content["module"]]['calrt_numbermonth'].'&nbsp;';
      ?></div>
      </div>
    </div>
  </td>
</tr>
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>

<tr>
  <td colspan="2" valign="top">
    <div class="element" style="width:100%;">
      <table border="0" cellpadding="0" cellspacing="0" summary="" width="100%">

<tr>  
  <td width="15%" align="right" valign="top" class="chatlist" style="padding-top:3px;">&nbsp;</td>
  <td style="padding-bottom:3px;"><span style="font-size: 7pt;"><?php echo $BL['modules'][$content["module"]]['cal_rt_1'] ?></span>
  <br /><span style="font-size: 7pt;"><?php echo $BL['modules'][$content["module"]]['cal_rt_2'] ?>: <?php echo '{CM_CALENDAR}{SHOW_CONTENT:CP,'.$content['id'].'}'; ?><br /><br /><?php echo $BL['modules'][$content["module"]]['cal_rt_3'] ?></span></td>
</tr>
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<!-- start minicalendar css  -->
<tr>
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;"><?php echo $BL['modules'][$content["module"]]['cal_rt_css'] ?>:&nbsp;</td>
	<td><select name="calrt_css" id="calrt_css" class="f11b">
<?php
	
	echo '     <option value="">'.$BL['be_admin_tmpl_default'].'</option>'.LF;

  $csslist = get_tmpl_files($phpwcms['modules'][$content["module"]]['dir'].'template/css','css');
  if(is_array($csslist) && count($csslist)) {
  	foreach($csslist as $valcss) {
  		$selected_css = (isset($content['cm_calendar']["calrt_css"]) && $valcss == $content['cm_calendar']["calrt_css"]) ? ' selected="selected"' : '';
  		$valcss = html_specialchars($valcss);
  		echo '      <option value="' . $valcss . '"' . $selected_css . '>' . $valcss . '</option>' . LF;
  	}
  }
?>      </select> <span class="chatlist">(/mod_cm_calendar/template/css)</span></td>
</tr>
<!-- end minicalendar css  -->
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<!-- start minicalendar options  -->
<tr>  
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;"><?php echo $BL['modules'][$content["module"]]['cal_rt_opt'] ?>:&nbsp;</td>  
  <td style="padding-bottom:3px;">     
    <table border="0" cellpadding="0" cellspacing="0" summary="">	
      <tr>
				<td width="20"><input type="checkbox" style="vertical-align:middle;" name="cm_calrt_artlnk" value="1" id="R25_1" <?php if ($content['cm_calendar']['cm_calrt_artlnk']==1) echo"checked='checked'"; ?> /></td>
        <td><label for="R25_1"><?php echo $BL['modules'][$content["module"]]['cm_calrt_artlnk']; ?></label>&nbsp;</td>
      </tr>	
      <tr>
				<td width="20"><input type="checkbox" style="vertical-align:middle;" name="cm_calrt_actdays" value="1" id="R25_2" <?php if ($content['cm_calendar']['cm_calrt_actdays']==1) echo"checked='checked'"; ?> /></td>
        <td><label for="R25_2"><?php echo $BL['modules'][$content["module"]]['cm_calrt_actdays']; ?></label>&nbsp;<?php echo cmShowArticles($content['cm_calendar']['cm_events_article'],'cm_events_article',$BL['modules'][$content["module"]]['no_art']); ?></td>
      </tr>
      <tr>
        <td width="20">&nbsp;</td>
        <td><input type="checkbox" style="vertical-align:middle;" name="cm_calrt_anchor" value="1" id="R25_8" <?php if ($content['cm_calendar']['cm_calrt_anchor']==1) echo"checked='checked'"; ?> /><label for="R25_8"><?php echo $BL['modules'][$content["module"]]['cm_calrt_anchor']; ?></label></td>
      </tr>
      <!-- tr>
				<td width="20"><input type="checkbox" style="vertical-align:middle;" name="cm_calrt_ajax" value="1" id="R25_2" <?php if ($content['cm_calendar']['cm_calrt_ajax']==1) echo"checked='checked'"; ?> /></td>
        <td><label for="R25_2"><?php echo $BL['modules'][$content["module"]]['cm_calrt_ajax']; ?></label>&nbsp;</td>
      </tr -->	
      <tr>
        <td colspan="2"><?php echo $BL['modules'][$content["module"]]['cm_calrt_firstday']; ?>&nbsp;&nbsp;
        <input name="cm_calrt_firstday" id="R25_3" value="1" type="radio" <?php if ($content['cm_calendar']['cm_calrt_firstday']==1) echo"checked='checked' "; ?> class=""><label for="R25_3"><?php echo $BL['modules'][$content["module"]]['lang_mon']; ?></label>&nbsp;
        <input name="cm_calrt_firstday" id="R25_4" value="2" type="radio" <?php if ($content['cm_calendar']['cm_calrt_firstday']==2) echo"checked='checked' "; ?> class=""><label for="R25_4"><?php echo $BL['modules'][$content["module"]]['lang_sun']; ?></label></td>
      </tr>
    </table>
  </td>
</tr>
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
<!-- start minicalendar images  -->
<tr>  
  <td align="right" valign="top" class="chatlist" style="padding-top:3px;">&nbsp;</td>  
	<td><table width="100%" border="0" cellpadding="0" cellspacing="0" summary="">
	 <tr>
    <td width="30%"><?php echo $BL['modules'][$content["module"]]['cal_rt_img_leftbut']; ?>&nbsp;</td>
    <td><select name="cal_rt_img_leftbut" id="cal_rt_img_leftbut" style="width:200px;" class="f11b"><?php
  	
  	echo '     <option value="0.gif">'.$BL['be_admin_tmpl_default'].'</option>'.LF;
  
    $csslist = get_tmpl_files($phpwcms['modules'][$content["module"]]['dir'].'template/img','jpg,gif,png');
    if(is_array($csslist) && count($csslist)) {
    	foreach($csslist as $valcss) {
    		$selected_css = (isset($content['cm_calendar']["cal_rt_img_leftbut"]) && $valcss == $content['cm_calendar']["cal_rt_img_leftbut"]) ? ' selected="selected"' : '';
    		$valcss = html_specialchars($valcss);
    		if ($valcss != '0.gif') echo '      <option value="' . $valcss . '"' . $selected_css . ' title="'.$phpwcms['modules'][$content["module"]]['dir'].'template/img/'.$valcss.'">' . $valcss . '</option>' . LF;
    	}
    }
  
  ?>
  		</select></td>
    </tr>
    <tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
	  <tr>
      <td><?php echo $BL['modules'][$content["module"]]['cal_rt_img_rightbut']; ?>&nbsp;</td>
      <td><select name="cal_rt_img_rightbut" id="cal_rt_img_rightbut" style="width:200px;" class="f11b"><?php
    	
    	echo '     <option value="0.gif">'.$BL['be_admin_tmpl_default'].'</option>'.LF;
    
    $csslist = get_tmpl_files($phpwcms['modules'][$content["module"]]['dir'].'template/img','jpg,gif,png');
    if(is_array($csslist) && count($csslist)) {
    	foreach($csslist as $valcss) {
    		$selected_css = (isset($content['cm_calendar']["cal_rt_img_rightbut"]) && $valcss == $content['cm_calendar']["cal_rt_img_rightbut"]) ? ' selected="selected"' : '';
    		$valcss = html_specialchars($valcss);
    		if ($valcss != '0.gif') echo '      <option value="' . $valcss . '"' . $selected_css . ' title="'.$phpwcms['modules'][$content["module"]]['dir'].'template/img/'.$valcss.'">' . $valcss . '</option>' . LF;
    	}
    }
    
    ?>				  
    		</select></td>
    </tr>
    <tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
    <tr><td></td><td><span class="chatlist">(/mod_cm_calendar/template/img)</span></td></tr></table>
  </td>
</tr>
<!-- end minicalendar images  -->
<!-- end minicalendar options  -->
<tr><td colspan="2" class=""><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<tr><td>&nbsp;</td><td class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
<!-- start ajax  -->
<tr><td colspan="2">
  <input type="hidden" name="cm_calrt_ajax" value="0" />
  <input type="hidden" name="cm_calrt_ajax_txt" value="1" />
  <input type="hidden" name="cm_calrt_ajax_daydig" value="1" />
  <input type="hidden" name="cal_rt_img_backlink" value="0.gif" />
  <input type="hidden" name="cal_rt_img_listinglink" value="0.gif" />
</td></tr>
<!-- end ajax  -->
<!-- end minicalendar view  -->

</table></div></td></tr>

<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
<tr><td colspan="2" class="rowspacer0x7">

<script type="text/javascript">
<!--
window.addEvent('domready', function() {

    var myAccordion = new Fx.Accordion($$('.toggle'), $$('.element'), {
        display: -1,
        alwaysHide: true,
        onActive: function(toggler, element){
          var property = 'background-color';
          var to = "#CCFF00";
          var parent = toggler.getParent();
          parent.tween(property, to);
     //     toggler.parentNode.tween(property, to);
        },
        onBackground: function(toggler, element){
          var property = 'background-color';
          var to = "#F3F5F8";
          var parent = toggler.getParent();
          parent.tween(property, to);
     //     toggler.parentNode.tween(property, to);
        }
    });

});

function showvalue(arg) {
	alert(arg);
	//arg.visible(false);
}

try {
		$("#eventlist_ical_img").msDropDown();
		$("#eventlist_print_img").msDropDown();
		$("#cal_rt_img_leftbut").msDropDown();
		$("#cal_rt_img_rightbut").msDropDown();
//only for ajax version
//		$("#cal_rt_img_backlink").msDropDown();
//    $("#cal_rt_img_listinglink").msDropDown();

		$("#ver").html($.msDropDown.version);
		} catch(e) {
			alert("Error: "+e.message);
		}

//-->
</script>
</td></tr>
<!-- bottom spacer - is followed by status "visible" checkbox -->
