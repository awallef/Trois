<?php
$this->Html->script('/trois/js/jquery-ui-1.9.1.min.js',array('inline' => false));
?>

<div class="index">

	<fieldset>
		<h2><?php echo __('Edit your Mediafiles selection'); ?></h2>
		
		
		<form action="<?php echo $this->Html->url(array(
			'controller'=>'MediaLinks',
			'action' => 'sortprocess',
			'admin' => true, 
			'plugin' => 'trois', 
			$foreign_model, 
			$foreign_field, 
			$foreign_key
		));  ?>" id="MediaSortForm" method="post" accept-charset="utf-8">
			<div class="submit"><input class="btn btn-large btn-primary" type="submit" value="Submit"></div>
        </form>			
	</fieldset>
	
	<?php echo $this->element('media_browse'); ?>
	
	
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Mediafile'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Upload Mediafiles'), array('action' => 'upload')); ?></li>
	</ul>
</div>