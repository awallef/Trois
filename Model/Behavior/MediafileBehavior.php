<?php

class MediafileBehavior extends ModelBehavior {

    public $settings = array();

    public function setup(&$model, $settings) {

        $this->settings[$model->alias] = $settings;

        // check for a title field (there is no default)
        if (!isset($this->settings[$model->alias]['fields']) || '' === $this->settings[$model->alias]['fields']) {
            throw new Exception('Must specify at least a source  field for MediafileBehavior');
        } elseif (empty($this->settings[$model->alias]['fields']) || !is_array($this->settings[$model->alias]['fields'])) {
            throw new Exception('Must specify at least a source  field for MediafileBehavior');
        }
    }

    public function afterDelete(&$model) {
        App::import('Model', 'Trois.MediaLink');
        $mediaLink = new MediaLink();
        $mediaLink->deleteAll(array('MediaLink.foreign_key' => $model->id, 'MediaLink.foreign_model' => $model->alias), false);
    }

    public function afterFind(&$model, $results, $primary) {
        foreach ($results as &$result) {
            foreach ($result as $model_name => &$r) {
                if (!empty($r)) {
                    if ($model_name == $model->alias)
                        $this->_performSingleSearch($model, $r);
                    else {

                        if (!empty($model->$model_name->actsAs['Trois.Mediafile'])) {
                            if ($model->recursive > 0) {
                                if (array_key_exists($model_name, $model->belongsTo) || array_key_exists($model_name, $model->hasOne))
                                    $this->_performSingleSearch($model->$model_name, $r);

                                if (array_key_exists($model_name, $model->hasAndBelongsToMany) || array_key_exists($model_name, $model->hasMany))
                                    $this->_performMultipleSearch($model->$model_name, $r);
                            }
                        }
                    }
                }
            }
        }

        return $results;
    }

    private function _performMultipleSearch($model, &$result) {
        if (empty($result))
            return;

        foreach ($result as &$r) {
            $this->_performSingleSearch($model, $r);
        }
    }

    private function _performSingleSearch($model, &$result) {
        if (empty($result) || array_key_exists('count', $result) || !array_key_exists('id', $result) )
            return;
        
        $fields = $model->actsAs['Trois.Mediafile']['fields'];
        foreach ($fields as $foreign_field) {

            /*
            $medias = Cache::read($model->alias . '_' . $foreign_field . '_' . $result['id'], '_mediafile_');

            if (!$medias) {
            */
                $medias = $model->query("
			
					SELECT
			
					Mediafile.id,
					Mediafile.name,
					Mediafile.date,
					Mediafile.type,
					Mediafile.size,
					Mediafile.src,
					Mediafile.embed,
					Mediafile.description,
					Mediafile.metadata
			
					FROM mediafiles AS Mediafile
			
					LEFT JOIN media_links AS MediaLink ON (Mediafile.id = MediaLink.mediafile_id )
			
					WHERE MediaLink.foreign_model = '" . $model->alias . "'
				
					AND MediaLink.foreign_field = '" . $foreign_field . "'
			
					AND MediaLink.foreign_key =" . $result['id'] . "
			
					ORDER BY MediaLink.order DESC"
                );

                foreach ($medias as &$media) {
                    if ($media['Mediafile']['metadata'])
                        $media['Mediafile']['metadata'] = unserialize($media['Mediafile']['metadata']);
                    else
                        $media['Mediafile']['metadata'] = array();
                }

                //Cache::write($model->alias . '_' . $foreign_field . '_' . $result['id'], $medias, '_mediafile_');
            //}

            $result[$foreign_field] = $medias;
        }
    }

}