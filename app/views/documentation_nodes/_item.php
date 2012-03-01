<div>

	<h4><?php echo $this->html->documentation_node_link($object); ?></h4>
	
	<div>
		<?php echo strip_tags($this->documentation->truncate_html($this->documentation->parse_documentation_with_local_id(str_replace('[children_list]', ' ', $object->content), $object->local_id))); ?>
	</div>

</div>