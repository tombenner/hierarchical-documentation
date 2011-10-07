<?php

class DocumentationNode extends MvcModel {

	var $display_field = 'title';
	var $order = 'lft';
	
	var $admin_columns = array(
		'id',
		'title'
	);
	var $admin_pages = array(
		'add',
		'delete',
		'edit',
		'tree'
	);
	var $admin_searchable_fields = array(
		'title',
		'content'
	);
	var $public_searchable_fields = array(
		'title',
		'content'
	);
	
	function to_url($object) {
		$slug = $object->title;
		$slug = preg_replace('/[^\w]/', '-', $slug);
		$slug = preg_replace('/[-]+/', '-', $slug);
		$slug = strtolower($slug);
		return 'documentation/'.$object->id.'/'.$slug.'/';
	}
	
}

?>