<?php

App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');

class ImageController extends AppController {
    
    public $uses = array();
    
    public function view(  ) {
        
        $thumbName = md5(json_encode($this->request->query));
        $dir = new Folder(CACHE . 'thumbs', true, 0755);
        $files = $dir->find($thumbName);
        
        if(!empty($files)){
            
            $modified = @filemtime (CACHE . 'thumbs/' . $thumbName);
            //debug( $modified );
            $this->response->modified($modified);
            //debug($this->response->checkNotModified($this->request));
            if ($this->response->checkNotModified($this->request))
            {
                $this->autoRender = false;
                $this->response->send();
                return;
            }
        }
        
        $this->set('params', $this->request->query);
        App::import('Trois.View','TroisImageView');
        $this->viewClass = 'TroisImage';
     
    }
    
}


?>
