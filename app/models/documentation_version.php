<?php

class DocumentationVersion extends MvcModel {

	var $display_field = 'name';
	var $has_many = array(
		'DocumentationNode' => array(
			'dependent' => true
		)
	);
	
	function after_create($object) {
		$documentation_node_model = mvc_model('DocumentationNode');
		$max_existing_documentation_version_id = $documentation_node_model->max('documentation_version_id');
		$documentation_nodes = $documentation_node_model->find(array(
			'conditions' => array(
				'documentation_version_id' => $max_existing_documentation_version_id
			)
		));
		foreach ($documentation_nodes as $documentation_node) {
			$node = $documentation_node->to_array();
			unset($node['id']);
			$node['documentation_version_id'] = $object->id;
			$documentation_node_model->create($node);
		}
	}
	
}

?>