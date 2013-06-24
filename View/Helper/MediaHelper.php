<?php

App::uses('AppHelper', 'View/Helper');

class MediaHelper extends AppHelper {

    public $helpers = array('Html');

    public function input($model, $field) {
        return $this->_View->element('helper/input', array('model'=>$model,'field'=>$field), array('plugin'=>'Trois'));
    }

    public function processUrl($src, $vars) {
        return $this->Html->url('/image.php?image='.$this->Html->url('/app/webroot/').$src).$vars;
    }
    
    public function thumb($params) {
        return $this->Html->url(array('controller' => 'image',  'action' => 'view', 'plugin' => 'trois', 'admin' => false)) .'?'. http_build_query($params);
    }
    
    public function videoThumb( $params ){
        
        // youtube short link 
        preg_match('~/youtu.be/([0-9a-z_-]+)~i', $params['image'], $matches);
        if( !empty($matches) ) $params['image'] = 'http://img.youtube.com/vi/'.$matches[1].'/0.jpg';//$matches[1];
        $matches = array();
        
        // youtube long link
        preg_match('~v=([0-9a-z_-]+)~i', $params['image'], $matches);
        if( !empty($matches) ) $params['image'] = 'http://img.youtube.com/vi/'.$matches[1].'/0.jpg';//$matches[1];
        $matches = array();
        
        preg_match('~/vimeo.com/([0-9a-z_-]+)~i', $params['image'], $matches);
        if( !empty($matches) ) {
                $imgid = $matches[1];
                $hash = unserialize($this->_curl_get("http://vimeo.com/api/v2/video/".$imgid.".php"));
                $params['image'] = $hash[0]['thumbnail_medium'];
        }
        
        return $this->Html->url(array('controller' => 'image',  'action' => 'view', 'plugin' => 'trois', 'admin' => false)) .'?'. http_build_query($params);
    }
    
    public function hasImagePreview($type ) {
        return ( $type == 'image/jpeg' ) || ( $type == 'image/png' ) || ( $type == 'embed/youtube' ) || ( $type == 'embed/vimeo' );
    }

    public function fluidVideo($media) {
        $embed = $media['Mediafile']['embed'];

        $pattern = "/height=\"[0-9]*\"/";
        $embed = preg_replace($pattern, "height='100%'", $embed);
        $pattern = "/width=\"[0-9]*\"/";
        $embed = preg_replace($pattern, "width='100%'", $embed);

        $html = '<div style="position:relative;width: 100%; height:62%; display:inline-block;">
			<div style="*height: 62%;margin-top: 62%;"></div>
		    <div style="position: absolute;top:0;left:0;bottom:0;right:0;">' . $embed . '</div>
		</div>';

        return $html;
    }

}
