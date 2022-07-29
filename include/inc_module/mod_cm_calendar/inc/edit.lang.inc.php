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

// pack abbreviation/language array
	$a_languages = array(
	'af' => 'Afrikaans',
	'sq' => 'Albanian',
	'ar-dz' => 'Arabic (Algeria)',
	'ar-bh' => 'Arabic (Bahrain)',
	'ar-eg' => 'Arabic (Egypt)',
	'ar-iq' => 'Arabic (Iraq)',
	'ar-jo' => 'Arabic (Jordan)',
	'ar-kw' => 'Arabic (Kuwait)',
	'ar-lb' => 'Arabic (Lebanon)',
	'ar-ly' => 'Arabic (libya)',
	'ar-ma' => 'Arabic (Morocco)',
	'ar-om' => 'Arabic (Oman)',
	'ar-qa' => 'Arabic (Qatar)',
	'ar-sa' => 'Arabic (Saudi Arabia)',
	'ar-sy' => 'Arabic (Syria)',
	'ar-tn' => 'Arabic (Tunisia)',
	'ar-ae' => 'Arabic (U.A.E.)',
	'ar-ye' => 'Arabic (Yemen)',
	'ar' => 'Arabic',
	'hy' => 'Armenian',
	'as' => 'Assamese',
	'az' => 'Azeri',
	'eu' => 'Basque',
	'be' => 'Belarusian',
	'bn' => 'Bengali',
	'bg' => 'Bulgarian',
	'ca' => 'Catalan',
	'zh-cn' => 'Chinese (China)',
	'zh-hk' => 'Chinese (Hong Kong SAR)',
	'zh-mo' => 'Chinese (Macau SAR)',
	'zh-sg' => 'Chinese (Singapore)',
	'zh-tw' => 'Chinese (Taiwan)',
	'zh' => 'Chinese',
	'hr' => 'Croatian',
	'cs' => 'Czech',
	'da' => 'Danish',
	'div' => 'Divehi',
	'nl-be' => 'Dutch (Belgium)',
	'nl' => 'Dutch (Netherlands)',
	'en-au' => 'English (Australia)',
	'en-bz' => 'English (Belize)',
	'en-ca' => 'English (Canada)',
	'en-ie' => 'English (Ireland)',
	'en-jm' => 'English (Jamaica)',
	'en-nz' => 'English (New Zealand)',
	'en-ph' => 'English (Philippines)',
	'en-za' => 'English (South Africa)',
	'en-tt' => 'English (Trinidad)',
	'en-gb' => 'English (United Kingdom)',
	'en-us' => 'English (United States)',
	'en-zw' => 'English (Zimbabwe)',
	'en' => 'English',
	'us' => 'English (United States)',
	'et' => 'Estonian',
	'fo' => 'Faeroese',
	'fa' => 'Farsi',
	'fi' => 'Finnish',
	'fr-be' => 'French (Belgium)',
	'fr-ca' => 'French (Canada)',
	'fr-lu' => 'French (Luxembourg)',
	'fr-mc' => 'French (Monaco)',
	'fr-ch' => 'French (Switzerland)',
	'fr' => 'French (France)',
	'mk' => 'FYRO Macedonian',
	'gd' => 'Gaelic',
	'ka' => 'Georgian',
	'de-at' => 'German (Austria)',
	'de-li' => 'German (Liechtenstein)',
	'de-lu' => 'German (Luxembourg)',
	'de-ch' => 'German (Switzerland)',
	'de' => 'German (Germany)',
	'el' => 'Greek',
	'gu' => 'Gujarati',
	'he' => 'Hebrew',
	'hi' => 'Hindi',
	'hu' => 'Hungarian',
	'is' => 'Icelandic',
	'id' => 'Indonesian',
	'it-ch' => 'Italian (Switzerland)',
	'it' => 'Italian (Italy)',
	'ja' => 'Japanese',
	'kn' => 'Kannada',
	'kk' => 'Kazakh',
	'kok' => 'Konkani',
	'ko' => 'Korean',
	'kz' => 'Kyrgyz',
	'lv' => 'Latvian',
	'lt' => 'Lithuanian',
	'ms' => 'Malay',
	'ml' => 'Malayalam',
	'mt' => 'Maltese',
	'mr' => 'Marathi',
	'mn' => 'Mongolian (Cyrillic)',
	'ne' => 'Nepali (India)',
	'nb-no' => 'Norwegian (Bokmal)',
	'nn-no' => 'Norwegian (Nynorsk)',
	'no' => 'Norwegian (Bokmal)',
	'or' => 'Oriya',
	'pl' => 'Polish',
	'pt-br' => 'Portuguese (Brazil)',
	'pt' => 'Portuguese (Portugal)',
	'pa' => 'Punjabi',
	'rm' => 'Rhaeto-Romanic',
	'ro-md' => 'Romanian (Moldova)',
	'ro' => 'Romanian',
	'ru-md' => 'Russian (Moldova)',
	'ru' => 'Russian',
	'sa' => 'Sanskrit',
	'sr' => 'Serbian',
	'sk' => 'Slovak',
	'ls' => 'Slovenian',
	'sb' => 'Sorbian',
	'es-ar' => 'Spanish (Argentina)',
	'es-bo' => 'Spanish (Bolivia)',
	'es-cl' => 'Spanish (Chile)',
	'es-co' => 'Spanish (Colombia)',
	'es-cr' => 'Spanish (Costa Rica)',
	'es-do' => 'Spanish (Dominican Republic)',
	'es-ec' => 'Spanish (Ecuador)',
	'es-sv' => 'Spanish (El Salvador)',
	'es-gt' => 'Spanish (Guatemala)',
	'es-hn' => 'Spanish (Honduras)',
	'es-mx' => 'Spanish (Mexico)',
	'es-ni' => 'Spanish (Nicaragua)',
	'es-pa' => 'Spanish (Panama)',
	'es-py' => 'Spanish (Paraguay)',
	'es-pe' => 'Spanish (Peru)',
	'es-pr' => 'Spanish (Puerto Rico)',
	'es-us' => 'Spanish (United States)',
	'es-uy' => 'Spanish (Uruguay)',
	'es-ve' => 'Spanish (Venezuela)',
	'es' => 'Spanish (Traditional Sort)',
	'sx' => 'Sutu',
	'sw' => 'Swahili',
	'sv-fi' => 'Swedish (Finland)',
	'sv' => 'Swedish',
	'syr' => 'Syriac',
	'ta' => 'Tamil',
	'tt' => 'Tatar',
	'te' => 'Telugu',
	'th' => 'Thai',
	'ts' => 'Tsonga',
	'tn' => 'Tswana',
	'tr' => 'Turkish',
	'uk' => 'Ukrainian',
	'ur' => 'Urdu',
	'uz' => 'Uzbek',
	'vi' => 'Vietnamese',
	'xh' => 'Xhosa',
	'yi' => 'Yiddish',
	'zu' => 'Zulu' );

