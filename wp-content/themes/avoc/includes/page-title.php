<?php
/*-----------------------------------------------------------------------------------

	WRITE PAGE TITLE
	
-----------------------------------------------------------------------------------*/

global $sr_prefix;
$theId = sr_getId();


/*************
GET DEFAULT TITLE
**************/
$titles = sr_getTitle();
if ($titles['tax']) { $pagetitle =  $titles['tax'];	$pagesub =  $titles['title']; } else { $pagetitle =  $titles['title']; }
/*************
GET DEFAULT TITLE
**************/


/*************
GET PAGE OPTIONS
**************/

// ALTERNATIVE MAIN TITLE
if (isset($theId) && get_post_meta($theId, $sr_prefix.'_alttitle', true)) { $pagetitle = get_post_meta($theId, $sr_prefix.'_alttitle', true); } 
// GET SUBTITLE
if (isset($theId) && get_post_meta($theId, $sr_prefix.'_subtitle', true)) { $pagesub = get_post_meta($theId, $sr_prefix.'_subtitle', true); }

if ((is_tag() || is_category() || is_search() || is_archive() || is_tax()) ||
	((is_tag() || is_category() || is_search() || is_archive() || is_tax()) && (class_exists('Woocommerce') && !is_shop()))) {
if ($titles['tax']) { $pagetitle =  $titles['tax']; $pagesub =  $titles['title']; } else { $pagetitle =  $titles['title']; } }

// GET OPTIONS
$showPagetitle = "default";
if (isset($theId)) { $showPagetitle = get_post_meta($theId, $sr_prefix.'_showpagetitle', true); }
if ((is_tag() || is_category() || is_search() || is_archive() || is_tax()) ||
	((is_tag() || is_category() || is_search() || is_archive() || is_tax()) && (class_exists('Woocommerce') && !is_shop()))) { $showPagetitle = "default"; }

if ((is_single() && get_post_type() == 'product') && !$showPagetitle) { $showPagetitle = "false"; }
/*************
GET PAGE OPTIONS
**************/




