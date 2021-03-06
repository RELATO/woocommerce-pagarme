<?php
/**
 * Credit Card - Checkout form.
 *
 * @author  Pagar.me
 * @package WooCommerce_Pagarme/Templates
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<fieldset id="pagarme-credit-cart-form-a-vista">
	<p class="form-row form-row-first">
		<label for="pagarme-card-a-vista-holder-name"><?php esc_html_e( 'Card Holder Name', 'woocommerce-pagarme' ); ?><span class="required">*</span></label>
		<input id="pagarme-card-a-vista-holder-name" class="input-text" type="text" autocomplete="off" style="font-size: 1.5em; padding: 8px;" />
	</p>
	<p class="form-row form-row-last">
		<label for="pagarme-card-a-vista-number"><?php esc_html_e( 'Card Number', 'woocommerce-pagarme' ); ?> <span class="required">*</span></label>
		<input id="pagarme-card-a-vista-number" class="input-text wc-credit-card-form-card-number" type="text" maxlength="20" autocomplete="off" placeholder="&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull;" style="font-size: 1.5em; padding: 8px;" />
	</p>
	<div class="clear"></div>
	<p class="form-row form-row-first">
		<label for="pagarme-card-a-vista-expiry"><?php esc_html_e( 'Expiry (MM/YY)', 'woocommerce-pagarme' ); ?> <span class="required">*</span></label>
		<input id="pagarme-card-a-vista-expiry" class="input-text wc-credit-card-form-card-expiry" type="text" autocomplete="off" placeholder="<?php esc_html_e( 'MM / YY', 'woocommerce-pagarme' ); ?>" style="font-size: 1.5em; padding: 8px;" />
	</p>
	<p class="form-row form-row-last">
		<label for="pagarme-card-a-vista-cvc"><?php esc_html_e( 'Card Code', 'woocommerce-pagarme' ); ?> <span class="required">*</span></label>
		<input id="pagarme-card-a-vista-cvc" class="input-text wc-credit-card-form-card-cvc" type="text" autocomplete="off" placeholder="<?php esc_html_e( 'CVC', 'woocommerce-pagarme' ); ?>" style="font-size: 1.5em; padding: 8px;" />
	</p>
	<div class="clear"></div>
	<?php if ( apply_filters( 'wc_pagarme_allow_credit_card_installments', 1 < $max_installment ) ) : ?>
		<p class="form-row form-row-wide">
			<label for="pagarme-card-a-vista-installments"><?php esc_html_e( 'Installments', 'woocommerce-pagarme' ); ?> <span class="required">*</span></label>
			<select name="pagarme-a-vista-installments" id="pagarme-a-vista-installments" style="font-size: 1.5em; padding: 8px; width: 100%;">
				<option value="0"><?php printf( esc_html__( 'Please, select the number of installments', 'woocommerce-pagarme' ) ); ?></option>
				<?php
				foreach ( $installments as $number => $installment ) :
					if ( 1 !== $number && $smallest_installment > $installment['installment_amount'] ) {
						break;
					}

					$interest           = ( ( $cart_total * 100 ) < $installment['amount'] ) ? sprintf( __( '(total of %s)', 'woocommerce-pagarme' ), strip_tags( wc_price( $installment['amount'] / 100 ) ) ) : __( '(interest-free)', 'woocommerce-pagarme' );
					$installment_amount = strip_tags( wc_price( $installment['installment_amount'] / 100 ) );
					?>
				<option value="<?php echo absint( $installment['installment'] ); ?>"><?php printf( esc_html__( '%1$dx of %2$s %3$s', 'woocommerce-pagarme' ), absint( $installment['installment'] ), esc_html( $installment_amount ), esc_html( $interest ) ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
	<?php endif; ?>
</fieldset>
