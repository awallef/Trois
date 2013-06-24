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

App::uses('Helper', 'View');
class AppHelper extends Helper {
    
    public function url($url = null, $full = false) {
        return parent::url(router_url_language($url), $full);
    }
    
}
