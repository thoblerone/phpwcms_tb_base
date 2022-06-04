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

initMootools();
initMootoolsAutocompleter();


?>
<h1 class="title" style="margin-bottom:10px"><?php echo $BLM['listing_title'] ?></h1>

<form action="<?php echo GLOSSARY_HREF ?>&amp;edit=<?php echo $detail['data']['detail_id'] ?>" method="post" style="background:#F3F5F8;border-top:1px solid #92A1AF;border-bottom:1px solid #92A1AF;margin:0 0 5px 0;padding:10px 8px 15px 8px">
<input type="hidden" name="detail_id" value="<?php echo $detail['data']['detail_id'] ?>" />
<input type="hidden" name="detail_id" value="<?php echo $detail['data']['detail_id'] ?>" />
<table border="0" cellpadding="0" cellspacing="0" width="100%" summary="">


<!-- // Viel zu viele Details
	<tr>
		<td align="right" class="chatlist"><?php echo $BL['be_cnt_image'] ?>:&nbsp;</td>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" summary="">
			<tr>
				<td><input type="text" name="cnt_image_name" id="cnt_image_name" value="<?php echo html_specialchars($detail['data']['detail_notes']['user_image']['name']) ?>" class="v12 width300" maxlength="250" /></td>
				<td style="padding:2px 0 0 5px" width="100">
					<a href="#" title="<?php echo $BL['be_cnt_openimagebrowser'] ?>" onclick="openFileBrowser('filebrowser.php?opt=7');return false;"><img src="img/button/open_image_button.gif" alt="" width="20" height="15" border="0" /></a>
					<a href="#" title="<?php echo $BL['be_cnt_delimage'] ?>" onclick="setImgIdName();return false;"><img src="img/button/del_image_button.gif" alt="" width="15" height="15" border="0" /></a>
					<input name="cnt_image_id" id="cnt_image_id" type="hidden" value="<?php echo $detail['data']['detail_notes']['user_image']['id'] ?>" />
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="tdtop5 tdbottom5">
		<table border="0" cellpadding="0" cellspacing="0" summary="">
		<tr>
	  <td><input name="cnt_image_zoom" type="checkbox" id="cnt_image_zoom" value="1" <?php is_checked(1, $detail['data']['detail_notes']['user_image']['zoom']); ?> /></td>
		  <td><label for="cnt_image_zoom" class="checkbox"><?php echo $BL['be_cnt_enlarge'] ?></label></td>

		  <td><input name="cnt_image_lightbox" type="checkbox" id="cnt_image_lightbox" value="1" <?php is_checked(1, $detail['data']['detail_notes']['user_image']['lightbox']); ?> onchange="if(this.checked){getObjectById('cnt_image_zoom').checked=true;}" /></td>
		  <td><label for="cnt_image_lightbox" class="checkbox"><?php echo $BL['be_cnt_lightbox'] ?></label></td>
		</tr>
		</table>

		<div id="cnt_image" style="padding-top:3px;"></div>
		<div style="padding-top:3px;"><b><? echo $BLM['current_image']?><br/>
		<img src="<?php echo PHPWCMS_URL.'img/cmsimage.php/'.$phpwcms['img_list_width'].'x'.$phpwcms['img_list_height'] ?>/<?php echo $detail['data']['detail_notes']['user_image']['id']?>" alt="" border="0" />
		</div>
		</td>
	</tr>

	<tr>
		<td align="right" class="chatlist tdtop4"><?php echo $BL['be_cnt_caption'] ?>:&nbsp;</td>
		<td class="tdbottom4">
		<textarea name="cnt_image_caption" id="cnt_image_caption" class="v12 width350" rows="2"><?php echo html_specialchars($detail['data']['detail_notes']['user_image']['caption']) ?></textarea>
		</td>
	</tr>
// TB -->
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['tag'] ?>:&nbsp;</td>
		<td><input name="detail_tag" type="text" id="detail_tag" class="v12" style="width:375px;" value="<?php echo html_specialchars(trim($detail['data']['detail_tag'])) ?>" size="30" maxlength="255" /></td>
	</tr>

