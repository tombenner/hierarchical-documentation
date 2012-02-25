<?php

class DocumentationNodesController extends MvcPublicController {

	var $default_searchable_fields = array(
		'title',
		'content'
	);
	
	public function index() {
		$this->set_tree_objects();
	}
	
	public function show() {
		$this->load_helper('Documentation');
		$this->set_tree_objects();
		$this->set_object();
		if (empty($this->object)) {
			$this->redirect('/404/');
		}
	}
	
	public function search() {
		$this->load_helper('Documentation');
		$this->set_tree_objects();
		$this->set_objects();
	}
	
	private function set_tree_objects() {
		$tree_objects = $this->model->find();
		$this->set(compact('tree_objects'));
	}
	
}

?>