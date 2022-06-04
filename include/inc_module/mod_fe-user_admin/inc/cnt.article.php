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


// Glossary module content part frontend article rendering

// if you ant to access module vars check that var
// $phpwcms['modules'][$crow["acontent_module"]]

$content['detail'] = @unserialize($crow["acontent_form"]);



// check for template and load default in case of error
if(empty($content['detail']['detail_template'])) {

	// load default template
	$content['detail']['detail_template'] = file_get_contents($phpwcms['modules'][$crow["acontent_module"]]['path'].'template/default/default.tmpl');
	// echo "Stop!";
} elseif(file_exists($phpwcms['modules'][$crow["acontent_module"]]['path'].'template/'.$content['detail']['detail_template'])) {

	// echo "Template found<br/>!";

	// load custom template
	$content['detail']['detail_template'] = file_get_contents($phpwcms['modules'][$crow["acontent_module"]]['path'].'template/'.$content['detail']['detail_template']);

} else {

	// again load default template
	$content['detail']['detail_template'] = file_get_contents($phpwcms['modules'][$crow["acontent_module"]]['path'].'template/default/default.tmpl');

}

// get template based image vars
		$detail['config']	= array_merge(	array(	'swidth'	=> 50,
													'sheight'	=> 100,
													'lwidth'	=> 150,
													'lheight'	=> 225,
													'crop'		=> 0,
													'q'			=> 75
												),
										parse_ini_str( get_tmpl_section('DETAIL_SETTINGS', $content['detail']['detail_template']), false )
									  );

		$detail['config']['swidth']		= abs(intval($detail['config']['swidth']));
		$detail['config']['lwidth']		= abs(intval($detail['config']['lwidth']));
		$detail['config']['sheight']	= abs(intval($detail['config']['sheight']));
		$detail['config']['lheight']	= abs(intval($detail['config']['lheight']));
		$detail['config']['crop']		= abs(intval($detail['config']['crop']));
		$detail['config']['q']			= abs(intval($detail['config']['q']));







$content['detail']['where'] = '';

if(!empty($content['detail']['detail_tag'])) {
	$content['detail']['detail_tag'] = convertStringToArray($content['detail']['detail_tag'], ' ');

	// print_r($content['detail']['detail_tag']);

	foreach($content['detail']['detail_tag'] as $_filter_c => $content['detail']['char']) {
		$content['detail']['detail_tag'][$_filter_c] = "detail_tag LIKE '%".aporeplace($content['detail']['char'])."%'";
	}
	if(count($content['detail']['detail_tag'])) {
		// echo "----->";
		// print_r( $content['detail']['char']);
		$content['detail']['where'] .= ' AND ('.implode(' OR ', $content['detail']['detail_tag']).')';
	}
}


