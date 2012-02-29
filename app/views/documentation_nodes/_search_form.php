<div class="documentation-search-form">
	<form action="<?php echo mvc_public_url(array('controller' => 'documentation_nodes', 'action' => 'search')); ?>" method="get">
		<input type="text" name="q" value="<?php echo empty($this->params['q']) ? '' : esc_attr($this->params['q']); ?>" />
		<input type="submit" value="Search" />
	</form>
</div>