<?php

MvcRouter::public_connect('', array('controller' => 'documentation_nodes', 'action' => 'show', 'local_id' => 1));
MvcRouter::public_connect('documentation/{:documentation_version_name:[\d.]+}', array('controller' => 'documentation_nodes', 'action' => 'show', 'local_id' => 1));
MvcRouter::public_connect('documentation/{:documentation_version_name:[\d.]+}/{:local_id:[\d]+}/.*', array('controller' => 'documentation_nodes', 'action' => 'show'));
MvcRouter::public_connect('documentation/{:local_id:[\d]+}/.*', array('controller' => 'documentation_nodes', 'action' => 'show'));
MvcRouter::public_connect('search', array('controller' => 'documentation_nodes', 'action' => 'search'));
MvcRouter::public_connect('{:controller}', array('action' => 'index'));
MvcRouter::public_connect('{:controller}/{:id:[\d]+}', array('action' => 'show'));
MvcRouter::public_connect('{:controller}/{:action}/{:id:[\d]+}');

MvcRouter::admin_ajax_connect(array('controller' => 'admin_documentation_nodes', 'action' => 'update_tree'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_documentation_nodes', 'action' => 'preview_content'));

?>