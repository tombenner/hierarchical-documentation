<h2>Search Results</h2>

<?php if (empty($objects)): ?>

	<p>Sorry, no results were found.</p>

<?php else: ?>

	<?php foreach($objects as $object): ?>
	
		<?php $this->render_view('_item', array('locals' => array('object' => $object))); ?>
	
	<?php endforeach; ?>
	
	<?php echo $this->pagination(); ?>

<?php endif; ?>