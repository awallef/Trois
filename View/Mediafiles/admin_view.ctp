<div class="mediafiles view">
<h2><?php  echo __('Mediafile'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mediafile['Mediafile']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($mediafile['Mediafile']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($mediafile['Mediafile']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($mediafile['Mediafile']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Size'); ?></dt>
		<dd>
			<?php echo h($mediafile['Mediafile']['size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Src'); ?></dt>
		<dd>
			<?php echo h($mediafile['Mediafile']['src']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Embed'); ?></dt>
		<dd>
			<?php echo h($mediafile['Mediafile']['embed']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($mediafile['Mediafile']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Metadata'); ?></dt>
		<dd>
			<?php echo h($mediafile['Mediafile']['metadata']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mediafile'), array('action' => 'edit', $mediafile['Mediafile']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mediafile'), array('action' => 'delete', $mediafile['Mediafile']['id']), null, __('Are you sure you want to delete # %s?', $mediafile['Mediafile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Mediafiles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediafile'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Links'), array('controller' => 'media_links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media Link'), array('controller' => 'media_links', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Tags'), array('controller' => 'media_tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media Tag'), array('controller' => 'media_tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Media Links'); ?></h3>
	<?php if (!empty($mediafile['MediaLink'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Mediafile Id'); ?></th>
		<th><?php echo __('Order'); ?></th>
		<th><?php echo __('Foreign Key'); ?></th>
		<th><?php echo __('Foreign Field'); ?></th>
		<th><?php echo __('Foreign Model'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mediafile['MediaLink'] as $mediaLink): ?>
		<tr>
			<td><?php echo $mediaLink['id']; ?></td>
			<td><?php echo $mediaLink['mediafile_id']; ?></td>
			<td><?php echo $mediaLink['order']; ?></td>
			<td><?php echo $mediaLink['foreign_key']; ?></td>
			<td><?php echo $mediaLink['foreign_field']; ?></td>
			<td><?php echo $mediaLink['foreign_model']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'media_links', 'action' => 'view', $mediaLink['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'media_links', 'action' => 'edit', $mediaLink['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'media_links', 'action' => 'delete', $mediaLink['id']), null, __('Are you sure you want to delete # %s?', $mediaLink['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Media Link'), array('controller' => 'media_links', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Media Tags'); ?></h3>
	<?php if (!empty($mediafile['MediaTag'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mediafile['MediaTag'] as $mediaTag): ?>
		<tr>
			<td><?php echo $mediaTag['id']; ?></td>
			<td><?php echo $mediaTag['name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'media_tags', 'action' => 'view', $mediaTag['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'media_tags', 'action' => 'edit', $mediaTag['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'media_tags', 'action' => 'delete', $mediaTag['id']), null, __('Are you sure you want to delete # %s?', $mediaTag['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Media Tag'), array('controller' => 'media_tags', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
