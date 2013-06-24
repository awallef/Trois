<div class="mediaLinks form">
<?php echo $this->Form->create('MediaLink'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Media Link'); ?></legend>
	<?php
		echo $this->Form->input('mediafile_id');
		echo $this->Form->input('order');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('foreign_field');
		echo $this->Form->input('foreign_model');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Media Links'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Mediafiles'), array('controller' => 'mediafiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediafile'), array('controller' => 'mediafiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
