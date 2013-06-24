<div class="mediaLinks index">
	<h2><?php echo __('Media Links'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('mediafile_id'); ?></th>
			<th><?php echo $this->Paginator->sort('order'); ?></th>
			<th><?php echo $this->Paginator->sort('foreign_key'); ?></th>
			<th><?php echo $this->Paginator->sort('foreign_field'); ?></th>
			<th><?php echo $this->Paginator->sort('foreign_model'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($mediaLinks as $mediaLink): ?>
	<tr>
		<td><?php echo h($mediaLink['MediaLink']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($mediaLink['Mediafile']['name'], array('controller' => 'mediafiles', 'action' => 'view', $mediaLink['Mediafile']['id'])); ?>
		</td>
		<td><?php echo h($mediaLink['MediaLink']['order']); ?>&nbsp;</td>
		<td><?php echo h($mediaLink['MediaLink']['foreign_key']); ?>&nbsp;</td>
		<td><?php echo h($mediaLink['MediaLink']['foreign_field']); ?>&nbsp;</td>
		<td><?php echo h($mediaLink['MediaLink']['foreign_model']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $mediaLink['MediaLink']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $mediaLink['MediaLink']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $mediaLink['MediaLink']['id']), null, __('Are you sure you want to delete # %s?', $mediaLink['MediaLink']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Media Link'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Mediafiles'), array('controller' => 'mediafiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediafile'), array('controller' => 'mediafiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
