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

$BE['HEADER'][] = '<link rel="stylesheet" media="screen" type="text/css" href="include/inc_module/mod_cm_calendar/template/datepicker/css/datepicker.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="include/inc_module/mod_cm_calendar/template/datepicker/js/datepicker.js"></script>


        <script type="text/javascript" src="include/inc_module/mod_cm_calendar/template/tp/jquery.utils.js"></script>
        <script type="text/javascript" src="include/inc_module/mod_cm_calendar/template/tp/jquery.strings.js"></script>
        <script type="text/javascript" src="include/inc_module/mod_cm_calendar/template/tp/jquery.anchorHandler.js"></script>
        <script type="text/javascript" src="include/inc_module/mod_cm_calendar/template/tp/jquery.ui.all.js"></script>
        <script type="text/javascript" src="include/inc_module/mod_cm_calendar/template/tp//src/ui.timepickr.js"></script>

        <link type="text/css" rel="Stylesheet" media="screen" href="include/inc_module/mod_cm_calendar/template/tp//dist/themes/default/ui.core.css">
        <link type="text/css" rel="Stylesheet" media="screen" href="include/inc_module/mod_cm_calendar/template/tp//src/css/ui.timepickr.css">

<script type="text/javascript">
<!--

function setImgIdName(file_id, file_name) {
	if(file_id == null) var file_id=0;
	if(file_name == null) var file_name="";
	document.getElementById("cnt_image_id").value = file_id;
	document.getElementById("cnt_image_name").value = file_name;
	
	showImage();
}

function showImage() {
	var id	= parseInt(document.getElementById("cnt_image_id").value);
	var img	= document.getElementById("cnt_image");
	if(id > 0) {
		img.innerHTML = \'<img src="'.PHPWCMS_URL.'img/cmsimage.php/'.$phpwcms["img_list_width"].'x'.$phpwcms["img_list_height"].'/\'+id+\'" alt="" border="0" />\';
		img.style.display = "";
	} else {
		img.style.display = "none";
	}
}
//-->
</script>'.LF;

?>

<form action="<?php echo cm_map_url( array('controller=events', 'edit='.$plugin['data']['cm_events_id']) ) ?>" name="frmEvents" method="post" style="background:#F3F5F8;border-top:1px solid #92A1AF;border-bottom:1px solid #92A1AF;margin:0 0 5px 0;padding:10px 8px 15px 8px">
<input type="hidden" name="cm_events_id" value="<?php echo $plugin['data']['cm_events_id'] ?>" />
<input type="hidden" name="cm_events_setid" value="<?php echo $plugin['data']['cm_events_setid']; ?>" />
<table border="0" cellpadding="0" cellspacing="0" width="100%" summary="">
	<tr> 
		<td align="right" class="chatlist" width="120"><?php echo $BL['be_cnt_last_edited']  ?>&nbsp;</td>
		<td colspan="2" class="v10" width="410"><?php 
		if($plugin['data']['cm_events_id']==0) {
		echo html_specialchars(date($BL['be_fprivedit_dateformat'], strtotime($plugin['data']['cm_events_changed']))) ;
		}else{
		echo html_specialchars(date($BL['be_fprivedit_dateformat'], $plugin['data']['cm_events_changed'])) ;
		}
		if(!empty($plugin['data']['cm_events_created'])) {
		?>		
		&nbsp;&nbsp;&nbsp;<span class="chatlist"><?php echo $BL['be_fprivedit_created']  ?>&nbsp;</span> 
		<?php 
				echo html_specialchars(date($BL['be_fprivedit_dateformat'], strtotime($plugin['data']['cm_events_created'])));
		}
		
		?></td>
	</tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <!-- calendar -->
	<tr>
		<td align="right" class="chatlist" valign="top"><?php echo $BLM['tab_cal']; ?>&nbsp;<div style="padding:3px;font-size:7pt;"><?php echo $BLM['entry_multi']; ?></div></td>
		<td align="left" colspan="2" class="v10">
    
