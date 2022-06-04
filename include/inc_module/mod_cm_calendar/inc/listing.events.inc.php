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
$_entry['query']			= '';
$highlight_showold =false;

// create pagination
if(isset($_GET['c'])) {
	$_SESSION['list_user_count_events'] = $_GET['c'] == 'all' ? '99999' : intval($_GET['c']);
	if( $_GET['c'] == 'all'){
    $_POST['filter'] = '';
    unset($_SESSION['filter_events']);
    unset($_SESSION['list_user_sort']);
    $_SESSION['list_active_events'] = 1;
    $_SESSION['list_inactive_events'] = 1;
    unset($_SESSION['list_showold']);
    unset($_POST["month"]);
    unset($_GET["month"]);
    unset($_POST["year"]);
    unset($_GET["year"]);
    unset($_SESSION['actcat']);
    unset($_SESSION['list_reset']);
    unset($_SESSION['filter_eventset']);
  }
}

if(isset($_GET['d'])) {
	$_SESSION['list_user_sort'] = $_GET['d'] == 'ASC' ? 'ASC' : 'DESC';
} else if (!isset($_SESSION['list_user_sort'])) {
  $_SESSION['list_user_sort'] = 'ASC';
}

if(isset($_GET['page'])) {
	$_SESSION['cm_page_events'] = intval($_GET['page']);
}

// set default values for paginating
if(empty($_SESSION['list_user_count_events'])) {
	$_SESSION['list_user_count_events'] = 25;
}


// paginate and search form processing
if(isset($_POST['do_pagination'])) {

	$_SESSION['list_active_events']	= empty($_POST['showactive']) ? 0 : 1;
	$_SESSION['list_inactive_events']	= empty($_POST['showinactive']) ? 0 : 1;
  
  $_SESSION['list_showold']	= empty($_POST['showold']) ? 0 : 1;
	
  $_SESSION['filter_events']			= clean_slweg($_POST['filter']);

	if(empty($_SESSION['filter_events']) || $_SESSION['filter_events']=='') {
		unset($_SESSION['filter_events']);
	} else {
		$_SESSION['filter_events']	= convertStringToArray($_SESSION['filter_events'], ' ');
		$_POST['filter']	= $_SESSION['filter_events'];
	}
	
	$_SESSION['cm_page_events'] = intval($_POST['page']);

}

if(empty($_SESSION['cm_page_events'])) {
	$_SESSION['cm_page_events'] = 1;
}

$_entry['list_active']		= isset($_SESSION['list_active_events'])	? $_SESSION['list_active_events']		: 1;
$_entry['list_inactive']	= isset($_SESSION['list_inactive_events'])	? $_SESSION['list_inactive_events']	: 1;
$_entry['showold']		= isset($_SESSION['list_showold'])	? $_SESSION['list_showold']		: 0;

// set correct status query
if($_entry['list_active'] != $_entry['list_inactive']) {
	
	if(!$_entry['list_active']) {
		$_entry['query'] .= 'cm_events_status=0';
		$_SESSION['list_reset']=1;
	}
	if(!$_entry['list_inactive']) {
		$_entry['query'] .= 'cm_events_status=1';
		$_SESSION['list_reset']=1;
	}
	
} else {
	$_entry['query'] .= 'cm_events_status!=9';
}

