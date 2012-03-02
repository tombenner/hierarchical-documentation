<?php

class AdminDocumentationNodesController extends MvcAdminController {
	
	var $default_columns = array(
		'local_id' => 'ID',
		'title'
	);
	var $default_searchable_fields = array(
		'title',
		'content'
	);

	public function add() {
		$this->load_helper('Documentation');
		$this->set_parents();
		if (!empty($this->params['data']['DocumentationNode'])) {
			$this->params['data']['DocumentationNode']['local_id'] = $this->model->next_local_id();
			$this->params['data']['DocumentationNode']['documentation_version_id'] = $this->model->admin_version_id();
		}
		$this->create();
	}

	public function edit() {
		$this->load_helper('Documentation');
		$id = $this->params['id'];
		$this->set_parents($id);
		$this->verify_id_param();
		$this->set_object();
		$this->create_or_save();
	}
	
	public function index() {
		$this->init_default_columns();
		$this->process_params_for_search();
		$this->params['conditions']['documentation_version_id'] = $this->model->admin_version_id();
		$collection = $this->model->paginate($this->params);
		$this->set('objects', $collection['objects']);
		$this->set_pagination($collection);
	}
	
	public function export() {
	}
	
	public function tree() {
		wp_enqueue_script('nest-sortable', mvc_js_url('hierarchical-documentation', 'nest_sortable.js'), array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), null, true);
		$objects = $this->DocumentationNode->find(array(
			'conditions' => array('documentation_version_id' => $this->model->admin_version_id())
		));
		$this->set('objects', $objects);
	}
	
	public function update_tree() {
		if (!empty($_POST['data'])) {
			$documentation_version_id = $this->model->admin_version_id();
			foreach($_POST['data'] as $node) {
				if (!empty($node['item_id']) && $node['item_id'] != 'root') {
					$data = array(
						'parent_id' => $node['parent_id'],
						'depth' => $node['depth'],
						'lft' => $node['left'],
						'rght' => $node['right']
					);
					$this->DocumentationNode->update_all($data, array('conditions' => array(
						'local_id' => $node['item_id'],
						'documentation_version_id' => $documentation_version_id
					)));
				}
			}
		}
		// To do: add JSON output confirming sucess
		die();
	}
	
	public function preview_content() {
		if (!empty($_POST['content'])) {
			$this->load_helper('Documentation');
			$id = empty($_POST['id']) ? null : $_POST['id'];
			echo $this->documentation->parse_documentation_with_id(stripslashes($_POST['content']), $id);
		}
		// To do: add JSON output confirming sucess
		die();
	}
	
	private function set_parents($id=null) {
		$conditions = $id ? array('id !=' => $id) : null;
		$parents = $this->DocumentationNode->find(array('conditions' => $conditions, 'selects' => array('id', 'title')));
		$this->set('parents', $parents);
	}
	
}

?>