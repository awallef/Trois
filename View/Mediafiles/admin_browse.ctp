<?php
/* * *
 *    __________                                       ____    ___________    .___.__  __   
 *    \______   \_______  ______  _  ________ ____    /  _ \   \_   _____/  __| _/|__|/  |_ 
 *     |    |  _/\_  __ \/  _ \ \/ \/ /  ___// __ \   >  _ </\  |    __)_  / __ | |  \   __\
 *     |    |   \ |  | \(  <_> )     /\___ \\  ___/  /  <_\ \/  |        \/ /_/ | |  ||  |  
 *     |______  / |__|   \____/ \/\_//____  >\___  > \_____\ \ /_______  /\____ | |__||__|  
 *            \/                          \/     \/         \/         \/      \/           
 */
$this->Paginator->options = array('url' => array(), 'update' => '#media-browse-pannel');

if( !empty($this->request->params['named']) )
{
	$paginationParams = array(
		'mode',
		'param',
		'limit',
		'index',
		'deirection'
	);
	
	foreach( $paginationParams as $param)
	{
		if (!empty($this->request->params['named'][$param]))
			$this->Paginator->options['url'][$param] = $this->request->params['named'][$param];
	}
}

?>

<div>
<?php echo $this->element('media_thumbs'); ?>
</div>

<div class="paging pagination">
    <ul>
		<?php
		echo '<li>'.$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')).'</li>';
		echo $this->Paginator->numbers(array('separator' => '','tag'=>'li'));
		echo '<li>'.$this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')).'</li>';
		?>
    </ul>
</div>

<p>
<?php
echo $this->Paginator->counter(array(
    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total')
));
?>
</p>