<?php

class HierarchicalDocumentationLoader extends MvcPluginLoader {

	var $db_version = '1.1';
	
	function init() {
	
		$this->tables = array(
			'documentation_nodes' => $this->wpdb->prefix.'documentation_nodes',
			'documentation_versions' => $this->wpdb->prefix.'documentation_versions'
		);
	
	}

	function activate() {
		
		$this->activate_app(__FILE__);
		
		require_once ABSPATH.'wp-admin/includes/upgrade.php';
		
		add_option('hierarchical_documentation_db_version', $this->db_version);
		
		$sql = '
			CREATE TABLE '.$this->tables['documentation_nodes'].' (
			  id int(11) NOT NULL auto_increment,
			  documentation_version_id int(11) default NULL,
			  local_id int(11) default NULL,
			  parent_id int(11) default NULL,
			  depth int(4) default NULL,
			  lft int(11) default NULL,
			  rght int(11) default NULL,
			  slug varchar(255) default NULL,
			  title varchar(255) default NULL,
			  content text default NULL,
			  PRIMARY KEY  (id),
			  KEY documentation_version_id (documentation_version_id),
			  KEY local_id (local_id),
			  KEY parent_id (parent_id),
			  KEY lft (lft),
			  KEY rght (rght)
			);';
		dbDelta($sql);
	
		$sql = '
			CREATE TABLE '.$this->tables['documentation_versions'].' (
			  id int(11) NOT NULL auto_increment,
			  name varchar(255) default NULL,
			  PRIMARY KEY  (id)
			);';
		dbDelta($sql);
		
		$sql = '
			SELECT
				id
			FROM
				'.$this->tables['documentation_versions'].'
			LIMIT
				1';
		$existing_version_id = $this->wpdb->get_var($sql);
		if (!$existing_version_id) {
			$sql = '
				INSERT INTO
					'.$this->tables['documentation_versions'].'
				(
					id,
					name
				) VALUES (
					1,
					"1.0"
				)';
			$this->wpdb->query($sql);
		}
		
	}

	function deactivate() {
		
		$this->deactivate_app(__FILE__);
	
	}

}

?>