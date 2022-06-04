<?php
/********************************************************************************************/
/**
 * Script fur den Test der Formularfunktion
 *
 * 17.03.2010 (c) K.Heermann http://planmatrix.de
 */
/********************************************************************************************/
// -------------------------------------------------------------------------------------------
// obligate check for phpwcms constants
  if (!defined('PHPWCMS_ROOT')) {die("You Cannot Access This Script Directly, Have a Nice Day."); }
// -------------------------------------------------------------------------------------------
 
 /** For testing form function
===============================================================================
===============================================================================
*/
function form_test( &$postvar, &$form, &$mail ) {
 
	echo '<br />===== postvar ===========================<br />';
    dumpVar($postvar);
 
//    echo '<br />===== form ==============================<br />';
//    dumpVar($form);
 
//    echo '<br />===== mail ==============================<br />';
// Sicherheitsrisiko wenn vergessen wird das Script nach Beendigung der Arbeiten zu entfernen.
// Ist für die meisten Anwendungen auch uninteressant.
//    dumpVar($mail);
//    echo '<br />===== mail ende =========================<br />';
 
}  // ==== End function
// /*
// ===============================================================================
// ===============================================================================
// */
 
 
// /** For testing form function
// ===============================================================================
// ===============================================================================
// */
function Stop_SpamValidateFormSubmission( &$postvar, &$form, &$mail ) {
 
	// debug_print_backtrace();

    // Sicherheitsrisiko wenn vergessen wird das Script nach Ende der Arbeiten zu entfernen.
	//echo '<br />===== postvar ===========================<br />';
    //dumpVar($postvar);
    //echo '<br />===== $POST ===========================<br />';
    //dumpVar($_POST);
    //echo '<br />===== form ==============================<br />';
    //dumpvar($form);
    //echo '<br />===== mail ==============================<br />';
    // ist für die meisten anwendungen uninteressant:
    //dumpvar($mail);
    //echo '<br />===== mail ende =========================<br />';

	foreach ($_POST as $key => $value)
	{
		// Spam bots like to post web adresses. Error everywhere if a field data contains http, except the allowed refferer field named "kommt_von_seite"
		if (strpos($key, "	" ) !== false)
			// empty data is OK
			continue;
		
		if (strpos($key, "kommt_von_seite") !== false) // this field is allowed to contain http in its data
			continue;
		
		if (strpos($value, "http") !== false)
		{
			// this field data contains the text http - this is probably a bot 
			// echo ("<pre>Value = $value, Key = $key</pre>\r\n");
			die ("<br />We are sorry but your data could not be processed. Please call if you find this should not have happened. Error: ". __LINE__ /*." @". __FILE__ */);
		}
	}
 
	if (isset($_POST["hnypot"]) && $_POST["hnypot"] !== "your ad here")
	{
		// this bot has filled out every text element in our form, even the hidden honeypot field.
		die ("<br />We are sorry but your data could not be processed. Please call if you find this should not have happened. Error: ". __LINE__ /*." @". __FILE__*/);
	}
 
	//die ("Stop_SpamValidateFormSubmission");
}  // ==== End function
// /*
// ===============================================================================
// ===============================================================================
// */
 
?>