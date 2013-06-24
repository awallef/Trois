<?php

App::uses('AppController', 'Controller');

class SitemapController extends AppController {

    public $uses = array();
    
    public function index(){
        
        // load sitemap.php
        if (file_exists(APP . DS . 'Config' . DS . 'Sitemap.php'))
		    App::import('Config', 'Sitemap' );
		else
		    App::import('Trois.Config', 'Sitemap' );
        
		$sitemap = new Sitemap( $this->request, $this->response);
		$sitemap->constructClasses();
		$this->set('data',$sitemap->get_sitemap_array());
    }
}
?>
