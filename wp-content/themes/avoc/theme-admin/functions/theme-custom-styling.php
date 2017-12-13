<?php

/*-----------------------------------------------------------------------------------

	CUSTOM STYLING OPTIONS

-----------------------------------------------------------------------------------*/
global $sr_prefix;



/*-----------------------------------------------------------------------------------*/
/*	Logo Height Styling
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'sr_custom_style_logo' ) ) {
	function sr_custom_style_logo() {
		global $sr_prefix;
		
		$return='';
				
		$logoLight = get_option($sr_prefix.'_logolight');
		$logoDark = get_option($sr_prefix.'_logodark');
		$responsiveLogoHeight = intval(get_option($sr_prefix.'_customlogoheightresponsive'));
				
		if ($logoLight) {
			$logoId =  sr_get_attachment_id_from_src($logoLight);
			$logodata = wp_get_attachment_image_src( $logoId, "full" );
			$logoHeight = $logodata[2];
			
			$return .= '
			header #logo { height: '.$logoHeight.'px;	 }
			/*.open-nav { height: '.$logoHeight.'px; }
			.open-nav .text { line-height: '.$logoHeight.'px;	 }*/
			header.header-open:not(.header-transparent) nav#main-nav > ul > li > a { line-height: '.$logoHeight.'px; }
			header.header-open:not(.header-transparent) nav#main-nav ul li > ul.sub-menu { top: calc(50% + 15px); }';
			
			$headerHeight = $logoHeight + (2*60);
			$filterTop = $logoHeight/2;
			if (get_option($sr_prefix.'_headerpadding') == "medium") { $headerHeight = $logoHeight + (2*40); $filterTop = $filterTop-5; }
			if (get_option($sr_prefix.'_headerpadding') == "small") { $headerHeight = $logoHeight + (2*30); $filterTop = $filterTop-5; }
			$return .= '
			/*#page-body { padding-top: '.$headerHeight.'px; }*/
			header:after, header:before { top: -'.$headerHeight.'px; height: '.$headerHeight.'px; }	
			header.header-open:not(.header-transparent) + #hero, header.header-open:not(.header-transparent) + #page-body { margin-top: '.$headerHeight.'px; }
			#header-filter, #header-share, #header-search { top: -'.$headerHeight.'px;	 min-height: '.$headerHeight.'px; }
			header.header-open:not(.header-transparent) #menu .open-filter, header.header-open:not(.header-transparent) #menu .open-share, header.header-open:not(.header-transparent) #menu .open-search, header.header-open:not(.header-transparent) #menu .menu-language { top: calc('.$filterTop.'px + 2px); -webkit-transform: translateY(100%); -moz-transform: translateY(100%); -ms-transform: translateY(100%); -o-transform: translateY(100%); transform: translateY(100%); }
			
			header.header-open + #hero.hero-full { height: calc(100vh - '.($logoHeight + (2*60)).'px); }
			header.margin-medium.header-open + #hero.hero-full { height: calc(100vh - '.($logoHeight + (2*40)).'px); }
			header.margin-small.header-open + #hero.hero-full { height: calc(100vh - '.($logoHeight + (2*30)).'px); }
			';
			
			if ($responsiveLogoHeight) {
				$headerHeight = $responsiveLogoHeight + (2*30);
				$return .= '
					@media only screen and (max-width: 781px) {
						header #logo { height: '.$responsiveLogoHeight.'px;	 }
						header:after, header:before { top: -'.$headerHeight.'px; height: '.$headerHeight.'px; }
						header.header-open:not(.header-transparent) + #hero, header.header-open:not(.header-transparent) + #page-body { margin-top: '.$headerHeight.'px; }
					}
				';
			}
			
		} 
		
		// hide header on loading
		if (get_option($sr_prefix.'_headerpreloader') == 'false') {
			$return .= '#page-loader { z-index: 11; }';
		}
		
		return $return;
	}
}
		
		
		
		
/*-----------------------------------------------------------------------------------*/
/*	Color Styling
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'sr_custom_style_color' ) ) {
	function sr_custom_style_color() {
		global $sr_prefix;
		
		/*
		GENERAL COLOR
		*/		
		if (get_option($sr_prefix.'_customcolor')){ 
		
			$main_color = get_option($sr_prefix.'_customcolor');
			
			$return = '
h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover { color: '.$main_color.' !important; }
input[type=submit], .button { background: '.$main_color.'; }
a { color: '.$main_color.'; }
.colored { color: '.$main_color.'; }
.widget_calendar tbody a:hover, .widget_calendar tbody a:focus { background: '.$main_color.'; }
nav#main-nav > ul:not(.hover-underline) > li:hover > a, nav#main-nav > ul:not(.hover-underline) > li.current-menu-item > a { color: '.$main_color.' !important; }
#backtotop:hover { color: '.$main_color.'; }
ul.filter li a.active, ul.filter li a:hover { color: '.$main_color.'; }
#blog-single .blog-meta .meta-author a:hover, #blog-single .blog-meta .meta-category a:hover, #blog-single .blog-meta .meta-tags a:hover { color: '.$main_color.'; }
.single-pagination li a:hover span	{ color: '.$main_color.'; }
.single-pagination li.backtoworks a:hover { color: '.$main_color.'; }
.entries-pagination li a:hover, .entries-pagination li.page span { color: '.$main_color.'; }
#blog-comments #cancel-comment-reply-link { color: '.$main_color.'; }
a.sr-button1:hover { background: '.$main_color.'; }
a.sr-button2 { background: '.$main_color.'; }
a.sr-button3:hover { background: '.$main_color.'; }
a.sr-button4 { background: '.$main_color.'; }
a.button:hover { background: '.$main_color.'; }
.inline-video:hover::before { color: '.$main_color.'; }
.inline-video .inline-iframe-container .close-inline-video:hover { color: '.$main_color.'; }
.tabs ul.tab-nav li a.active { color: '.$main_color.'; }
.toggle-item .toggle-title.toggle-active:after { color: '.$main_color.'; }
.toggle-item .toggle-title:hover:after { color: '.$main_color.'; }
.toggle-item .toggle-title:hover .toggle-name  { color: '.$main_color.'; }	
.toggle-item .toggle-title.toggle-active .toggle-name  { color: '.$main_color.'; }
#hero .page-title h1 a, #hero .page-title h2 a, #hero .page-title h3 a, #hero .page-title h4 a, #hero .page-title h5 a, #hero .page-title h6 a { color: '.$main_color.'; }


.wolf-caption a.caption-hover:hover h4, 
.wolf-caption a.caption-hover:hover h5, 
.wolf-caption a.caption-hover:hover h6, 
.wolf-caption a.caption-hover:hover h3 { color: '.$main_color.'; }	

.shop-container .shop-item .grid-button .sr-button-text:hover,
.woocommerce .cart-actions .button,
.woocommerce .coupon input[type=submit], .woocommerce .checkout-coupon input[type=submit],
.woocommerce .star-rating span,
.woocommerce-MyAccount-navigation ul li a:hover, .woocommerce-MyAccount-navigation ul li.is-active a { color: '.$main_color.'; }



';
		
		} 		
		
		// Sale Badge color		
		if (get_option($sr_prefix.'_shopgridsalecolor') == 'custom' && get_option($sr_prefix.'_shopgridsalecolorcustom')){
			$saleColor = get_option($sr_prefix.'_shopgridsalecolorcustom');
			$return .= 'span.onsale.custom { background: '.$saleColor.'; }';
		}
				

	return $return;
		
	}
}




