<?php 


/*

 name: NB CBL CPT (new beginnings childbirth library custom post types)
 
 description: Sets up CPT's for use in the library
 
 params: n/a
 
 returns: called by the 'init' action hook. 

*/

function nb_cbl_cpt() {
	
	
	/*
		Materials CPT
	 */ 

	$nb_material_labels = array(
		'name' => _x('Materials', 'post type general name', 'nb-childbirthlibrary'),
		'singular_name' => _x('Material', 'post type singular name', 'nb-childbirthlibrary'),
		'add_new' => _x('New Material', 'material', 'nb-childbirthlibrary'),
		'add_new_item' => __('Add New Material', 'nb-childbirthlibrary'),
		'edit_item' => __('Edit Material', 'nb-childbirthlibrary'),
		'new_item' => __('New Material', 'nb-childbirthlibrary'),
		'all_items' => __('All Materials', 'nb-childbirthlibrary'),
		'view_item' => __('View Material', 'nb-childbirthlibrary'),
		'search_items' => __('Search Materials', 'nb-childbirthlibrary'),
		'not_found' =>  __('No materials found', 'nb-childbirthlibrary'),
		'not_found_in_trash' => __('No materials found in Trash', 'nb-childbirthlibrary'), 
		'parent_item_colon' => '',
		'menu_name' => __('Catalog', 'nb-childbirthlibrary')
	);

	$nb_material_args = array(
		'labels' => $nb_material_labels,
		'description' => 'childbirth library resources and materials',
		'public' => true ,
		'publicly_queryable' => true,
		'query_var' => true,
		'show_ui' => true,
		'has_archive' => true, 
		'hierarchical' => true,
		'menu_position' => 52,
		'menu_icon' => 'dashicons-book-alt',
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt',  'page-attributes', 'revisions', 'comments' ),  
		'taxonomies' => array( 'mat_cats', 'mat_tags', 'mat_writers' ),
		'capabilities' => array(
			'publish_posts' => 'publish_materials',
			'edit_posts' => 'edit_materials',
			'edit_others_posts' => 'edit_others_materials',
			'delete_posts' => 'delete_materials',
			'delete_others_posts' => 'delete_others_materials',
			'read_private_posts' => 'read_private_materials',
			'edit_post' => 'edit_material',
			'delete_post' => 'delete_material',
			'read_post' => 'read_material',
			'read' => 'read_materials',
			'edit_private_posts' => 'edit_private_materials',
			'edit_published_posts' => 'edit_published_materials',
			'delete_published_posts' => 'delete_published_materials',
			'delete_private_posts' => 'delete_private_materials'
		), 
		'map_meta_cap'=> true, 
		'rewrite' => array( 'slug' => 'materials' )
	); 

	register_post_type('nb_material', $nb_material_args);
	
	
	/*
		Course CPT
	*/ 
	
	
	$nb_course_labels = array(
		'name' => _x('Course', 'post type general name', 'doula-course'),
		'singular_name' => _x('Course', 'post type singular name', 'doula-course'),
		'add_new' => _x('Add New', 'course', 'doula-course'),
		'add_new_item' => __('Add New Section', 'doula-course'),
		'edit_item' => __('Edit Section', 'doula-course'),
		'new_item' => __('New Section', 'doula-course'),
		'all_items' => __('All Sections', 'doula-course'),
		'view_item' => __('View Section', 'doula-course'),
		'search_items' => __('Search Sections', 'doula-course'),
		'not_found' =>  __('No sections found', 'doula-course'),
		'not_found_in_trash' => __('No sections found in Trash', 'doula-course'), 
		'parent_item_colon' => '',
		'menu_name' => __('Course', 'doula-course')
	);

	$nb_course_args = array(
		'labels' => $nb_course_labels,
		'description' => 'comprehensive classes in childbirth support',
		'public' => true ,
		'publicly_queryable' => true,
		'query_var' => true,
		'show_ui' => true,
		'has_archive' => true, 
		'hierarchical' => true,
		'menu_position' => 53,
		'menu_icon' => 'dashicons-welcome-learn-more',
		'supports' => array( 'title', 'editor', 'page-attributes', 'revisions', 'comments' ),  
		'capabilities' => array(
			'publish_posts' => 'publish_courses',
			'edit_posts' => 'edit_courses',
			'edit_others_posts' => 'edit_others_courses',
			'delete_posts' => 'delete_courses',
			'delete_others_posts' => 'delete_others_courses',
			'read_private_posts' => 'read_private_courses',
			'edit_post' => 'edit_course',
			'delete_post' => 'delete_course',
			'read_post' => 'read_course',
			'read' => 'read_courses',
			'edit_private_posts' => 'edit_private_courses',
			'edit_published_posts' => 'edit_published_courses',
			'delete_published_posts' => 'delete_published_courses',
			'delete_private_posts' => 'delete_private_courses'
		), 
		'map_meta_cap'=> true, 
		'rewrite' => array( 'slug' => 'courses' )
	); 

	register_post_type('course', $nb_course_args); 	 
	
	
}


