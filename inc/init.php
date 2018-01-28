<?php
/**
 * EDDUpSells basic init file.
 *
 * @package EDDUpSells
 * @author Shahbaz Ahmed <shahbazahmed9@hotmail.com>
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Restricted' );
}

if ( ! class_exists( 'EDDUpSells' ) ) {


	/**
	 * EDDUpSells basic class.
	 */
	class EDDUpSells
	{

		/**
		 * [__construct description]
		 */
		function __construct() {

			add_action( 'init', array( $this, 'init' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

			add_action( 'wp_head', array( $this, 'wp_head' ) );

			add_action( 'wp_footer', array( $this, 'wp_footer' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );

			add_action( 'add_meta_boxes', array( $this, 'metabox' ) );

			add_action( 'wp_ajax_eddupsells_ajax_action', array( $this, 'ajax' ) );
			add_action( 'wp_ajax_nopriv_eddupsells_ajax_action', array( $this, 'ajax' ) );

			add_action( 'edd_save_download', array( $this, 'save_edd' ) );

		}

		/**
		 * Basic init.
		 *
		 * @return void [description]
		 */
		function init() {
			load_plugin_textdomain( 'edd-upsells', false, EDDUPSELLS__PLUGIN_DIR . '/languages' );
		}

		/**
		 * [ajax description]
		 *
		 * @return [type] [description]
		 */
		function ajax() {

			$req = $_REQUEST;

			if ( ! isset( $req['subaction'] ) ) {
				return wp_send_json( array( 'items' ) );
			}

			$subaction = $req['subaction'];

			switch ( $subaction ) {
				case 'update_cart':
					edd_get_template_part( 'checkout_cart' );
					break;

				case 'upsells_products' :

					$search = isset( $req['q'] ) ? $req['q'] : '';

					if ( ! $search ) {
						return wp_send_json( array( 'items' ) );
					}

					$query = new WP_Query( array( 'post_type' => 'download', 's' => $search, 'posts_per_page' => -1 ) );

					$return = array();

					if ( $query->have_posts() ) {

						while ( $query->have_posts() ) {
							$query->the_post();

							$return[] = array( 'full_name' => get_the_title(), 'id' => get_the_id() );
						}
					}
					wp_reset_postdata();

					return wp_send_json( array( 'items' => $return ) );

					break;

			}

			exit;
		}

		/**
		 * [save_edd description]
		 *
		 * @param  integer $post_id [description].
		 * @param  [type]  $post    [description].
		 * @return void           [description]
		 */
		function save_edd( $post_id, $post = object ) {

			$data = $_POST;

			if ( isset( $data['edd_upsells'] ) ) {
				update_post_meta( $post_id, '_product_field_type_ids', $data['edd_upsells'] );
			}
		}
		/**
		 * [admin_enqueue description]
		 *
		 * @return void [description]
		 */
		function admin_enqueue() {

			global $post_type;

			if ( 'download' === $post_type ) {
				wp_enqueue_script( 'select2', EDDUPSELLS__PLUGIN_URL . 'assets/js/select2.full.min.js', array( 'jquery' ), '', true );
				wp_enqueue_script( 'eddupsells_js', EDDUPSELLS__PLUGIN_URL . 'assets/js/eddupsells.admin.js', array( 'select2' ), '', true );
				wp_enqueue_style( 'select2', EDDUPSELLS__PLUGIN_URL . 'assets/css/select2.min.css' );
			}
		}
		/**
		 * [metabox description]
		 *
		 * @return void [description]
		 */
		function metabox() {

			if ( ! function_exists( 'edd_get_label_singular' ) ) {
				return;
			}

			$post_types = apply_filters( 'edd_download_metabox_post_types' , array( 'download' ) );

			foreach ( $post_types as $post_type ) {

				/** Product Prices */
				add_meta_box( 'edd_product_upsells', sprintf( __( '%1$s Upsells', 'edd-upsells' ), edd_get_label_singular(), edd_get_label_plural() ),  array( $this, 'custom_fields' ), $post_type, 'normal', 'high' );

			}
		}

		/**
		 * Prints the output of the custom field in general tab
		 *
		 * @return  void [<description>]
		 */
		function custom_fields() {

			include EDDUPSELLS__PLUGIN_DIR . 'views/fields.php';
		}

		/**
		 * Enqueue the frontend scripts and styles.
		 *
		 * @return void [description]
		 */
		function enqueue() {

			if ( is_singular( 'download' ) ) {

				wp_enqueue_script( 'animatedModal', EDDUPSELLS__PLUGIN_URL . 'assets/js/animatedModal.min.js', array( 'jquery' ), '', true );
				wp_enqueue_script( 'eddupsells_js', EDDUPSELLS__PLUGIN_URL . 'assets/js/eddupsells.js', array( 'animatedModal' ), '', true );
				wp_enqueue_style( 'animate', EDDUPSELLS__PLUGIN_URL . 'assets/css/animate.min.css' );
				wp_enqueue_style( 'eddupsells_css', EDDUPSELLS__PLUGIN_URL . 'assets/css/eddupsells.css' );
			}
		}

		/**
		 * [wp_head description]
		 *
		 * @return void [description]
		 */
		function wp_head() {
		        $output = '<style>

		            /*use your style here */

		            </style>';

		    echo $output;
		}

		/**
		 * [wp_footer description]
		 *
		 * @return void [description]
		 */
		function wp_footer() {

			if ( is_singular( 'download' ) ) {
				include EDDUPSELLS__PLUGIN_DIR . 'views/footer-modal.php';
			}
		}

	}
}


new EDDUpSells;
