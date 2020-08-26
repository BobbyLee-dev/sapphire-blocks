<?php
/**
 * Plugin Name: Sapphire Blocks
 * Plugin URI: 
 * Description: Custom Gutenberg Blocks.
 * Author: Bobby Lee
 * Author URI: https://therunningcoder.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Load translations (if any) for the plugin from the /languages/ folder.
 * 
 * @link https://developer.wordpress.org/reference/functions/load_plugin_textdomain/
 */
function sapphire_blocks_load_textdomain() {
	load_plugin_textdomain( 'sapphire_blocks', false, basename( __DIR__ ) . '/languages' );
}

add_action( 'init', 'sapphire_blocks_load_textdomain' );




/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';