// and now lets check where we are - listing mode or detail view
if(!empty($GLOBALS['_getVar']['detail_id'])) {

	// print_r($GLOBALS['_getVar']['detail_id']);
	$GLOBALS['_getVar']['detail_id'] = intval($GLOBALS['_getVar']['detail_id']);

	// get detail entry template sections
	$content['detail']['detail_head']	= get_tmpl_section('DETAIL_HEAD',	$content['detail']['detail_template']);

	$content['detail']['detail_footer']	= get_tmpl_section('DETAIL_FOOTER',	$content['detail']['detail_template']);

	$content['detail']['detail_entry']	= get_tmpl_section('DETAIL_ENTRY',	$content['detail']['detail_template']);

	$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_userdetail WHERE detail_aktiv=1 ';
	$sql .= 'AND detail_id='.$GLOBALS['_getVar']['detail_id'];
	$sql .= $content['detail']['where'];

	// echo $sql;

	$content['detail']['entry'] = _dbQuery($sql);

	// get image stuff out for single entry

	if(!empty($content['detail']['entry'][0]['detail_userimage'])) {



			$content['detail_userimage']		= unserialize($content['detail']['entry'][0]['detail_userimage']) or die ();
			$content['detail_userimage']		= array(

											'id'		=> intval($content['detail_userimage']['id']),
											'name'		=> clean_slweg($content['detail_userimage']['name']),
											'zoom'		=> empty($content['detail_userimage']['zoom']) ? 0 : 1,
											'lightbox'	=> empty($content['detail_userimage']['lightbox']) ? 0 : 1,
											'caption'	=> clean_slweg($content['detail_userimage']['caption']),
											'link'		=> clean_slweg($content['detail_userimage']['link'])
															);


	}
	if(!empty($content['detail']['entry'][0]['detail_notes'])) {



			$content['detail_notes']		= unserialize($content['detail']['entry'][0]['detail_notes']) or die ();
			$content['detail_notes']		= array(

											'alias'		=> clean_slweg($content['detail_notes']['user_alias'])

															);


	}
	// Lightbox
	if(empty($content['detail_userimage']['lightbox'])) {
			// echo "No lightbox";

	} else {
		initializeLightbox();
		$content['detail_userimage']['lightbox'] = 'rel="lightbox"';

	}

	if(!empty($_entry_value['detail_notes'])) {

			$_entry_value['detail_notes']		= unserialize($_entry_value['detail_notes']) or die ();

			$_entry_value['detail_notes']		= array(


											'alias'		=> clean_slweg($_entry_value['detail_userimage']['alias']),

															);

		    // print_r($_entry_value['detail_notes']['alias']);
			if($_entry_value['detail_notes']['alias'] = "") {
				$_entry_value['detail_notes']['alias']	= $content['detail_notes']['alias'];
			}


	}
	if(!empty($GLOBALS['_getVar']['backlink'])) {

		$_entry_value['detail_backlink'] = "index.php?".$GLOBALS['_getVar']['backlink'];
	}



	if(empty($content['detail']['entry'][0])) {

		$content['detail']['entry']['detail_title']	= '';
		$content['detail']['entry']['detail_prof']	= 'none found';
		$content['detail']['entry']['detail_text']	= $content['detail']['detail_noentry'];
		$content['detail']['entry']['detail_id']	= 'empty-detail-id';



	} else {

		$content['detail']['entry'] = $content['detail']['entry'][0];


	}

	unset($GLOBALS['_getVar']['detail_id']);
	unset($GLOBALS['_getVar']['detail_title']);

	$content['detail_userimage']['image_small'] = "<img border=\"0\" src=\"".PHPWCMS_URL."img/cmsimage.php/".$detail['config']['swidth']	."x".$detail['config']['sheight']."x".$detail['config']['crop']	."x".$detail['config']['q']	."/".$content['detail_userimage']['id']."\" title=\"\" alt=\"\">";

	$content['detail_userimage']['image_large'] = "<img border=\"0\" src=\"".PHPWCMS_URL."img/cmsimage.php/".$detail['config']['lwidth']	."x".$detail['config']['lheight']."x".$detail['config']['crop']	."x".$detail['config']['q']	."/".$content['detail_userimage']['id']."\" title=\"\" alt=\"\">";

	$content['detail']['backlink'] = "<a href=\"javascript:history.back();\">Terug</a>";




	$content['detail']['detail_entry']	= get_tmpl_section('DETAIL_ENTRY',		$content['detail']['detail_template']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'IMAGE_SMALL', $content['detail_userimage']['image_small']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'IMAGE_LARGE', $content['detail_userimage']['image_large']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'IMAGE_URL', $content['detail_userimage']['link']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'IMAGE_ID', $content['detail_userimage']['id']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'CAPTION', $content['detail_userimage']['caption']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'LIGHTBOX', $content['detail_userimage']['lightbox']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'ZOOM', $content['detail_userimage']['zoom']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'SWIDTH', $detail['config']['swidth']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'SHEIGHT', $detail['config']['sheight']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'LWIDTH', $detail['config']['lwidth']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'LHEIGHT', $detail['config']['lheight']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'CROP', $detail['config']['crop']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'Q', $detail['config']['q']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'TEXTVAR1', $content['detail']['entry']['detail_text1']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'TEXTVAR2', $content['detail']['entry']['detail_text2']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'TEXTVAR3', $content['detail']['entry']['detail_text3']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'TEXTVAR4', $content['detail']['entry']['detail_text4']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'TEXTVAR5', $content['detail']['entry']['detail_text5']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'VARCHAR1', $content['detail']['entry']['detail_varchar1']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'VARCHAR2', $content['detail']['entry']['detail_varchar2']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'VARCHAR3', $content['detail']['entry']['detail_varchar3']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'VARCHAR4', $content['detail']['entry']['detail_varchar4']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'VARCHAR5', $content['detail']['entry']['detail_varchar5']);

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'TITLE', html_entities($content['detail']['entry']['detail_title']));

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'FIRSTNAME', html_entities($content['detail']['entry']['detail_firstname']));

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'LASTNAME', html_entities($content['detail']['entry']['detail_lastname']));

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'PHONE', html_entities($content['detail']['entry']['detail_fon']));

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'EMAIL', html_entities($content['detail']['entry']['detail_email']));

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'LASTNAME', html_entities($content['detail']['entry']['detail_lastname']));

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'COMPANY', html_entities($content['detail']['entry']['detail_company']));

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'FUNCTION', html_entities($content['detail']['entry']['detail_prof']));

	$content['detail']['detail_entry']	= render_cnt_template($content['detail']['detail_entry'], 'BACKLINK', $content['detail']['backlink']);








	$content['detail']['item'] = $content['detail']['detail_head'] . $content['detail']['detail_entry'] . $content['detail']['detail_footer'];
	$content['detail']['item'] = str_replace('{DETAIL_ID}', $content['detail']['entry']['detail_id'], $content['detail']['item']);
	$content['detail']['item'] = str_replace('{BACKLINK}', $content['detail']['base_link'], $content['detail']['item']);
	// print_r($content['detail']['item']);
	// fine we will display given detail ID
	$CNT_TMP .= $content['detail']['item'];

}
// If no single id is given.

