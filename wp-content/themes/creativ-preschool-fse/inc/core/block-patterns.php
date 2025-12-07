<?php
/**
 * Block Patterns
 *
 * @since 1.0.0
 */

/**
 * Registers pattern categories for Creativ Preschool FSE
 *
 * @since 1.0.0
 *
 * @return void
 */
function creativ_preschool_fse_register_pattern_category() {
	$block_pattern_categories = array(
		'theme' => array( 'label' => __( 'Theme Patterns', 'creativ-preschool-fse' ) ),
	);

	$block_pattern_categories = apply_filters( 'creativ_preschool_fse_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_pattern_category
		}		
	}
}
add_action( 'init', 'creativ_preschool_fse_register_pattern_category', 9 );