/*************
USE THE OPTIONS
**************/	
$heroClass = '';		
$heroAdd = '';		
$fullHeight = get_post_meta($theId, $sr_prefix.'_pagetitleheight', true);
$scrollDown = get_post_meta($theId, $sr_prefix.'_pagetitlescrolldown', true);
$titleposition = get_post_meta($theId, $sr_prefix.'_pagetitleposition', true);
$margin = get_post_meta($theId, $sr_prefix.'_pagetitlemargin', true);
$slider = '';
if ($showPagetitle == 'color') {
	$colorBg = get_post_meta($theId, $sr_prefix.'_color_bgcolor', true);
	$colorText = get_post_meta($theId, $sr_prefix.'_color_textcolor', true);
		
	$heroAdd = 'style="background-color:'.esc_attr($colorBg).'"';	
	$heroClass = 'text-'.$colorText;
} else if ($showPagetitle == 'image') {
	$image = get_post_meta($theId, $sr_prefix.'_image_bgimage', true);
	$imageText = get_post_meta($theId, $sr_prefix.'_image_textcolor', true);
	$imageParallax = get_post_meta($theId, $sr_prefix.'_image_parallax', true);
	
	if ($imageParallax == 'false') {
		$heroClass = 'text-'.$imageText;
		$heroAdd = 'style="background:url('.esc_url($image).') center center;background-size:cover;"';	
	} else if ($imageParallax == 'true' ) {
		$heroClass = 'parallax-section text-'.$imageText;
		$heroAdd = 'data-parallax-image="'.esc_url($image).'"';	
	}
} else if ($showPagetitle == 'video' || $showPagetitle == 'youtube' || $showPagetitle == 'vimeo') {
	
	if ($showPagetitle == 'video') {
		$mp4 = get_post_meta($theId, $sr_prefix.'_video_mp4', true);
		$webm = get_post_meta($theId, $sr_prefix.'_video_webm', true);
		$oga = get_post_meta($theId, $sr_prefix.'_video_oga', true);
		
		$heroAdd = '	data-phattype="html5" 
						data-phatmp4="'.esc_attr($mp4).'" 
						data-phatwebm="'.esc_attr($webm).'" 
						data-phatogv="'.esc_attr($oga).'"';	
	} else if ($showPagetitle == 'youtube') {
		$youtube = get_post_meta($theId, $sr_prefix.'_video_youtube', true);
		$heroAdd = '	data-phattype="youtube" 
						data-phatvideoid="'.esc_attr($youtube).'"' ;
	} else if ($showPagetitle == 'vimeo') {
		$vimeo = get_post_meta($theId, $sr_prefix.'_video_vimeo', true);
		$heroAdd = '	data-phattype="vimeo" 
						data-phatvideoid="'.esc_attr($vimeo).'"' ;
	}
	
	$videoText = get_post_meta($theId, $sr_prefix.'_video_textcolor', true);
	$ratio = get_post_meta($theId, $sr_prefix.'_video_ratio', true);
	if (!$ratio) { $ratio = "21/9"; }
	$poster = get_post_meta($theId, $sr_prefix.'_video_poster', true);
	$loop = get_post_meta($theId, $sr_prefix.'_video_loop', true);
	if (!$loop) { $loop = "true"; }
	$mute = get_post_meta($theId, $sr_prefix.'_video_sound', true);
	$playpause = get_post_meta($theId, $sr_prefix.'_video_playpause', true);
	if (!$playpause) { $playpause = "false"; }
	$oColor = get_post_meta($theId, $sr_prefix.'_video_overlaycolor', true);
	$oOpacity = get_post_meta($theId, $sr_prefix.'_video_overlayopacity', true);
	if ($oColor == '') { $oColor = "#ffffff"; $oOpacity = 0; }
	
	$heroClass = 'videobg-section text-'.esc_attr($videoText);
	$heroAdd .= '		data-phatratio="'.esc_attr($ratio).'"
						data-phatposter="'.esc_attr($poster).'"
						data-phatloop="'.esc_attr($loop).'"
						data-phatmute="'.esc_attr($mute).'"
						data-phatplaypause="'.esc_attr($playpause).'"
						data-phatoverlaycolor="'.esc_attr($oColor).'"
						data-phatoverlayopacity="0.'.esc_attr($oOpacity).'"';
} else if ($showPagetitle == 'fullslider') {
	$slides = get_post_meta($theId, $sr_prefix.'_fullslider_slides', true);	
	$navigation = get_post_meta($theId, $sr_prefix.'_fullslider_navigation', true);	
	$autoplay = get_post_meta($theId, $sr_prefix.'_fullslider_autoplay', true);	
	$loop = get_post_meta($theId, $sr_prefix.'_fullslider_loop', true);	
	
	$slides = explode('||', $slides);
	
	$sliderOPtions = '';
	if ($navigation == 'bullets') { $sliderOPtions .= ' data-dots="true" data-nav="false"'; }
	else if ($navigation == 'arrows') { $sliderOPtions .= ' data-dots="false" data-nav="true"'; }
	else if ($navigation == 'both') { $sliderOPtions .= ' data-dots="true" data-nav="true"'; }
	
	if ($autoplay == 'true') { $sliderOPtions .= ' data-autoplay="true"'; }
	if ($loop == 'true') { $sliderOPtions .= ' data-loop="true"'; }
	
	$firstSlide = explode('~~', $slides[0]);
	$navColor = ''; if ($firstSlide[6] == 'text-light') { $navColor = 'nav-light'; } 
	
	$outputSlider = '<div class="owl-slider hero-slider '.$navColor.'"'.$sliderOPtions.'>';
	foreach ($slides as $i) { 
		$object = explode('~~', $i); 
		$imageId = $object[0];
		$mainTitle = $object[2];
		$mainTitleSize = $object[3];
		$subTitle = $object[4];
		$subTitleSize = $object[5];
		$color = $object[6];
		
		if (isset($object[7])) {
		$olinkto = $object[7];
		$oportfolios = $object[8];
		$opages = $object[9];
		$oposts = $object[10];
		$oproducts = $object[11];
		$ocustom = $object[12];
		}
		
		$image = wp_get_attachment_image_src($imageId,'full'); $image = $image[0];
		
		$outputSlider .= '<div class="slider-item '.$color.'" style="background-image:url('.$image.');">';
		if ($mainTitle || $subTitle) {
       		$outputSlider .= '<div class="owl-slider-caption">';
            if ($mainTitle) { $outputSlider .= '<'.$mainTitleSize.'><strong>'.$mainTitle.'</strong></'.$mainTitleSize.'>'; }
            if ($subTitle) { $outputSlider .= '<'.$subTitleSize.' class="alttitle">'.$subTitle.'</'.$subTitleSize.'>'; }
            $outputSlider .= '</div>';
		}
		if (isset($olinkto) && $olinkto && $olinkto !== "false") {
			$theLink = "";
			if ($olinkto == "portfolios") { $theLink = get_permalink( $oportfolios ); }
			if ($olinkto == "pages") { $theLink = get_permalink( $opages ); }
			if ($olinkto == "posts") { $theLink = get_permalink( $oposts ); }
			if ($olinkto == "products") { $theLink = get_permalink( $oproducts ); }
			if ($olinkto == "custom" && $ocustom) { $theLink = $ocustom; }
        	$outputSlider .= '<a href="'.$theLink.'" class="full-link"></a>';
		}
        $outputSlider .= '</div>';
	}
	$outputSlider .= '</div>';
	if ($fullHeight == 'hero-auto') { $fullHeight = ''; }
} else if ($showPagetitle == 'inlinevideo') { 
	$type = get_post_meta($theId, $sr_prefix.'_inlinevideo_type', true);
	$id = get_post_meta($theId, $sr_prefix.'_inlinevideo_id', true);
	$bgimage = get_post_meta($theId, $sr_prefix.'_inlinevideo_bgimage', true);
	$textColor = get_post_meta($theId, $sr_prefix.'_inlinevideo_textcolor', true);
	
	$heroClass = 'parallax-section inline-video text-'.$textColor;
	$heroAdd = 'data-parallax-image="'.esc_url($bgimage).'" data-type="'.esc_attr($type).'" data-videoid="'.esc_attr($id).'"';	
} else if ($showPagetitle == 'slider') { 
	$revslider = get_post_meta($theId, $sr_prefix.'_slider_slider', true);
	$fullHeight = 'hero-auto';
} else if ($showPagetitle == 'default') { 
	$fullHeight = 'hero-auto';
	$titleposition = '';
	$margin = 'false';
} else if ($showPagetitle == 'false') { 
	$fullHeight = 'hero-auto';
	$titleposition = '';
	$margin = 'true';
}
/*************
USE THE OPTIONS
**************/	