else {

	// get list entries template sections
	$content['detail']['list_head']			= get_tmpl_section('DETAIL_LIST_HEAD',		$content['detail']['detail_template']);
	$content['detail']['list_footer']		= get_tmpl_section('DETAIL_LIST_FOOTER',		$content['detail']['detail_template']);
	$content['detail']['list_entry']		= get_tmpl_section('DETAIL_LIST_ENTRY',		$content['detail']['detail_template']);
	$content['detail']['list_spacer']		= get_tmpl_section('DETAIL_LIST_SPACER',		$content['detail']['detail_template']);




	$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_userdetail WHERE detail_aktiv=1'.$content['detail']['where'].' ORDER BY detail_title';

	$content['detail']['entries'] = _dbQuery($sql);


	// print_r($content['detail']['entries']);



	$CNT_TMP .= render_cnt_template($content['detail']['list_head'], 'FILTER', $_filter_link);

	if(!count($content['detail']['entries'])) {

		$content['detail']['entries'][0]['detail_title']		= '';
		$content['detail']['entries'][0]['detail_firstname']	= '';
		$content['detail']['entries'][0]['detail_tag']			= $content['detail']['detail_noentry'];
		$content['detail']['entries'][0]['detail_alias']		= $content['detail']['detail_alias'];

		$_no_entry = true;


	} else {

		$_no_entry = false;


	}

	foreach($content['detail']['entries'] as $_entry_key => $_entry_value) {
		$content['detail']['base_link'] = substr($_SERVER['REQUEST_URI'], '?', '&');
		// $content['detail']['base_link'] = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'].'?', '&'));


		$content['detail']['backlink'] = html_specialchars("<a href=\"javascript(this.browser.back);\">Terug</a>");


		if(!empty($_entry_value['detail_userimage'])) {

			$_entry_value['detail_userimage']		= unserialize($_entry_value['detail_userimage']) or die ();
			$_entry_value['detail_userimage']		= array(

											'id'		=> intval($_entry_value['detail_userimage']['id']),
											'name'		=> clean_slweg($_entry_value['detail_userimage']['name']),
											'zoom'		=> empty($content['detail']['entries']['detail_userimage']['zoom']) ? 0 : 1,
											'lightbox'	=> empty($content['detail']['entries']['detail_userimage']['lightbox']) ? 0 : 1,
											'caption'	=> clean_slweg($content['detail']['entries']['detail_userimage']['caption']),
											'link'		=> clean_slweg($content['detail']['entries']['detail_userimage']['link'])
															);

		}

		if(!empty($_entry_value['detail_notes'])) {
			// echo "Hello";

			$_entry_value['detail_notes']		= unserialize($_entry_value['detail_notes']) or die ();
			// print_r($_entry_value['detail_notes']);
			$_entry_value['detail_notes']['alias']		= array(


											'alias'		=> clean_slweg($_entry_value['detail_notes']['user_alias']),

															);




		}
		if($content['detail']['detail_alias'] == "") {
			$content['detail']['detail_alias'] = $_entry_value['detail_notes']['alias']['alias'];
		}








		$_entry_value['detail_userimage']['image_small'] = "<img border=\"0\" src=\"".PHPWCMS_URL."img/cmsimage.php/".$detail['config']['swidth']	."x".$detail['config']['sheight']."x".$detail['config']['crop']	."x".$detail['config']['q']	."/".$_entry_value['detail_userimage']['id']."\" title=\"\" alt=\"\">";

		$_entry_value['detail_userimage']['image_large'] = "<img border=\"0\" src=\"".PHPWCMS_URL."img/cmsimage.php/150x200x0x75/".$_entry_value['detail_userimage']['id']."\" title=\"\" alt=\"\">";



		// Old bu sttill nneeedddeeedd, het lhaalt de "list entry set op !" anders blijven het {FIRSTNAME} tags uit de template inplaats van de values er van.
		$content['detail']['entries'][$_entry_key] = str_replace('{DETAIL_ID}', $_entry_value['detail_id'], $content['detail']['list_entry']);
		//

		$content['detail']['entries'][$_entry_key] = str_replace('{LINK}', $_no_entry ? '#' :
			$content['detail']['base_link'].'index.php?'.$content['detail']['detail_alias'].'&amp;detail_id='.$_entry_value['detail_id'].'&amp;detail_title='.urlencode($_entry_value['detail_title']), $content['detail']['entries'][$_entry_key]);


		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'BACKLINK', html_specialchars($content['detail']['back_link']));

		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'TITLE', html_specialchars($_entry_value['detail_title']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'FIRSTNAME', html_specialchars($_entry_value['detail_firstname']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'LASTNAME', html_specialchars($_entry_value['detail_lastname']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'FUNCTIE', html_specialchars($_entry_value['detail_prof']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'COMPANY', html_specialchars($_entry_value['detail_company']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'PHONE', html_specialchars($_entry_value['detail_fon']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'FAX', html_specialchars($_entry_value['detail_fax']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'WEBSITE', html_specialchars($_entry_value['detail_website']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'EMAIL', html_specialchars($_entry_value['detail_email']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'SIGNATURE', html_specialchars($_entry_value['detail_signature']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'FUNCTION', html_specialchars($_entry_value['detail_prof']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'TEXTVAR1', html_specialchars($_entry_value['detail_textvar1']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'TEXTVAR2', html_specialchars($_entry_value['detail_textvar2']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'TEXTVAR3', html_specialchars($_entry_value['detail_textvar3']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'TEXTVAR4', html_specialchars($_entry_value['detail_textvar4']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'TEXTVAR5', html_specialchars($_entry_value['detail_textvar5']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'VARCHAR1', html_specialchars($_entry_value['detail_varchar1']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'VARCHAR2', html_specialchars($_entry_value['detail_varchar2']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'VARCHAR3', html_specialchars($_entry_value['detail_varchar3']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'VARCHAR4', html_specialchars($_entry_value['detail_varchar4']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'VARCHAR5', html_specialchars($_entry_value['detail_varchar5']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'IMAGE_NAME', html_specialchars($_entry_value['detail_userimage']['name']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'IMAGE_ID', html_specialchars($_entry_value['detail_userimage']['id']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'CAPTION', html_specialchars($_entry_value['detail_userimage']['caption']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'ZOOM', html_specialchars($_entry_value['detail_userimage']['zoom']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'LIGHTBOX', html_specialchars($_entry_value['detail_userimage']['lightbox']));
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'IMAGE_LINK', html_specialchars($_entry_value['detail_userimage']['link']));

		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'IMAGE_SMALL', $_entry_value['detail_userimage']['image_small']);
		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'IMAGE_LARGE', $_entry_value['detail_userimage']['image_large']);

		$content['detail']['entries'][$_entry_key] = render_cnt_template($content['detail']['entries'][$_entry_key], 'ALIAS', html_specialchars($_entry_value['detail_notes']['alias']));


		// print_r( $content['detail']['entries'][$_entry_key]);

		if(!empty($content['detail']['detail_maxwords']) && !$_no_entry) {
			$_entry_value['detail_text'] = getCleanSubString(strip_tags($_entry_value['detail_text1']), $content['detail']['detail_maxwords'], $template_default['ellipse_sign'], 'word');
		}


	}

	$CNT_TMP .= implode($content['detail']['list_spacer'] ,$content['detail']['entries']);
	$CNT_TMP .= render_cnt_template($content['detail']['list_footer'], 'FILTER', $_filter_link);

}

// render content part title/subtitle
$CNT_TMP = render_cnt_template($CNT_TMP, 'CP_TITLE', html_specialchars($crow['acontent_title']));
$CNT_TMP = render_cnt_template($CNT_TMP, 'CP_SUBTITLE', html_specialchars($crow['acontent_subtitle']));

?>