/*

 name: NB CBL TAX (new beginnings childbirth library taxonomies)
 
 description: Taxonomies associcated with library materials. 
 
 params: n/a
 
 returns: called by the 'init' action hook. 

*/

// create two taxonomies, genres and writers for the post type "book"
function nb_cbl_tax() {
	
	
	// Add new category taxonomy sepecific for library materials,  hierarchical
	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name', 'nb-childbirthlibrary' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'nb-childbirthlibrary' ),
		'search_items'      => __( 'Search Categories', 'nb-childbirthlibrary' ),
		'all_items'         => __( 'All Categories', 'nb-childbirthlibrary' ),
		'parent_item'       => __( 'Parent Category', 'nb-childbirthlibrary' ),
		'parent_item_colon' => __( 'Parent Category:', 'nb-childbirthlibrary' ),
		'edit_item'         => __( 'Edit Category', 'nb-childbirthlibrary' ),
		'update_item'       => __( 'Update Category', 'nb-childbirthlibrary' ),
		'add_new_item'      => __( 'Add New Category', 'nb-childbirthlibrary' ),
		'new_item_name'     => __( 'New Category Name', 'nb-childbirthlibrary' ),
		'menu_name'         => __( 'Category', 'nb-childbirthlibrary' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'section' ),
	);

	register_taxonomy( 'mat_cats', 'nb_material', $args );
	
	

	// Add new tags taxonomy specific for library material, NOT hierarchical
	$labels = array(
		'name'                       => _x( 'Tags', 'taxonomy general name', 'nb-childbirthlibrary' ),
		'singular_name'              => _x( 'Tag', 'taxonomy singular name', 'nb-childbirthlibrary' ),
		'search_items'               => __( 'Search Tags', 'nb-childbirthlibrary' ),
		'popular_items'              => __( 'Popular Tags', 'nb-childbirthlibrary' ),
		'all_items'                  => __( 'All Tags', 'nb-childbirthlibrary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Tag', 'nb-childbirthlibrary' ),
		'update_item'                => __( 'Update Tag', 'nb-childbirthlibrary' ),
		'add_new_item'               => __( 'Add New Tag', 'nb-childbirthlibrary' ),
		'new_item_name'              => __( 'New Tag Name', 'nb-childbirthlibrary' ),
		'separate_items_with_commas' => __( 'Separate tags with commas', 'nb-childbirthlibrary' ),
		'add_or_remove_items'        => __( 'Add or remove tags', 'nb-childbirthlibrary' ),
		'choose_from_most_used'      => __( 'Choose from the most used tags', 'nb-childbirthlibrary' ),
		'not_found'                  => __( 'No tags found.', 'nb-childbirthlibrary' ),
		'menu_name'                  => __( 'Tags', 'nb-childbirthlibrary' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'topic' ),
	);

	register_taxonomy( 'mat_tags', 'nb_material', $args );

	
	
	// Add new writers taxonomy, NOT hierarchical
	$labels = array(
		'name'                       => _x( 'Writers', 'taxonomy general name', 'nb-childbirthlibrary' ),
		'singular_name'              => _x( 'Writer', 'taxonomy singular name', 'nb-childbirthlibrary' ),
		'search_items'               => __( 'Search Writers', 'nb-childbirthlibrary' ),
		'popular_items'              => __( 'Popular Writers', 'nb-childbirthlibrary' ),
		'all_items'                  => __( 'All Writers', 'nb-childbirthlibrary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Writer', 'nb-childbirthlibrary' ),
		'update_item'                => __( 'Update Writer', 'nb-childbirthlibrary' ),
		'add_new_item'               => __( 'Add New Writer', 'nb-childbirthlibrary' ),
		'new_item_name'              => __( 'New Writer Name', 'nb-childbirthlibrary' ),
		'separate_items_with_commas' => __( 'Separate writers with commas', 'nb-childbirthlibrary' ),
		'add_or_remove_items'        => __( 'Add or remove writers', 'nb-childbirthlibrary' ),
		'choose_from_most_used'      => __( 'Choose from the most used writers', 'nb-childbirthlibrary' ),
		'not_found'                  => __( 'No writers found.', 'nb-childbirthlibrary' ),
		'menu_name'                  => __( 'Writers', 'nb-childbirthlibrary' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'writer' ),
	);

	register_taxonomy( 'mat_writers', 'nb_material', $args );
	
}



add_action( 'init', 'nb_cbl_cpt', 10 ); //Add Custom Post Types

add_action( 'init', 'nb_cbl_tax', 10 ); //Add Taxonomies for CPT

function my_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    nb_cbl_cpt();
    nb_cbl_tax();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'my_rewrite_flush' );

?>