<?php
App::uses('AppController', 'Controller');

class Sitemap extends AppController {

    public $uses = array('Client');
    
    public function get_sitemap_array(){
        
        $sitemap = array(
			array(
				'loc' => '/',
				'lastmod' => Date('Y-m-d'),
				'changefreq' => 'weekly',
				'priority' => 1	
			)
		);
		return $sitemap;
    }
}
?>