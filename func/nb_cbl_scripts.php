<?php 


/*

 name: NB CBL ADMIN JS
 
 description: enqueue scripts hook for JavaScript Features on Materials CPTs
 
 params: $hook = the page that is being hooked, for example: post.php. 
 
 returns: Adds jquery action to metaboxes. 

*/
 

//ENQUE SCRIPTS  
function nb_cbl_admin_js( $hook ) {
	global $post_type;
	if( ( ( $hook == 'post.php' ) || ( $hook == 'post-new.php' ) ) && ( $post_type == 'nb_material' ) ){
		
	
		if ( is_admin() ) {
			wp_enqueue_script( 'jquery' );
			//adding scripts file in the footer
			wp_register_script( 'nb-cbl-admin-js', plugins_url( '/nb-cbl-admin.js', __FILE__ ) , array( 'jquery' ), false, true );
			wp_enqueue_script( 'nb-cbl-admin-js' );
			
			wp_enqueue_style('nb-cbl-admin-css',  plugins_url( '/nb-cbl-admin.css', __FILE__ ) );
		} 
		
	}
}

// connect to admin action hook for scripts. 
add_action('admin_enqueue_scripts', 'nb_cbl_admin_js', 1);

?>