/*-----------------------------------------------------------------------------------*/
/*	Typorgraphy Styling
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'sr_custom_style_typography' ) ) {
	function sr_custom_style_typography() {
		global $sr_prefix;
		
		$defaultfonts = array('body','h1','h2','h3','h4','h5','h6');
		
		// DEFAULT FONTS
		$return = '';
		$return1024 = '';
		$return780 = '';
		$return480 = '';
		foreach($defaultfonts as $font) {
			$family = get_option($sr_prefix.'_'.$font.'font-font');
			$weight = get_option($sr_prefix.'_'.$font.'font-weight');
			$boldweight = get_option($sr_prefix.'_'.$font.'font-boldweight');
			$size = get_option($sr_prefix.'_'.$font.'font-size');
			$lineheight = get_option($sr_prefix.'_'.$font.'font-height');
			if (!$lineheight) $lineheight = intval(intval($size)*1.3).'px';
			$spacing = get_option($sr_prefix.'_'.$font.'font-spacing');
			$transform = get_option($sr_prefix.'_'.$font.'font-transform');
			
			if ($font !== 'body') { $fontClass = ', .'.$font; } else { $fontClass = ''; }
			$return .= $font.$fontClass.' {';
				if ($family) { $return .= 'font-family: "'.$family.'";'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
				if ($size) { $return .= 'font-size: '.$size.';line-height: '.$lineheight.';'; }
				if ($spacing && $spacing !== '0') { $return .= 'letter-spacing: '.$spacing.'em;'; }
				if ($transform) { $return .= 'text-transform: '.$transform.';'; }
			$return .= '}';
			if ($boldweight) { $return .= $font.' strong,'.$font.' b { font-weight: '.$boldweight.'; }'; }
			
			if ($font == 'body') {
				//$return .= 'input[type=text], input[type=password], input[type=email], input[type=number], input[type=tel], textarea { font-family: '.$family.'; font-weight: '.$weight.'; }';
				$return .= '.widget_nav_menu ul.menu > li { font-weight: '.$boldweight.'; }';
				$return .= '.widget_nav_menu ul.menu > li > .sub-menu li { font-weight: '.$weight.'; }';
				//$return .= '.price, .amount { font-weight: '.$boldweight.'; }';
			}
			
			if ($font == 'h1') {
				$return .= '#page-loader .loader, .inline-video:after { font-family:'.$family.'; font-weight:'.$weight.'; text-transform: '.$transform.'; letter-spacing: '.$spacing.'em; }';	
			}
			
			if ($font == 'h4') {
				$return .= '#reply-title { font-size: '.$size.';line-height: '.$lineheight.'; }';	
			}
			
			if ($font == 'h5') {
				$return .= '.woocommerce-MyAccount-navigation ul li a { font-size: '.$size.'; line-height: '.$lineheight.'; }';	
			}
			
			if ($font == 'h6') {
				$return .= 'legend { font-size: '.$size.'; line-height: '.$lineheight.'; }';
				$return .= '.sr-button-text, #scroll-down, #backtotop, .entries-pagination li a, .single-pagination li a, #menu .open-filter, #menu .open-share, .menu-cart-content .cart-bottom .total .label { font-size: '.intval(intval($size)*0.8).'px;  }';
				$return .= '.price, .amount, .shop-container .shop-item .grid-button .sr-button-text, .shop-container .shop-item .grid-button .sr-button-text strong, ul.cart_list li .item-name { font-size: '.intval(intval($size)*0.9).'px;  }';
			}
			
			
			// Responsiveness
			$size1024 = get_option($sr_prefix.'_'.$font.'font-1024');
			if ($size1024) { $return1024 .= $font.$fontClass.' { font-size: '.$size1024.' !important; line-height: '.intval(intval($size1024)*1.3).'px !important; }'; }
			
			$size780 = get_option($sr_prefix.'_'.$font.'font-780');
			if ($size780) { $return780 .= $font.$fontClass.' { font-size: '.$size780.' !important; line-height: '.intval(intval($size780)*1.3).'px !important; }'; }
			
			$size480 = get_option($sr_prefix.'_'.$font.'font-480');
			if ($size480) { $return480 .= $font.$fontClass.' { font-size: '.$size480.' !important; line-height: '.intval(intval($size480)*1.3).'px !important; }'; }
			
		}
		
		if ($return1024) { $return .= '@media only screen and (max-width: 1024px) { '.$return1024.' }'; }
		if ($return780) { $return .= '@media only screen and (max-width: 781px) { '.$return780.' }'; }
		if ($return480) { $return .= '@media only screen and (max-width: 481px) { '.$return480.' }'; }
		// DEFAULT FONTS
		
		
		// SUB TITLE
			$family = get_option($sr_prefix.'_subtitle-font');
			$weight = get_option($sr_prefix.'_subtitle-weight');
			$boldweight = get_option($sr_prefix.'_subtitle-boldweight');
			$spacing = get_option($sr_prefix.'_subtitle-spacing');
			$transform = get_option($sr_prefix.'_subtitle-transform');
			
			$return .= '.alttitle {';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
				if ($spacing && $spacing !== '0') { $return .= 'letter-spacing: '.$spacing.'em;'; }
				if ($transform) { $return .= 'text-transform: '.$transform.';'; }
			$return .= '}';
			if ($boldweight) { $return .= '.alttitle b, .alttitle strong { font-weight: '.$boldweight.'; }'; }
						
			$return .= 'table caption, blockquote, .copyright, ul.filter li a, .blog-masonry-entry .blog-content .time, .blog-masonry-entry .post-sticky, .widget_rss .rss-date, .widget_rss cite,
			.price, .amount, .woocommerce span.onsale,
			.woocommerce-MyAccount-navigation ul li a { ';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
				if ($spacing && $spacing !== '0') { $return .= 'letter-spacing: '.$spacing.'em;'; }
			$return .= '}';
			
			$return .= '#blog-single .blog-meta .meta-author span, #blog-single .blog-meta .meta-category span, #blog-single .blog-meta .meta-author span, #blog-single .blog-meta .meta-tags span, .menu-cart-content .cart-bottom .total .label { ';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
			$return .= '}';
		// SUB TITLE
		
				
		// ROOT NAVIGATION
			$family = get_option($sr_prefix.'_navigationfont-font');
			$weight = get_option($sr_prefix.'_navigationfont-weight');
			$size = get_option($sr_prefix.'_navigationfont-size');
			$spacing = get_option($sr_prefix.'_navigationfont-spacing');
			$transform = get_option($sr_prefix.'_navigationfont-transform');
			
			$return .= 'nav#main-nav ul li > a, .open-nav .text, .widget_nav_menu ul.menu li {';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
				if ($size) { $return .= 'font-size: '.$size.';'; }
				if ($spacing && $spacing !== '0') { $return .= 'letter-spacing: '.$spacing.'em;'; }
				if ($transform) { $return .= 'text-transform: '.$transform.';'; }
			$return .= '}';
			
			$return .= '.widget_calendar tfoot a, #menu .open-filter, #menu .open-share, #menu .menu-language a, #scroll-down, .single-pagination li a, .entries-pagination li a, .entries-pagination li span, .sr-button-text, .sr-button-text strong, #blog-comments .comment-reply-link, #blog-comments #cancel-comment-reply-link, #backtotop, table th, .woocommerce .cart-actions .button, .woocommerce .coupon input[type=submit], .woocommerce .checkout-coupon input[type=submit], .phatvideo-bg .mute-video, .phatvideo-bg .playpause-video {';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
				if ($spacing && $spacing !== '0') { $return .= 'letter-spacing: '.$spacing.'em;'; }
				if ($transform) { $return .= 'text-transform: '.$transform.';'; }
			$return .= '}';
			
			$return .= '#blog-single .blog-meta .meta-author a, #blog-single .blog-meta .meta-category a, #blog-single .blog-meta .meta-tags a {';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
				if ($transform) { $return .= 'text-transform: '.$transform.';'; }
			$return .= '}';
		// ROOT NAVIGATION
		
		
		// SUB NAVIGATION
			$family = get_option($sr_prefix.'_navigationsubfont-font');
			$weight = get_option($sr_prefix.'_navigationsubfont-weight');
			$size = get_option($sr_prefix.'_navigationsubfont-size');
			$spacing = get_option($sr_prefix.'_navigationsubfont-spacing');
			$transform = get_option($sr_prefix.'_navigationsubfont-transform');
			
			$return .= 'nav#main-nav ul li > ul.sub-menu li a {';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
				if ($size) { $return .= 'font-size: '.$size.';'; }
				if ($spacing && $spacing !== '0') { $return .= 'letter-spacing: '.$spacing.'em;'; }
				if ($transform) { $return .= 'text-transform: '.$transform.';'; }
			$return .= '}';
		// SUB NAVIGATION
		
		
		// BUTTON
			$family = get_option($sr_prefix.'_buttonfont-font');
			$weight = get_option($sr_prefix.'_buttonfont-weight');
			$boldweight = get_option($sr_prefix.'_buttonfont-boldweight');
			$spacing = get_option($sr_prefix.'_buttonfont-spacing');
			$transform = get_option($sr_prefix.'_buttonfont-transform');
			
			$return .= 'a.sr-button, input[type=submit], .button, a.button {';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
				if ($spacing && $spacing !== '0') { $return .= 'letter-spacing: '.$spacing.'em;'; }
				if ($transform) { $return .= 'text-transform: '.$transform.';'; }
			$return .= '}';
			
			/*$return .= 'input[type=text], input[type=password], input[type=email], input[type=number], input[type=tel], textarea, select, .select2-container .select2-choice .select2-chosen { ';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($boldweight) { $return .= 'font-weight: '.$boldweight.';'; }
			$return .= '}';*/
		// BUTTON
		
		
		// LABEL
			$family = get_option($sr_prefix.'_labelfont-font');
			$weight = get_option($sr_prefix.'_labelfont-weight');
			$size = get_option($sr_prefix.'_labelfont-size');
			$spacing = get_option($sr_prefix.'_labelfont-spacing');
			$transform = get_option($sr_prefix.'_labelfont-transform');
			
			$return .= 'label, form label {';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
				if ($size) { $return .= 'font-size: '.$size.';'; }
				if ($spacing && $spacing !== '0') { $return .= 'letter-spacing: '.$spacing.'em;'; }
				if ($transform) { $return .= 'text-transform: '.$transform.';'; }
			$return .= '}';
		// LABEL
		
		// INPUT
			$family = get_option($sr_prefix.'_inputfont-font');
			$weight = get_option($sr_prefix.'_inputfont-weight');
			$size = get_option($sr_prefix.'_inputfont-size');
			$spacing = get_option($sr_prefix.'_inputfont-spacing');
			$transform = get_option($sr_prefix.'_inputfont-transform');
			
			$return .= 'input[type=text], input[type=password], input[type=email], input[type=number], input[type=tel], textarea, select, .select2-container .select2-choice .select2-chosen {';
				if ($family) { $return .= 'font-family: '.$family.';'; }
				if ($weight) { $return .= 'font-weight: '.$weight.';'; }
				if ($size) { $return .= 'font-size: '.$size.';'; }
				if ($spacing && $spacing !== '0') { $return .= 'letter-spacing: '.$spacing.'em;'; }
				if ($transform) { $return .= 'text-transform: '.$transform.';'; }
			$return .= '}';
		// INPUT
				
		return $return;
		
	}
}

?>