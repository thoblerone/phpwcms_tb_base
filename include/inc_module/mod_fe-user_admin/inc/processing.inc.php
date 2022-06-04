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


// try

if(isset($_GET['edit'])) {
	$detail['id']		= intval($_GET['edit']);
} else {
	$detail['id']		= 0;
}



// process post form
if(isset($_POST['detail_title'])) {

	// echo intval($_POST['detail_id']);

	$detail['data'] = array(

				'detail_id'			=> intval($_POST['detail_id']),
				'detail_title'		=> clean_slweg($_POST['detail_title']),
				'detail_created'	=> date('Y-m-d H:i:s'),
				'detail_changed'	=> date('Y-m-d H:i:s'),
				'detail_firstname'	=> clean_slweg($_POST['detail_firstname']),
				'detail_tag'		=> clean_slweg($_POST['detail_tag']),
				'detail_alias'		=> clean_slweg($_POST['detail_alias']),
				'detail_lastname'	=> clean_slweg($_POST['detail_lastname']),
				'detail_company'	=> clean_slweg($_POST['detail_company']),
				'detail_street'		=> clean_slweg($_POST['detail_street']),
				'detail_add'		=> clean_slweg($_POST['detail_add']),
				'detail_city'		=> clean_slweg($_POST['detail_city']),
				'detail_zip'		=> clean_slweg($_POST['detail_zip']),
				'detail_region'		=> clean_slweg($_POST['detail_region']),
				'detail_country'	=> clean_slweg($_POST['detail_country']),
				'detail_fon'		=> clean_slweg($_POST['detail_fon']),
				'detail_fax'		=> clean_slweg($_POST['detail_fax']),
				'detail_mobile'		=> clean_slweg($_POST['detail_mobile']),
				'detail_signature'	=> clean_slweg($_POST['detail_signature']),
				'detail_prof'		=> clean_slweg($_POST['detail_prof']),
				'detail_public'		=> empty($_POST['detail_public']) ? 0 : 1,
				'detail_aktiv'		=> empty($_POST['detail_aktiv']) ? 0 : 1,
				'detail_newsletter'	=> empty($_POST['detail_newsletter']) ? 0 : 1,
				'detail_website'	=> clean_slweg($_POST['detail_website']),
				'detail_gender'		=> clean_slweg($_POST['detail_gender']),
				'detail_birthday'	=> clean_slweg($_POST['detail_birthday']),
				'detail_varchar1'	=> clean_slweg($_POST['detail_varchar1']),
				'detail_varchar2'	=> clean_slweg($_POST['detail_varchar2']),
				'detail_varchar3'	=> clean_slweg($_POST['detail_varchar3']),
				'detail_varchar4'	=> clean_slweg($_POST['detail_varchar4']),
				'detail_varchar5'	=> clean_slweg($_POST['detail_varchar5']),
				'detail_text1'		=> slweg($_POST['detail_text1']),
				'detail_text2'		=> slweg($_POST['detail_text2']),
				'detail_text3'		=> slweg($_POST['detail_text3']),
				'detail_text4'		=> slweg($_POST['detail_text4']),
				'detail_text5'		=> slweg($_POST['detail_text5']),

				'detail_email'		=> clean_slweg($_POST['detail_email']),
				'detail_login'		=> clean_slweg($_POST['detail_login']),
				'detail_password'	=> clean_slweg($_POST['detail_password']),

				'detail_int1'		=> intval($_POST['detail_int1']),
				'detail_int2'		=> intval($_POST['detail_int2']),
				'detail_int3'		=> intval($_POST['detail_int3']),
				'detail_int4'		=> intval($_POST['detail_int4']),
				'detail_int5'		=> intval($_POST['detail_int5']),

				'detail_float1'		=> intval($_POST['detail_float1']),
				'detail_float2'		=> intval($_POST['detail_float2']),
				'detail_float3'		=> intval($_POST['detail_float3']),
				'detail_float4'		=> intval($_POST['detail_float4']),
				'detail_float5'		=> intval($_POST['detail_float5']),


				'detail_notes'		=> array(

							'user_login'		=> clean_slweg($_POST['detail_login']),
							'user_tag'			=> clean_slweg($_POST['detail_tag']),
							'user_firstname'	=> clean_slweg($_POST['detail_firstname']),
							'user_lastname'		=> clean_slweg($_POST['detail_lastname']),
							'user_alias'		=> clean_slweg($_POST['detail_alias']),
							'user_tel'			=> clean_slweg($_POST['detail_fon']),
							'user_email'		=> clean_slweg($_POST['detail_email']),
							'user_company'		=> clean_slweg($_POST['detail_company']),
							'user_gender'		=> clean_slweg($_POST['detail_gender']),
							'user_street'		=> clean_slweg($_POST['detail_street']),
							'user_zip'			=> clean_slweg($_POST['detail_zip']),
							'user_city'			=> clean_slweg($_POST['detail_city']),
							'user_title'		=> clean_slweg($_POST['detail_title']),
							'user_name'			=> clean_slweg($_POST['detail_name']),
							'user_image'		=> array(
												'id'		=> intval($_POST['cnt_image_id']),
												'name'		=> clean_slweg($_POST['cnt_image_name']),
												'zoom'		=> empty($_POST['cnt_image_zoom']) ? 0 : 1,
												'lightbox'	=> empty($_POST['cnt_image_lightbox']) ? 0 : 1,
												'caption'	=> clean_slweg($_POST['cnt_image_caption']),
												'link'		=> clean_slweg($_POST['cnt_image_link'])
												),

											),








								);


		// print_r($detail['data']);

		//print_r($detail['data']['detail_notes']['user_image']);

	if(empty($detail['data']['detail_title'])) {

		$detail['error']['detail_title'] = 1;

	}

	if(empty($detail['data']['detail_login'])) {

		$detail['error']['detail_login'] = 1;

	} else {

		$sql  = 'SELECT COUNT(*) FROM '.DB_PREPEND."phpwcms_userdetail ";
		$sql .= "WHERE detail_login LIKE '".aporeplace($detail['data']['detail_login']);
		$sql .= "' AND detail_id <> ".$detail['data']['detail_id'];

		if(_dbQuery($sql, 'COUNT')) {

			$detail['error']['detail_login'] = 1;

		}

	}

//print_r($detail['error']);
	if(!isset($detail['error'])) {

		if(isset($detail['data']['detail_id'])) {



			// UPDATE
			$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_userdetail SET ';

			$sql .= "detail_title='".aporeplace($detail['data']['detail_title'])."', ";
			$sql .= "detail_firstname='".aporeplace($detail['data']['detail_firstname'])."', ";
			$sql .= "detail_lastname='".aporeplace($detail['data']['detail_lastname'])."', ";
			$sql .= "detail_company='".aporeplace($detail['data']['detail_company'])."', ";
			$sql .= "detail_street='".aporeplace($detail['data']['detail_street'])."', ";
			$sql .= "detail_tag='".aporeplace($detail['data']['detail_tag'])."', ";
			$sql .= "detail_alias='".aporeplace($detail['data']['detail_alias'])."', ";
			$sql .= "detail_add='".aporeplace($detail['data']['detail_add'])."', ";
			$sql .= "detail_city='".aporeplace($detail['data']['detail_city'])."', ";
			$sql .= "detail_zip='".aporeplace($detail['data']['detail_zip'])."', ";
			$sql .= "detail_region='".aporeplace($detail['data']['detail_region'])."', ";
			$sql .= "detail_country='".aporeplace($detail['data']['detail_country'])."', ";
			$sql .= "detail_fon='".aporeplace($detail['data']['detail_fon'])."', ";
			$sql .= "detail_fax='".aporeplace($detail['data']['detail_fax'])."', ";
			$sql .= "detail_mobile='".aporeplace($detail['data']['detail_mobile'])."', ";
			$sql .= "detail_signature='".aporeplace($detail['data']['detail_signature'])."', ";
			$sql .= "detail_prof='".aporeplace($detail['data']['detail_prof'])."', ";
			$sql .= "detail_public='".aporeplace($detail['data']['detail_public'])."', ";
	    	$sql .= "detail_aktiv='".aporeplace($detail['data']['detail_aktiv'])."', ";
			$sql .= "detail_newsletter='".aporeplace($detail['data']['detail_newsletter'])."', ";
			$sql .= "detail_website='".aporeplace($detail['data']['detail_website'])."', ";
			$sql .= "detail_userimage='".aporeplace(serialize($detail['data']['detail_notes']['user_image']))."', ";
			$sql .= "detail_notes='".aporeplace(serialize($detail['data']['detail_notes']))."', ";
			$sql .= "detail_gender='".aporeplace($detail['data']['detail_gender'])."', ";
			$sql .= "detail_birthday='".aporeplace($detail['data']['detail_birthday'])."', ";
			$sql .= "detail_varchar1='".aporeplace($detail['data']['detail_varchar1'])."', ";
			$sql .= "detail_varchar2='".aporeplace($detail['data']['detail_varchar2'])."', ";
			$sql .= "detail_varchar3='".aporeplace($detail['data']['detail_varchar3'])."', ";
			$sql .= "detail_varchar4='".aporeplace($detail['data']['detail_varchar4'])."', ";
			$sql .= "detail_varchar5='".aporeplace($detail['data']['detail_varchar5'])."', ";
			$sql .= "detail_email='".aporeplace($detail['data']['detail_email'])."', ";
			$sql .= "detail_text1='".aporeplace($detail['data']['detail_text1'])."', ";
			$sql .= "detail_text2='".aporeplace($detail['data']['detail_text2'])."', ";
			$sql .= "detail_text3='".aporeplace($detail['data']['detail_text3'])."', ";
			$sql .= "detail_text4='".aporeplace($detail['data']['detail_text4'])."', ";
			$sql .= "detail_text5='".aporeplace($detail['data']['detail_text5'])."', ";
			if($detail['data']['detail_password']) {
				$sql .= "detail_password	= '".aporeplace(md5($detail['data']['detail_password']))."', ";
			}

			$sql .= "detail_login='".aporeplace($detail['data']['detail_login'])."', ";
			$sql .= "detail_int1='".aporeplace($detail['data']['detail_int1'])."', ";
			$sql .= "detail_int2='".aporeplace($detail['data']['detail_int2'])."', ";
			$sql .= "detail_int3='".aporeplace($detail['data']['detail_int3'])."', ";
			$sql .= "detail_int4='".aporeplace($detail['data']['detail_int4'])."', ";
			$sql .= "detail_int5='".aporeplace($detail['data']['detail_int5'])."', ";
			$sql .= "detail_float1='".aporeplace($detail['data']['detail_float1'])."', ";
			$sql .= "detail_float2='".aporeplace($detail['data']['detail_float2'])."', ";
			$sql .= "detail_float3='".aporeplace($detail['data']['detail_float3'])."', ";
			$sql .= "detail_float4='".aporeplace($detail['data']['detail_float4'])."', ";
			$sql .= "detail_float5='".aporeplace($detail['data']['detail_float5'])."' ";





			$sql .= "WHERE detail_id=".$detail['data']['detail_id'];

			// echo "Hierrrrrr;".$detail['data']['detail_object'];

			if(@_dbQuery($sql, 'UPDATE')) {

				if(isset($_POST['save'])) {

					headerRedirect(decode_entities(GLOSSARY_HREF));

				}

			} else {

				$detail['error']['update'] = mysql_error();

			}


		} else {

			// INSERT
			$sql  = 'INSERT INTO '.DB_PREPEND.'phpwcms_userdetail (';
			$sql .= 'detail_created, detail_changed, detail_title, detail_firstname, ';
			$sql .= 'detail_lastname, detail_login, detail_password, detail_highlight, detail_notes, detail_aktiv, detail_prof, detail_signature, detail_public, detail_fax, detail_mobile, detail_country, detail_newsletter, detail_website, detail_gender, detail_text1, detail_text2, detail_text3, detail_text4, detail_text5, detail_varchar1, detail_varchar2, detail_varchar3, detail_varchar4, detail_varchar5, detail_email, detail_tag, detail_alias, detail_birthday' ;
			$sql .= ') VALUES (';
			$sql .= "'".aporeplace($detail['data']['detail_created'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_changed'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_title'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_firstname'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_lastname'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_login'])."', ";
			$sql .= "'".aporeplace(md5($detail['data']['detail_password']))."', ";
			$sql .= "'".aporeplace($detail['data']['detail_highlight'])."', '";
			$sql .= "'".aporeplace(serialize($detail['data']['detail_notes']))."', ";
			$sql .= "'".aporeplace($detail['data']['detail_aktiv'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_prof'])."', '";
			$sql .= "'".aporeplace($detail['data']['detail_signature'])."', '";
			$sql .= "'".aporeplace($detail['data']['detail_public'])."', '";
			$sql .= "'".aporeplace($detail['data']['detail_fax'])."', '";
			$sql .= "'".aporeplace($detail['data']['detail_mobile'])."', '";
			$sql .= "'".aporeplace($detail['data']['detail_country'])."', '";
			$sql .= "'".aporeplace($detail['data']['detail_newsletter'])."', '";
			$sql .= "'".aporeplace($detail['data']['detail_website'])."', '";
			$sql .= "'".aporeplace($detail['data']['detail_gender'])."', '";
			$sql .= "'".aporeplace($detail['data']['detail_text1'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_text2'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_text3'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_text4'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_text5'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_varchar1'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_varchar2'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_varchar3'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_varchar4'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_varchar5'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_email'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_tag'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_alias'])."', ";
			$sql .= "'".aporeplace($detail['data']['detail_birthday'])."' ";


			$sql .= ')';

			if($result = @_dbQuery($sql, 'INSERT')) {

				if(isset($_POST['save'])) {

					headerRedirect(decode_entities(GLOSSARY_HREF));

				}

				if(!empty($result['INSERT_ID'])) {
					$detail['id'] = $result['INSERT_ID'];
				}

			} else {

				$detail['error']['update'] = mysql_error();

			}


		}
	}

}

// try to read entry from database
if($detail['id'] && !isset($detail['error'])) {

	$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_userdetail WHERE detail_id='.$detail['id'];
	$detail['data'] = _dbQuery($sql);
	$detail['data'] = $detail['data'][0];

	/////////////////////////////////////////////////////////////////////////////////////*
	/*$plugin['data']['calendar_object'] = @unserialize($plugin['data']['calendar_object']);

	if(is_array($plugin['data']['calendar_object'])) {
		if(isset($plugin['data']['calendar_object']['image'])) {
			$plugin['data']['calendar_image'] = $plugin['data']['calendar_object']['image'];
		}
	}*/
	///////////////////////////////////////////////////////////////////////////////////////




	$detail['data']['detail_notes'] = @unserialize($detail['data']['detail_notes']);


	if(is_array($detail['data']['detail_notes'])) {
		if(isset($detail['data']['detail_notes']['user_image'])) {

				$detail['data']['detail_userimage'] = $detail['data']['detail_notes']['user_image'];




				}
	}
	// print_r($detail['data']['detail_notes']);
	// print_r($detail['data']['detail_notes']);
	// echo "<br/><br/>";
	// print_r($detail['data']['detail_userimage']);
}

// default values
if(empty($detail['data'])) {

	$detail['data'] = array(

				'detail_id'			=> 0,
				'detail_title'		=> '',
				'detail_created'	=> '',
				'detail_changed'	=> date('Y-m-d H:i:s'),
				'detail_firstname'	=> '',
				'detail_tag'	=> '',
				'detail_lastname'	=> '',
				'detail_company'	=> '',
				'detail_street'		=> '',
				'detail_add'		=> '',
				'detail_city'		=> '',
				'detail_zip'		=> '',
				'detail_region'		=> '',
				'detail_country'	=> '',
				'detail_signature'	=> '',
				'detail_prof'		=> '',
				'detail_country'	=> '',
				'detail_fon'		=> '',
				'detail_fax'		=> '',
				'detail_mobile'		=> '',
				'detail_notes'		=> array(),
				'detail_public'		=> '',
				'detail_aktiv'		=> '',
				'detail_newsletter'	=> '',
				'detail_website'	=> '',
				'detail_userimage'	=> array(),
				'detail_gender'		=> '',
				'detail_birthday'	=> '',
				'detail_varchar1'	=> '',
				'detail_varchar2'	=> '',
				'detail_varchar3'	=> '',
				'detail_varchar4'	=> '',
				'detail_varchar5'	=> '',
				'detail_text1'		=> '',
				'detail_text2'		=> '',
				'detail_text3'		=> '',
				'detail_text4'		=> '',
				'detail_text5'		=> '',
				'detail_email'	=> '',
				'detail_login'	=> '',
				'detail_password'	=> '',
				'userdetail_lastlogin'	=> '',
				'detail_int1'	=> '',
				'detail_int2'	=> '',
				'detail_int3'	=> '',
				'detail_int4'	=> '',
				'detail_int1'	=> '',
				'detail_int2'	=> '',
				'detail_int3'	=> '',
				'detail_int4'	=> '',
				'detail_int5'	=> ''


								);

}





?>