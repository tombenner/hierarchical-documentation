jQuery(document).ready(function(){
	
	jQuery('#documentation_tree ol').sortable({
		connectWith: '#documentation_tree ol'
	});
	
	var save_button = jQuery('#documentation_tree_save_button');
	
	save_button.click(function(){
	
		var self = jQuery('#documentation_tree > ol');

		var sDepth = 0;
		var ret = [];
		var left = 1;
		var listType = 'ol';

		ret.push({"item_id": 'root', "parent_id": 'none', "depth": sDepth, "left": '1', "right": (self.find('li').length + 1) * 2});

		self.children('li').each(function () {
			left = _recursiveArray(jQuery(this), sDepth + 1, left);
		});

		function _sortByLeft(a,b) {
			return a['left'] - b['left'];
		}
		ret = ret.sort(_sortByLeft);
		
		var data = {
			action: 'admin_documentation_nodes_update_tree',
			data: ret
		};
		
		save_button.blur().val('Saving...').attr('disabled', 'disabled');
		jQuery.post(ajaxurl, data, function(){
			save_button.val('Save!').removeAttr('disabled');
			alert('Successfully saved!');
		});
		
		return false;

		function _recursiveArray(item, depth, left) {

			right = left + 1;

			if (item.children(listType).children('li').length > 0) {
				depth ++;
				item.children(listType).children('li').each(function () {
					right = _recursiveArray(jQuery(this), depth, right);
				});
				depth --;
			}

			id = (item.attr('id')).match((/(.+)[-=_](.+)/));

			if (depth === sDepth + 1) {
				pid = 'root';
			} else {
				parentItem = (item.parent(listType).parent('li').attr('id')).match((/(.+)[-=_](.+)/));
				pid = parentItem[2];
			}
			
			if (id != null) {
				ret.push({"item_id": id[2], "parent_id": pid, "depth": depth, "left": left, "right": right});
			}

			return left = right + 1;
		
		}
		
	});
	
});