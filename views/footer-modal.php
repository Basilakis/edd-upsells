<?php
/**
 * Checkout page footer modal output
 *
 * @package EDDUpSells
 * @author Shahbaz Ahmed <shahbazahmed9@hotmail.com>
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Restricted' );
} ?>

<a href="#animatedModal" id="open_animiatedModal" style="display: none;"></a>
<!--DEMO01-->
<div id="animatedModal">

	<!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
	<div class="close-animatedModal"> 
	    CLOSE MODAL
	</div>
	    
	<div class="modal-content woocommerce">

		<div class="container site-inner">

			<div class="content-area col-md-6">
				<?php $ids = get_post_meta( get_the_id(), '_product_field_type_ids', true );?>

				<?php if ( $ids ) :

					$query = new WP_Query( array( 'post_type' => 'download', 'post__in' => $ids, 'posts_per_page' => -1 ) ); ?>
					
					<ul class="products">

						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						
							<?php $file = locate_template( 'edd_templates/content-download.php' );

							if ( file_exists( $file ) ) {
								get_template_part( 'edd_templates/content', 'download' );
							} else {
								include EDDUPSELLS__PLUGIN_DIR . 'views/content-download.php';
							} ?>

						<?php endwhile; ?>
					
					</ul>

					<?php wp_reset_postdata();
				endif; ?>
			</div>

			<aside class="sidebar col-md-4">
				<?php edd_get_template_part( 'checkout_cart' ); ?>
			</aside>

		</div>
	</div>

</div>

