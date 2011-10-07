jQuery(document).ready(function(){
	
	var preview_button = jQuery('#DocumentationNodePreview');
	var preview_result_div = jQuery('#DocumentationNodePreviewResult');
	
	preview_button.click(function(){
		
		var content = jQuery('#DocumentationNodeContent').val();
		var id = jQuery('#DocumentationNodeHiddenId').val();
		
		var data = {
			action: 'admin_documentation_nodes_preview_content',
			content: content,
			id: id
		};
		
		preview_button.blur().attr('disabled', 'disabled');
		preview_result_div.html('<em>Loading...</em>');
		jQuery.post(ajaxurl, data, function(response){
			var preview_container = jQuery('#DocumentationNodePreviewContainer');
			preview_container.show();
			/*jQuery('html,body').animate(
				{scrollTop: preview_container.offset().top},
				'slow'
		    );*/
			preview_button.text('Preview').removeAttr('disabled');
			preview_result_div.html(response);
		});
		
	});
	
	preview_button.click();
	
});