<?php    
    $sql = "SELECT * FROM ".DB_PREPEND."phpwcms_cmcalendar_categories WHERE cm_cat_status!=9 ORDER BY cm_cat_name ASC";
    $data = _dbQuery($sql);
	$xml="";
  foreach($data as $row) {
	 		$xml .=	'<option value="'.$row['cm_cat_id'].'"';
	 		if (in_array($row['cm_cat_id'], $plugin['data']['cm_events_allcals'])) {
          $xml  .= ' selected="selected"';
        }
      $xml .= '>'.$row['cm_cat_name'];
        if ($row['cm_cat_status']==0)  $xml .= ' ['.$BLM['disabled'].']';
      $xml .= '</option>';
	}	
 ?>   
    
    <select id="cm_events_allcals" name="cm_events_allcals[]" size="5" multiple style="width:400px;" class="f11 listrow">
     <?php echo $xml; ?>
    </select>
	</tr>
  <!-- end calendar -->

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <!-- date time span if (!$values['editDate']) -->
  <tr>
    <td align="right" class="chatlist" valign="middle"><?php echo $BLM['entry_date']; ?></td>
    <td align="left" colspan="2" class="v10" valign="top">
      <table width="100%" style=""><tr>
        <td align="left" rowspan="3">

<div id="date2" style="position:relative;width:200px;height:200px;"></div>
<input type="hidden" id="cm_events_date" name="cm_events_date" value="<?php echo $plugin['data']['cm_events_date']; ?>" />
<script type="text/javascript">
$(function(){
$('#date2').DatePicker({
			flat: true,
      date: $('#cm_events_date').val(),
	    current: $('#cm_events_date').val(),
			format: 'Y-m-d',
			calendars: 1,
			mode: 'single',
			onChange: function(formated, dates) {
			 $('#cm_events_date').val(formated);
			},
			starts: 1
		});
})

