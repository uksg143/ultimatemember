<?php

class UM_Uninstall {

	function __construct() {

	}
	
	/***
	***	@remove UM
	***/
	function remove_um() {
		global $ultimatemember;
		
		foreach( wp_load_alloptions() as $k => $v ) {
		
			if ( substr( $k, 0, 3 ) == 'um_' || substr( $k, 0, 3 ) == 'UM_' ) {
				
				if ( $k == 'um_core_forms' || $k == 'um_core_pages' || $k == 'um_core_directories' ) {
					$v = unserialize( $v );
					foreach( $v as $post_id ) {
						wp_delete_post( $post_id, 1 );
					}
				}
				
				delete_option( $k );
				
			}
			
		}
		
		$roles = get_posts( array( 'post_type' => 'um_role', 'number' => 999 ) );
		foreach( $roles as $role ) {
			wp_delete_post( $role->ID, 1 );
		}

		if ( is_plugin_active( um_plugin ) ) {
			deactivate_plugins( um_plugin );
		}
		
		exit( wp_redirect( admin_url('plugins.php') ) );

	}

}