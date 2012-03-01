<h1><?php echo $object->__name; ?></h1>

<?php echo $this->documentation->parse_documentation_with_local_id($object->content, $object->local_id); ?>