$mainSize = get_post_meta($theId, $sr_prefix.'_alttitle-size', true);
$subSize = get_post_meta($theId, $sr_prefix.'_subtitle-size', true); 

/* ON SINGLE */	
if ((is_single() && get_post_type() == 'post') || post_password_required()) { 
	$pagesub = get_the_time('M j, Y');
	$subSize = 'h6'; 
	if (!$mainSize) { $mainSize = 'h3'; }
}
/* ON SINGLE */	

/* PASSWORD PROTECTION */	
if (post_password_required()) {
	$fullHeight = 'hero-auto';
	$titleposition = '';
	$margin = 'false';
	$heroClass = '';
	$heroAdd = '';
	$revslider = '';
	$outputSlider = '';
	$mainSize = 'h3';
	$subSize = 'h6'; 
	$scrollDown = '';
	$pagesub = __('Protected','sr_avoc_theme');
}
/* PASSWORD PROTECTION */	

if (!$mainSize) { $mainSize = 'h1'; }
if (!$subSize) { $subSize = 'h5'; }

$titleArrangement = get_post_meta($theId, $sr_prefix.'_titlearrangement', true);
$titleWrite = '';
if (isset($pagesub) && $titleArrangement !== 'main') { $titleWrite .= '<'.$subSize.' class="alttitle">'.$pagesub.'</'.$subSize.'>'; }
$titleWrite .= '<'.$mainSize.'><strong>'.$pagetitle.'</strong></'.$mainSize.'>';
if (isset($pagesub) && $titleArrangement == 'main') { $titleWrite .= '<'.$subSize.' class="alttitle">'.$pagesub.'</'.$subSize.'>'; }


?>
				
			<?php if ($showPagetitle !== 'false' || ($showPagetitle == 'false' && post_password_required())) { ?>
				<section id="hero" class="<?php echo esc_attr($fullHeight); ?> <?php echo esc_attr($heroClass); ?>" <?php echo $heroAdd; ?>>
                	<?php 
					if (isset($revslider) && $revslider && $revslider !== 'false') { 
						if(class_exists('RevSlider')){ 
							echo putRevSlider($revslider); 
						}
					} else if (isset($outputSlider) && $outputSlider !== '') { 
						echo $outputSlider; 
					} else if ($titleposition !== 'false') {?>
                    <div class="page-title <?php echo esc_attr($titleposition); ?>">								
                        <?php if ($titleWrite && $titleWrite !== '') { echo $titleWrite; } ?>
                    </div>
                    <?php } ?>
                    
                    <?php if ($scrollDown == 'light' || $scrollDown == 'dark') { ?>
                    <a id="scroll-down" class="text-<?php echo esc_attr($scrollDown); ?>" href="#"><?php _e("Scroll Down","sr_avoc_theme"); ?></a>
                    <?php } ?> 
				</section>
                
            	<?php if ($margin !== 'false') { ?><div class="spacer spacer-big spacer-hero"></div><?php } ?>
			<?php } else {
				if (get_post_meta($theId, $sr_prefix.'_pagebuilder_active', true)) {
					if (stripos(get_the_content(),'horizontalsection') == 1) {  } else {
						echo '<div class="spacer spacer-big spacer-hero"></div>';
					}
				}
			} 
			?>