?>

<form action="<?php echo cm_map_url( array('controller=lang', 'edit='.$plugin['data']['cm_lang_id']) ) ?>" name="frmLang" method="post" style="background:#F3F5F8;border-top:1px solid #92A1AF;border-bottom:1px solid #92A1AF;margin:0 0 5px 0;padding:10px 8px 15px 8px">
<input type="hidden" name="grrr" value="<?php echo $plugin['data']['cm_lang_id'] ?>" />
<input type="hidden" name="cm_lang_sys" value="<?php echo $plugin['data']['cm_lang_sys'] ?>" />
<table border="0" cellpadding="0" cellspacing="0" width="100%" summary="">
	<tr> 
		<td align="right" class="chatlist"><?php echo $BL['be_cnt_last_edited']  ?>:&nbsp;</td>
		<td colspan="2" class="v10" width="410"><?php		
		if($plugin['data']['cm_lang_id']==0) {
		echo html_specialchars(date($BL['be_fprivedit_dateformat'], strtotime($plugin['data']['cm_lang_changedate']))) ;
		}else{
		echo html_specialchars(date($BL['be_fprivedit_dateformat'], $plugin['data']['cm_lang_changedate'])) ;
		}
		if(!empty($plugin['data']['cm_lang_createdate'])) {
		?>		
		&nbsp;&nbsp;&nbsp;<span class="chatlist"><?php echo $BL['be_fprivedit_created']  ?>:</span> 
		<?php 
				echo html_specialchars(date($BL['be_fprivedit_dateformat'], strtotime($plugin['data']['cm_lang_createdate'])));
		}
		
		?></td>
	</tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

