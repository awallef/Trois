<div class="mediaLinks view">
<h2><?php  echo __('Media Link'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mediaLink['MediaLink']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mediafile'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mediaLink['Mediafile']['name'], array('controller' => 'mediafiles', 'action' => 'view', $mediaLink['Mediafile']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order'); ?></dt>
		<dd>
			<?php echo h($mediaLink['MediaLink']['order']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Foreign Key'); ?></dt>
		<dd>
			<?php echo h($mediaLink['MediaLink']['foreign_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Foreign Field'); ?></dt>
		<dd>
			<?php echo h($mediaLink['MediaLink']['foreign_field']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Foreign Model'); ?></dt>
		<dd>
			<?php echo h($mediaLink['MediaLink']['foreign_model']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Media Link'), array('action' => 'edit', $mediaLink['MediaLink']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Media Link'), array('action' => 'delete', $mediaLink['MediaLink']['id']), null, __('Are you sure you want to delete # %s?', $mediaLink['MediaLink']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Links'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media Link'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Mediafiles'), array('controller' => 'mediafiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediafile'), array('controller' => 'mediafiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