if(isset($_SESSION['filter_events']) && is_array($_SESSION['filter_events']) && count($_SESSION['filter_events'])) {
	
	$_entry['filter_array'] = array();
  $_SESSION['list_reset']=1;
	foreach($_SESSION['filter_events'] as $_entry['filter']) {
		//
		$_entry['filter_array'][] = "cm_events_title LIKE '%".aporeplace($_entry['filter'])."%'";

	}
	if(count($_entry['filter_array'])) {
		
		$_SESSION['filter_events'] = ' AND ('.implode(' OR ', $_entry['filter_array']).')';
		$_entry['query'] .= $_SESSION['filter_events'];
	
	}

} elseif(isset($_SESSION['filter_events']) && is_string($_SESSION['filter_events'])) {

	$_entry['query'] .= $_SESSION['filter_events'];
	$_SESSION['list_reset']=1;

}
if (isset($_POST["cmMonth"])) $_POST["month"] = $_POST["cmMonth"];
if (isset($_POST["cmMonth"])) $_SESSION['list_reset']=1;
if (!isset($_POST["month"]) || !$_POST["month"]) {
	if 	(!isset($_GET['month']) || !$_GET['month']) {
		$month = date("n", mktime());
		$date = "none"; 
	} else {
		$month = $_GET['month'];
		$date = $_GET['date'];
	}
} else {
	$month = $_POST['month'];
  if (isset($_POST["cmMonth"])) $_entry['query'] .= " AND (MONTH(cm_events_date)) = ($month)";
	$date = "none"; // no specific date, list all for that month
}
if (isset($_POST["cmYear"])) $_POST["year"] = $_POST["cmYear"];
if (isset($_POST["cmYear"])) $_SESSION['list_reset']=1;
if (!isset($_POST["year"]) || !$_POST["year"]) {
	if(!isset($_GET["year"]) || !$_GET["year"]) {
		$year = date("Y", mktime());
	} else {
		$year = $_GET['year'];
	}
} else {
	$year = $_POST['year'];
  if (isset($_POST["cmMonth"])) $_entry['query'] .= " AND (YEAR(cm_events_date)) = ($year)";
}


  $actyear = date("Y");
if (isset($_SESSION['list_showold']) && ($_SESSION['list_showold'] == 1)) {

	$showoldquery = "";
  $_SESSION['list_reset']=1;
} else {
	$showoldquery = " AND ( (cm_events_date) >= (CURDATE()) OR ( (MONTH(cm_events_date)) = (MONTH(CURDATE())) AND " .
  							"(YEAR(cm_events_date)) = ($year) ) )";
//							"(YEAR(cm_events_date)) <= ($year) AND " .
//							"(YEAR(DATE_ADD(cm_events_date, INTERVAL(cm_events_span - 1) DAY))) >= ($year)";

}

//filter as result from click on day in calender
	if(isset($_GET["calday"])) {
  $calday = intval($_GET["calday"]);
  $calmonth = intval($_GET["calmonth"]);
  $calyear = intval($_GET["calyear"]);
    //if day select in calendar before today then show old entries automatically and highlight the checkbox on load
    if(date("U") > strtotime($calyear.'-'.$calmonth.'-'.$calday)) {
      $showoldquery ="";
      $highlight_showold = true;
    }
  $_entry['query'] .= " AND (DAY(cm_events_date)) = ($calday) AND (MONTH(cm_events_date)) = ($calmonth) AND (YEAR(cm_events_date)) = ($calyear)";
  $_SESSION['list_reset']=1;
  //sets the calendar to the actual month to avoid reset of the month when filtering per day
  $month =$calmonth;
  $year =$calyear;
}

//filter eventset
if(isset($_GET["filterset"]) || isset($_SESSION['filter_eventset'])) {
  if(isset($_GET["filterset"]))  $filterset = intval($_GET["filterset"]);
  if(isset($_SESSION['filter_eventset']))  $filterset = intval($_SESSION['filter_eventset']);
  $_entry['query'] .= " AND cm_events_setid = $filterset";
  $_SESSION['filter_eventset'] = $filterset;
  $_SESSION['list_reset']=1;
}

$_entry['query'] .= $showoldquery; //was a bug i V1.1 - show old entries or not is relevant for pagination

// paginating values
$_entry['count_total'] = _dbQuery('SELECT COUNT(cm_events_id) FROM '.DB_PREPEND.'phpwcms_cmcalendar_events WHERE '.$_entry['query'], 'COUNT');
$_entry['pages_total'] = ceil($_entry['count_total'] / $_SESSION['list_user_count_events']);
if($_SESSION['cm_page_events'] > $_entry['pages_total']) {
	$_SESSION['cm_page_events'] = empty($_entry['pages_total']) ? 1 : $_entry['pages_total'];
}
if(!isset($_SESSION['actcat'])) $_SESSION['actcat']=0;
if(isset($_POST['actcat'])) {
	$_SESSION['actcat'] = intval($_POST['actcat']);
} 

if(isset($_SESSION['actcat']) && $_SESSION['actcat']!=0) {
	$_entry['query'] .= " AND cm_events_allcals LIKE '%|".$_SESSION['actcat']."|%'";
	$_SESSION['list_reset']=1;
}

