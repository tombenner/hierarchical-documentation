jQuery(document).ready(function(){

	var current_url_path = window.location.pathname;
	var current_node = jQuery('#documentation_tree a[href$="'+current_url_path+'"]').parents('li:first');
	if (current_node.length == 1) {
		current_node.parents('ol').show();
		current_node.children('ol').show();
		current_node.addClass('current');
	}

});