</script><div style="clear:both;"></div>
	     </td>
       <td align="right" class="chatlist">&nbsp;</td>
        <td align="left" width="120">&nbsp;</td>
		    </tr><tr>
        <td align="right" class="chatlist">&nbsp;&nbsp;<?php echo $BLM['entry_span']; ?></td>
        <td align="left"><?php echo showSpan($plugin['data']['cm_events_span']); ?></td>
		
	</tr><!-- date open -->
  <tr>
        <td align="right" class="chatlist" valign="top"><?php echo $BLM['entry_opendate']; ?></td>
        <td align="left" valign="top">
          <table>
            <tr>
              <td valign="top" width="120">
                <input type="checkbox" name="cm_events_dat_undef" value=1 <?php is_checked($plugin['data']['cm_events_dat_undef'], 1) ?> />
              </td>
            </tr>
            <tr>
              <td align="left" valign="top">
                <span style="font-size:7pt;vertical-align:top;width:120px;"><?php echo $BLM['entry_opendate1']; ?></span>
              </td>
            </tr>
          </table>
        </td>
  </tr>
    <!-- end date open -->
  </table>
    </td>
  </tr>
  <!-- end date -->

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>

  <!-- time timepicker-->

	<tr>
    <td align="right" valign="top" class="chatlist" style="padding:3px 0 0 0;"><?php echo $BLM['entry_time']; ?>&nbsp;</td>
    <td colspan="2"><div style="position:relative;width:100%;height:80px;">
        <input type="text" id="cm_events_time" size="12" name="cm_events_time" value="<?php echo $plugin['data']['cm_events_time']; ?>" />
        <span id="tphandle" class="chatlist" style="cursor:pointer;">Time Picker</span></div>
    </td>
  </tr>
  <!-- end time -->

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <!-- title -->
    <tr>
        <td align="right" class="chatlist"><?php echo $BLM['entry_title']; ?>&nbsp;</td>
        <td align="left"><input type="text" id="cm_events_title" name="cm_events_title" class="f11b<?php 
		
		//error class
		if(!empty($plugin['error']['cm_events_title'])) echo ' errorInputText';
		
		?>" style="width:300px;" value="<?php echo html_specialchars($plugin['data']['cm_events_title']); ?>" /></td>
    </tr>
  <!-- end title -->

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <!-- location -->
  <tr>
    <td align="right" class="chatlist"><?php echo $BLM['entry_location']; ?>&nbsp;</td>
    <td align="left"><input type="text" id="cm_events_location" name="cm_events_location" class="f11b" style="width:300px;" value="<?php echo html_specialchars($plugin['data']['cm_events_location']); ?>" /></td>
  </tr>
  <!-- end location -->

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <!-- teaser -->
  <tr>
    <td align="right" valign="top" class="chatlist"><?php echo $BLM['teaser_txt']; ?>&nbsp;</td>
		<td colspan="2" align="left"><textarea name="cm_events_extrainfo" id="cm_events_extrainfo" class="f11b" style="width:300px;" rows="5" cols="40"><?php echo html_specialchars($plugin['data']['cm_events_extrainfo']); ?></textarea></td>
  </tr>

  <!-- end teaser -->

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <!-- image -->
  <tr>
    <td align="right" valign="top" class="chatlist"><?php echo $BL['be_cnt_image']; ?>&nbsp;</td>
		<td colspan="2" align="left">
    
		<table cellpadding="0" cellspacing="0" border="0" summary="">
	
			<tr>
				<td><input type="text" name="cm_events_image_name" id="cnt_image_name" value="<?php echo html_specialchars($plugin['data']['cm_events_image']['cm_events_image_name']) ?>" class="file" maxlength="250" /></td>
				<td style="padding:2px 0 0 5px" width="100">
					<a href="#" title="<?php echo $BL['be_cnt_openimagebrowser'] ?>" onclick="openFileBrowser('filebrowser.php?opt=7');return false;"><img src="img/button/open_image_button.gif" alt="" width="20" height="15" border="0" /></a>
					<a href="#" title="<?php echo $BL['be_cnt_delimage'] ?>" onclick="setImgIdName();return false;"><img src="img/button/del_image_button.gif" alt="" width="15" height="15" border="0" /></a>
					<input name="cm_events_image_id" id="cnt_image_id" type="hidden" value="<?php echo $plugin['data']['cm_events_image']['cm_events_image_id'] ?>" />
				</td>
			</tr>

			<tr>
				<td colspan="2" class="tdtop5 tdbottom5">
				<table border="0" cellpadding="0" cellspacing="0" summary="">
				<tr>
			  <td><input name="cm_events_image_zoom" type="checkbox" id="cm_events_image_zoom" value="1" <?php is_checked(1, $plugin['data']['cm_events_image']['cm_events_image_zoom']); ?> /></td>
				  <td><label for="cm_events_image_zoom" class="checkbox"><?php echo $BL['be_cnt_enlarge'] ?></label></td>

				  <td><input name="cm_events_image_lightbox" type="checkbox" id="cm_events_image_lightbox" value="1" <?php is_checked(1, $plugin['data']['cm_events_image']['cm_events_image_lightbox']); ?> onchange="if(this.checked){document.getElementById('cm_events_image_zoom').checked=true;}" /></td>
				  <td><label for="cm_events_image_lightbox" class="checkbox"><?php echo $BL['be_cnt_lightbox'] ?></label></td>		
				</tr>
				</table>				
				</td>
			</tr>
		</table>    
    
    </td>
  </tr>
        
  <tr>
    <td align="right" valign="top" class=""><div id="cnt_image" style="padding:5px;"></div></td>
		<td colspan="2" align="left">
    
		<table cellpadding="0" cellspacing="0" border="0" summary="">
		  <tr>
				<td colspan="2" class="tdbottom4"><label class="chatlist"><?php echo $BL['be_cnt_caption'] ?></label><br />
				<textarea name="cm_events_image_caption" id="cm_events_image_caption" class="f11b" style="width:300px;" rows="2" cols="40"><?php echo html_specialchars($plugin['data']['cm_events_image']['cm_events_image_caption']) ?></textarea>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><label class="chatlist"><?php echo $BL['be_profile_label_website'] ?></label><br />
        <input type="text" name="cm_events_image_link" id="cm_events_image_link" class="f11b" maxlength="500" style="width:300px;" value="<?php echo html_specialchars($plugin['data']['cm_events_image']['cm_events_image_link']) ?>" /></td>
			</tr>
	
		</table>    
    
    </td>
  </tr>

  <!-- end image -->



	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <!-- descr -->
  <tr>
    <td align="right" valign="top" class="chatlist"><?php echo $BLM['entry_descr']; ?>&nbsp;</td>

		<td colspan="2" align="left"></td>
 </tr><tr><td colspan="3"><?php
		$wysiwyg_editor = array(
			'value'		=> $plugin['data']['cm_events_description'],
			'field'		=> 'cm_events_description',
			'height'	=> '250px',
			'width'		=> '520px',
			'rows'		=> '10',
			'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
			'lang'		=> 'en'
		);
		
		include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
		
		?></td>
  </tr>
  <!-- end descr -->

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <!-- articlelink -->
  <tr>
    <td align="right" class="chatlist"><?php echo $BLM['entry_artlnk']; ?>&nbsp;</td>
    <td align="left"> <?php echo cmShowArticles($plugin['data']['cm_events_article'],'cm_events_article',$BLM['no_art'],200); ?></td>
  </tr>
  <!-- end articlelink -->

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

  <!-- sets -->

