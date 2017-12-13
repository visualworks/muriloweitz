<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="wrapper-small">
<?php

//dani_woo_getSpacer('top');

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>
<div class="clear"></div>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	
    <div class="checkout-section clearfix">
    	
    	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
    
            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
    
			<?php do_action( 'woocommerce_checkout_billing' ); ?>

			<?php do_action( 'woocommerce_checkout_shipping' ); ?>
    
            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
    
        <?php endif; ?>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<div id="order_review" class="woocommerce-checkout-review-order">
			<h4 id="order_review_heading"><strong><?php _e( 'Your order', 'woocommerce' ); ?></strong></h4>
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>

		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
         
  	</div> <!-- END .checkout-section -->      

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</div>
