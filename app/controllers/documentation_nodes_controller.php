<?php

class DocumentationNodesController extends MvcPublicController {

	var $default_searchable_fields = array(
		'title',
		'content'
	);
	var $before = array('set_version', 'set_versions');
	var $version = null;
	var $versions = array();
	
	public function index() {
		$this->set_tree_objects();
	}
	
	public function show() {
		$this->load_helper('Documentation');
		$this->set_tree_objects();
		
		$object = $this->model->find_one(array(
			'conditions' => array(
				'local_id' => $this->params['local_id'],
				'documentation_version_id' => $this->version->id
			)
		));
		$this->set('object', $object);
		if (empty($this->object)) {
			$this->redirect('/404/');
		}
		foreach ($this->versions as $key => $version) {
			$related_node = $this->model->find_one(array('conditions' => array(
				'local_id' => $object->local_id,
				'documentation_version_id' => $version->id
			)));
			if (!$related_node) {
				$related_node = $this->model->first_node($version->id);
			}
			$this->versions[$key]->related_node = $related_node;
		}
		$this->set('versions', $this->versions);
	}
	
	public function search() {
		$this->load_helper('Documentation');
		$this->set_tree_objects();
		$this->set_objects();
	}
	
	private function set_tree_objects() {
		$tree_objects = $this->model->find(array('conditions' => array('documentation_version_id' => $this->version->id)));
		$this->set(compact('tree_objects'));
	}
	
	public function set_objects() {
		$this->process_params_for_search();
		$version = displayed_documentation_version();
		$this->params['conditions']['documentation_version_id'] = $version->id;
		$collection = $this->model->paginate($this->params);
		$this->set('objects', $collection['objects']);
		$this->set_pagination($collection);
	}
	
	public function set_version() {
		global $current_documentation_version, $url_documentation_version;
		$url_documentation_version = null;
		$this->load_model('DocumentationVersion');
		if (!empty($this->params['documentation_version_name'])) {
			$version = $this->DocumentationVersion->find_one(array('conditions' => array('name' => $this->params['documentation_version_name'])));
			if (!empty($version)) {
				$url_documentation_version = $version;
				$current_documentation_version = $version;
				$this->version = $version;
				$this->set('current_version', $this->version);
				return true;
			}
		}
		$version = null;
		if (!empty($this->params['version_id'])) {
			$version = $this->DocumentationVersion->find_by_id($this->params['version_id']);
		}
		if (empty($version)) {
			$version_id = mvc_setting('DocumentationSettings', 'public_version_id');
			if (empty($version_id)) {
				$version_id = 1;
			}
			$version = $this->DocumentationVersion->find_by_id($version_id);
		}
		$this->version = $version;
		$this->set('current_version', $this->version);
		$current_documentation_version = $this->version;
	}
	
	public function set_versions() {
		$this->load_model('DocumentationVersion');
		$versions = $this->DocumentationVersion->find();
		if (empty($versions)) {
			$versions = array();
		}
		$this->versions = $versions;
		$this->set('versions', $this->versions);
	}
	
}

?>