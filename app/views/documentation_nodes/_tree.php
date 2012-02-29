<div id="documentation_tree">
<?php

echo '<ol>';
for($current_index=0; $current_index<count($objects); $current_index++) {
	$current_node = $objects[$current_index];
	$previous_depth = empty($objects[$current_index-1]) ? null : $objects[$current_index-1]->depth;
	$next_depth = empty($objects[$current_index+1]) ? null : $objects[$current_index+1]->depth;
	$current_depth = $current_node->depth;
	if (!is_null($previous_depth) && $previous_depth > $current_depth) {
		echo str_repeat('</ol></li>', $previous_depth - $current_depth);
	}
	echo '<li id="item_'.$current_node->local_id.'">';
	echo $this->render_view('_tree_item', array('locals' => array('object' => $current_node)));
	if (!is_null($next_depth) && $next_depth > $current_depth) {
		echo '<ol>';
	} else {
		echo '</li>';
	}
}
echo '</ol>';

?>
</div>