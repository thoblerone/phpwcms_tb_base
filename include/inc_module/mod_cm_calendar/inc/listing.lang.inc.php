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

// create pagination
if(isset($_GET['c'])) {
	$_SESSION['list_user_count_lang'] = $_GET['c'] == 'all' ? '99999' : intval($_GET['c']);
	if( $_GET['c'] == 'all'){
    $_POST['filter'] = '';
    unset($_SESSION['filter_lang']);
  }

}
if(isset($_GET['page'])) {
	$_SESSION['cm_page_lang'] = intval($_GET['page']);
}

// set default values for paginating
if(empty($_SESSION['list_user_count_lang'])) {
	$_SESSION['list_user_count_lang'] = 25;
}

// paginate and search form processing
if(isset($_POST['do_pagination'])) {

	$_SESSION['list_active_lang']	= empty($_POST['showactive']) ? 0 : 1;
	$_SESSION['list_inactive_lang']	= empty($_POST['showinactive']) ? 0 : 1;

	$_SESSION['filter_lang']			= clean_slweg($_POST['filter']);

	if(empty($_SESSION['filter_lang']) || $_SESSION['filter_lang']=='') {
		unset($_SESSION['filter_lang']);
	} else {
		$_SESSION['filter_lang']	= convertStringToArray($_SESSION['filter_lang'], ' ');
		$_POST['filter']	= $_SESSION['filter_lang'];
	}
	
	$_SESSION['cm_page_lang'] = intval($_POST['page']);

}

if(empty($_SESSION['cm_page_lang'])) {
	$_SESSION['cm_page_lang'] = 1;
}

$_entry['list_active']		= isset($_SESSION['list_active_lang'])	? $_SESSION['list_active_lang']		: 1;
$_entry['list_inactive']	= isset($_SESSION['list_inactive_lang'])	? $_SESSION['list_inactive_lang']	: 1;


// set correct status query
if($_entry['list_active'] != $_entry['list_inactive']) {
	
	if(!$_entry['list_active']) {
		$_entry['query'] .= 'cm_lang_status=0';
	}
	if(!$_entry['list_inactive']) {
		$_entry['query'] .= 'cm_lang_status=1';
	}
	
} else {
	$_entry['query'] .= 'cm_lang_status!=9';
}

if(isset($_SESSION['filter_lang']) && is_array($_SESSION['filter_lang']) && count($_SESSION['filter_lang'])) {
	
	$_entry['filter_array'] = array();

	foreach($_SESSION['filter_lang'] as $_entry['filter']) {
		//
		$_entry['filter_array'][] = "cm_lang_name LIKE '%".aporeplace($_entry['filter'])."%'";
		$_entry['filter_array'][] = "cm_lang_loc LIKE '%".aporeplace($_entry['filter'])."%'";
	}
	if(count($_entry['filter_array'])) {
		
		$_SESSION['filter_lang'] = ' AND ('.implode(' OR ', $_entry['filter_array']).')';
		$_entry['query'] .= $_SESSION['filter_lang'];
	
	}

} elseif(isset($_SESSION['filter_lang']) && is_string($_SESSION['filter_lang'])) {

	$_entry['query'] .= $_SESSION['filter_lang'];

}

// paginating values
$_entry['count_total'] = _dbQuery('SELECT COUNT(cm_lang_id) FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE '.$_entry['query'], 'COUNT');
$_entry['pages_total'] = ceil($_entry['count_total'] / $_SESSION['list_user_count_lang']);
if($_SESSION['cm_page_lang'] > $_entry['pages_total']) {
	$_SESSION['cm_page_lang'] = empty($_entry['pages_total']) ? 1 : $_entry['pages_total'];
}

?>

<div class="navBarLeft imgButton chatlist" style="float:left">
	&nbsp;&nbsp;
	<a href="<?php echo cm_map_url(array('controller=lang', 'edit=0')) ?>" title="<?php echo $BLM['create_new_lang'] ?>"><img src="<?php echo $phpwcms['modules'][$module]['dir'].'img/'; ?>book_add.gif" alt="Add" border="0" /><span><?php echo $BLM['create_new_lang'] ?></span></a>
</div>
<div style="clear:both"></div>

<form action="<?php echo cm_map_url('controller=lang') ?>" method="post" name="paginate" id="paginate"><input type="hidden" name="do_pagination" value="1" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="paginate" summary="">
	<tr>
		<td><table border="0" cellpadding="0" cellspacing="0" summary="">
			<tr>
				
				<td><input type="checkbox" name="showactive" id="showactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_active'], 1) ?> /></td>
				<td><label for="showactive"><img src="img/button/aktiv_12x13_1.gif" alt="" style="margin:1px 1px 0 1px;" /></label></td>
				<td><input type="checkbox" name="showinactive" id="showinactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_inactive'], 1) ?> /></td>
				<td><label for="showinactive"><img src="img/button/aktiv_12x13_0.gif" alt="" style="margin:1px 1px 0 1px;" /></label></td>