$sql = "SELECT * FROM ".DB_PREPEND."phpwcms_cmcalendar_categories WHERE cm_cat_status!=9 ORDER BY cm_cat_name ASC";
$data_cats = _dbQuery($sql);
	$xml_cats =	'<option value="0">alle Kalender</option>';
  foreach($data_cats as $rowcat) {
	 		$xml_cats .=	'<option value="'.$rowcat['cm_cat_id'].'"';
      if (isset($_SESSION['actcat']) && $_SESSION['actcat'] == $rowcat['cm_cat_id']) $xml_cats .=' selected="selected" ';
      $xml_cats .= '>'.$rowcat['cm_cat_name'].'</option>';
	}

//mootools 1.2
initMootools('1.2');

//$BE['HEADER'][] = LF.'';
$cal = new cmCalendar;
$cal->setLanguageBackend($BL);
echo '<div style="float:right;padding-bottom:5px;width:200px;"><div id="BackendCalendar" class="BackendCalendar">' . $cal->make_calendar($month, $year, $_SESSION['actcat']) . '</div></div>';
?>
<div class="navBarLeft imgButton chatlist" style="float:left">
	&nbsp;&nbsp;
	<a href="<?php echo cm_map_url('controller=events') ?>&amp;edit=0" title="<?php echo $BLM['create_new_events'] ?>"><img src="<?php echo $phpwcms['modules'][$module]['dir'].'img/'; ?>event_new.gif" alt="Add" border="0" /><span><?php echo $BLM['create_new_events'] ?></span></a>
</div>
<div style="clear:both"></div>

<form action="<?php echo cm_map_url('controller=events') ?>" method="post" name="paginate" id="paginate"><input type="hidden" name="do_pagination" value="1" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="paginate" summary="">
	<tr>
		<td style="border-bottom:1px solid #727889;"><table border="0" cellpadding="0" cellspacing="0" summary="">
			<tr>
				<td><input type="checkbox" name="showactive" id="showactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_active'], 1) ?> /></td>
				<td><label for="showactive"><img src="img/button/aktiv_12x13_1.gif" alt="" style="margin:1px 1px 0 1px;" /></label></td>
				<td><input type="checkbox" name="showinactive" id="showinactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_inactive'], 1) ?> /></td>
				<td><label for="showinactive"><img src="img/button/aktiv_12x13_0.gif" alt="" style="margin:1px 1px 0 1px;" /></label></td>

<?php 
if($_entry['pages_total'] > 1) {

	echo '<td class="chatlist">|&nbsp;</td>';
	echo '<td>';
	if($_SESSION['cm_page_events'] > 1) {
		echo '<a href="'. cm_map_url( array('controller=events', 'page='.($_SESSION['cm_page_events']-1)) ) . '">';
		echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/action_back.gif" alt="" border="0" /></a>';
	} else {
		echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/action_back.gif" alt="" border="0" class="inactive" />';
	}
	echo '</td>';
	echo '<td><input type="text" name="page" id="page" maxlength="4" size="4" value="'.$_SESSION['cm_page_events'];
	echo '"  class="textinput" style="margin:0 3px 0 5px;width:30px;font-weight:bold;" /></td>';
	echo '<td class="chatlist">/'.$_entry['pages_total'].'&nbsp;</td>';
	echo '<td>';
	if($_SESSION['cm_page_events'] < $_entry['pages_total']) {
		echo '<a href="'.cm_map_url( array('controller=events', 'page='.($_SESSION['cm_page_events']+1)) ) .'">';
		echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/action_forward.gif" alt="" border="0" /></a>';
	} else {
		echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/action_forward.gif" alt="" border="0" class="inactive" />';
	}
	echo '</td><td class="chatlist">&nbsp;|&nbsp;</td>';

} else {

	echo '<td class="chatlist">|&nbsp;<input type="hidden" name="page" id="page" value="1" /></td>';

}
?>
				<td><input type="text" name="filter" id="filter" size="10" value="<?php 
				
				if(isset($_POST['filter']) && is_array($_POST['filter']) ) {
					echo html_specialchars(implode(' ', $_POST['filter']));
				}
				
				?>" class="textinput" style="margin:0 2px 0 0;width:110px;text-align:left;" title="filter results" /></td>
				<td><input type="image" name="gofilter" src="<?php echo $phpwcms['modules'][$module]['dir'].'img/'; ?>action_go.gif" style="margin-right:3px;" /></td>
			<td><?php if (isset($_SESSION['list_reset'])) echo '<span style="padding:3px;background:#CCFF00;font-size:7pt;padding-left:3px;">'.$BLM['filtered_list'].' - <a href="'. cm_map_url(array('controller=events', 'c=all')).'">'.$BLM['show_all'].'</a></span>'; ?> </td>
			</tr>
		</table></td>
	<td class="chatlist" align="left" style="border-bottom:1px solid #727889;">&nbsp;</td>
	<td class="chatlist" align="right" style="border-bottom:1px solid #727889;">
		<a href="<?php echo cm_map_url(array('controller=events', 'c=10')) ?>">10</a>
		<a href="<?php echo cm_map_url(array('controller=events', 'c=25')) ?>">25</a>
		<a href="<?php echo cm_map_url(array('controller=events', 'c=50')) ?>">50</a>
		<a href="<?php echo cm_map_url(array('controller=events', 'c=100')) ?>">100</a>
		<a href="<?php echo cm_map_url(array('controller=events', 'c=250')) ?>">250</a>
		<a href="<?php echo cm_map_url(array('controller=events', 'c=all')) ?>"><?php echo $BL['be_ftptakeover_all'] ?></a>
	</td>

	</tr>
	<tr>
	 <td colspan="3"><table border="0" width="100%" cellpadding="0" cellspacing="0" summary="">
			<tr>
    <td id="highlight_showold"><table border="0" cellpadding="0" cellspacing="0" summary="">
			<tr>
				<td><input type="checkbox" name="showold" id="showold" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['showold'], 1) ?> /></td>
				<td>&nbsp;<label for="showold"><?php echo $BLM['show_olddates'] ?></label></td>
      </tr>
		</table>
    </td>
    <td class="chatlist" align="left" height="25">
