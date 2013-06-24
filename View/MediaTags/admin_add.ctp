<div class="mediaTags form">
<?php echo $this->Form->create('MediaTag'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Media Tag'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('Mediafile');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Media Tags'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Mediafiles'), array('controller' => 'mediafiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediafile'), array('controller' => 'mediafiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
