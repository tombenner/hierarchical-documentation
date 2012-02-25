<?php

class DocumentationNode extends MvcModel {

	var $display_field = 'title';
	var $order = 'lft';
	
	function to_url($object) {
		$slug = $object->title;
		$slug = preg_replace('/[^\w]/', '-', $slug);
		$slug = preg_replace('/[-]+/', '-', $slug);
		$slug = strtolower($slug);
		return 'documentation/'.$object->id.'/'.$slug.'/';
	}
	
}

?>