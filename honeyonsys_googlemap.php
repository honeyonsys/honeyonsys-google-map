<?php
/* 
Plugin Name: Honeyonsys Google Map
Plugin URI: http://honeyonsys.github.io/wordpressplugins/hgm/
Description: This plugin is to display the google map on your wordpress blog/page. You can show single/multiple markers on the map and also can style the map.
Version: 1.0 
Author: honeyonsys
Author URI: http://honeyonsys.github.io
License: GPL2


Honeyonsys Google Map is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Honeyonsys Google Map is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Honeyonsys Google Map. If not, see {License URI}.
*/ 

$siteurl = get_option('siteurl');
define('HGM_FOLDER', dirname(plugin_basename(__FILE__)));
define('HGM_URL', $siteurl.'/wp-content/plugins/' . HGM_FOLDER);
define('HGM_FILE_PATH', dirname(__FILE__));
define('HGM_DIR_NAME', basename(HGM_FILE_PATH));

global $wpdb;

function activate_hgm_plugin(){
	if(get_option('hgm_location')==FALSE){
		$locations_data = array(array("honeyonsys",30.8995432,75.931709, "Web Developer<br>website: http://honeyonsys.github.io"));
		add_option('hgm_location', $locations_data, '', 'yes' );	
	}
	
	if(get_option('hgm_center_lat')==FALSE){
		add_option('hgm_center_lat', '30.8995432', '', 'yes' );	
	}
	
	if(get_option('hgm_center_lon')==FALSE){
		add_option('hgm_center_lon', '75.931709', '', 'yes' );	
	}
	
	if(get_option('hgm_zoom')==FALSE){
		add_option('hgm_zoom', '10', '', 'yes' );	
	}
	
	if(get_option('hgm_width')==FALSE){
		add_option('hgm_width','100%');	
	}
	
	if(get_option('hgm_height')==FALSE){
		add_option('hgm_height','400px');	
	}
	
}
register_activation_hook( __FILE__, 'activate_hgm_plugin' );

function uninstall_hgm_plugin(){
	delete_option( 'hgm_location' );
	delete_option( 'hgm_center_lat' );
	delete_option( 'hgm_center_lon' );
	delete_option( 'hgm_zoom' );
	delete_option('hgm_width');
	delete_option('hgm_height');
}

register_uninstall_hook( __FILE__, 'uninstall_hgm_plugin' );


add_action( 'admin_enqueue_scripts', 'load_hgm_admin_style' );
function load_hgm_admin_style() {

	wp_enqueue_style( 'admin_css', HGM_URL.'/css/hgm_admin_style.css', false, '1.0.0' );
}

include('inc/hgm_functions.php');
add_shortcode('show_map_locations','map_with_locations');
add_action('admin_menu', 'hgm_menu');
function hgm_menu(){
	add_menu_page('Honeyonsys Google Map', 'HGM Settings', 'manage_options', 'hgm-top-level-handle', 'hgm_admin_form',HGM_URL.'/images/logo-small.png','6');
	
}

