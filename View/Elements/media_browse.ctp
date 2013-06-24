<?php
/***
 *    ___________.__.__           __________                                     ___________    .___.__  __   
 *    \_   _____/|__|  |   ____   \______   \_______  ______  _  ________ ____   \_   _____/  __| _/|__|/  |_ 
 *     |    __)  |  |  | _/ __ \   |    |  _/\_  __ \/  _ \ \/ \/ /  ___// __ \   |    __)_  / __ | |  \   __\
 *     |     \   |  |  |_\  ___/   |    |   \ |  | \(  <_> )     /\___ \\  ___/   |        \/ /_/ | |  ||  |  
 *     \___  /   |__|____/\___  >  |______  / |__|   \____/ \/\_//____  >\___  > /_______  /\____ | |__||__|  
 *         \/                 \/          \/                          \/     \/          \/      \/           
 */

$this->Html->script('Trois.browse_media', array('inline' => false));

$selectBoxes = '';
$url = array(
    'admin' => true,
    'plugin' => 'trois',
    'controller' => 'Mediafiles',
    'action' => 'browse'
);

$simpleBrowseUrl = array(
    'admin' => true,
    'plugin' => 'trois',
    'controller' => 'Mediafiles',
    'action' => 'browse',
    'sort' => 'id',
    'direction' => 'desc',
    'limit' => 25,
    'index' => 'id'
);

$deleteManyJsonUrl = array(
    'admin' => true,
    'plugin' => 'trois',
    'controller' => 'Mediafiles',
    'action' => 'deletemany'
);

$editManyJsonUrl = array(
    'admin' => true,
    'plugin' => 'trois',
    'controller' => 'Mediafiles',
    'action' => 'editmany'
);

$removeManyJsonUrl = array(
    'admin' => true,
    'plugin' => 'trois',
    'controller' => 'MediaLinks',
    'action' => 'deletemany'
);

$addManyJsonUrl = array(
    'admin' => true,
    'plugin' => 'trois',
    'controller' => 'MediaLinks',
    'action' => 'addmany'
);

$editUrl = array(
    'admin' => true,
    'plugin' => 'trois',
    'controller' => 'Mediafiles',
    'action' => 'edit'
);

//debug( $this->request );

?>


<!-- Search Pannel -->
<div class="media-search-pannel">
    <?php
    $url['mode'] = 1;

    echo $this->Form->create(null, array(
        'url' => $url,
        'id' => 'media-search-by-name-form'
    ));
    ?>
    
    <!-- PASS JS SOME HELP -->
    <input id="media-sort-mode" type="hidden" value="<?php echo $sortMode; ?>">
    <input id="media-search-base-url" type="hidden" value="<?php echo $this->Html->url( '/' ); ?>">
    <input id="media-search-first-query" type="hidden" value="<?php echo $this->Html->url( $simpleBrowseUrl ); ?>">
    <input id="media-delete-many-query" type="hidden" value="<?php echo $this->Html->url( $deleteManyJsonUrl ).'.json'; ?>">
    <input id="media-edit-many-query" type="hidden" value="<?php echo $this->Html->url( $editManyJsonUrl ).'.json'; ?>">
    <input id="media-remove-many-query" type="hidden" value="<?php echo $this->Html->url( $removeManyJsonUrl ).'.json'; ?>">
    <input id="media-add-many-query" type="hidden" value="<?php echo $this->Html->url( $addManyJsonUrl ).'.json'; ?>">
    <input id="media-request-here" type="hidden" value="<?php echo $this->request->here; ?>">
    
    <?php if( $sortMode ){ ?>
	<input id="media-foreign_model" type="hidden" value="<?php echo $foreign_model; ?>">
	<input id="media-foreign_field" type="hidden" value="<?php echo $foreign_field; ?>">
	<input id="media-foreign_key" type="hidden" value="<?php echo $foreign_key; ?>">
	<?php } ?>
    
    <input id="media-edit-query" type="hidden" value="<?php echo $this->Html->url( $editUrl ); ?>">

    <div class="input-append">
        <input class="span2" id="media-search-by-name-form-param" name="param" type="text" placeholder="Find by Name...">
        <button class="btn" id="media-search-by-name-form-btn" type="button">Go!</button>
    </div>

<?php echo $this->Form->end(); ?>

    <?php
    if (!empty($tags)) {

        $tagsHtml = $this->Html->tag('option', __('Find By Tag'), array('value' => $this->Html->url($simpleBrowseUrl)));

        foreach ($tags as $tag) {

            $url['mode'] = 2;
            $url['param'] = $tag['MediaTag']['id'];

            $tagsHtml .= $this->Html->tag('option', $tag['MediaTag']['name'], array('value' => $this->Html->url($url)));
        }

        $selectBoxes .= $this->Html->tag('select', $tagsHtml, array(
        	'id' => 'media-search-by-tag-select-box'
        ));
    }
    
    
    $tagsHtml = $this->Html->tag('option', __('Limit Per Page'), array('value' => 25));
    $limits_per_page = array(10,20,50,100,200);
    foreach ($limits_per_page as $limit_per_page) {

        $tagsHtml .= $this->Html->tag('option', $limit_per_page, array('value' => $limit_per_page));
    }

    $selectBoxes .= $this->Html->tag('select', $tagsHtml, array(
        	'id' => 'media-search-limit-select-box'
        ));

    echo $selectBoxes;
    ?>

</div>

<div style="height:40px;"></div>

<ul id="mediaTab" class="nav nav-tabs">
  <li class="active"><a id="media-tab-browse" href="#media-browse-pannel"  data-toggle="tab">Mediafiles</a></li>
  <li><a id="media-tab-edit" href="#media-edit-pannel" data-toggle="tab">Edit</a></li>
  <?php if( $sortMode ){ ?>
  	<li><a id="media-tab-sort" href="#media-sort-pannel" data-toggle="tab">Selection</a></li>
  <?php } ?>
</ul>

<div class="tab-content">
	<div id="media-browse-pannel" class="tab-pane active" >
	
	</div>
	
	<div id="media-edit-pannel" class="tab-pane">
	
	</div>
	<?php if( $sortMode ){ ?>
	<div id="media-sort-pannel" class="tab-pane">
		<div>
			<?php echo $this->element('media_thumbs'); ?>
		</div>
	</div>
	<?php } ?>
	
</div>