<?php
if ($plugin['data']['cm_events_id'] == 0) {
?>

  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

	<tr>
    <td align="right" class="chatlist"><?php echo $BLM['sheduleOptions']; ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr>
    <td colspan="3">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td align="left">
          <input type="radio" name="schedule_type" id="R000" value="once" <?php is_checked($plugin['data']['schedule_type'], 'once') ?> onclick="vis_singleEvent(this)" />
          <label for="R000"><?php echo $BLM['singleEvent']; ?></label>&nbsp;</td>
        <td width="" align="left"><?php echo $BLM['singleEvent_instruct']; ?> 

<script type="text/javascript">
function vis_singleEvent (a) {
  if(a.checked) {
    document.getElementById('daily_until2').value='';
    document.getElementById('daily_until2').style.visibility = 'hidden';
    document.getElementById('monthlya_until').value='';
    document.getElementById('monthlya_until').style.visibility = 'hidden';  
    document.getElementById('monthlyb_until').value='';
    document.getElementById('monthlyb_until').style.visibility = 'hidden';  
  }
}
</script>
      </td>
      </tr>
      <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
      <tr>
        <td align="left">
          <input type="radio" name="schedule_type" id="R001" value="daily" <?php is_checked($plugin['data']['schedule_type'], 'daily') ?> onclick="vis_daily_until(this)" />
          <label for="R001"><?php echo $BLM['weekly']; ?></label></td>
     <td align="left"><?php echo $BLM['weekly_instruct']; ?>&nbsp;<input type="text" name="daily_every" id="daily_until_every" maxlength="2" style="width:20px;" class="day_field" value="7" /><?php echo $BLM['weekly_instruct2']; ?></td>
     <td align="right">
    <input type="text" id="daily_until2" name="daily_until" value="<?php if ($plugin['data']['daily_until']) {echo $plugin['data']['daily_until'];}else{echo date('Y-m-d');} ?>" class="daily_until3 <?php		
		//error class
		if(!empty($plugin['error']['cm_daily_until'])) echo ' errorInputText';
		?>" style="visibility:hidden;" />
<script type="text/javascript">
$(function(){
    $('.daily_until3').DatePicker({
			format:'Y-m-d',
			date: $('#daily_until2').val(),
			current: $('#daily_until2').val(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#daily_until2').DatePickerSetDate($('#daily_until2').val(), true);
			},
			onChange: function(formated, dates){
        if ($('#daily_until2').val() != formated) {
				  $('#daily_until2').DatePickerHide();
        }
				$('#daily_until2').val(formated);
			}
		});
})

function vis_daily_until (a) {

  if(a.checked) {
    document.getElementById('daily_until2').value='<?php echo date('Y-m-d'); ?>';
    document.getElementById('daily_until2').style.visibility = 'visible';
    document.getElementById('monthlya_until').value='';
    document.getElementById('monthlya_until').style.visibility = 'hidden';  
    document.getElementById('monthlyb_until').value='';
    document.getElementById('monthlyb_until').style.visibility = 'hidden';  
  }
}
</script>
       </td>
      </tr>
      <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
      <tr>
        <td align="left">
          <input type="radio" name="schedule_type" id="R002" value="monthlya" <?php is_checked($plugin['data']['schedule_type'], 'monthlya') ?> onclick="vis_monthlya_until(this)" />
          <label for="R002"><?php echo $BLM['monthly']; ?></label>&nbsp;</td>
    		 <td align="left"><?php echo $BLM['monthly_instructDate']; ?></td>
  		   <td align="right">
    <input type="text" id="monthlya_until" name="monthlya_until" value="<?php echo $plugin['data']['monthlya_until']; ?>" class="monthlya_until <?php		
		//error class
		if(!empty($plugin['error']['cm_monthlya_until'])) echo ' errorInputText';
		?>" style="visibility:hidden;" />
<script type="text/javascript">
$(function(){
    $('.monthlya_until').DatePicker({
			format:'Y-m-d',
			date: $('#monthlya_until').val(),
			current: $('#dmonthlya_until').val(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#monthlya_until').DatePickerSetDate($('#monthlya_until').val(), true);
			},
			onChange: function(formated, dates){
        if ($('#monthlya_until').val() != formated) {
				  $('#monthlya_until').DatePickerHide();
        }
				$('#monthlya_until').val(formated);
			}
		});
})

function vis_monthlya_until (a) {
  if(a.checked) {
    document.getElementById('daily_until2').value='';
    document.getElementById('daily_until2').style.visibility = 'hidden';
    document.getElementById('monthlya_until').value='<?php echo date('Y-m-d'); ?>';
    document.getElementById('monthlya_until').style.visibility = 'visible';  
    document.getElementById('monthlyb_until').value='';
    document.getElementById('monthlyb_until').style.visibility = 'hidden';  
  }
}
</script>
      </td>
      </tr>
      <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
      <tr>
        <td align="left">
          <input type="radio" name="schedule_type" id="R003" value="monthlyb" <?php is_checked($plugin['data']['schedule_type'], 'monthlyb') ?> onclick="vis_monthlyb_until(this)" />
          <label for="R003"><?php echo $BLM['monthly']; ?></label>&nbsp;</td>
		    <td align="left"><?php echo $BLM['monthly_instructWeekday']; ?></td>
        <td align="right">
    <input type="text" id="monthlyb_until" name="monthlyb_until" value="<?php echo $plugin['data']['monthlyb_until']; ?>" class="monthlyb_until <?php		
		//error class
		if(!empty($plugin['error']['cm_monthlyb_until'])) echo ' errorInputText';
		?>" style="visibility:hidden;" />
<script type="text/javascript">
$(function(){
    $('.monthlyb_until').DatePicker({
			format:'Y-m-d',
			date: $('#monthlyb_until').val(),
			current: $('#monthlyb_until').val(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#monthlyb_until').DatePickerSetDate($('#monthlyb_until').val(), true);
			},
			onChange: function(formated, dates){
        if ($('#monthlyb_until').val() != formated) {
				  $('#monthlyb_until').DatePickerHide();
        }
				$('#monthlyb_until').val(formated);
			}
		});
})

function vis_monthlyb_until (a) {
  if(a.checked) {
    document.getElementById('daily_until2').value='';
    document.getElementById('daily_until2').style.visibility = 'hidden';
    document.getElementById('monthlya_until').value='';
    document.getElementById('monthlya_until').style.visibility = 'hidden';  
    document.getElementById('monthlyb_until').value='<?php echo date('Y-m-d'); ?>';
    document.getElementById('monthlyb_until').style.visibility = 'visible';  
  }
}
</script>
       </td>
      </tr>
    </table>
    </td>
  </tr>

<?php
}
?>

  <!-- end sets -->
  <!-- TB Modification owner userID-->
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>
	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

   <tr>
        <td align="right" class="chatlist"><?php echo $BLM['entry_uid']; ?>&nbsp;&nbsp;</td>
        <td align="left" colspan="2">

         <table border="0" cellpadding="0" cellspacing="0" summary="">
            <tr>
               <td><?php
            $outputenabled = "";
            $outputdisabled = "";
            $u_sql = "SELECT usr_id, usr_name, usr_login, usr_admin FROM ".DB_PREPEND."phpwcms_user WHERE usr_aktiv=1 ORDER BY usr_admin DESC, usr_name";
            if($u_result = _dbQuery($u_sql)) {
			   foreach($u_result as $u_row) {
                   $outputenabled .= '<option value="'.$u_row[0].'"';
                  if (
                     $u_row['usr_id'] == $plugin['data']['cm_events_userId'] ||
                      ( $plugin['data']['cm_events_userId'] == 0 &&
                        $u_row['usr_id'] == $_SESSION['wcs_user_id']
                      )
                   )
                  {
                    $outputenabled .= ' selected';
                    $outputdisabled = html_specialchars(($u_row['usr_name']) ? $u_row['usr_name'] : $u_row['usr_login']);
                  }
                  if(intval($u_row['usr_admin'])) {
                    $outputenabled .= ' style="background-color: #FFC299;"';
                    $outputdisabled .='" style="background-color: #FFC299;width:250px;';
                  }
                  $outputenabled .= '>'.html_specialchars(($u_row['usr_name']) ? $u_row['usr_name'] : $u_row['usr_login']).'</option>'."\n";
               }
            }

