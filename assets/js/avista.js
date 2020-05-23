/* global wcPagarmeParams, PagarMe */
(function( $ ) {
	'use strict';

	$( function() {

		/**
		 * Process the credit card data when submit the checkout form.
		 */
		$( 'body' ).on( 'click', '#place_order', function() {
			if ( ! $( '#payment_method_pagarme-credit-card-a-vista' ).is( ':checked' ) ) {
				return true;
			}

			PagarMe.encryption_key = wcPagarmeParams2.encryptionKey;

			var form2         = $( 'form.checkout, form#order_review' ),
				creditCard2     = new PagarMe.creditCard(),
				creditCardForm2 = $( '#pagarme-credit-cart-form-a-vista', form2 ),
				errors2         = null,
				errorHtml2      = '';

			// Lock the checkout form.
			form2.addClass( 'processing' );

			// Set the Credit card data.
			creditCard2.cardHolderName      = $( '#pagarme-card-a-vista-holder-name', form2 ).val();
			creditCard2.cardExpirationMonth = $( '#pagarme-card-a-vista-expiry', form2 ).val().replace( /[^\d]/g, '' ).substr( 0, 2 );
			creditCard2.cardExpirationYear  = $( '#pagarme-card-a-vista-expiry', form2 ).val().replace( /[^\d]/g, '' ).substr( 2 );
			creditCard2.cardNumber          = $( '#pagarme-card-a-vista-number', form2 ).val().replace( /[^\d]/g, '' );
			creditCard2.cardCVV             = $( '#pagarme-card-a-vista-cvc', form2 ).val();

			// Get the errors.
			errors2 = creditCard2.fieldErrors();

			// Display the errors in credit card form.
			if ( ! $.isEmptyObject( errors2 ) ) {
				form2.removeClass( 'processing' );
				$( '.woocommerce-error', creditCardForm2 ).remove();

				errorHtml2 += '<ul>';
				$.each( errors2, function ( key, value ) {
					errorHtml2 += '<li class="aqui">' + value + '</li>';
				});
				errorHtml2 += '</ul>';

				creditCardForm2.prepend( '<div class="woocommerce-error">' + errorHtml2 + '</div>' );
			} else {
				form2.removeClass( 'processing' );
				$( '.woocommerce-error', creditCardForm2 ).remove();

				// Generate the hash.
				creditCard2.generateHash( function ( cardHash ) {
					// Remove any old hash input.
					$( 'input[name=pagarme_card_hash]', form2 ).remove();

					// Add the hash input.
					form2.append( $( '<input name="pagarme_card_hash" type="hidden" />' ).val( cardHash ) );

					// Submit the form.
					form2.submit();
				});
			}

			return false;
		});
	});

}( jQuery ));
