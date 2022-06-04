<?php
// -------------------------------------------------------------------------------------------
// obligate check for phpwcms constants
  if (!defined('PHPWCMS_ROOT')) {
    die("You Cannot Access This Script Directly, Have a Nice Day."); }
// -------------------------------------------------------------------------------------------

/**********************************************************************************************
 * SIMPLE Version
 * V1.1  13.11.09 KH  Ohne Grafiken in JS-Head, diese werden vom JS Script aus den HTML-Grafiken ausgelesen
 * Based on http://code.google.com/p/slideshow/ 
 * V1.2  12.10.10 KH Update: new gif image is generated with width/height from CP TAG
 * V1.4  18.11.10 KH Update: Var {$GLOBALS['crow'] changed to $data 
 * (E.g. a call with "show_content" was not possible because global variables used by the calling location)
 * 18.11.10 KH Update: Simple Version generated
 * 
 ***********************************************************************************************/
 
 
function CP_IMAGES_SLIDESHOW2_SIMPLE($text, & $data) {
 
	if( $data['acontent_type'] == 29 AND strpos($text, '<!--slideshow2!simple//-->') )  // CP: 29 => image <div>   CP: 31 => image special
	{ 
	
		$tg_text = array();
		
	// === CUSTOM fallback===============================================
		$tg_text['image']['width'] 			= 500;  // image width fallback
		$tg_text['image']['height'] 		= 400;  // image height fallback
		
		$tg_text['flag']['prevnext'] 		= false;
		$tg_text['flag']['thumb'] 			= false;
		$tg_text['flag']['thumbvertical'] 	= false;
		$tg_text['flag']['thumbnoslide'] 	= false;
		$tg_text['flag']['wiping'] 			= false;
		
	// ==================================================================
		
		/* ======= CP image <div> parameter
		http://www.phpwcms-howto.de/wiki/doku.php/english/technics/database/phpwcms_articlecontent
		========================== */
		
		// catch the CP-ID
		$CP_ID 	= $data["acontent_id"];  

		// All image parameters
		$CP		= @unserialize($data["acontent_form"]);
		
		// Setup some parameters
		if ($CP['lightbox']) 	$tg_text['strg']['lightbox'] 	= 'rel="lightbox"';
		else 					$tg_text['strg']['lightbox'] 	= '';
		

		// Catch the CUSTOM VAR
		// ============================================
		preg_match_all('/\[CP_TRIG_CUSTOM_VAR\](.*?)\[\/CP_TRIG_CUSTOM_VAR\]/ism',$text, $tg_text['custom']);
		
		if ($tg_text['custom'][1][0]) {  // is there any content?
		
			// WIDTH / HEIGHT
			if ( strpos($tg_text['custom'][1][0],'[%WIDTH:') !== false ) {
				preg_match('/\[%WIDTH:(\d+)%\]/i', $tg_text['custom'][1][0], $tg_text['temp']);
				if(!empty($tg_text['temp'][1])) $tg_text['image']['width'] = $tg_text['temp'][1];
			}
			if ( strpos($tg_text['custom'][1][0],'[%HEIGHT:') !== false ) {
				preg_match('/\[%HEIGHT:(\d+)%\]/i', $tg_text['custom'][1][0], $tg_text['temp']);
				if(!empty($tg_text['temp'][1])) $tg_text['image']['height'] = $tg_text['temp'][1];
			}
			// PREV NEXT for LightBox
			if ( strpos($tg_text['custom'][1][0],'[%PREVNEXT:') !== false ) {
				preg_match('/\[%PREVNEXT:(\d+)%\]/i', $tg_text['custom'][1][0], $tg_text['temp']);
				if(!empty($tg_text['temp'][1]) AND ($tg_text['temp'][1] == 1)) $tg_text['flag']['prevnext'] = true;
			}
			// Thumb enabled
			if ( strpos($tg_text['custom'][1][0],'[%THUMBNAIL:') !== false ) {
				preg_match('/\[%THUMBNAIL:(\d+)%\]/i', $tg_text['custom'][1][0], $tg_text['temp']);
				if(!empty($tg_text['temp'][1]) AND ($tg_text['temp'][1] == 1)) { $tg_text['flag']['thumb'] = true; 
				
					// Thumbvertical enabled
					if ( strpos($tg_text['custom'][1][0],'[%THUMBVERTICAL:') !== false ) {
						preg_match('/\[%THUMBVERTICAL:(\d+)%\]/i', $tg_text['custom'][1][0], $tg_text['temp']);
						if(!empty($tg_text['temp'][1]) AND ($tg_text['temp'][1] == 1)) $tg_text['flag']['thumbvertical'] = true;
					}
					// Thumb no slide
					if ( strpos($tg_text['custom'][1][0],'[%THUMBNOSLIDE:') !== false ) {
						preg_match('/\[%THUMBNOSLIDE:(\d+)%\]/i', $tg_text['custom'][1][0], $tg_text['temp']);
						if(!empty($tg_text['temp'][1]) AND ($tg_text['temp'][1] == 1))  $tg_text['flag']['thumbnoslide'] = true;
					}
				
				
				}
			}
			
			// Wiping enabled
			if ( strpos($tg_text['custom'][1][0],'[%WIPING:') !== false ) {
				preg_match('/\[%WIPING:(\d+)%\]/i', $tg_text['custom'][1][0], $tg_text['temp']);
				if(!empty($tg_text['temp'][1]) AND $tg_text['temp'][1] == 1) { $tg_text['flag']['wiping'] = true; }
			}
			
		}
	
	
		// Catch the first text area
		// ============================================
		preg_match_all('/\[CP_TRIG_WRAP\](.*?)\[\/CP_TRIG_WRAP\]/ism',$text, $tg_text['wrap']);
		
		if ($tg_text['wrap'][1][0]) {  // is there any content?

			// ---------------------------------------------------------------------------------
			// Prev/Next on: Prev/Next for LightBox, no slideshow feature available
			// ---------------------------------------------------------------------------------
			
			
			// Set "Group the lightbox" for prev/next
			if ( $tg_text['flag']['prevnext'] ) $tg_text['strg']['lightbox'] = 'rel="lightbox['.$CP_ID.']"';
			

			// if zoom is not set,  there it no content!!!
			preg_match_all('/\[CP_TRIG_IMG\](.*?)\[\/CP_TRIG_IMG\]/is',			$text, $tg_text['img']); 		// the whole generated img string

			// image string
			preg_match_all('/\[CP_TRIG_STR\](.*?)\[\/CP_TRIG_STR\]/is',			$text, $tg_text['str']);
			
			// Thumb section
			preg_match_all('/\[CP_TRIG_THUMB\](.*?)\[\/CP_TRIG_THUMB\]/is',		$text, $tg_text['thumb']);

		}



		// IMAGES ==================================================
		$tg_text_temp[0] = '    <div class="slideshow-images">'.LF;

		// Images: If zoom=on AND Prev/Next=on ---------------------
		if ($CP['zoom'] AND $tg_text['flag']['prevnext'] AND $tg_text['str'][1]) {
		
			foreach ($tg_text['str'][1] as $key => $value) {
				
				$tg_text['image3'] = my_img_width_height_simple($CP["images"][$key], $key, $tg_text['image']['width'], $tg_text['image']['height']);
				
				$value = str_replace('{CP_TRIG_REL_LIGHBOX}'  ,$tg_text['strg']['lightbox'] , $value);
				$value = str_replace('{CP_TRIG_CLASS_ID}'     ,$key+1                       , $value);
				$value = str_replace('{CP_TRIG_WIDTH_HEIGHT}' ,$tg_text['image3'][7]        , $value);
				$value = str_replace('{CP_TRIG_LEFT_TOP}'     ,$tg_text['image3'][8]        , $value);
				$tg_text_temp[0] .= '      '.$value.LF;
			}
			
		}
		
		// Images: If zoom=on AND LighBox=on -----------------------
//		elseif ($CP['zoom'] AND $CP['lightbox'] AND $tg_text['str'][1]) {
		elseif ($CP['zoom']  AND $tg_text['str'][1]) {
			
			foreach ($tg_text['str'][1] as $key => $value) {
				
				$value = str_replace('{CP_TRIG_REL_LIGHBOX}'	,$tg_text['strg']['lightbox']	, $value);
				$value = str_replace('{CP_TRIG_CLASS_ID}'		,$key+1 						, $value);
				$value = str_replace('{CP_TRIG_WIDTH_HEIGHT}'	,''								, $value);
				$value = str_replace('{CP_TRIG_LEFT_TOP}'		,''								, $value);
				$tg_text_temp[0] .= '      '.$value.LF;
			}
			
		}
		
		
		// <img src="content/images/ec0704526b3f098d477f40982dfe4f18.jpg" width="80" height="60" alt="Dscn1531_800x600.jpg" border="0" />
		
		
		// Images: If zoom=off -------------------------------------
		if (!$CP['zoom'] AND $tg_text['img'][1]) {
		
			foreach ($tg_text['img'][1] as $key => $value) {
				
				$tg_text['image3'] = my_img_width_height_simple($CP["images"][$key], $key, $tg_text['image']['width'], $tg_text['image']['height']);
				
				$value = preg_replace('/\<img src="(.*?) \/\>/is','<img '.$tg_text['image3'][0].' />',$value);
				$tg_text_temp[0] .= '      '.$value.LF;
			}
			
		}
		
		$tg_text_temp[0] .= '    </div>'.LF;
		// IMAGES END ==============================================


		// Thumbs ==================================================
		if ($tg_text['flag']['thumb'] AND $tg_text['thumb'][1]) {
			
			$tg_text_temp[0] .= '    <div class="slideshow-thumbnails">'.LF.'      <ul>'.LF;
			
			foreach ($tg_text['thumb'][1] as $key => $value) {
			
				$value = str_replace('{CP_TRIG_CLASS_ID}', $key+1, $value);
				$tg_text_temp[0] .= '      '.$value.LF;
			}
			
			$tg_text_temp[0] .= '      </ul>'.LF.'    </div>'.LF;
		}
		// THUMBS END ==============================================



		// Footer in template (for the site head area) =============
		// Set JS parameters for slidebox script 
		preg_match('/\[CP_TRIG_WRAP_FOOTER\](.*?)\[\/CP_TRIG_WRAP_FOOTER\]/ism',$text, $tg_text['wrap_footer']);
		if ($tg_text['wrap_footer'][1]) {

			$tg_text_temp[1] = '';

			// set thumbnail 
			$tg_text['wrap_footer'][1] = str_replace('{CP_TRIG_THUMBNAIL}'	, ($tg_text['flag']['thumb'])?'true':'false', $tg_text['wrap_footer'][1]);
			// set image width 
			$tg_text['wrap_footer'][1] = str_replace('{CP_TRIG_WIDTH}'		, ($tg_text['image']['width']), $tg_text['wrap_footer'][1]);
			// set image height 
			$tg_text['wrap_footer'][1] = str_replace('{CP_TRIG_HEIGHT}'		, ($tg_text['image']['height']), $tg_text['wrap_footer'][1]);


			// set linked
			$tg_text['wrap_footer'][1] = str_replace('{CP_TRIG_LINKED}'		, ($CP['zoom'])?'true':'false', $tg_text['wrap_footer'][1]);
			
		}

		// Test: If LightBox/PrevNext is set, disable slimbox JS (unload). We need the next/prev feature in picture
		if ($tg_text['flag']['prevnext'] ) {  
			$tg_text['wrap_footer'][1] = preg_replace('/\[CP_TRIG_WRAP_FOOTER_JS\](.*?)\[\/CP_TRIG_WRAP_FOOTER_JS\]/ism','' ,$tg_text['wrap_footer'][1]);  
		}
		
		// Test: If wiping is not set, disable wiping css. 
		if (!$tg_text['flag']['wiping'] ) {  
			$tg_text['wrap_footer'][1] = preg_replace('/\[CP_TRIG_WRAP_CSS_WIPING\](.*?)\[\/CP_TRIG_WRAP_CSS_WIPING\]/ism','' ,$tg_text['wrap_footer'][1]);  
		}
		// Test: If thumb vertical is not set, disable thumb vertical css. 
		if (!$tg_text['flag']['thumbvertical'] ) {  
			$tg_text['wrap_footer'][1] = preg_replace('/\[CP_TRIG_WRAP_CSS_THUMBVERTICAL\](.*?)\[\/CP_TRIG_WRAP_CSS_THUMBVERTICAL\]/ism','' ,$tg_text['wrap_footer'][1]);  
		}
		// Test: If thumb no slide is not set, disable thumb no slide css. 
		if (!$tg_text['flag']['thumbnoslide'] ) {  
			$tg_text['wrap_footer'][1] = preg_replace('/\[CP_TRIG_WRAP_CSS_THUMBNOSLIDE\](.*?)\[\/CP_TRIG_WRAP_CSS_THUMBNOSLIDE\]/ism','' ,$tg_text['wrap_footer'][1]);  
		}


		$text = preg_replace('/\[CP_TRIG_WRAP_CONTENT\](.*?)\[\/CP_TRIG_WRAP_CONTENT\]/ism', '<!-- slideshow2 //-->'.LF.$tg_text_temp[0].$tg_text_temp[1], $text);  // fill content
		$text = preg_replace('/\[CP_TRIG_WRAP_FOOTER\](.*?)\[\/CP_TRIG_WRAP_FOOTER\]/ism', $tg_text['wrap_footer'][1], $text);  // replace the footer

	} // ---- END if( $data['acontent_type'] == 29 

      return $text;
      
} // ---- END function
 
 
	// 
	function my_img_width_height_simple($CP_IMG, $_key, $slide_width, $slide_height) {
	
		$_zoominfo = get_cached_image(
			array(	"target_ext"	=>	$CP_IMG[3],
					"image_name"	=>	$CP_IMG[2] . '.' . $CP_IMG[3],
// +KH:12.10.10  new image is generated with width/height from CP TAG
//					"max_width"		=>	$GLOBALS['phpwcms']["img_prev_width"],
					"max_width"		=>	((!empty($slide_width)) ? $slide_width :$GLOBALS['phpwcms']["img_prev_width"]),
//					"max_height"	=>	$GLOBALS['phpwcms']["img_prev_height"],
					"max_height"	=>	((!empty($slide_height))? $slide_height:$GLOBALS['phpwcms']["img_prev_height"]),
					"crop_image"	=> true,
//					"thumb_name"	=>	md5(	$CP_IMG[$key][2].$tg_text['image']['width'].
//												$tg_text['image']['height'].$GLOBALS['phpwcms']["sharpen_level"]
					
// +KH:12.10.10  new image is generated with width/height from CP TAG
//					"thumb_name"	=>	md5(	$CP_IMG[2].$GLOBALS['phpwcms']["img_prev_width"].
//												$GLOBALS['phpwcms']["img_prev_height"].$GLOBALS['phpwcms']["sharpen_level"]
//											)
					"thumb_name"	=>	md5(	$CP_IMG[2].((!empty($slide_width)) ? $slide_width :$GLOBALS['phpwcms']["img_prev_width"]).
												((!empty($slide_height))? $slide_height:$GLOBALS['phpwcms']["img_prev_height"]).$GLOBALS['phpwcms']["sharpen_level"]
											)
				)
				
			);
	
	
		// fill up alt "..." with capture or image name
		if (empty($CP_IMG[6])) $CP_IMG[6] = $CP_IMG[1];  

		$tg01['w'] 	= $_zoominfo[1]; 							// real width
		$tg01['h'] 	= $_zoominfo[2]; 							// real height
		
		$tg02[1] 	= 'id="slide-'.($_key+1).'" '; 				// id for every entry
		$tg02[2] 	= 'src="'.PHPWCMS_IMAGES.$_zoominfo[0].'" ';// hash-name.ext
		$tg02[3] 	= $_zoominfo[3].' ';						// html width/height
		$tg02[4] 	= 'alt="'.$CP_IMG[6].'" ';					// capture or alt text
		$tg02[5] 	= 'style="';
//		$tg02[6] 	= 'display: block; position: absolute; z-index: 1; visibility: visible; opacity: 1; ';
		$tg02[6] 	= 'display: block; z-index: 1; visibility: visible; opacity: 1; ';
		
		// ------- calculate the right image widt/height
		$tg01['dw'] =	$slide_width  / $tg01['w'] ;
		$tg01['dh'] =	$slide_height / $tg01['h'] ;
		$tg01['d']  =	($tg01['dh'] > $tg01['dw']) ? $tg01['dh'] : $tg01['dw'];
		
		$tg01['iw']	= ceil($tg01['d'] * $tg01['w']);
		$tg01['ih']	= ceil($tg01['d'] * $tg01['h']);
		// -------
		
		// img.set('styles', {height: Math.ceil(h * d), width: Math.ceil(w * d)});
		$tg02[7] = 
		'width: ' .$tg01['iw'].'px; '.  // 'height: 667px; width: 500px;
		'height: '.$tg01['ih'].'px; ';
		
		
		// img.set('styles', {'left': (size.x - this.width) / -2, 'top': (size.y - this.height) / -2});
		// calculate the right spacing
		$tg02[8] 	= 
		'left: '.ceil(($tg01['iw'] - $slide_width)  / -2) .'px; '.  // 'left: 0px; top: -133px;"'
		'top: ' .ceil(($tg01['ih'] - $slide_height) / -2) .'px; ';
		
		$tg02[9] 	= '" ';  // End Style
		
		
		$tg02['0'] = implode($tg02);

//		$value = preg_replace('/\<img src="(.*?) \/\>/is','<img '.$tg02[0].' />',$value);
//		$tg_text_temp[0] .= '      '.$value.LF;

	return $tg02;
	}

   register_cp_trigger('CP_IMAGES_SLIDESHOW2_SIMPLE');
?>