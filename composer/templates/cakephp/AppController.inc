<?php
/*** 
 *    ________ ____  _____      __ 
 *    \_____  \\   \/  /  \    /  \
 *      _(__  < \     /\   \/\/   /
 *     /       \/     \ \        / 
 *    /______  /___/\  \ \__/\  /  
 *           \/      \_/      \/   
 * 
 *      Trois admin v 1.0.1
 * 
 *      Copyright 2013 3xw, GmbH
 *      Belmont - Switzerland
 *      made by cousteau
 *
 *
 */
App::uses('TroisAppController', 'Trois.Controller');

class AppController extends TroisAppController {

    public $components = array(
        'Session',
        'Auth' => array(
            //'loginRedirect' => array('controller' => 'users', 'action' => 'index', 'admin' => true, 'plugin' => 'trois' ),
            //'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home')
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email')
                )
            ),
            'loginAction' => array(
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => 'trois'
            ),
        ),
        'RequestHandler',
        
    );
    
    public $helpers = array('Trois.Media');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
}