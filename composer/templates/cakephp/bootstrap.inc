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

/**
 * Normal config
 */
Cache::config('default', array('engine' => 'File'));

Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'FileLog',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'FileLog',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));


/***
 *    ___________.__                           _________         __           
 *    \__    ___/|  |_________   ____   ____   \_   ___ \_____  |  | __ ____  
 *      |    |   |  |  \_  __ \_/ __ \_/ __ \  /    \  \/\__  \ |  |/ // __ \ 
 *      |    |   |   Y  \  | \/\  ___/\  ___/  \     \____/ __ \|    <\  ___/ 
 *      |____|   |___|  /__|    \___  >\___  >  \______  (____  /__|_ \\___  >
 *                    \/            \/     \/          \/     \/     \/    \/ 
 */

CakePlugin::load('Trois', array('bootstrap' => true,'routes'=>true));


Configure::write('Trois.backendMenu', array(
    
    /** functionalities in Trois plugin boy!!! **/
    'Medias'                => array(
        
        'dropdown' => array(
            'Bibliothèque'             => array('controller'=>'Mediafiles', 'action' => 'index', 'admin' => true, 'plugin' => 'trois' ),
            'Téléverser des fichiers' => array('controller'=>'Mediafiles', 'action' => 'upload', 'admin' => true, 'plugin' => 'trois' ),
            'Gestion des tags'          => array('controller'=>'MediaTags', 'action' => 'index', 'admin' => true, 'plugin' => 'trois' ),
            'Utilisation'          => array('controller'=>'Mediafiles', 'action' => 'usage', 'admin' => true, 'plugin' => 'trois' ),
        )
    ),
    
    'Utilisateurs' => array(
        'dropdown' => array(
            'Utilisateurs'          => array('controller'=>'Users', 'action' => 'index', 'admin' => true, 'plugin' => 'trois' ),
            'Groupes'               => array('controller'=>'Groups', 'action' => 'index', 'admin' => true, 'plugin' => 'trois' ),
        )
    )
    
    
    
));

/*
 * Configure::write('Config.languages', array('eng','fra') );
 * Configure::write('Config.language', 'eng');
 */

define('DEFAULT_LANGUAGE', 'eng');
if (!function_exists('router_url_language')) {
    function router_url_language($url) {
        if ($lang = Configure::read('Config.language')) {
            if (is_array($url)) {
                if (!isset($url['language'])) {
                    $url['language'] = $lang;
                }
                if ($url['language'] == DEFAULT_LANGUAGE) {
                    unset($url['language']);
                }
            } else if ($url == '/' && $lang !== DEFAULT_LANGUAGE) {
                $url.= $lang;
            }
        }

        return $url;
    }
}