<?php 
if($_entry['pages_total'] > 1) {

	echo '<td class="chatlist">|&nbsp;</td>';
	echo '<td>';
	if($_SESSION['cm_page_lang'] > 1) {
		echo '<a href="'. cm_map_url( array('controller=lang', 'page='.($_SESSION['cm_page_lang']-1)) ) . '">';
		echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/action_back.gif" alt="" border="0" /></a>';
	} else {
		echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/action_back.gif" alt="" border="0" class="inactive" />';
	}
	echo '</td>';
	echo '<td><input type="text" name="page" id="page" maxlength="4" size="4" value="'.$_SESSION['cm_page_lang'];
	echo '"  class="textinput" style="margin:0 3px 0 5px;width:30px;font-weight:bold;" /></td>';
	echo '<td class="chatlist">/'.$_entry['pages_total'].'&nbsp;</td>';
	echo '<td>';
	if($_SESSION['cm_page_lang'] < $_entry['pages_total']) {
		echo '<a href="'.cm_map_url( array('controller=lang', 'page='.($_SESSION['cm_page_lang']+1)) ) .'">';
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
				
				?>" class="textinput" style="margin:0 2px 0 0;width:110px;text-align:left;" title="filter results by language" /></td>
				<td><input type="image" name="gofilter" src="<?php echo $phpwcms['modules'][$module]['dir'].'img/'; ?>action_go.gif" style="margin-right:3px;" /></td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;<?php if (isset($_SESSION['filter_lang'])) echo $BLM['filtered_list'].' - <a href="'. cm_map_url(array('controller=lang', 'c=all')).'">'.$BLM['show_all'].'</a>'; ?> </td>
			</tr>
		</table></td>

	<td class="chatlist" align="right">
		<a href="<?php echo cm_map_url(array('controller=lang', 'c=10')) ?>">10</a>
		<a href="<?php echo cm_map_url(array('controller=lang', 'c=25')) ?>">25</a>
		<a href="<?php echo cm_map_url(array('controller=lang', 'c=50')) ?>">50</a>
		<a href="<?php echo cm_map_url(array('controller=lang', 'c=100')) ?>">100</a>
		<a href="<?php echo cm_map_url(array('controller=lang', 'c=250')) ?>">250</a>
		<a href="<?php echo cm_map_url(array('controller=lang', 'c=all')) ?>"><?php echo $BL['be_ftptakeover_all'] ?></a>
	</td>

	</tr>
</table>
</form>

<table width="100%" border="0" cellpadding="0" cellspacing="0" summary="" class="shop">

	<tr><td colspan="4" bgcolor="#92A1AF"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	
<?php
// loop listing available languages
$row_count = 0;                

$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_cmcalendar_language WHERE '.$_entry['query'];
$sql .= ' ORDER BY cm_lang_name';
$sql .= ' LIMIT '.(($_SESSION['cm_page_lang']-1) * $_SESSION['list_user_count_lang']).','.$_SESSION['list_user_count_lang'];
$data = _dbQuery($sql);

$controller_link =  cm_map_url('controller=lang');

foreach($data as $row) {

	echo '<tr'.( ($row_count % 2) ? ' bgcolor="#F3F5F8"' : '' ).' onmouseover="this.bgColor=\'#CCFF00\';" onmouseout="this.bgColor=\''.( ($row_count % 2) ? '#F3F5F8' : '' ).'\';">'.LF.'<td width="25" style="padding:2px 3px 2px 4px;">';
	echo '<img src="'.$phpwcms['modules'][$module]['dir'].'img/book.gif" alt="'.$BLM['cm_lang_lang'].'" /></td>'.LF;
	echo '<td class="dir" width="30%">&nbsp;'.html_specialchars($row["cm_lang_name"])."</td>\n";
  echo '<td class="dir" width="30%">'.html_specialchars($row["cm_lang_loc"])."</td>\n";
	echo '<td align="right" nowrap="nowrap" class="button_td">';
	echo '<a href="'.$controller_link.'&amp;edit='.$row["cm_lang_id"].'">';		
	echo '<img src="img/button/edit_22x13.gif" border="0" alt="" /></a>';
 if ($row["cm_lang_id"]!=1 && $_SESSION["wcs_user_admin"] == 1) {
	echo '<a href="'.$controller_link.'&amp;verify=' . $row["cm_lang_id"] . '-' . $row["cm_lang_status"] .'">';		
	echo '<img src="img/button/aktiv_12x13_'.$row["cm_lang_status"].'.gif" border="0" alt="" /></a>';
	echo '<a href="'.$controller_link.'&amp;delete='.$row["cm_lang_id"];
	echo '" title="delete: '.html_specialchars($row["cm_lang_name"]).'"';
	echo ' onclick="return confirm(\''.$BLM['delete_lang'].' '.html_specialchars(addslashes($row["cm_lang_name"])).'\');">';
	echo '<img src="img/button/trash_13x13_1.gif" border="0" alt=""></a>';
 } 
	echo "</td>\n</tr>\n";

	$row_count++;
}

if($row_count) {
	echo '<tr><td colspan="4" bgcolor="#92A1AF"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>';
}

?>	


</table>