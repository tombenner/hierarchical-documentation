<h2>Add Documentation Node</h2>

<?php echo $this->form->create($model->name); ?>
<?php echo $this->form->hidden_input('depth', array('value' => '1')); ?>
<?php echo $this->form->input('title'); ?>
<?php echo $this->form->input('content'); ?>
<?php echo $this->form->button('Preview'); ?>
<?php echo $this->form->end('Add'); ?>

<?php echo $this->render_view('_preview_and_help'); ?>