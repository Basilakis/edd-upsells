<?php
/**
 * Downloads loop
 *
 * @package EDD UpSells
 * @author Shahbaz Ahmed <shahbazahmed9@hotmail.com>
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Restricted' );
} ?>



				
				
<li <?php post_class(); ?>>
	
	<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link">

		<?php the_post_thumbnail( 'thumbnail', array( 'img-response' ) ); ?>
		
		<h3><?php the_title(); ?></h3>
		
		<?php edd_get_template_part( 'shortcode-content', 'price' ); ?>
	</a>

	<div class="edd_download_buy_button">
		<?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
	</div>
</li>

				
				