<!-- Beginn Mod novallis # datai_varchar5: Nutzung für Angabe der Landing page -->
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
	<tr>
		<td align="right" class="chatlist tdtop4"><?php echo $BLM['detail_varchar5'] ?>:&nbsp;</td>
		<td><input name="detail_varchar5" type="text" id="detail_varchar5" class="v12" style="width:375px;" value="<?php echo html_specialchars(trim($detail['data']['detail_varchar5'])) ?>" size="30" maxlength="255" /></td>
	</tr>
	<tr>
		<td align="right" class="chatlist">&nbsp;</td>
		<td><?php echo $BLM['info_landing_page'] ?></td>
	</tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
<!-- // Ende Mod novallis -->
	<tr>
		<? if(!empty($detail['data']['detail_notes']['user_alias'])) { ?>
		<td align="right" class="chatlist"><?php echo $BLM['alias'] ?>:&nbsp;</td>
		<td><input name="detail_alias" type="text" id="detail_alias" class="v12" style="width:375px;" value="<?php echo html_specialchars(trim($detail['data']['detail_notes']['user_alias'])) ?>" size="30" maxlength="255" /></td>

		<? }
		else {
			?>
		<td align="right" class="chatlist"><?php echo $BLM['alias'] ?>:&nbsp;</td>
		<td><input name="detail_alias" type="text" id="detail_alias" class="v12" style="width:375px;" value="<?php echo html_specialchars(trim($BLM['detail_default_alias'])) ?>" size="30" maxlength="255" /></td>
		<? } ?>

	</tr>

	<tr>
		<td align="right" class="chatlist">&nbsp;</td>
		<td><?php echo $BLM['alias_search_text'] ?></td>
	</tr>


	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>
	<tr><td colspan="2" class="rowspacer7x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>



	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_title'] ?>:&nbsp;</td>
		<td><input name="detail_title" type="text" id="detail_title" class="f11b<?php

		//error class
		if(!empty($detail['error']['detail_title'])) echo ' errorInputText';

		?>" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_title']) ?>" size="30" maxlength="1000" /></td>
	</tr>

	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_login'] ?>:&nbsp;</td>
		<td><input name="detail_login" type="text" id="detail_login" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_login']) ?>" size="30" maxlength="220" /></td>
	</tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_password'] ?>:&nbsp;</td>
		<td><input name="detail_password" type="text" id="detail_password" class="f11" style="width:400px;" value="" size="30" maxlength="220" /></td>
	</tr>
		<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_email'] ?>:&nbsp;</td>
		<td><input name="detail_email" type="text" id="detail_email" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_email']) ?>" size="30" maxlength="220" /></td>
	</tr>

	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_firstname'] ?>:&nbsp;</td>
		<td><input name="detail_firstname" type="text" id="detail_firstname" class="f11b<?php

		//error class
		if(!empty($detail['error']['detail_firstname'])) echo ' errorInputText';

		?>" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_firstname']) ?>" size="30" maxlength="200" /></td>
	</tr>

	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>

	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_lastname'] ?>:&nbsp;</td>
		<td><input name="detail_lastname" type="text" id="detail_lastname" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_lastname']) ?>" size="30" maxlength="220" /></td>
	</tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_company'] ?>:&nbsp;</td>
		<td><input name="detail_company" type="text" id="detail_company" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_company']) ?>" size="30" maxlength="220" /></td>
	</tr>
<!-- // TB viel zu viele Details
		<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_prof'] ?>:&nbsp;</td>
		<td><input name="detail_prof" type="text" id="detail_prof" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_prof']) ?>" size="30" maxlength="220" /></td>
	</tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_street'] ?>:&nbsp;</td>
		<td><input name="detail_street" type="text" id="detail_street" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_street']) ?>" size="30" maxlength="220" /></td>
	</tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_add'] ?>:&nbsp;</td>
		<td><input name="detail_add" type="text" id="detail_add" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_add']) ?>" size="30" maxlength="220" /></td>
	</tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_city'] ?>:&nbsp;</td>
		<td><input name="detail_city" type="text" id="detail_city" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_city']) ?>" size="30" maxlength="220" /></td>
	</tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_zip'] ?>:&nbsp;</td>
		<td><input name="detail_zip" type="text" id="detail_zip" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_zip']) ?>" size="30" maxlength="220" /></td>
	</tr>

	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_region'] ?>:&nbsp;</td>
		<td><input name="detail_region" type="text" id="detail_region" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_region']) ?>" size="30" maxlength="220" /></td>
	</tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_country'] ?>:&nbsp;</td>
		<td><input name="detail_country" type="text" id="detail_country" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_country']) ?>" size="30" maxlength="220" /></td>
	</tr>
