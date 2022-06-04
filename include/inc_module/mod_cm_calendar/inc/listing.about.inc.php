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
<form action="<?php echo cm_map_url('controller=about') ?>" method="post" name="formsitemaplisting" id="formsitemaplisting">

<table width="100%" border="0" cellpadding="0" cellspacing="0" summary="">
	<tr><td><img src="img/leer.gif" alt="" width="1" height="3"></td></tr>
	<tr>
    <td><img src="<?php echo $phpwcms['modules'][$module]['dir'].'img/cm_calendar_header.jpg'; ?>" alt="" width="550" height="94"></td>
  </tr>
	<tr><td><img src="img/leer.gif" alt="" width="1" height="10"></td></tr>
	<tr>
    <td>Thank you for using the phpwcms-module <strong>cmCalendar Version 1.2</strong></td>
  </tr>
	<tr>
    <td>The module was written by Webrealisierung GmbH in June 2009 and released on JULY-06-2009 under the GNU General Public Licence.<br />
    Update to v1.2 FEBRUARY-01-2012</td>
  </tr>
	<tr><td><img src="img/leer.gif" alt="" width="1" height="10"></td></tr>
	<tr>
    <td>For support see the <a href="http://forum.phpwcms.org/" target="_blank">phpwcms forum</a> or you find a detailed documentation of all functions of the module on the <a href="http://www.phpwcms-howto.de/wiki" target="_blank">PHPWCMS-HowTo:wiki</a> Website.
There you'll find other modules to use in phpwcms as well as a <strong>donation button</strong>.</td>
  </tr>
	<tr><td><img src="img/leer.gif" alt="" width="1" height="10"></td></tr>
	<tr>
    <td>For the Mini-Calendar in frontend exists an AJAX version with enhanced functionality and some eyecatching effects.<br />
The AJAX extension is only available as donation-ware. If you're interested please see instructions on the documentation site.</td>
  </tr>
	<tr><td><img src="img/leer.gif" alt="" width="1" height="10"></td></tr>
	<tr>
    <td>Thank you for using cmCalendar!</td>
  </tr>
	<tr><td><img src="img/leer.gif" alt="" width="1" height="100"></td></tr>
  <tr><td colspan="6" bgcolor="#92A1AF"><img src="img/leer.gif" alt="" width="1" height="1"></td></tr>
</table>
</form>

<?php

?>
