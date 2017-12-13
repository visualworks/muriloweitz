<?php

/*-----------------------------------------------------------------------------------

	CUSTOM FONTS

-----------------------------------------------------------------------------------*/
function sr_theme_fonts_register($checkTypekit = false) {
	global $sr_prefix;
	$fontmanager = stripslashes(get_option('_sr_fontmanager')); 
	$sr_fonts = array( 'bodyfont','h1font','h2font','h3font','h4font','h5font','h6font','subtitle','navigationfont','navigationsubfont','buttonfont','labelfont','inputfont');
    $fonts_url = '';
    
	$sr_font_families = array();
	
	$sr_active_googlefonts = array();
	$sr_active_googleweights = array();
	$displayTypekitScript = false;
	foreach($sr_fonts as $font) {
		$family = get_option('_sr_'.$font.'-font');	
		$weight = get_option('_sr_'.$font.'-weight');	
		$boldweight = get_option('_sr_'.$font.'-boldweight');
		
		if ($family) {
			
			$typekit = false;
			$customF = false;
			if (strpos($fontmanager, $family)) {
				$json = json_decode($fontmanager);
				foreach($json->fonts as $f) {
					if ($family == $f->name && $f->type == 'Google Font') {
						$typekit = false;
						$customF = false;
					} else if ($family == $f->name && $f->type == 'Typekit') {
						$typekit = true;
						$displayTypekitScript = true;
					} else {
						$customF = true;
					}
				} 
			}
			
			if (!$typekit && !$customF) {
				if(!in_array($family, $sr_active_googlefonts) && $family ) {
					$sr_active_googlefonts[] = $family;
				}
				if (!array_key_exists($family, $sr_active_googleweights)) {
					if (strpos($weight, 'italic') !== false) { $sr_active_googleweights[$family] = str_replace("italic", "", $weight).','.$weight; }
					else { $sr_active_googleweights[$family] = $weight; }
					if($weight !== $boldweight && $boldweight) {
						if (strpos($boldweight, 'italic') !== false) { $sr_active_googleweights[$family] .= ','.str_replace("italic", "", $boldweight).','.$boldweight; }
						else { $sr_active_googleweights[$family] .= ','.$boldweight; }
					} 
				} else {
					$check = $sr_active_googleweights[$family];
					if(strpos($check,$weight) === false) {
						if (strpos($weight, 'italic') !== false) { $sr_active_googleweights[$family] .= ','.str_replace("italic", "", $weight).','.$weight; }
						else { $sr_active_googleweights[$family] .= ','.$weight; }
					}
					if(strpos($check,$boldweight) === false && $boldweight) {
						if (strpos($weight, 'italic') !== false) { $sr_active_googleweights[$family] .= ','.str_replace("italic", "", $boldweight).','.$boldweight; }
						else { $sr_active_googleweights[$family] .= ','.$boldweight; }
					} 
				}
			} // END id $typekitorcustom
		}
	} // END foreach
			
	foreach($sr_active_googlefonts as $f) {
		$sr_font_families[] = $f.':'.$sr_active_googleweights[$f];
	} 

	$query_args = array(
		'family' => urlencode( implode( '|', $sr_font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	
	if ($displayTypekitScript && $checkTypekit) {
		return true;	
	} else if (count($sr_active_googlefonts) && !$checkTypekit) {
		return $fonts_url;
	}
		
}



function sr_theme_fonts_enqueue() {
    wp_enqueue_style( 'sr-fonts', sr_theme_fonts_register(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'sr_theme_fonts_enqueue' );


function add_typekit_script() {
	if (sr_theme_fonts_register(true)) {
		$typekitScript = stripslashes(get_option('_sr_typekit'));
		echo $typekitScript;
	}
}
add_action('wp_head', 'add_typekit_script'); 

?>