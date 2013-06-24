<?php
$this->Html->script('/trois/js/FileAPI', array('inline' => false));
?>
<div class="media form">

    <h2>Upload Medias</h2>

    <div id="uploadDataArea" class="left">
        <fieldset>
<?php
echo $this->Form->input('description', array('label' => 'Description and #tags, or @tags', 'type' => 'textarea'));
?>
        </fieldset>

    </div>

    <div id="spacerArea" class="left"></div>
    <div id="fileDropArea" class="left">
        <div id="fileDrop">
            <p>Drop files here<br/>Or</p>
            <div class="inputbtn">
                <input type="file" id="fileField" name="fileField" multiple />
            </div>
        </div>


    </div>

    <div class="clear"></div>

    <div id="files">
        <h2>File list</h2>
        <p>
            <a id="reset" class="btn btn-danger" href="#" title="Remove all files from list">Clear list</a>
            <a id="upload" class="btn btn-primary"  href="#" title="Upload all files in list">Upload files</a>
        </p>
        <div id="fileList"></div>
    </div>



</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>

        <li><?php echo $this->Html->link(__('List Mediafile'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('List Media Links'), array('controller' => 'media_links', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Media Link'), array('controller' => 'media_links', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Media Tags'), array('controller' => 'media_tags', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Media Tag'), array('controller' => 'media_tags', 'action' => 'add')); ?> </li>
    </ul>
</div>

<script>
    $(document).ready(function(){
	
		
        FileAPI = new FileAPI(
        document.getElementById("fileList"),
        document.getElementById("fileDrop"),
        document.getElementById("fileField"),
        '<?php echo $this->Html->url('/trois/assets/icons/'); ?>',
        '<?php echo $this->Html->url(array('controller' => 'Mediafiles', 'action' => 'config', 'admin' => true, 'plugin' => 'trois')) . '.json'; ?>',
        '<?php echo $this->Html->url(array('controller' => 'Mediafiles', 'action' => 'uploadprocess', 'admin' => true, 'plugin' => 'trois')) . '.json'; ?>',
        '<?php echo $this->Html->url(array('controller' => 'Mediafiles', 'action' => 'index', 'admin' => true, 'plugin' => 'trois')); ?>',
        false
    );
        FileAPI.init();
		
        $('#reset').click(function( evt){
            FileAPI.clearList(evt);
        });
		
        $('#upload').click(function(evt){
            FileAPI.startUpload(evt);
        });

	
    });
</script>
