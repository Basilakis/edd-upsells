<?php
/*
Plugin Name: EDDUpsells
Plugin URI: http://creativeg.gr
Description: Easy Digital Downloads Upsells is a plugin to show upsells downloads on add to cart event
Version: 1.0.0
Author: Basilis Kanonidis
Author URI: http://creativeg.gr
Text Domain: eddupsells
*/

// Make sure we don't expose any info if called directly.
if ( ! defined( 'ABSPATH' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'EDDUPSELLS_VERSION', '1.0.0' );
define( 'EDDUPSELLS__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'EDDUPSELLS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once EDDUPSELLS__PLUGIN_DIR . 'inc/init.php';
