<h1><?php echo $object->__name; ?></h1>

<?php echo $this->documentation->parse_documentation($object->content, $object->id); ?>