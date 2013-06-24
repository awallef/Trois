<div class="media form">
<?php echo $this->Form->create('Mediafile',array('type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Mediafile'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('src',array('type'=>'file'));
		echo $this->Form->input('embed');
		echo $this->Form->input('description',array( 'label' => 'Description and #tags, or @tags','type' => 'textarea' ));
	?>
	</fieldset>
	
	<div id="metadataArea">
	    <h2>Metadata</h2>
	    <?php 
			echo $this->element('datafield_edit');
		?>
	</div>
	
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Media'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Media Links'), array('controller' => 'media_links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media Link'), array('controller' => 'media_links', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Tags'), array('controller' => 'media_tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media Tag'), array('controller' => 'media_tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
