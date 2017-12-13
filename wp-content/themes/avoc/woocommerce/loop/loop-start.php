<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version     2.0.0
 */

$maxItemWidth = 420;
if (get_option('_sr_shopmasonrythumbsize')) { $maxItemWidth = intval(get_option('_sr_shopmasonrythumbsize')); }
if (isset($_GET['maxitemwidth'])) { $maxItemWidth = $_GET['maxitemwidth']; }
?>
<div id="shop-grid" class="masonry shop-masonry shop-container spacing-true fitrows clearfix" data-maxitemwidth="<?php echo esc_attr($maxItemWidth); ?>">
