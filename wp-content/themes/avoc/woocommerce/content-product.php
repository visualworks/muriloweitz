<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
global $sr_prefix;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}


// remove default link open
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
// remove default product thumb
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
// remove rating stars
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
// remove default link close
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );


// GET options when not comming from pagebuilder
if (!isset($gridtype)) {
	$gridtype = get_option($sr_prefix.'_shopgridtype'); 
	$captionsize = get_option($sr_prefix.'_shopcaptionsize'); 
	$masonryHover = get_option($sr_prefix.'_shopmasonryhover'); 
	$addtocart = get_option($sr_prefix.'_shopaddtocart'); 
}
if (!isset($gridtype)) { $gridtype = 'masonry'; }
if (!isset($captionsize)) { $captionsize = 'h6'; }

$infoClass = "";
if($addtocart == "false") {
	// remove add to cart button
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	$infoClass = "no-price-hide";
}
?>

	<?php if (isset($gridtype) && $gridtype == 'wolf') { 
					
		$theTitle = get_post_meta(get_the_ID(), $sr_prefix.'_altcaption', true); if (!$theTitle || $theTitle == '') { $theTitle = get_the_title();}
		
		$imgClass = '';
		if ($wolfhover !== 'default') { $imgClass = 'img-hover hover-'.$wolfhover; }
		
		$captionClass = "";
		if (isset($wolfcaptionbg)) { $captionClass = $wolfcaptionbg; }
	?>
	
	<div <?php post_class('wolf-item shop-item'); ?>>
	
		<div class="wolf-item-inner">
			<div class="wolf-media <?php if ($wolfhover == 'default') { ?>shop-media<?php } ?>">
				<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
				<a href="<?php echo esc_url(get_permalink()); ?>" class="wolf-media-link <?php echo esc_attr($imgClass); ?>"><?php
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'thumb-big' );
				// Check if .gif file
				if (strpos($image[0], '.gif') !== false) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ) , 'full' );
				}
				echo '<img width="'.$image[1].'" height="'.$image[2].'" src="'.$image[0].'" alt="'.get_the_title(get_post_thumbnail_id( $product->get_id() )).'">';
				?></a>
				<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
			</div>
			
			<div class="wolf-caption <?php if ($wolfhover == 'default') { ?>shop-caption<?php } ?> <?php echo esc_attr($captionClass); ?>">
			
				<div class="item-infos <?php echo esc_attr($infoClass); ?>">	
				<?php echo '<'.$captionsize.' class="product-name"><a href="'.get_the_permalink().'"><strong>'.get_the_title().'</strong></a></'.$captionsize.'>'; ?>
				<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
				</div>
				
			</div>
		</div>
	</div>
	
	<?php } else { ?>

	<div <?php post_class('masonry-item shop-item'); ?>>
	
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<a href="<?php echo esc_url(get_permalink()); ?>" class="img-hover <?php if($masonryHover == 'dark') { echo 'hover-dark text-light';} ?>">
			<?php echo woocommerce_get_product_thumbnail(); ?>
			<!--
			<div class="hover-caption">
				<h5><strong><?php the_title(); ?></strong></h5>
			</div>
			-->
		</a>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		<div class="item-infos <?php echo esc_attr($infoClass); ?>">	
    	<?php echo '<'.$captionsize.' class="product-name"><a href="'.get_the_permalink().'"><strong>'.get_the_title().'</strong></a></'.$captionsize.'>'; ?>
		<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
		</div>
	</div> <!-- END .portfolio-masonry-entry-->
	
	<?php } ?>
