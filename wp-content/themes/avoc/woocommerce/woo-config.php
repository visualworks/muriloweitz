<?php 



/*-----------------------------------------------------------------------------------

	WooCommerce Configuration

-----------------------------------------------------------------------------------*/
if( !function_exists( 'sr_woo_minicart_callback' ) ) {
	function sr_woo_minicart_callback() {
		global $wpdb;
		
		if ($_POST['wpml']) {
			global $sitepress;
			$sitepress->switch_lang($_POST['wpml'], true);
			//load_theme_textdomain( $domain, $path );
		}
		?>ra
       	<div class="menu-cart-content">
			<?php woocommerce_mini_cart(); ?>
		</div>
        <?php
		die(); // this is required to return a proper result
	}
}
add_action('wp_ajax_nopriv_sr_woo_minicart', 'sr_woo_minicart_callback'); 
add_action('wp_ajax_sr_woo_minicart', 'sr_woo_minicart_callback');



/*-----------------------------------------------------------------------------------

	WooCommerce Configuration

-----------------------------------------------------------------------------------*/
// Adds theme support for woocommerce 
add_theme_support('woocommerce');

// Disbale default woo css
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );



/*-----------------------------------------------------------------------------------

	Register Shop Sidebar

-----------------------------------------------------------------------------------*/
if( !function_exists( 'avoc_shop_sidebar' ) ) {
	function avoc_shop_sidebar() {
		global $sr_prefix;
		
		/*
		$titleSize = 'h6';
		if (get_option('_sr_widgettitlefont-size')) { $titleSize = get_option('_sr_widgettitlefont-size'); }
		*/
		
		if(get_option($sr_prefix.'_shopsidebar') == 'true') {
			register_sidebar( array(
				'name' => esc_html__( 'Shop Sidebar', 'avoc' ),
				'id' => 'shop-sidebar',
				'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
				'after_widget' => "</div>",
				'before_title' => '<h6 class="widget-title"><strong>',
				'after_title' => '</strong></h6>'
			) );	
		}
		
	}
	
}
add_action( 'widgets_init', 'avoc_shop_sidebar' );



/*-----------------------------------------------------------------------------------*/

/*	Remove some default elements

/*-----------------------------------------------------------------------------------*/

// Remove Breadcrumb
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);


// Remove "You may also like..." from cart
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10, 1 );


// Edit Price Output on loop
function sr_price_html( $price, $product ){
    $return = str_replace( '<ins>', '', $price );
    $return = str_replace( '</ins>', '', $return );
	return $return;
}
add_filter( 'woocommerce_get_price_html', 'sr_price_html', 100, 2 );


// Products per page
$shopcount = 12;
if (get_option('_sr_shopgridcount')) { $shopcount = intval(get_option('_sr_shopgridcount')); }
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$shopcount.';' ), 20 );

// Remove related products
if (!get_option('_sr_shopsinglerelated')) { } else {
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
}

// Remove Upsells "You may also like..."
if (!get_option('_sr_shopsingleupsells')) { } else {
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
}

// Disable Reviews
if (!get_option('_sr_shopsinglereviews')) { } else {
	add_filter( 'woocommerce_product_tabs', 'avoc_woo_disablereviews', 98 );
		function avoc_woo_disablereviews($tabs) {
		unset($tabs['reviews']);
		return $tabs;
	}
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
}


// grid options (result count + ordering)
add_action( 'woocommerce_before_shop_loop', 'avoc_woo_wrapgridoptions_start', 2 );
if ( ! function_exists( 'avoc_woo_wrapgridoptions_start' ) ) {
	function avoc_woo_wrapgridoptions_start() { echo '<div class="grid-options clearfix">'; } 
}
add_action( 'woocommerce_before_shop_loop', 'avoc_woo_wrapgridoptions_end', 52 );
if ( ! function_exists( 'avoc_woo_wrapgridoptions_end' ) ) {
	function avoc_woo_wrapgridoptions_end() { echo '</div>'; } 
}

// remove sorting  
if (get_option($sr_prefix.'_disableshopsorting')) {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
}

// remove result count  
if (get_option($sr_prefix.'_disableshopresultcount')) {
	remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
}


// move meta on single product
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 22 );


// wrap the info messages 
add_action( 'woocommerce_before_checkout_form', 'avoc_wrap_forms_start', 1 );
function avoc_wrap_forms_start() { echo '<div class="before-checkout clearfix">'; }
add_action( 'woocommerce_before_checkout_form', 'avoc_wrap_forms_end', 12 );
function avoc_wrap_forms_end() { echo '</div>'; }



/*-----------------------------------------------------------------------------------*/

/*	Mini Cart

/*-----------------------------------------------------------------------------------*/
function avoc_woo_minicart_menu() {
	if (get_option('_sr_shopshowminicart') == 'yes') {
	?>
    <div class="menu-cart">
    	<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="open-cart">
        	<span class="minicart-icon"></span>
            <span class="minicart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
      	</a>
      	<div class="menu-cart-content">
			<?php woocommerce_mini_cart(); ?>
		</div> 
    </div>
	<?php
	}
}	
	
	

/*-----------------------------------------------------------------------------------*/

/*	SPACER FUNCTION

/*-----------------------------------------------------------------------------------*/
function avoc_woo_getSpacer($pos) {
	global $sr_prefix;
	$theId = sr_getId();

	$showPagetitle = "default";
	if (isset($theId)) { $showPagetitle = get_post_meta($theId, $sr_prefix.'_showpagetitle', true); }
	if (is_account_page()) {
		$heroClass = 'account-hero';		
		$showPagetitle = "default";
	} else if (is_product_category() || is_product_tag() || is_search()) {
		$showPagetitle = "default";
	} else if (is_product() && !$showPagetitle) {
		$showPagetitle = "false";
	}
	
	/* TOP SPACER */
	$spacerTop = false;
	if ($showPagetitle == 'false') { $spacerTop = '<div class="spacer spacer-big shop-spacer-top"></div>'; }
	if ($spacerTop && $pos == 'top') { echo $spacerTop; }
	/* TOP SPACER */
	
	/* BOTTOM SPACER */
	$spacerBottom = '<div class="spacer spacer-big shop-spacer-bottom"></div>';
	if (!is_shop() && $spacerBottom && $pos == 'bottom') { echo $spacerBottom; }
	/* BOTTOM SPACER */
	
}
	 
?>