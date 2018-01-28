<?php
/**
 * Output the custom Easy Digital Download fields.
 *
 * @package EDDUpSells
 * @author Shahbaz Ahmed <shahbazahmed9@hotmail.com>
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Restricted' );
}

global $post; ?>


<p class="form-field product_field_type">
	

	<label for="product_field_type"><?php esc_html_e( 'UpSell Products on Checkout Page', 'edd-upsells' ); ?></label>

	<?php wp_nonce_field( 'eddupsells_nonce_field_action', 'eddupsells_nonce_field' ); ?>

	<?php $product_field_type_ids = get_post_meta( $post->ID, '_product_field_type_ids', true );

	if ( $product_field_type_ids ) {

		$new_ids_data = '';
		foreach ( $product_field_type_ids as $value ) {
			$new_ids_data .= '<option value="'.esc_attr( $value ).'" selected="selected">'.esc_attr( get_the_title( $value ) ).'</option>';
		}
	} else {
		$new_ids_data = '';
	}?>

	<select class="js-data-example-ajax" name="edd_upsells[]" multiple="multiple">
		<?php echo  $new_ids_data; ?>
	</select>

	<span class="woocommerce-help-tip" data-tip="<?php esc_html_e( 'Up-sells are products which you recommend instead of the currently viewed product, for example, products that are more profitable or better quality or more expensive.', 'eddupsells' ); ?>"></span>	

</p>
