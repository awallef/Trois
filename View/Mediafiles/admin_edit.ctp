<?php echo $this->Form->create('Mediafile'); ?>
	<fieldset>
	
	<h2>Edit</h2>
	
	<?php
		echo $this->Form->input('id');
		
		if( $this->request->data['Mediafile']['type'] == 'image/jpeg' || $this->request->data['Mediafile']['type'] == 'image/png' )
		{
			echo $this->Html->tag('img','', array(
				'src' => $this->Html->url('/'.$this->request->data['Mediafile']['src']),
				'style'=> 'width:100%;'
			));
			
			echo $this->Html->tag('div',' ',array('style'=>'height:20px;'));
			
		}elseif( $this->request->data['Mediafile']['type'] == 'embed/youtube' || $this->request->data['Mediafile']['type'] == 'embed/vimeo' )
		{
			echo $this->Media->fluidVideo($this->request->data);
			echo $this->Html->tag('div',' ',array('style'=>'height:20px;'));
			echo $this->Form->input('embed');
		}else
		{
			echo $this->Form->input('embed');
		}
		
		echo $this->Form->input('type',array('type'=>'hidden'));
                echo $this->Form->input('src',array('type'=>'hidden'));
		
		echo '<div>Size: '.(round($this->request->data['Mediafile']['size']/1024)).' Kb</div>';
		
		echo $this->Form->input('name');
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


