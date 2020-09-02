<?php

/**
 * Server rendering for /blocks/examples/12-dynamic
 */
function render_sapphire_recipe($attributes, $content) {
	var_dump($attributes);
	echo 'dynamic stuff, but what is dynamic? the headings and Icons? - How to get user content 
	added by user?';

}

function register_sapphire_recipe() {

	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
  }
  
  // Register dynamic block.
	register_block_type( 'sapphire-blocks/recipe', array(
		'render_callback' => 'render_sapphire_recipe'
	) );

}
add_action( 'init', 'register_sapphire_recipe' );




