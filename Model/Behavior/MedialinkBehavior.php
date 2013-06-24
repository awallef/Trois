<?php

class MedialinkBehavior extends ModelBehavior {

    private $_dataToBeSaved = false;

    public function beforeValidate(&$model) {
        if (isset($model->data['MediaLink'])) {
            $this->_dataToBeSaved = $model->data['MediaLink'];
        }

        return true;
    }

    public function afterSave(&$model, $created) {

        CakeLog::write('debug', $this->_dataToBeSaved );

        // if new mediafile is created and something is to store
        if (( $created ) && ( $this->_dataToBeSaved )) {
            App::import('Model', 'Trois.MediaLink');
            $mediaLink = new MediaLink();

            /*
              if( !empty($data['foreign_model']) )
              {
             */
            $data = $this->_dataToBeSaved;
            $data['mediafile_id'] = $model->id;


            $data['order'] = $mediaLink->getCount(
                    $data['foreign_model'], $data['foreign_field'], $data['foreign_key']
            );

            $mediaLink->create();
            $mediaLink->save($data);
            /*
              }else{
              foreach( $this->_dataToBeSaved as $data )
              {
              $data['mediafile_id'] =  $model->id;

              $data['order'] = $mediaLink->getCount(
              $data['foreign_model'],
              $data['foreign_field'],
              $data['foreign_key']
              );

              $mediaLink->create();
              $mediaLink->save( $data );
              }
              }
             */
        }

        $this->_dataToBeSaved = false;
    }

    public function afterDelete(&$model) {
        App::import('Model', 'Trois.MediaLink');
        $mediaLink = new MediaLink();
        $mediaLink->deleteAll(array('MediaLink.mediafile_id' => $model->id), false);
    }

}