<div style="margin-bottom:30px;background-color: rgb(245, 245, 245); padding:10px;">


    <h3><?php echo $field; ?></h3>
    <?php
    //debug( $this->request->data );

    echo '<div style="margin-bottom:10px;">';
    echo $this->Html->tag('a', 'Upload', array(
        'href' => $this->Html->url(array(
            'controller' => 'Mediafiles',
            'action' => 'foreignupload',
            'admin' => true,
            'plugin' => 'trois',
            $model,
            $field,
            $this->request->data[$model]['id']
        )),
        'style' => 'margin-right: 10px;',
        'class' => 'btn btn-primary'
            ));

    echo $this->Html->tag('a', 'Edit', array(
        'href' => $this->Html->url(array(
            'controller' => 'MediaLinks',
            'action' => 'foreignsort',
            'admin' => true,
            'plugin' => 'trois',
            $model,
            $field,
            $this->request->data[$model]['id']
        )),
        'class' => 'btn btn-primary'
            ));
    echo '</div>';


    if(!empty($this->request->data)){
        $data = $this->request->data;
        if(!empty($data[$model][$field])){
            $mediafiles = $data[$model][$field];
            echo '<div style="margin-bottom:10px;">There are '.count($mediafiles).' mediafile(s) associated to this '.$model.'</div>';
            echo '<div style="margin-bottom:10px;">';
            for ($i = 0; $i < count($mediafiles); $i++) {
                echo $this->element('media_thumb', array('mediafiles'=>$mediafiles,'i'=>$i,'edition' => false), array('plugin'=>'Trois'));
            }
             echo '<div style="clear:both;"></div>';
            echo '</div>';

        }else{
          echo '<div style="margin-bottom:10px;">No mediafile associated to this '.$model.'</div>';  
        }
    }

    ?>
</div>