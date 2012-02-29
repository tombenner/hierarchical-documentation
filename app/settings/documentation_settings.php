<?php

class DocumentationSettings extends MvcSettings {

	var $settings = array(
		'admin_version_id' => array(
			'type' => 'select',
			'label' => 'Admin Version',
			'options_method' => 'get_all_versions',
			'default' => 1
		),
		'public_version_id' => array(
			'type' => 'select',
			'label' => 'Public Version',
			'options_method' => 'get_all_versions',
			'default' => 1
		),
		'show_search_form' => array(
			'type' => 'checkbox',
			'default' => 1
		),
		'show_version_list' => array(
			'type' => 'checkbox',
			'default' => 0
		)
	);
	
	public function get_all_versions() {
		$documentation_version_model = mvc_model('DocumentationVersion');
		$versions = $documentation_version_model->find();
		$list = array();
		foreach ($versions as $version) {
			$list[$version->id] = $version->name;
		}
		return $list;
	}
	
}

?>