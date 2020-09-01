<?php

/**
 * Server rendering for /blocks/examples/12-dynamic
 */
function render_sapphire_recipe($attributes, $content) {
 print_r($content);
 echo 'hi';


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




