<?php
/*
Plugin Name: NB Childbirth Library
Plugin URI: https://www.childbirthlibrary.org/
Description: Plugin for Childbirth Library, site specific features and functionality
Version: 1.0
Author: Brent Leavitt
Author URI: https://www.trainingdoulas.com/
License: GPLv2

*/

$nb_vars = array(
	
	'remote_post' => false,
	'post_slug' => ''
	
);

//Add Custom Post Types. 
include_once('func/nb_cbl_cpt.php'); 

//Add User Access Scripts 
include_once('func/nb_cbl_access.php'); 

//Add Custom Meta Boxes.
include_once('func/nb_cbl_meta_box.php');

//Add URL Parsing functionality. 
include_once('func/nb_cbl_parser.php');

//Add styles and script.
include_once('func/nb_cbl_scripts.php');




add_filter( 'wp_mail_from', function( $name ) {
	return 'rachel@childbirthlibrary.org';
});

add_filter( 'wp_mail_from_name', function( $name ) {
	return 'Test at New Beginnings';
});



?>