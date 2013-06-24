<div class="media-action-pannel">
    <div class="media-action-pannel-inner">
        <button class="btn" type="button" id="MediaActionCheckAll">Check All</button>
        <button class="btn" type="button" id="MediaActionUncheckAll">Uncheck All</button>

        <?php
        $tagsHtml = $this->Html->tag('option', __('Group Action'), array('value' => 'no action'));
        $tagsHtml .= $this->Html->tag('option', __('Delete'), array('value' => 'delete'));

        echo $this->Html->tag('select', $tagsHtml, array('id' => 'media-action'));
        ?>

        <button class="btn btn-primary" id="media-action-btn" type="button" >Go!</button>
    </div>
</div>

<div id="sortable">

    <?php
    for ($i = 0; $i < count($mediafiles); $i++) {
        echo $this->element('media_thumb', array('mediafiles'=>$mediafiles,'i'=>$i,'edition' => true), array('plugin'=>'Trois'));
    }
    ?>    
</div>

<div style="clear: both;"></div>