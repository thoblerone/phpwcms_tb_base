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

?>
<h1 class="title" style="margin-bottom:10px"><?php echo $BLM['listing_title'] ?></h1>
<div id="tabsG" style="height:20px;">
	<ul>
		<li<?php if($controller == 'cp') echo ' class="activeTab"'; ?>><a href="<?php echo cm_map_url('controller=cp') ?>"><span><?php echo $BLM['tab_cp'] ?></span></a></li>
		<li<?php if($controller == 'cal') echo ' class="activeTab"'; ?>><a href="<?php echo cm_map_url('controller=cal') ?>"><span><?php echo $BLM['tab_cal'] ?></span></a></li>
		<li<?php if($controller == 'events') echo ' class="activeTab"'; ?>><a href="<?php echo cm_map_url('controller=events') ?>"><span><?php echo $BLM['tab_events'] ?></span></a></li>
		<li<?php if($controller == 'lang') echo ' class="activeTab"'; ?>><a href="<?php echo cm_map_url('controller=lang') ?>"><span><?php echo $BLM['tab_lang'] ?></span></a></li>
		<li<?php if($controller == 'about') echo ' class="activeTab"'; ?>><a href="<?php echo cm_map_url('controller=about') ?>"><span><?php echo $BLM['tab_about'] ?></span></a></li>
	</ul>
	<br class="clear" />
</div>
