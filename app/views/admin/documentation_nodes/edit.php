<h2>Edit Documentation Node</h2>

<?php echo $this->html->documentation_node_link($object, array('text' => 'View (version '.$object->documentation_version->name.')')); ?>

<?php echo $this->form->create($model->name); ?>
<?php echo $this->form->input('title'); ?>
<?php echo $this->form->input('content'); ?>
<?php echo $this->form->button('Preview'); ?>
<?php echo $this->form->end('Update'); ?>

<?php echo $this->render_view('_preview_and_help'); ?>