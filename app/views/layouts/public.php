<?php get_header(); ?>

<div class="page">

	<?php if (mvc_setting('DocumentationSettings', 'show_search_form')): ?>
		<?php $this->render_view('documentation_nodes/_search_form'); ?>
	<?php endif; ?>
	
	<div id="single-body" class="post-body">

		<?php $this->render_view('documentation_nodes/_tree', array('locals' => array('objects' => $tree_objects))); ?>
		
		<div id="documentation_container">
		
			<?php $this->render_main_view(); ?>
		
		</div>
		
		<div style="clear:both"></div>
	
	</div>

	<?php if (mvc_setting('DocumentationSettings', 'show_version_list')): ?>
		<?php $this->render_view('documentation_nodes/_version_list', array('locals' => array('current_version' => $current_version, 'versions' => $versions))); ?>
	<?php endif; ?>

</div>

<?php get_footer(); ?>