<input type="hidden" name="cmMonth" id="cmMonth" value=""><input type="hidden" name="cmYear" id="cmYear" value="">
<?php 
		$months = "<select style=\"width: 85px;height:18px;font-size:7pt;\" name=\"monthselect\" class=\"menu\" onchange=\"document.getElementById('cmMonth').value=this.value\">\n";
			$months .= "<option value='0' selected='selected'>month...</option>\n";
    for ($i=1; $i<=12; $i++) {
			$months .= "<option";
			//if ($month==$i) {
			//	$months .= " selected";
			//} 
			$months .= " value=\"" .date("n", strtotime("$i/15/$year"))."\">";
			$months .= $cal->langInfo[strtolower(date("M", strtotime("$i/15/$year")))];
			$months .= "</option>\n";
		}
		$months .= "</select>&nbsp;";
 echo $months;

		$years  = "<select style=\"width: 55px;height:18px;font-size:7pt;\" name=\"yearselect\" class=\"menu\" onchange=\"document.getElementById('cmYear').value=this.value\">\n";
    $years .= "<option value=\"0\" selected='selected'>year...</option>\n";
    $years .= "<option value=\"" . ($year-2) . "\">".($year-2)."</option>\n";
		$years .= "<option value=\"" . ($year-1) . "\">".($year-1)."</option>\n";
		$years .= "<option value=\"" . ($year) . "\">" . ($year) . "</option>\n";
		$years .= "<option value=\"" . ($year+1) . "\">".($year+1)."</option>\n";
		$years .= "<option value=\"" . ($year+2) . "\">".($year+2)."</option>\n";
		$years .= "</select>\n";
 echo $years;	
 ?>
 
				<input type="image" name="godate" src="<?php echo $phpwcms['modules'][$module]['dir'].'img/'; ?>action_go.gif" style="margin-right:3px;vertical-align:text-bottom;" />

    </td>
    <td class="chatlist" align="left" height="25">
<select style="width:100px;height:18px;font-size:7pt;" name="actcat" onchange="this.form.submit();"><?php echo $xml_cats ?></select>
    </td>
    <td class="chatlist" align="right"><table border="0" cellpadding="0" cellspacing="0" summary="">
			<tr>
				<td><a href="<?php echo cm_map_url(array('controller=events', 'd=ASC')) ?>"><img src="<?php echo $phpwcms['modules'][$module]['dir'].'img/'; ?>arrow_down.gif" border="0" alt="ASC" /></a></td>
				<td><a href="<?php echo cm_map_url(array('controller=events', 'd=DESC')) ?>"><img src="<?php echo $phpwcms['modules'][$module]['dir'].'img/'; ?>arrow_up.gif" border="0" alt="DESC" /></a></td>
			</tr>
		</table>
    </td>
  </tr>
