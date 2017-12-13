<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids ) {
	?>
    <div id="shop-gallery-grid" class="gallery-container clearfix">
	<?php

		foreach ( $attachment_ids as $attachment_id ) {

			$props       = wc_get_product_attachment_props( $attachment_id, $post );

			if ( ! $props['url'] ) {
				continue;
			}
			
			echo '<div class="sr-gallery-item">';

			echo apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					'<a href="%s" class="%s" title="%s" data-rel="lightcase:productgallery">%s</a>',
					esc_url( $props['url'] ),
					esc_attr( 'thumb-hover overlay-effect' ),
					esc_attr( $props['caption'] ),
					wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props )
				),
				$attachment_id,
				$post->ID,
				esc_attr( 'thumb-hover overlay-effect' )
			);
			
			echo '</div>';

		}

	?></div>
	<?php
}
