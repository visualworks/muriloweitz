<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper tabs">
		<ul class="tab-nav clearfix wc-tabs">
			<?php $i = 0; foreach ( $tabs as $key => $tab ) : if ($i == 0) { $active = 'class="active"'; } else { $active = ""; } ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
                	<h5 class="alttitle tab-name">
					<a href="tab-<?php echo esc_attr( $key ); ?>" <?php echo $active; ?>>
					<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
                    </h5>
				</li>
			<?php $i++; endforeach; ?>
		</ul>
       	<div class="clear"></div>
        <div class="tab-container clearfix">
		<?php $i = 0; foreach ( $tabs as $key => $tab ) : if ($i == 0) { $active = 'active'; } else { $active = ""; } ?>
			<div class="tab-content tab-<?php echo esc_attr( $key ); ?> woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab <?php echo esc_attr( $active ); ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
			</div>
		<?php $i++; endforeach; ?>
		</div>
	</div>

<?php endif; ?>
