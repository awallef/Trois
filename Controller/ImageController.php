<?php

App::uses('AppController', 'Controller');

class ImageController extends AppController {
    
    public $uses = array();
    
    public function view(  ) {
        $this->set('params', $this->request->query);
        App::import('Trois.View','TroisImageView');
        $this->viewClass = 'TroisImage';
    }
    
}


?>
