<?php
$version = displayed_documentation_version();
?>
<div class="documentation-search-form">
	<form action="<?php echo mvc_public_url(array('controller' => 'documentation_nodes', 'action' => 'search')); ?>" method="get">
		<input type="text" name="q" value="<?php echo empty($this->params['q']) ? '' : esc_attr($this->params['q']); ?>" />
		<input type="hidden" name="version_id" value="<?php echo empty($this->params['version_id']) ? $version->id : esc_attr($this->params['version_id']); ?>" />
		<input type="submit" value="Search" />
	</form>
</div>