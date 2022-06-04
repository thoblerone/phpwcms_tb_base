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


// Glossary module content part form fields

// it's typically implemented in a 2 column table

// -> a spacer table row
//	<tr><td colspan="2"><img src="img/lines/l538_70.gif" alt="" width="538" height="1" /></td></tr>

// -> this can be used as spaceholfer
//	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="6" /></td></tr>

// -> this is the tyical way to format rows with label and input
//	<tr>
//		<td align="right" class="chatlist">Field label</td>
//		<td><input type="text" value="" /></td>
//	</tr>

// current module vars are stored in $phpwcms['modules'][$content["module"]]
// var to modules path: $phpwcms['modules'][$content["module"]]['path']

// before you can use module content part vars check if value is valid and what you are expect
// when defining modules vars it is always recommend to name t "modulename_varname".

if(empty($content['detail']['detail_template'])) {
	$content['detail']['detail_template'] = '';
}
if(empty($content['detail']['detail_max_words'])) {
	$content['detail']['detail_id'] = '';
}

// echo $content['detail']['detail_template'];

$BE['HEADER']['contentpart.js'] = getJavaScriptSourceLink('include/inc_js/contentpart.js');

// necessary JavaScript libraries
initMootools();
initMootoolsAutocompleter();


$BE['BODY_CLOSE'][] = '<script language="javascript" type="text/javascript">document.getElementById("target_ctype").disabled = true;</script>';

?>
<!-- top spacer - seperate from title/subtitle section -->
<tr><td colspan="2" style="padding-bottom:8px"><img src="img/lines/l538_70.gif" alt="" width="538" height="1" /></td></tr>
<!-- start custom fields here -->

<!-- retrieve templates -->
<tr>
	<td align="right" class="chatlist"><?php echo $BL['be_admin_struct_template'] ?>:&nbsp;</td>
	<td><select name="detail_template" id="detail_template" class="f11b">
<?php

	echo '<option value="">'.$BL['be_admin_tmpl_default'].'</option>'.LF;

// templates for forum
$tmpllist = get_tmpl_files($phpwcms['modules'][$content["module"]]['path'].'template');
if(is_array($tmpllist) && count($tmpllist)) {
	foreach($tmpllist as $val) {
		$vals = '';
		if($val == $content['detail']['detail_template']) $vals= ' selected="selected"';
		$val = html_specialchars($val);
		echo '<option value="'.$val.'"'.$vals.'>'.$val."</option>\n";
	}
}

?>
		</select></td>
</tr>
<!-- end templates -->

<!-- little space -->
<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="15" /></td></tr>
<!-- end space -->

<!-- input field -->




<!-- End example -->



<!-- end field -->

<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="8" /></td></tr>

<tr>
	<td align="right" class="chatlist"><?php echo $BL['modules'][$content["module"]]['teaser'] ?>:&nbsp;</td>
	<td><table cellpadding="0" cellspacing="0" border="0" summary="">
		<tr>
			<td><input name="detail_maxwords" type="text" class="f11b" id="detail_maxwords" style="width: 50px;" size="5" maxlength="5" onKeyUp="if(!parseInt(this.value)) this.value='';" value="<?php echo $content['detail']['detail_maxwords'] ?>" /></td>
			<td class="chatlist">&nbsp;<?php echo $BL['modules'][$content["module"]]['max_words'] ?></td>
		</tr>
	</table></td>
</tr>

<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="8" /></td></tr>

<tr>
	<td align="right" class="chatlist"><?php echo $BL['modules'][$content["module"]]['tag'] ?>:&nbsp;</td>
	<td><input type="text" name="detail_tag" id="detail_tag" value="<?php echo html_specialchars($content['detail']['detail_tag']) ?>" class="f11b" style="width: 440px" maxlength="1000" /></td>
</tr>

<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="8" /></td></tr>


<tr>
	<td align="right" class="chatlist"><?php echo $BL['modules'][$content["module"]]['alias'] ?>:&nbsp;</td>
	<td><table cellpadding="0" cellspacing="0" border="0" summary="">
		<tr>
			<td><input name="detail_alias" type="text" class="f11b" id="detail_alias" style="width: 150px;" size="300" maxlength="300" value="<?php echo $content['detail']['detail_alias'] ?>" /></td>
			<td class="chatlist">&nbsp;<?php echo $BL['modules'][$content["module"]]['alias_text'] ?></td>
		</tr>
	</table></td>
</tr>


<!-- we dont use this,....yet


<tr>
	<td>&nbsp;</td>
	<td><table cellpadding="0" cellspacing="0" border="0" summary="">
		<tr>
			<td bgcolor="#e7e8eb"><input type="checkbox" name="detail_paginate" id="detail_paginate" value="1"<?php is_checked(1, $content['detail']['detail_paginate']) ?> /></td>
			<td bgcolor="#e7e8eb"><label for="detail_paginate">&nbsp;<?php echo $BL['be_pagination'] ?>&nbsp;&nbsp;</label></td>
			<td>&nbsp;&nbsp;</td>
			<td><select name="detail_paginate_basis" id="detail_paginate_basis" onchange="setPaginateBasis();">

				<option value="0"<?php is_selected(0, $content['detail']['detail_paginate_basis']) ?>><?php echo $BL['be_pagniate_count'] ?></option>
				<option value="1"<?php is_selected(1, $content['detail']['detail_paginate_basis']) ?>><?php echo $BL['be_date_day'] ?></option>
				<option value="2"<?php is_selected(2, $content['detail']['detail_paginate_basis']) ?>><?php echo $BL['be_date_week'] ?></option>
				<option value="3"<?php is_selected(3, $content['detail']['detail_paginate_basis']) ?>><?php echo $BL['be_date_month'] ?></option>
				<option value="4"<?php is_selected(4, $content['detail']['detail_paginate_basis']) ?>><?php echo $BL['be_date_year'] ?></option>

			</select></td>
			<td>&nbsp;&nbsp;</td>
			<td><input type="text" name="detail_paginate_count" id="detail_paginate_count" value="<?php echo html_specialchars($content['detail']['detail_paginate_count']) ?>" class="width25" /></td>
		</tr>
		</table></td>
</tr>

-->


<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="8" /></td></tr>

<tr>
	<td align="right" class="chatlist" style="padding:3px 5px 0 0" valign="top"><?php echo $BL['modules'][$content["module"]]['no_entry'] ?>:</td>
	<td><textarea name="detail_noentry" id="detail_noentry" class="f11" rows="5" style="width: 440px"><?php echo html_specialchars($content['detail']['detail_noentry']) ?></textarea></td>
</tr>
<tr>
	<td colspan="2">
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
		postData: {action: 'tag', method: 'json'},
		onRequest: function(el) {
			indicator2.setStyle('display', '');
		},
		onComplete: function(el) {
			indicator2.setStyle('display', 'none');
		}
	});
});

var teaser_items = $('calink');
var source_items = $('calinklist');


function setPaginateBasis() {
	if($('detail_paginate_basis').selectedIndex == 0) {
		$('detail_paginate_count').setStyle('visibility', 'visible');
	} else {
		$('detail_paginate_count').setStyle('visibility', 'hidden');
	}
}
//-->
</script>
</td></tr>

<!-- end custom fields -->
<!-- bottom spacer - is followed by status "visible" checkbox -->
<tr><td colspan="2" style="padding-top:8px"><img src="img/lines/l538_70.gif" alt="" width="538" height="1" /></td></tr>
