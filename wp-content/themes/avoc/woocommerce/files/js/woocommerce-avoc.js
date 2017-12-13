/*-----------------------------------------------------------------------------------

 	Script - All Custom frontend jQuery scripts & functions
 
-----------------------------------------------------------------------------------*/
(function(){
'use strict';

jQuery(window).load(function() {
		
	/*---------------------------------------------- 
	
			Q U A N T I T Y   B U T T O N S 
			
	------------------------------------------------*/
    jQuery( ".quantity" ).on( 'click', '.plus, .minus', function() {

        // Get values
        var $qty        = jQuery( this ).closest( '.quantity' ).find( '.qty' ),
            currentVal  = parseFloat( $qty.val() ),
            max         = parseFloat( $qty.attr( 'max' ) ),
            min         = parseFloat( $qty.attr( 'min' ) ),
            step        = $qty.attr( 'step' );

        // Format values
        if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

        // Change the value
        if ( jQuery( this ).is( '.plus' ) ) {

            if ( max && ( max == currentVal || currentVal > max ) ) {
                $qty.val( max );
            } else {
                $qty.val( currentVal + parseFloat( step ) );
            }

        } else {

            if ( min && ( min == currentVal || currentVal < min ) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( currentVal - parseFloat( step ) );
            }

        }

        // Trigger change event
        $qty.trigger( 'change' );
    });
	
		
	
	
	/*---------------------------------------------- 
	
		 A J A X   A D D   T O   C A R T
			
	------------------------------------------------*/
	jQuery('body').on("click", ".ajax_add_to_cart", function() { 
		
		if (!jQuery(this).parents(".product").hasClass("outofstock")) {			
			setTimeout(function(){ 
				var url = srvars.ajaxurl;
				var addData = { action:'sr_woo_minicart' };
				if(srvars.wpml){ addData.wpml = srvars.wpml; }
				jQuery.ajax({
						type:'POST',			// this might lead to issues for html template
						url:url,
						data: addData,
						dataType:"html",
						error: function () {
						},
						success: function(response) { 
							//console.log(response);
							if (response) {
								var itemCount = jQuery(response).find('.cart-list').data('items');
								jQuery(".minicart-count").html(itemCount).addClass('updated');
								jQuery(".menu-cart-content .cart-list").replaceWith(jQuery(response).find(".cart-list"));
								jQuery(".menu-cart-content .cart-bottom").replaceWith(jQuery(response).find(".cart-bottom"));
							} 
						}
				});
			},800);
		
		}
		
	});
	
	
	
});

})(jQuery);
