<?php

/*--------------------------------------------------*/
/* Simple Sidebar Manager > get simple sidebar
/*--------------------------------------------------*/

if ( !function_exists('get_simple_sidebar') ) {

	function get_simple_sidebar() {

		global $wp_query;
		$postId = $wp_query->get_queried_object_id();

		$sidebar_position = get_post_meta( $postId, 'ssm_sidebar_position', true );
		$sidebar_id = get_post_meta( $postId, 'ssm_sidebar', true );

		$sidebar = array(
			'position' => $sidebar_position,
			'id' => $sidebar_id
		);

		return $sidebar;

	}

}
