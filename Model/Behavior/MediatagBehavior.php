<?php

class MediatagBehavior extends ModelBehavior
{
	
	public $settings = array();
	
	public function setup(&$model, $settings)
	{
		
		$this->settings[$model->alias] = $settings;

		// check for a datafield field (there is no default)
		if (!isset($this->settings[$model->alias]['tag_field']) || '' === $this->settings[$model->alias]['tag_field']) {
			throw new Exception('Must specify a field for MediatagBehavior');
		}
		
	}
	
	public function beforeValidate(&$model )
	{
		$tag_field = $this->settings[$model->alias]['tag_field'];
		
		if (isset($model->data[$model->alias][$tag_field]) ) {
			if( $model->data[$model->alias][$tag_field] != '' )
			{
				preg_match_all("/(#\w+)/", $model->data[$model->alias][$tag_field], $hashMatches);
				preg_match_all("/(@\w+)/", $model->data[$model->alias][$tag_field], $atMatches);				
				$matches = array_merge( $hashMatches[0], $atMatches[0]);
				
				$tags = array();
				
				foreach( $matches as $tag ){
					$row = $model->MediaTag->find('first', array(
			        	'conditions' => array('MediaTag.name' => $tag)
				    ));
				    
				    if( !$row ){
		    
				    	$model->MediaTag->create();
				    	$data = array('name' => $tag );
				    	$model->MediaTag->save( $data );
				    	array_push( $tags, $model->MediaTag->getLastInsertId() );
				    	
				    }else{
				    	array_push( $tags, $row['MediaTag']['id']  );
				    }
				}
				
				$model->data['MediaTag']['MediaTag'] = $tags;
			}	
		}
		
		return true;
	}
	
}