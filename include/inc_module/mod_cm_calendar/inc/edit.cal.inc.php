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

?>

<form action="<?php echo cm_map_url( array('controller=cal', 'edit='.$plugin['data']['cm_cat_id']) ) ?>" name="frmLang" method="post" style="background:#F3F5F8;border-top:1px solid #92A1AF;border-bottom:1px solid #92A1AF;margin:0 0 5px 0;padding:10px 8px 15px 8px">
<input type="hidden" name="cm_cat_id" value="<?php echo $plugin['data']['cm_cat_id'] ?>" />
<table border="0" cellpadding="0" cellspacing="0" width="100%" summary="">
	<tr> 
		<td align="right" class="chatlist"><?php echo $BL['be_cnt_last_edited']  ?>:&nbsp;</td>
		<td colspan="2" class="v10" width="410"><?php 
		if($plugin['data']['cm_cat_id']==0) {
		echo html_specialchars(date($BL['be_fprivedit_dateformat'], strtotime($plugin['data']['cm_cat_changed']))) ;
		}else{
		echo html_specialchars(date($BL['be_fprivedit_dateformat'], $plugin['data']['cm_cat_changed'])) ;
		}
		if(!empty($plugin['data']['cm_cat_created'])) {
		?>		
		&nbsp;&nbsp;&nbsp;<span class="chatlist"><?php echo $BL['be_fprivedit_created']  ?>:</span> 
		<?php 
				echo html_specialchars(date($BL['be_fprivedit_dateformat'], strtotime($plugin['data']['cm_cat_created'])));
		}
		
		?></td>
	</tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

	<tr> 
		<td align="right" class="chatlist"><?php echo $BLM['cal_name'] ?>:&nbsp;</td>
		<td colspan="2"><input type="text" name="cm_cat_name" id="cm_cat_name" class="f11b<?php 
		
		//error class
		if(!empty($plugin['error']['cm_cat_name'])) echo ' errorInputText';
		
		?>" style="width:300px;" value="<?php echo $plugin['data']['cm_cat_name'] ?>" /></td>
	</tr>
		

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>


	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BL['be_ftptakeover_status'] ?>:&nbsp;</td>
		<td colspan="2"><table border="0" cellpadding="0" cellspacing="0" summary="">		
			<tr>
				<td><input type="checkbox" name="cm_cat_status" id="cm_cat_status" value="1"<?php is_checked($plugin['data']['cm_cat_status'], 1) ?> /></td>
				<td><label for="cm_cat_status"><?php echo $BL['be_cnt_activated'] ?></label></td>
			</tr>
		</table></td>
	</tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

	<tr> 
		<td>&nbsp;</td>
		<td colspan="2">
			<input name="submit2" id="sub1" type="submit" class="button10" value="<?php echo empty($plugin['data']['cm_cat_id']) ? $BL['be_admin_fcat_button2'] : $BL['be_article_cnt_button1'] ?>" />
			<input name="save" id="sub2" type="submit" class="button10" value="<?php echo $BL['be_article_cnt_button3'] ?>" />
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="close" type="submit" class="button10" value="<?php echo $BL['be_admin_struct_close'] ?>" />
		</td>
	</tr>
</table>

</form>