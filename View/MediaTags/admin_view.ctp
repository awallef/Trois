<div class="mediaTags view">
<h2><?php  echo __('Media Tag'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mediaTag['MediaTag']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($mediaTag['MediaTag']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Media Tag'), array('action' => 'edit', $mediaTag['MediaTag']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Media Tag'), array('action' => 'delete', $mediaTag['MediaTag']['id']), null, __('Are you sure you want to delete # %s?', $mediaTag['MediaTag']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Tags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media Tag'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Mediafiles'), array('controller' => 'mediafiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediafile'), array('controller' => 'mediafiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Mediafiles'); ?></h3>
	<?php if (!empty($mediaTag['Mediafile'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Size'); ?></th>
		<th><?php echo __('Src'); ?></th>
		<th><?php echo __('Embed'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Metadata'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mediaTag['Mediafile'] as $mediafile): ?>
		<tr>
			<td><?php echo $mediafile['id']; ?></td>
			<td><?php echo $mediafile['name']; ?></td>
			<td><?php echo $mediafile['date']; ?></td>
			<td><?php echo $mediafile['type']; ?></td>
			<td><?php echo $mediafile['size']; ?></td>
			<td><?php echo $mediafile['src']; ?></td>
			<td><?php echo $mediafile['embed']; ?></td>
			<td><?php echo $mediafile['description']; ?></td>
			<td><?php echo $mediafile['metadata']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'mediafiles', 'action' => 'view', $mediafile['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'mediafiles', 'action' => 'edit', $mediafile['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'mediafiles', 'action' => 'delete', $mediafile['id']), null, __('Are you sure you want to delete # %s?', $mediafile['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Mediafile'), array('controller' => 'mediafiles', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
