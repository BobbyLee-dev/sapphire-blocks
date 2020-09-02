<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
include __DIR__ . '/blocks/recipe/recipe.php';

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function sapphire_blocks_block_assets() { // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_register_style(
		'sapphire_blocks-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		is_admin() ? array( 'wp-editor' ) : null, // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'sapphire_blocks-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', ), // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'sapphire_blocks-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `sapphireBlocksGlobal` object.
	wp_localize_script(
		'sapphire_blocks-block-js',
		'sapphireBlocksGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `sapphireBlocksGlobal` object.
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 * 
	 * Not sure if each block needs this because all block will
	 * point to same build files? But did it for good measure.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	// Array of block created in this plugin.
	$blocks = [
		'sapphire-blocks/test-block',
		'sapphire-blocks/test-block2',
		// 'sapphire-blocks/recipe',
	];
	
	// Loop through $blocks and register each block with the same script and styles.
	foreach( $blocks as $block ) {
		register_block_type( $block, array(
			'style'         => 'sapphire_blocks-style-css',					// Calls registered script above
			'editor_script' => 'sapphire_blocks-block-js',					// Calls registered stylesheet above
			'editor_style'  => 'sapphire_blocks-block-editor-css',  // Calls registered stylesheet above
		) );	  
	}

	// Dynamic setup start+++++++++++++++++
	
	// Include dynamic block php callback
	// include __DIR__ . '/blocks/recipe/recipe.php';

	// // Register dynamic block.
	// register_block_type( 'sapphire-blocks/recipe', array(
	// 	'style'         	=> 'sapphire_blocks-style-css',					// Calls registered script above
	// 	'editor_script' 	=> 'sapphire_blocks-block-js',					// Calls registered stylesheet above
	// 	'editor_style'  	=> 'sapphire_blocks-block-editor-css',  // Calls registered stylesheet above
	// 	'render_callback' => 'render_sapphire_recipe'
	// ) );
	// // Dynamic setup End +++++++++++++++++



}

// Hook: Block assets.
add_action( 'init', 'sapphire_blocks_block_assets' );




/** 
 * Add custom "Sapphire Blocks" block category
 * 
 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/filters/block-filters/#managing-block-categories
 */

function sapphire_blocks_block_categories( $categories, $post ) {

	// if ( $post->post_type !== 'post' ) {
	// 	return $categories;
	// }
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'sapphire-blocks',
				'title' => __( 'Sapphire Blocks', 'sapphire-blocks' ),
				'icon'  => 'smiley',
			),
		)
	);
}

add_filter( 'block_categories', 'sapphire_blocks_block_categories', 10, 2 );
