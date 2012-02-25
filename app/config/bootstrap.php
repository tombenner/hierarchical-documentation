<?php

MvcConfiguration::set(array(
	'Debug' => false
));

MvcConfiguration::append(array(
	'AdminPages' => array(
		'documentation_nodes' => array(
			'add',
			'delete',
			'edit',
			'tree'
		)
	)
));

add_action('mvc_admin_init', 'documentation_admin_init', 10, 1);

function documentation_admin_init($args) {
	extract($args);
	if ($controller == 'documentation_nodes') {
		if ($action == 'tree') {
			wp_enqueue_script('nest-sortable', mvc_js_url('hierarchical-documentation', 'nest_sortable.js'), array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), null, true);
		}
		if (in_array($action, array('add', 'edit'))) {
			wp_enqueue_script('preview-markdown', mvc_js_url('hierarchical-documentation', 'preview_markdown.js'), array('jquery'), null, true);
			wp_enqueue_style('edit-documentation', mvc_css_url('hierarchical-documentation', 'edit_documentation.css'));
		}
	}
}

add_action('mvc_public_init', 'documentation_public_init', 10, 1);

function documentation_public_init($args) {
	extract($args);
	if ($controller == 'documentation_nodes') {
		if (in_array($action, array('index', 'show', 'search'))) {
			wp_enqueue_script('public-documentation-tree', mvc_js_url('hierarchical-documentation', 'public_documentation_tree.js'), array('jquery'), null, true);
			wp_enqueue_style('public-documentation-tree', mvc_css_url('hierarchical-documentation', 'public_documentation.css'));
		}
	}
}

add_filter('mvc_page_title', 'documentation_page_title');

function documentation_page_title($args) {
	if ($_SERVER['REQUEST_URI'] == '/') {
		$args['title'] = 'Home |';
	} else {
		$args['title'] = str_replace('Documentation Nodes', 'Documentation', $args['title']);
	}
	return $args;
}

?>