<?php if ($plugin['data']['cm_lang_id'] == 0)  { ?>
	<tr> 
		<td align="right" class="chatlist"><?php echo $BLM['lang_name'] ?>:&nbsp;</td>
		<td colspan="2">
    <select name="cm_llocs" class="v12<?php
		//error class
		if(!empty($plugin['error']['cm_lang_loc'])) echo ' errorInputText';
		?>" onchange="this.form.submit();">
      <option value="0"> </option>
	<?php
    $langName = "";
		foreach($a_languages as $key => $value) {
			echo '<option value="' . $key . '"';
			if($plugin['data']['cm_lang_loc'] === $key) {
        echo " selected=selected";
        $langName = $value;
      }
			echo '>' . html_specialchars($value) . '</option>' . LF;
		
		}
 		?>   
    </select><?php if(!empty($plugin['error']['cm_lang_loc'])) echo ' '.$plugin['error']['cm_lang_loc']; ?>
    <input type="hidden" name="cm_lang_name" value="<?php echo $langName ?>" />
    </td>
	</tr>
		
<?php } else { ?>
<tr> 
		<td align="right" class="chatlist"><?php echo $BLM['lang_name'] ?>:&nbsp;</td>
		<td colspan="2"><input type="hidden" name="cm_lang_name" value="<?php echo $plugin['data']['cm_lang_name'] ?>" />
    <input type="hidden" name="cm_llocs" value="<?php echo $plugin['data']['cm_lang_loc'] ?>" />
    <strong><?php echo $plugin['data']['cm_lang_loc'].' - '.$plugin['data']['cm_lang_name'] ?></strong></td>
</tr>

<?php } ?>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_cale'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_cale" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_cale'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_date'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_date" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_date'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_span'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_span" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_span'] ?>" />&nbsp;<?php echo $BLM['lang_span_exmpl'] ?></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_titl'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_titl" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_titl'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_time'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_time" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_time'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_loca'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_loca" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_loca'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_desc'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_desc" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_desc'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_noen'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_noen" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_noen'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_noca'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_noca" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_noca'] ?>" /></td></tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_dateformat'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_dateformat" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_dateformat'] ?>" />&nbsp;<a href="https://www.php.net/manual/function.date.php" target="_blank">Reference</a></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_undf'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_undf" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_undf'] ?>" />&nbsp;<?php echo $BLM['lang_undf_exmpl'] ?></td></tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
	
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_prnt'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_prnt" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_prnt'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_ical'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_ical" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_ical'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_artl'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_artl" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_artl'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['cal_rt_img_leftbut'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_lbut" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_lbut'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['cal_rt_img_rightbut'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_rbut" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_rbut'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['cal_rt_img_backlink'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_bckl" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_bckl'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['cal_rt_img_listinglink'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_lstl" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_lstl'] ?>" /></td></tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
 
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_slct'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_slct" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_slct'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_slct_all'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_slct_all" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_slct_all'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_slct_am'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_slct_am" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_slct_am'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_slct_ay'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_slct_ay" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_slct_ay'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_slct_nm'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_slct_nm" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_slct_nm'] ?>" />&nbsp;<?php echo $BLM['lang_slct_nm_exmpl'] ?></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_slct_ny'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_slct_ny" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_slct_ny'] ?>" />&nbsp;<?php echo $BLM['lang_slct_ny_exmpl'] ?></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_slct_lm'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_slct_lm" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_slct_lm'] ?>" />&nbsp;<?php echo $BLM['lang_slct_lm_exmpl'] ?></td></tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_jan'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_jan" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_jan'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_feb'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_feb" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_feb'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_mar'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_mar" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_mar'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_apr'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_apr" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_apr'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_may'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_may" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_may'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_jun'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_jun" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_jun'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_jul'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_jul" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_jul'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_aug'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_aug" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_aug'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_sep'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_sep" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_sep'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_oct'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_oct" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_oct'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_nov'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_nov" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_nov'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_dec'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_dec" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_dec'] ?>" /></td></tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_mon'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_mon" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_mon'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_tue'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_tue" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_tue'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_wed'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_wed" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_wed'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_thu'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_thu" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_thu'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_fri'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_fri" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_fri'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_sat'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_sat" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_sat'] ?>" /></td></tr>
  <tr><td align="right" class="chatlist"><?php echo $BLM['lang_sun'] ?>:&nbsp;</td><td><input type="text" name="cm_lang_sun" class="v12" style="width:200px;" size="20" maxlength="200" value="<?php echo $plugin['data']['lang']['cm_lang_sun'] ?>" /></td></tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>




<?php  if ($plugin['data']['cm_lang_id']!=1) {	?>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BL['be_ftptakeover_status'] ?>:&nbsp;</td>
		<td colspan="2"><table border="0" cellpadding="0" cellspacing="0" summary="">		
			<tr>
				<td><input type="checkbox" name="cm_lang_status" id="cm_lang_status" value="1"<?php is_checked($plugin['data']['cm_lang_status'], 1) ?> /></td>
				<td><label for="cm_lang_status"><?php echo $BL['be_cnt_activated'] ?></label></td>
			</tr>
		</table></td>
	</tr>
<?php  } else {	?>
	<tr>
		<td align="right" class="chatlist"></td>
    <td colspan="2"><input type="hidden" name="cm_lang_status" value="1" /></td>
	</tr>
<?php  }	?>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

	<tr> 
		<td>&nbsp;</td>
		<td colspan="2"><?php 
		  if(empty($plugin['error']['cm_lang_loc'])) {	?>
			<input name="submit2" id="sub1" type="submit" class="button10" value="<?php echo empty($plugin['data']['cm_lang_id']) ? $BL['be_admin_fcat_button2'] : $BL['be_article_cnt_button1'] ?>" />
			<input name="save" id="sub2" type="submit" class="button10" value="<?php echo $BL['be_article_cnt_button3'] ?>" />
			&nbsp;&nbsp;&nbsp;&nbsp;<?php  }	?>
			<input name="close" type="submit" class="button10" value="<?php echo $BL['be_admin_struct_close'] ?>" />
		</td>
	</tr>
</table>

</form>