if($plugin['data']['cm_events_setid']){
?><input type="text" class="f11b" name="cm_events_userId_disabled" disabled="disabled" value="<?php echo $outputdisabled; ?>" />
               <input type="hidden" name="cm_events_userId" value="<?php echo $plugin['data']['cm_events_userId']; ?>" /><?php
} else {
?><select name="cm_events_userId" id="cm_events_userId" style="width: 250px" class="f11b"><?php echo $outputenabled; ?></select><?php
}
?>
            </td>
            <td>&nbsp;&nbsp;</td>
            <td bgcolor="#FFC299"><img src="img/leer.gif" alt="" width="15" height="10" /></td>
            <td class="chatlist">&nbsp;<?php echo $BL['be_article_adminuser'] ?></td>
            </tr></table>

      </td>
   </tr>
  <!-- end TB Modification owner userID-->

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
  <tr><td colspan="3" class="rowspacer0x7"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
	<tr>
		<td align="right" class="chatlist"><?php echo $BL['be_ftptakeover_status'] ?>&nbsp;</td>
		<td colspan="2"><table border="0" cellpadding="0" cellspacing="0" summary="">		
			<tr>
				<td><input type="checkbox" name="cm_events_status" id="cm_events_status" value="1"<?php is_checked($plugin['data']['cm_events_status'], 1) ?> /></td>
				<td><label for="cm_events_status"><?php echo $BL['be_cnt_activated'] ?></label></td>
			</tr>
		</table></td>
	</tr>

	<tr><td colspan="3"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

	<tr> 
		<td>&nbsp;</td>
		<td colspan="2">
			<input name="submit2" id="sub1" type="submit" class="button10" value="<?php echo empty($plugin['data']['cm_events_id']) ? $BL['be_admin_fcat_button2'] : $BL['be_article_cnt_button1'] ?>" />
			<input name="save" id="sub2" type="submit" class="button10" value="<?php echo $BL['be_article_cnt_button3'] ?>" />
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="close" type="submit" class="button10" value="<?php echo $BL['be_admin_struct_close'] ?>" />
		</td>
	</tr>
</table>
<script type="text/javascript">
<!--
	
	// Show image
	showImage();

$(function(){
      $('#cm_events_time').timepickr({
      convention:24,
      trigger: 'none',
      handle: '#tphandle',
      resetOnBlur:false,
      rangeMin:['00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55']
      });
  });

//-->
</script>
</form>
<DIV ID="testdiv1" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></DIV>