<?php
$this->Html->script('/trois/js/jquery-ui-1.9.1.min.js',array('inline' => false));
?>

<style>
#sortable { list-style-type: none; margin: 0; padding: 0; }
</style>
<script>

function removeMe( elem )
{
	if( confirm('delete from collection ?') )
	{
		var data = {};
		data['url'] =  "<?php echo $this->Html->url(array( 'controller' => 'Mediafiles','action' => 'delete','plugin' => 'trois','admin' => true)); ?>/" + $(elem.target).attr('id')
		data['type'] =  'POST';
		
		$.ajax(data).done(function() { 
		  $('.thumbs-id-' + $(elem.target).attr('id') ).remove();
		});
	}
}



$(function() {
	$( "#sortable" ).sortable();
	$( "#sortable" ).disableSelection();
	
	$('#FsCollectionSortForm').submit(function() {
	 	
	 	var input = $("<input>").attr("type", "hidden").attr("name", "data[MediaLink][foreign_model]").val( '<?php echo  $foreign_model; ?>' );
	 	$('#FsCollectionSortForm').append($(input));
	 	
	 	var input = $("<input>").attr("type", "hidden").attr("name", "data[MediaLink][foreign_field]").val( '<?php echo  $foreign_field; ?>' );
	 	$('#FsCollectionSortForm').append($(input));
	 	
	 	var input = $("<input>").attr("type", "hidden").attr("name", "data[MediaLink][foreign_key]").val( '<?php echo  $foreign_key; ?>' );
	 	$('#FsCollectionSortForm').append($(input));
	 	
		$.each( $('#sortable li'), function(i,elem) {
		
			var input = $("<input>").attr("type", "hidden").attr("name", "data[Mediafile]["+$(elem).attr('id')+"]").val( ( $('#sortable li').length - 1 ) - i );
			$('#FsCollectionSortForm').append($(input));
			i++;
		});
	  	return true;
	});
	
	$('.thumbs-delete').each(function(){
		
		$(this).click( removeMe );
	});
	
});
</script>

<div class="fsCollections form">

	<fieldset>
		<legend><?php echo __('Sort your Mediafiles'); ?></legend>
		
		
		<form action="<?php echo $this->Html->url(array('controller'=>'MediaLinks', 'action' => 'sortprocess', 'admin' => true, 'plugin' => 'trois', $foreign_model, $foreign_field, $foreign_key ));  ?>" id="FsCollectionSortForm" method="post" accept-charset="utf-8">
			<!--<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>-->
            <div class="submit"><input type="submit" value="Submit"></div>
        </form>
		
		<?php echo $this->element('media_thumbs'); ?>
					
	</fieldset>

</div>