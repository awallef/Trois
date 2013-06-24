<?php

Router::connect('/admin', array('controller' => 'Welcome', 'action' => 'index', 'admin' => true, 'plugin' => 'trois'));

Router::connect('/sitemap', array('controller' => 'Sitemap', 'action' => 'index', 'admin' => false, 'plugin' => 'trois'));

$extentions = Router::extensions();

if(empty($extentions))
{
    Router::parseExtensions('json','xml');
}else{
    if(array_search('json', $extentions) === false)
    {
        array_push($extentions, 'json');
    }
    
    if(array_search('xml', $extentions) === false)
    {
        array_push($extentions, 'xml');
    }
    
    call_user_func_array('Router::parseExtensions', $extentions);
}