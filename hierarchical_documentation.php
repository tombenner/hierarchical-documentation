<?php
/*
Plugin Name: Hierarchical Documentation
Plugin URI: http://wordpress.org/extend/plugins/hierarchical-documentation/
Description: Lets admins create searchable, hierarchically-organized documentation. Supports Markdown and syntax highlighting for code. Requires WP MVC.
Author: Tom Benner
Version: 1.1
Author URI: 
*/

register_activation_hook(__FILE__, 'hierarchical_documentation_activate');
register_deactivation_hook(__FILE__, 'hierarchical_documentation_deactivate');

function hierarchical_documentation_activate() {
	require_once dirname(__FILE__).'/hierarchical_documentation_loader.php';
	$loader = new HierarchicalDocumentationLoader();
	$loader->activate();
}

function hierarchical_documentation_deactivate() {
	require_once dirname(__FILE__).'/hierarchical_documentation_loader.php';
	$loader = new HierarchicalDocumentationLoader();
	$loader->deactivate();
}

?>