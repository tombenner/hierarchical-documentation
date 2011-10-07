<?php

class AdminDocumentationNodesController extends MvcAdminController {

	public function add() {
		$this->load_helper('Documentation');
		$this->set_parents();
		$this->create_or_save();
	}

	public function edit() {
		$this->load_helper('Documentation');
		$id = $this->params['id'];
		$this->set_parents($id);
		$this->verify_id_param();
		$this->set_object();
		$this->create_or_save();
	}
	
	public function tree() {
		wp_enqueue_script('nest-sortable', mvc_js_url('hierarchical-documentation', 'nest_sortable.js'), array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), null, true);
		$objects = $this->DocumentationNode->find();
		$this->set('objects', $objects);
	}
	
	public function update_tree() {
		if (!empty($_POST['data'])) {
			foreach($_POST['data'] as $node) {
				if (!empty($node['item_id']) && $node['item_id'] != 'root') {
					$this->DocumentationNode->update($node['item_id'], array(
						'parent_id' => $node['parent_id'],
						'depth' => $node['depth'],
						'lft' => $node['left'],
						'rght' => $node['right']
					));
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
			echo $this->documentation->parse_documentation(stripslashes($_POST['content']), $id);
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