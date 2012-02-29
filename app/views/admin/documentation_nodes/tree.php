<style>
/* To do: move this hacky style definition to <head> */
#documentation_tree ol {
	padding:8px 5px 8px 30px;
	margin:10px 0 10px 10px;
	border:1px solid #eee;
}
#documentation_tree li {
	padding:10px 0;
	margin:10px 0;
}
</style>

<h2>Tree</h2>

<div id="documentation_tree">

<?php
echo '<ol>';
for($current_index=0; $current_index<count($objects); $current_index++) {
	$current_node = $objects[$current_index];
	$previous_depth = empty($objects[$current_index-1]) ? null : $objects[$current_index-1]->depth;
	$next_depth = empty($objects[$current_index+1]) ? null : $objects[$current_index+1]->depth;
	$current_depth = $current_node->depth;
	if (!is_null($previous_depth) && $previous_depth > $current_depth) {
		echo str_repeat('</ol></li>', $previous_depth - $current_depth + 1);
	}
	if (!is_null($previous_depth) && $previous_depth == $current_depth) {
		echo '</li>';
	}
	echo '<li id="item_'.$current_node->local_id.'">';
	echo $this->render_view('_tree_item', array('locals' => array('object' => $current_node)));
	echo '<ol>';
	if (is_null($next_depth) || $next_depth == $current_depth) {
		echo '</ol>';
	}
}
echo '</ol>';
?>

</div>

<form action="" method="get">
	<input type="submit" id="documentation_tree_save_button" value="Save" />
</form>