</table>
    </td>
  </tr>
</table>
</form>

<table width="100%" border="0" cellpadding="0" cellspacing="0" summary="" class="shop">
	<tr><td colspan="4" bgcolor="#92A1AF"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
<?php
// loop listing available events
$row_count = 0;                

$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_events WHERE '.$_entry['query'];

$sql .= ' ORDER BY cm_events_date';
(($_SESSION['list_user_sort'] ==  'ASC')) ? $sql .= ' ASC' : $sql .= ' DESC';
$sql .= ' LIMIT '.(($_SESSION['cm_page_events']-1) * $_SESSION['list_user_count_events']).','.$_SESSION['list_user_count_events'];
$data = _dbQuery($sql);
//dumpVar($sql);
$controller_link =  cm_map_url('controller=events');
if ($data) {
  foreach($data as $row) {
  	echo '<tr'.( ($row_count % 2) ? ' bgcolor="#F3F5F8"' : '' ).' onmouseover="this.bgColor=\'#CCFF00\';" onmouseout="this.bgColor=\''.( ($row_count % 2) ? '#F3F5F8' : '' ).'\';">'.LF;
    echo '<td><table width="100%"><tr>'.LF;
    echo '<td width="25%">'.$BLM['entry_date'].': '.date($BLM['entry_dateformat'], strtotime($row["cm_events_date"])).'</td>'.LF;
    echo '<td width="25%">'.$BLM['entry_time'].': '.$row["cm_events_time"].'</td>'.LF;
    echo '<td width="25%">'.$BLM['entry_span'].': '.$row["cm_events_span"].'</td>'.LF;
// TB Modification: show event owner user id
    echo '<td width="25%" rowspan="3" valign="top">'.$BLM['entry_uid'].':<br />'.$row["cm_events_userId"] . " - ".LF;
   // TB get clear text user name from ID
   {
      $usr_sql = "SELECT detail_id, detail_lastname FROM ".DB_PREPEND."phpwcms_userdetail WHERE detail_id=".$row["cm_events_userId"];

      if($usr_result = _dbQuery($usr_sql)) {
		  if(isset($usr_result[0])) {
            echo $usr_result[0]['detail_lastname'];
         }
      }
	  else // maybe event belongs to backend user?
	  {
		$usr_sql = "SELECT usr_id, usr_name FROM ".DB_PREPEND."phpwcms_user WHERE usr_id=".$row["cm_events_userId"];
		if($usr_result = _dbQuery($usr_sql)) {
			if(isset($usr_result[0])) {
            echo $usr_result[0]['usr_name'];
         }
	   }
	  }
   }
    echo '</td>'.LF;
    echo '</tr><tr>'.LF;
  	echo '<td colspan="3"><strong>'.html_specialchars($row["cm_events_title"]).'</strong></td>'.LF;
    echo '</tr><tr>'.LF;
   	echo '<td colspan="3">'.$BLM['entry_location'].': '.html_specialchars(substr($row["cm_events_location"], 0, 60));
    echo (strlen($row["cm_events_location"])>=60) ? "..." : "";
    echo '</td>'.LF;
    echo '</tr><tr>'.LF;
  	echo '<td colspan="4"><table width="100%"><tr>'.LF;

    echo '<td width="33%" align="left" >';
$trans = array('"' => "'", );
$trans_str = strtr($row["cm_events_description"], $trans);
$trans_str = str_replace("\n", "", $trans_str);
$trans_str = str_replace("%0D", "", $trans_str);
$trans_str = str_replace("%0d", "", $trans_str);
$trans_str = str_replace("\r", "", $trans_str);
$trans_str = str_replace("%0A", "", $trans_str);
$trans_str = str_replace("%0a", "", $trans_str);
$trans_str = "<div style='width:500px;'>".$trans_str."</div>";
    echo '<span style="cursor:pointer;" onmouseover="Tip(\''.addslashes($trans_str).'\')">'.$BLM['entry_seedescr'].'</span>';
    echo '</td>'.LF;
    echo '<td width="33%" align="left" >';
    echo '<span style="cursor:pointer;" onmouseover="Tip(\'';
$calendars =array();
$calendars = explode('|',trim($row['cm_events_allcals'], '|'));
 	 		$xml =	'';
  $j=0;
  foreach($data_cats as $row_cats) {

	 		if (in_array($row_cats['cm_cat_id'], $calendars)) {
          $xml  .= addslashes( $row_cats['cm_cat_name']).'<br>';
          $j++;
        }
	}
    echo $xml;
 
    echo '\')">'.$BLM['entry_incal1'].' '.$j.' '.$BLM['entry_incal2'].'</span>';
    echo '</td>'.LF;
    echo '<td width="33%" align="right" nowrap="nowrap" class="button_td">';
// TB Modification: Edit functions only, if this is user's own event or current user is admin
   if ($_SESSION['wcs_user_id'] == $row["cm_events_userId"] ||
       $_SESSION["wcs_user_admin"] == 1)
   {
    if ($row["cm_events_setid"]>0) {
      echo $BLM['entry_set'].': ';
      echo '<a href="'.$controller_link.'&amp;filterset='.$row["cm_events_setid"].'">';
    	echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/filter_30x13.gif" border="0" alt="" /></a>';
    	echo '<a href="'.$controller_link.'&amp;editset='.$row["cm_events_setid"].'">';		
    	echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/edit_22x13.gif" border="0" alt="" /></a>';	
    	echo '<a href="'.$controller_link.'&amp;verifyset=' . $row["cm_events_setid"] . '-' . $row["cm_events_status"] .'">';		
    	echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/aktiv_12x13_'.$row["cm_events_status"].'.gif" border="0" alt="" /></a>';
    	echo '<a href="'.$controller_link.'&amp;deleteset='.$row["cm_events_setid"];
    	echo '" title="delete set"';
    	echo ' onclick="return confirm(\''.$BLM['delete_entryset'].'\');">';
    	echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/trash_13x13_1.gif" border="0" alt=""></a>'; 
    	echo '&nbsp;|&nbsp;';
    }

  	echo '<a href="'.$controller_link.'&amp;edit='.$row["cm_events_id"].'">';		
  	echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/edit_22x13.gif" border="0" alt="" /></a>';
  	echo '<a href="'.$controller_link.'&amp;verify=' . $row["cm_events_id"] . '-' . $row["cm_events_status"] .'">';		
  	echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/aktiv_12x13_'.$row["cm_events_status"].'.gif" border="0" alt="" /></a>';
  	echo '<a href="'.$controller_link.'&amp;delete='.$row["cm_events_id"];
  	echo '" title="delete: '.html_specialchars($row["cm_events_title"]).'"';
  	echo ' onclick="return confirm(\''.$BLM['delete_entry'].' '.html_specialchars(addslashes($row["cm_events_title"])).'\');">';
  	echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/trash_13x13_1.gif" border="0" alt=""></a>';
   }
  	echo '</td></tr></table>'.LF;
    echo '</td>'.LF;   
    echo '</tr></table>'.LF;
  	echo '</td></tr>'.LF;
  	$row_count++;
  }
} else {
  echo '<tr><td>'.$BLM['no_entry'].'</td></tr>';
}

if($row_count) {
	echo '<tr><td colspan="4" bgcolor="#92A1AF"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>';
}

?>
<tr><td colspan="4">
<script language="javascript" type="text/javascript">
<!--

//on dom ready...
window.addEvent('domready', function() {

<?php if($highlight_showold == true) {echo '$("highlight_showold").set(\'tween\', {duration: \'2000\'}).highlight( \'#CCFF00\');
$("showold").checked=true';} ?>

});

//ajax-calendar-backend
var changeCalendar = function(){};

  changeCalendar.extend({
    'changeto' : function(mode,month,year){
    var req = new Request.HTML({
          method: 'post',
          url: 'include/inc_module/mod_cm_calendar/genajax_backend.php',
          update: $('BackendCalendar'),
          onRequest: function() {  },
          onComplete: function(response) {  }
        }).send('mode='+mode+'&cal=<?php echo trim($_SESSION['actcat'], ',') ?>&name=1&lng=<?php echo $_SESSION['wcs_user_lang'] ?>&month='+month+'&yr='+year);
    }
});

//-->
</script>
</td></tr>
</table>