// TB -->
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_fon'] ?>:&nbsp;</td>
		<td><input name="detail_fon" type="text" id="detail_fon" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_fon']) ?>" size="30" maxlength="220" /></td>
	</tr>
<!-- // Viel zu viele Details
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_fax'] ?>:&nbsp;</td>
		<td><input name="detail_fax" type="text" id="detail_fax" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_fax']) ?>" size="30" maxlength="220" /></td>
	</tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_mobile'] ?>:&nbsp;</td>
		<td><input name="detail_mobile" type="text" id="detail_mobile" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_mobile']) ?>" size="30" maxlength="220" /></td>
	</tr>


	<tr>
		<td align="right" class="chatlist tdtop4"><?php echo $BLM['detail_signature'] ?>:&nbsp;</td>
		<td><textarea name="detail_signature" id="detail_signature" class="v12 width375" rows="5"><?php echo @unserialize($detail['data']['detail_signature']) ?></textarea></td>
	</tr>
// TB -->
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

	<tr>
		<td align="right" class="chatlist tdtop4"><?php echo $BLM['detail_public'] ?>:&nbsp;</td>
		<td><input type="checkbox" name="detail_public" id="detail_public" value="1"<?php is_checked(empty($detail['data']['detail_public'])?0:1, 1) ?> /></td>

	</td>

	</tr>
<!-- // Viel zu viele Details
	<tr>
		<td align="right" class="chatlist tdtop4"><?php echo $BLM['detail_gender'] ?>:&nbsp;</td>
		<td><table border="0" cellpadding="0" cellspacing="0" summary="">
			<tr>
				<td><input type="checkbox" name="detail_gender" id="detail_gender" value="1"<?php is_checked(empty($detail['data']['detail_gender'])?0:1, 1) ?> />
				<label for="detail_gender"><?php echo $BLM['detail_gender_male'] ?></label>

				<input type="checkbox" name="detail_gender" id="detail_gender" value="1"<?php is_checked(empty($detail['data']['detail_gender'])?0:1, 2) ?> />
				<label for="detail_gender_female"><?php echo $BLM['detail_gender_female'] ?></label>

				<input type="checkbox" name="detail_gender" id="detail_gender" value="1"<?php is_checked(empty($detail['data']['detail_gender'])?0:3, 1) ?> />
				<label for="detail_gender_female"><?php echo $BLM['detail_gender_unknown'] ?></label>

				</td>
			</tr>
		</table></td>

	</tr>

	<tr>
		<td align="right" class="chatlist tdtop4"><?php echo $BLM['detail_newsletter'] ?>:&nbsp;</td>
		<td><table border="0" cellpadding="0" cellspacing="0" summary="">
			<tr>
				<td><input type="checkbox" name="detail_newsletter" id="detail_newsletter" value="1"<?php is_checked(empty($detail['data']['detail_newsletter'])?0:1, 1) ?> /></td>

			</tr>
		</table></td>

	</tr>
// TB -->
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>
	<tr><td colspan="2" class="rowspacer7x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>

