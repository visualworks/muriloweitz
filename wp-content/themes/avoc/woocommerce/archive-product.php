<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); 

// Sidebar
$sidebar = "false"; 
if (get_option('_sr_shopsidebar')) { $sidebar = get_option('_sr_shopsidebar'); }
if (isset($_GET['sidebar'])) { $sidebar = $_GET['sidebar']; }
if ($sidebar == 'true') {
	$sidebarPos = 'right-float';
	$contentPos = 'left-float';
	$sidebarPos = get_option('_sr_shopsidebarposition');
	if ($sidebarPos == 'right-float') { $contentPos = 'left-float'; } else { $contentPos = 'right-float'; }
	$sidebarStyle = get_option('_sr_shopsidebarstyle');
	if ($sidebarStyle == 'sidebar-dark') { $sidebarStyle .= ' text-light'; }
} 

// Grid Width
$gridWidth = get_option('_sr_shopgridsize');
if (isset($_GET['gridsize'])) { $gridWidth = $_GET['gridsize']; }
if (!$gridWidth) { $gridWidth = 'wrapper'; }


avoc_woo_getSpacer('top');
?>

<div class="<?php echo esc_attr($gridWidth); ?>">
	
    <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

        <h2 class="woo-page-title"><strong><?php woocommerce_page_title(); ?></strong></h2>
        <div class="spacer spacer-mini"></div>

    <?php endif; ?>

    
	<?php if ($sidebar == 'true') { ?><div class="sidebar-content <?php echo esc_attr($contentPos); ?>"><?php } ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
		
		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
			
			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
        
    	<?php avoc_woo_getSpacer('bottom'); ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

    <?php if ($sidebar == 'true') { ?></div>
	<aside id="sidebar" class="<?php echo esc_attr($sidebarPos); ?> <?php echo esc_attr($sidebarStyle); ?>">
		<?php dynamic_sidebar('Shop Sidebar'); ?>
	</aside>
	<div class="clear"></div>
	<?php } ?>
    
</div> <!-- END .wrapper -->

<?php get_footer( 'shop' ); ?>
