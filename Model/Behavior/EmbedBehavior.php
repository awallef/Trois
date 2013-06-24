<?php

class EmbedBehavior extends ModelBehavior
{
	
	public $settings = array();
	
	public function setup(&$model, $settings)
	{
		
		$this->settings[$model->alias] = $settings;

		// check for a datafield field (there is no default)
		if (!isset($this->settings[$model->alias]['embed_field']) || '' === $this->settings[$model->alias]['embed_field']) {
			throw new Exception('Must specify a field for EmbedBehavior');
		}
		
	}
	
	public function beforeValidate(&$model )
	{
		$field = $this->settings[$model->alias]['embed_field'];
		
		if (isset($model->data[$model->alias][$field]) ) {
			if( $model->data[$model->alias][$field] != '' && !empty( $model->data[$model->alias][$field] ) )
			{
				$type = 'embed';
				$subType = 'other';
				
				if( $model->data[$model->alias]['name'] == '' ) return false;
				
				preg_match('~soundcloud~i', $model->data[$model->alias][$field], $matches);
				if( !empty($matches) ) $subType = 'soundcloud';
				
				preg_match('~vimeo~i', $model->data[$model->alias][$field], $matches);
				if( !empty($matches) ) $subType = 'vimeo';
				
				preg_match('~youtu~i', $model->data[$model->alias][$field], $matches);
				if( !empty($matches) ) $subType = 'youtube';
				
				$model->data[$model->alias]['type'] = $type.'/'.$subType;
				$model->data[$model->alias]['size'] = 0;
				$model->data[$model->alias]['date'] = date('Y-m-d H:i:s');
				
				$model->data[$model->alias]['src'] == '';
					
				if( $subType == 'youtube' )
				{
					preg_match('~/embed/([0-9a-z_-]+)~i', $model->data[$model->alias][$field], $matches);
					if( !empty($matches) )
					{
						$model->data[$model->alias]['src'] = 'http://img.youtube.com/vi/'.$matches[1].'/0.jpg';//$matches[1];
					}
				}
				
				if( $subType == 'vimeo' )
				{
					preg_match('~/video/([0-9a-z_-]+)~i', $model->data[$model->alias][$field], $matches);
					if( !empty($matches) )
					{
						$imgid = $matches[1];
						$hash = unserialize($this->_curl_get("http://vimeo.com/api/v2/video/".$imgid.".php"));
						$model->data[$model->alias]['src'] = $hash[0]['thumbnail_medium'];
					}
				}
				
				
			}	
		}
		
		return true;
	}
	
	public function beforeSave( &$model )
	{
		
		
		if (!empty($model->data[$model->alias]['src']) ) {
			
			if( $model->data[$model->alias]['src'] != '' && !empty( $model->data[$model->alias]['src'] ) && !is_array( $model->data[$model->alias]['src'] ) && ( $model->data[$model->alias]['type'] == 'embed/youtube' || $model->data[$model->alias]['type'] == 'embed/vimeo' ) )
			{
				//Get the file
				$content = file_get_contents($model->data[$model->alias]['src']);
				
				
				$name = 'embed_'. preg_replace('/[^a-z0-9_.]/i', '', $model->data[$model->alias]['name'].'.jpg');
				
				$folder = new Folder();
				$path = WWW_ROOT .'files'.DS.date("Y").DS.date("m");
				$folder->create( $path, false );
				
				$model->data[$model->alias]['src'] = 'files'.DS.date("Y").DS.date("m").DS.$name;
				
				
				//Store in the filesystem.
				$fp = fopen($path.DS.$name, "w");
				fwrite($fp, $content);
				fclose($fp);
				
				$model->data[$model->alias]['size'] = filesize( $path.DS.$name );
			}
		}
		
		return true;
	}
	
	// vimeo get image...
	private function _curl_get($url, array $get = NULL, array $options = array()) 
	{    
	    $defaults = array( 
	        CURLOPT_URL => $url, 
	        CURLOPT_HEADER => 0, 
	        CURLOPT_RETURNTRANSFER => TRUE, 
	        CURLOPT_TIMEOUT => 4 
	    ); 
	    
	    $ch = curl_init(); 
	    curl_setopt_array($ch, ($options + $defaults)); 
	    if( ! $result = curl_exec($ch)) 
	    { 
	        trigger_error(curl_error($ch)); 
	    } 
	    curl_close($ch); 
	    return $result; 
	} 
}