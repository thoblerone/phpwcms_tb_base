*************************************************************************************

  cmCalendar Module v1 by breitsch - webrealisierung gmbh (breitsch@hotail.com) 2009
  cmCalendar Module v1.2 by breitsch - webrealisierung gmbh (breitsch@hotmail.com) 2012

  License: GNU General Public License version 2, or (at your option) any later version
  This script is a module for PHPWCMS.

*************************************************************************************


Installation
------------

The installation procedure is quick and easy!

Unzip the downloaded file to your phpwcms installation.

To activate the module go to the modules section an click the new 'cmCalendar' link.

That's it!
The script adds 3 tables to the phpwcms database.


Update to v1.2 (only recommended for phpwcms >= 1.4.4 r381)
--------------

BACKUP the existing module files and the Database!
Unzip the downloaded file to your phpwcms installation and overwrite the existing files in folder: include/inc_module/mod_cm_calendar

CHECK TO NOT overwrite your template and css files in folder:
- include/inc_module/mod_cm_calendar/template/cntpart
- include/inc_module/mod_cm_calendar/template/css
- include/inc_module/mod_cm_calendar/template/print

You MUST update all your existing cmCalendar ContentParts within your site.
Especially the field 'selection' under event listing could contain a serialized string, delete it and enter the desired selection values again.
Check your teaser template, the classes there changed.

No changes are made in the Database.


Documentation
-------------

see
http://www.phpwcms-howto.de/wiki/doku.php/3rd-party-modules

*************************************************************************************
