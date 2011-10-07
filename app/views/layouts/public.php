<?php get_header(); ?>

<div class="page">

	<div id="single-body" class="post-body">

		<?php $this->render_view('documentation_nodes/_tree', array('locals' => array('objects' => $tree_objects))); ?>
		
		<div id="documentation_container">
		
			<?php $this->render_main_view(); ?>
		
		</div>
		
		<div style="clear:both"></div>
	
	</div>

</div>

<?php get_footer(); ?>