<!-- // Viel zu viele Details
	<tr>
		<td class="chatlist" colspan="2" style="padding-bottom:4px"><h1 class="title" style="margin-bottom:10px"><?php echo $BLM['detail_text1'] ?>:</h1></td>
	</tr>


	<tr>
		<td colspan="2" align="center"><?php

		$wysiwyg_editor = array(
			'value'		=> $detail['data']['detail_text1'],
			'field'		=> 'detail_text1',
			'height'	=> '200px',
			'toolbarset'=> 'basic',
			'width'		=> '524px',
			'rows'		=> '15',
			'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
			'lang'		=> 'nl'
		);

		include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');


		?></td>
	</tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>
	<tr><td colspan="2" class="rowspacer7x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>

	<tr>
		<td class="chatlist" colspan="2" style="padding-bottom:4px"><h1 class="title" style="margin-bottom:10px"><?php echo $BLM['detail_text2'] ?>:</h1></td>
	</tr>

	<tr>
		<td colspan="2" align="center"><?php

		$wysiwyg_editor = array(
			'value'		=> $detail['data']['detail_text2'],
			'field'		=> 'detail_text2',
			'height'	=> '200px',
			'width'		=> '524px',
			'rows'		=> '15',
			'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
			'lang'		=> 'nl'
		);

		include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');


		?></td>
	</tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>
	<tr><td colspan="2" class="rowspacer7x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>


	<tr>
		<td class="chatlist" colspan="2" style="padding-bottom:4px"><h1 class="title" style="margin-bottom:10px"><?php echo $BLM['detail_text3'] ?>:</h1></td>
	</tr>

	<tr>
		<td colspan="2" align="center"><?php

		$wysiwyg_editor = array(
			'value'		=> $detail['data']['detail_text3'],
			'field'		=> 'detail_text3',
			'height'	=> '200px',
			'width'		=> '524px',
			'rows'		=> '15',
			'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
			'lang'		=> 'nl'
		);

		include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');


		?></td>
	</tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>
	<tr><td colspan="2" class="rowspacer7x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>

	<tr>
		<td class="chatlist" colspan="2" style="padding-bottom:4px"><h1 class="title" style="margin-bottom:10px"><?php echo $BLM['detail_text4'] ?>:</h1></td>
	</tr>

	<tr>
		<td colspan="2" align="center"><?php

		$wysiwyg_editor = array(
			'value'		=> $detail['data']['detail_text4'],
			'field'		=> 'detail_text4',
			'height'	=> '200px',
			'width'		=> '524px',
			'rows'		=> '15',
			'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
			'lang'		=> 'nl'
		);

		include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');


		?></td>
	</tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>
	<tr><td colspan="2" class="rowspacer7x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>

	<tr>
		<td class="chatlist" colspan="2" style="padding-bottom:4px"><h1 class="title" style="margin-bottom:10px"><?php echo $BLM['detail_text5'] ?>:</h1></td>
	</tr>

	<tr>
		<td colspan="2" align="center"><?php

		$wysiwyg_editor = array(
			'value'		=> $detail['data']['detail_text5'],
			'field'		=> 'detail_text5',
			'height'	=> '200px',
			'width'		=> '524px',
			'rows'		=> '15',
			'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
			'lang'		=> 'nl'
		);

		include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');


		?></td>
	</tr>

	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>
	<tr><td colspan="2" class="rowspacer7x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>

	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_varchar1'] ?>:&nbsp;</td>
		<td><input name="detail_varchar1" type="text" id="detail_varchar1" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_varchar1']) ?>" size="30" maxlength="220" /></td>
	</tr>

	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_varchar2'] ?>:&nbsp;</td>
		<td><input name="detail_varchar2" type="text" id="detail_varchar2" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_varchar2']) ?>" size="30" maxlength="220" /></td>
	</tr>

	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_varchar3'] ?>:&nbsp;</td>
		<td><input name="detail_varchar3" type="text" id="detail_varchar3" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_varchar3']) ?>" size="30" maxlength="220" /></td>
	</tr>

	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_varchar4'] ?>:&nbsp;</td>
		<td><input name="detail_varchar4" type="text" id="detail_varchar4" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_varchar4']) ?>" size="30" maxlength="220" /></td>
	</tr>
// TB -->
<!-- Mod novallis # umgruppiert nach oben
	<tr>
		<td align="right" class="chatlist"><?php echo $BLM['detail_varchar5'] ?>:&nbsp;</td>
		<td><input name="detail_varchar5" type="text" id="detail_varchar5" class="f11" style="width:400px;" value="<?php echo html_specialchars($detail['data']['detail_varchar5']) ?>" size="30" maxlength="220" /></td>
	</tr>
// Ende Mod novallis # -->

	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>



	<tr>
		<td align="right" class="chatlist tdtop4"><?php echo $BLM['detail_aktiv'] ?>:&nbsp;</td>
		<td><table border="0" cellpadding="0" cellspacing="0" summary="">
			<tr>
				<td><input type="checkbox" name="detail_aktiv" id="detail_aktiv" value="1"<?php is_checked(empty($detail['data']['detail_aktiv'])?0:1, 1) ?> /></td>
				<td><label for="glossary_status"><?php echo $BL['be_cnt_activated'] ?></label></td>
			</tr>
		</table></td>

	</tr>

	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input name="submit" type="submit" class="button10" value="<?php echo empty($detail['data']['detail_id']) ? $BL['be_admin_fcat_button2'] : $BL['be_article_cnt_button1'] ?>" />
			<input name="save" type="submit" class="button10" value="<?php echo $BL['be_article_cnt_button3'] ?>" />
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="new" type="button" class="button10" value="<?php echo ucfirst($BL['be_msg_new']) ?>" onclick="location.href='<?php echo decode_entities(GLOSSARY_HREF) ?>&edit=0';return false;" />
			<input name="close" type="button" class="button10" value="<?php echo $BL['be_admin_struct_close'] ?>" onclick="location.href='<?php echo decode_entities(GLOSSARY_HREF) ?>';return false;" />
		</td>
	</tr>

