<?php 

/*

 filename: NB_CBL_PARSER.PHP
 description: This parses the URLS for the classes/courses Material Post Type. 

*/
 
 /** FOR DEBUGGING **/
 
//add_filter('posts_request','debug_post_request'); // debugging sql query of a post

function debug_post_request($sql_text) {
	global $wp_query, $nb_vars; 
	
   $GLOBALS['debugku'] = $sql_text; //intercept and store the sql<br/>
  if( $nb_vars[ 'remote_post' ]  && $wp_query->is_main_query() ){
	  print_r($GLOBALS['debugku']); 
  }
	

}
 
 
 function wpd_request_filter( $request ){
   //echo "Testing the request that is being sent: <br />";
	
	$post_type = 'nb_material';
	$new_post_type = 'course';
	
	if( strpos( $request[ 'post_type' ], $post_type ) === 0 ){
		
		$request[ 'post_type' ] = $new_post_type; 
		
		$request[ $new_post_type ] = $request[ $post_type ];
		unset( $request[ $post_type ] );
		$post_name = $request[ 'name' ]; 
		$request[ 'name' ] = substr($post_name, strrpos($post_name, '/') + 1);
		
		//print_pre( $request );
		
	}

    return $request;
}
//add_filter( 'request', 'wpd_request_filter' );
 
 
/*
	NAME: 
	
	DESCRIPTION: 
	
	PARAMS: 
	
	RETURNS: 

*/


function nb_cbl_parser( ) {
	
	global $wp_query, $nb_vars;
	
	
/* 	if( ( $wp_query->is_404 ) && ( !empty( $wp_query->query['nb_material'] ) ) ){
		
		status_header( 200 );
		//$wp_query->is_single = true;
		$wp_query->is_404=false; 
		
		$nb_vars[ 'remote_post' ] = true;
		$nb_vars[ 'post_slug' ] = $wp_query->query_vars['name'];
		

	} */
	
	
	
	
	
	
}

//add_action( 'wp', 'nb_cbl_parser' );


/*
	NAME: nb_cbl_materials_tempalte
	
	DESCRIPTION: Redirects to the materials template if we're loading remote content. Provides function for 'template_include' action hook.
	
	PARAMS: $template (required)
	
	RETURNS: template to be loaded. 

*/

function nb_cbl_materials_tempalte( $template ) {

	global $nb_vars;
	
	if ( $nb_vars[ 'remote_post' ]  ) {
		$new_template = locate_template( array( 'single-nb_material.php' ) );
		if ( '' != $new_template ) {
			return $new_template;
		}
	}

	return $template;
}

add_filter( 'template_include', 'nb_cbl_materials_tempalte', 99 );



/*
	NAME: nb_cbl_blog_switch
	
	DESCRIPTION: 
	
	PARAMS: 
	
	RETURNS: 

*/

function nb_cbl_blog_switch( $query ){
		
		global $nb_vars; 
		
		if( ( $query->is_single ) && ( !empty( $query->query['nb_material'] ) ) ){
			
			
			status_header( 200 );
			$query->is_404=false; 
			
			$nb_vars[ 'remote_post' ] = true;
			$nb_vars[ 'post_slug' ] =  $query->query[ 'name' ];
			
		} 
		
		
		
		
		if( $nb_vars[ 'remote_post' ] && $query->is_main_query()  ){
			
			switch_to_blog( 6 );			
			
			print_pre( $query );
			
			
		}
	
}



/*
	NAME: nb_cbl_end_blog_switch
	
	DESCRIPTION: 
	
	PARAMS: 
	
	RETURNS: 

*/

function nb_cbl_end_blog_switch( $test ){
		
		global $nb_vars, $wp_query, $post; 
		
		
		if( $nb_vars[ 'remote_post' ] && $wp_query->is_main_query()  ){
			
			print_pre( $post );
			
			restore_current_blog();
			
			$nb_vars[ 'remote_post' ] = false; 
			echo "Called from the End BLOG SWITCH";
		}
		
		
}

//add_filter( 'wp', 'nb_cbl_end_blog_switch' );



/*
	NAME: nb_cbl_content_from_blog
	
	DESCRIPTION: Pulls content from other blog for use in requesting blog
	
	PARAMS: $blog_id (required) , 
			$local_post_type (optional) default is 'post'  , 
			$remote_post_type (optional) default is 'post'  , 
			$slug (optional) default is  empty.
	
	RETURNS: Reset the $POST with current info from remote site. Also returns Children (array). 

*/



function nb_cbl_content_from_blog( $blog_id, $local_post_type = 'post' , $remote_post_type = 'post' , $slug = '' ){
	
	global $wp_query;

	//echo "THe value of SLUG is: {$slug}"; 
	$post_slug = ( empty( $slug ) )? $post->post_name : $slug ;
		
	$post_type_data = get_post_type_object( $local_post_type );
	
	
    $local_pt_slug = $post_type_data->rewrite['slug'];


	 
	$post_args = array(
		'post_type' => $remote_post_type,
		'name' => $post_slug 
	); 
	

	//Retrieve urls for children of current pages. 
	$child_args = array(
		'post_parent' => $post->ID,
		'post_type' => $remote_post_type,
		'post_status' => 'published'
		
	);
	
	$links_arr = [];
	
	$parent_slug = $post->post_name;
	
	$children = get_children( $child_args );
	
	$url_separator = '/';
	
	
	
	foreach( $children  as $c_id => $c_obj ){
		
		$links_arr[ $c_id ]['name'] = $c_obj->post_title;
		$links_arr[ $c_id ]['url'] = "{$parent_slug}{$url_separator}{$c_obj->post_name}{$url_separator}";
		$perma = get_permalink( $c_id );
		//echo "The Permalink for Child#{$c_id} is : {$perma}. <br />";
		
		$ancestors = get_post_ancestors( $post );
		
		//print_pre( $ancestors );
		
		$slug = get_post_field( 'post_name', $c_id );
		
		$links_arr[ $c_id ]['url'] = get_home_url( 1, $url_separator . $local_pt_slug . $url_separator . 'classes' . $url_separator . $links_arr[ $c_id ]['url'] );
		
	}
	
	return ( !empty( $links_arr ) )? $links_arr : false;
	
}

?>