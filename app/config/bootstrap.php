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
			'tree',
			'export' => array(
				'parent_slug' => 'tools.php',
				'label' => 'Export Documentation'
			)
		)
	)
));

function current_documentation_version() {
	global $current_documentation_version;
	return $current_documentation_version;
}

function url_documentation_version_name() {
	global $url_documentation_version;
	if (isset($url_documentation_version->name)) {
		return $url_documentation_version->name;
	}
	return null;
}

function displayed_documentation_version() {
	global $current_documentation_version, $url_documentation_version;
	if (!empty($url_documentation_version)) {
		return $url_documentation_version;
	}
	if (isset($_GET['version_id'])) {
		$documentation_version_model = mvc_model('DocumentationVersion');
		$version = $documentation_version_model->find_by_id($_GET['version_id']);
		if (!empty($version)) {
			return $version;
		}
	}
	return $current_documentation_version;
}

add_filter('mvc_before_public_url', 'documentation_before_public_url');
function documentation_before_public_url($options) {
	if (!empty($options['object'])) {
		if ($options['object']->__model_name == 'DocumentationNode') {
			$options['local_id'] = $options['object']->local_id;
			if (!empty($options['documentation_version_name']) && $options['documentation_version_name'] == '__default__') {
				unset($options['documentation_version_name']);
			} else if (empty($options['documentation_version_name'])) {
				if (is_admin()) {
					if (!empty($options['object']->documentation_version->name)) {
						$options['documentation_version_name'] = $options['object']->documentation_version->name;
					}
				} else {
					$options['documentation_version_name'] = url_documentation_version_name();
				}
			}
		}
	}
	return $options;
}

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

add_action('plugins_loaded', 'download_export');
function download_export() {
	global $pagenow;
	if ($pagenow == 'tools.php' &&
			isset($_GET['page']) && $_GET['page']=='mvc_documentation_nodes-export' &&
			isset($_GET['action']) && $_GET['action'] == 'mvc_download_documentation_export') {
		header('Content-Type: text/plain');
		header('Content-Disposition: attachment; filename="documentation.sql"');
		global $wpdb;
		$prefix = $wpdb->prefix;
		$command = 'mysqldump -u'.DB_USER.' -p'.DB_PASSWORD.' -h'.DB_HOST.' '.DB_NAME.' '.$prefix.'documentation_nodes '.$prefix.'documentation_versions';
		system($command, $sql);
		echo $sql;
		die();
	}
}

?>