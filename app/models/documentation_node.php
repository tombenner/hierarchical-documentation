<?php

class DocumentationNode extends MvcModel {

	var $display_field = 'title';
	var $order = 'lft';
	var $belongs_to = array('DocumentationVersion');
	
	function to_url($object, $options=array()) {
		$slug = $object->title;
		$slug = preg_replace('/[^\w]/', '-', $slug);
		$slug = preg_replace('/[-]+/', '-', $slug);
		$slug = strtolower($slug);
		$slug = trim($slug, '-');
		$path = 'documentation/';
		if (!empty($options['documentation_version_name'])) {
			$path .= $options['documentation_version_name'].'/';
		}
		$path .= $object->local_id.'/'.$slug.'/';
		return $path;
	}
	
	function admin_version_id() {
		return mvc_setting('DocumentationSettings', 'admin_version_id');
	}
	
	function public_version_id() {
		return mvc_setting('DocumentationSettings', 'public_version_id');
	}
	
	function next_local_id() {
		$max_local_id = $this->max('local_id', array('conditions' => array('documentation_version_id' => $this->admin_version_id())));
		if (empty($max_local_id)) {
			$max_local_id = 0;
		}
		return $max_local_id + 1;
	}
	
	function first_node($documentation_version_id=null) {
		if (!$documentation_version_id) {
			$documentation_version_id = $this->public_version_id();
		}
		$node = $this->find_one(array(
			'conditions' => array('documentation_version_id' => 1),
			'order' => 'lft'
		));
		return $node;
	}
	
}

?>