</table>

</form>

<script type="text/javascript">
<!--

window.addEvent('domready', function(){

	/* Autocompleter for categories/tags */
	var searchCategory = $('detail_tag');
	var indicator2 = new Element('span', {'class': 'autocompleter-loading', 'styles': {'display': 'none'}}).setHTML('').injectAfter(searchCategory);
	var completer2 = new Autocompleter.Ajax.Json(searchCategory, 'include/inc_act/ajax_connector.php', {
		multi: true,
		maxChoices: 30,
		autotrim: true,
		minLength: 0,
		allowDupes: false,
		postData: {action: 'category', method: 'json'},
		onRequest: function(el) {
			indicator2.setStyle('display', '');
		},
		onComplete: function(el) {
			indicator2.setStyle('display', 'none');
		}
	});
	/* Autocompleter for alias */
	var selectLang = $('detail_alias');
	var indicator1 = new Element('span', {'class': 'autocompleter-loading', 'styles': {'display': 'none'}}).setHTML('').injectAfter(selectLang);
	var completer1 = new Autocompleter.Ajax.Json(selectLang, 'include/inc_act/ajax_connector.php', {
		multi: false,
		allowDupes: false,
		autotrim: true,
		minLength: 0,
		maxChoices: 20,
		postData: {action: 'alias', method: 'json'},
		onRequest: function(el) {
			indicator1.setStyle('display', '');
		},
		onComplete: function(el) {
			indicator1.setStyle('display', 'none');
		}
	});

	selectLang.addEvent('keyup', function(){
		this.value = this.value.replace(/[^a-z\-\_]/g, '');
	});

	/* Autocompleter for Landing-page */
	var selectLang2 = $('detail_varchar5');
	var indicator2 = new Element('span', {'class': 'autocompleter-loading', 'styles': {'display': 'none'}}).setHTML('').injectAfter(selectLang2);
	var completer2 = new Autocompleter.Ajax.Json(selectLang, 'include/inc_act/ajax_connector.php', {
		multi: false,
		allowDupes: false,
		autotrim: true,
		minLength: 0,
		maxChoices: 20,
		postData: {action: 'detail_varchar5', method: 'json'},
		onRequest: function(el) {
			indicator2.setStyle('display', '');
		},
		onComplete: function(el) {
			indicator2.setStyle('display', 'none');
		}
	});

	selectLang2.addEvent('keyup', function(){
		this.value = this.value.replace(/[^a-z\-\_]/g, '');
	});


	setCalendarAllDay();
	setRangeDates(<?php echo $plugin['data']['calendar_range'] ?>);

	$('calendar_form').addEvent('submit', function(r) {
		var calendar_title = $('calendar_title');
		calendar_title.value = calendar_title.value.clean();
		if( calendar_title.value == '' ) {
			var r = new Event(r).stop();
			alert('<?php echo $BLM['alert_empty_title'] ?>');
		}
	});


	showImage();

});



function setImgIdName(file_id, file_name) {
	if(file_id == null) file_id=0;
	if(file_name == null) file_name='';
	getObjectById('cnt_image_id').value = file_id;
	getObjectById('cnt_image_name').value = file_name;

	showImage();
}

function showImage() {
	id	= parseInt(getObjectById('cnt_image_id').value);
	img	= getObjectById('cnt_image');
	if(id > 0) {
		img.innerHTML = '<img src="<?php echo PHPWCMS_URL.'img/cmsimage.php/'.$phpwcms['img_list_width'].'x'.$phpwcms['img_list_height'] ?>/'+id+'" alt="" border="0" />';
		img.style.display = '';
	} else {
		img.style.display = 'none';
	}
}

function setPaginateBasis() {
	if($('detail_paginate_basis').selectedIndex == 0) {
		$('detail_paginate_count').setStyle('visibility', 'visible');
	} else {
		$('detail_paginate_count').setStyle('visibility', 'hidden');
	}
}
//-->
</script>



?>