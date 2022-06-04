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

//folder
$folder = PHPWCMS_ROOT.'/content/rss/';
  $artID = intval($_GET['art_id']);
  $cpID = intval($_GET['cp_id']);
$filename	=  'feed-calendar-'.$artID.'-'.$cpID.'.xml';
$error = '';

  if (file_exists($folder.$filename)) {
    @unlink($folder.$filename);
    headerRedirect(decode_entities(cm_map_url('controller=cp')));
  } else {
  	$error = "File: ".$filename.", not found.<br />";


?>

<div align="left" class="v10 error_message"><? echo $error;?></div>

<?php
	}
?>