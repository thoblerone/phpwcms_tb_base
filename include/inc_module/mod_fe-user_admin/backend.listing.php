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

// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------


$_entry['query']			= '';

if(isset($_POST['active'])) {
	$active = $_POST['active'];
}
else {
	$active = '0';
}
if(isset($_POST['inactive'])) {
	$inactive = $_POST['inactive'];
}
else {
	$inactive = '0';
}


?>


<div style="padding : 3px 35px 0 19px;">
	<p><?php echo $BLM['introtext'] ?></p>
</div>

<div style="padding : 3px 35px 0 19px;">
	<form method="post"action="phpwcms.php?do=modules&module=personel" name="form" id="form">
		<?php echo $BLM['active_toggle']?><input type="checkbox" name="active" value="1" onclick="this.form.submit();" <?php if($active == '1') {?> checked <?php } ?> /> 
		<?php echo $BLM['inactive_toggle']?><input type="checkbox" name="inactive" value="1" onclick="this.form.submit();" <?php if($inactive != '0') {?> checked <?php } ?> />
	</form>
</div>





<table width="100%" border="0" cellpadding="0" cellspacing="0" summary="">

	<tr><td colspan="5"><img src="img/leer.gif" alt="" width="1" height="3"></td></tr>
	<tr><td colspan="5" bgcolor="#92A1AF"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>

<?php
// loop listing available newsletters
$row_count = 0;

$sqlUserList = 'SELECT * FROM '.DB_PREPEND.'phpwcms_userdetail where ';
if($active == '1') {

	$sqlUserList .= ' detail_aktiv = 1';
}
if($inactive == '1') {

	if($active == '1') {
		$sqlUserList.= ' OR ';
	}
		
	$sqlUserList.= ' detail_aktiv = 0';
}
if($active != '1' && $inactive != '1') {
	$sqlUserList = 'SELECT * FROM '.DB_PREPEND.'phpwcms_userdetail';
}

echo $sqlUserList;
$data = _dbQuery($sqlUserList);

echo '<tr>';
echo '<td>&nbsp;</td>';
echo '<td><b>'.$BLM['detail_firstname'].'</b></td>';
echo '<td><b>'.$BLM['detail_lastname'].'</b></td>';
echo '<td><b>'.$BLM['detail_login'].'</b></td>';
echo '<td><b>'.$BLM['detail_password'].'</b></td>';

if(!empty($data)) {
	foreach($data as $row) {

		echo '<tr'.( ($row_count % 2) ? ' bgcolor="#F3F5F8"' : '' ).'>'.LF.'<td width="20" style="width:20px;padding:2px 1px 2px 3px;">';
		echo '<img src="img/usricon/';
		echo ($row["detail_aktiv"]==1) ? 'usr_14.gif' : 'usr_6.gif';
		echo '" alt="'.$BLM['detail_image'].'" /></td>'.LF;
		echo '<td class="dir" >'.html_specialchars($row["detail_firstname"])."&nbsp;</td>\n";

		echo '<td class="dir">'.html_specialchars($row["detail_lastname"])."&nbsp;</td>\n";

		echo '<td class="dir">'.html_specialchars($row["detail_login"])."&nbsp;</td>\n";

		echo '<td align="right" nowrap="nowrap" class="button_td">';

		echo '<a href="'.GLOSSARY_HREF.'&amp;edit='.$row["detail_id"].'">';
		echo '<img src="img/button/edit_22x13.gif" border="0" alt="" /></a>';

		/* echo '<a href="'.GLOSSARY_HREF.'&amp;editid='.$row["detail_id"].'&amp;verify=';
		echo (($row["detail_status"]) ? '0' : '1').'">';
		echo '<img src="img/button/aktiv_12x13_'.$row["detail_status"].'.gif" border="0" alt="" /></a>';
		*/
		echo '<a href="'.GLOSSARY_HREF.'&amp;delete='.$row["detail_id"];
		echo '" title="delete: '.html_specialchars($row["detail_title"]).'"';
		echo ' onclick="return confirm(\''.$BLM['delete_entry'].' '.js_singlequote($row["detail_title"]).'\');">';
		echo '<img src="img/button/trash_13x13_1.gif" border="0" alt=""></a>';

		echo "</td>\n</tr>\n";

		$row_count++;
	}
}

if($row_count) {
	echo '<tr><td colspan="5" bgcolor="#92A1AF"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>';
}

?>

	<tr><td colspan="5"><img src="img/leer.gif" alt="" width="1" height="15"></td></tr>
</table>