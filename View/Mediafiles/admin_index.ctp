<div class="fsfiles index">
    <h2>Browse Mediafiles</h2>
    <?php echo $this->element('media_browse'); ?>
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Mediafile'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Upload Mediafiles'), array('action' => 'upload')); ?></li>
	</ul>
</div>

