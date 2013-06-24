<?php


/* fix cake plugin assets!!! 2.1 to 2.X
****************************************************/
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher'
));

/* some vars...
****************************************************/

Configure::write('Trois.applicationName', 'Trois');
Configure::write('Trois.applicationIconSrc', '/trois/assets/icons/iPhone114.png');
Configure::write('Trois.applicationSplachIphoneSrc', '/trois/assets/icons/IphoneSplash.png');



/* * ***************************************************
 * *****************************************************
  _________               .__
  \_   ___ \_____    ____ |  |__   ____
  /    \  \/\__  \ _/ ___\|  |  \_/ __ \
  \     \____/ __ \\  \___|   Y  \  ___/
  \______  (____  /\___  >___|  /\___  >
  \/     \/     \/     \/     \/
 * *****************************************************
 * **************************************************** */

$engine = 'File';
if (extension_loaded('apc') && function_exists('apc_dec') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
    $engine = 'Apc';
}

// In development mode, caches should expire quickly.
$duration = '+14 days';
if (Configure::read('debug') >= 1) {
    $duration = '+2 hours';
}

// Prefix each application on the same server with a different string, to avoid Memcache and APC conflicts.
$prefix = 'trois_';

// MEDIAFILE.....
if (!is_dir(CACHE . 'Trois' . DS))
{
    mkdir(CACHE . 'Trois' . DS,0777);
}

Cache::config('_mediafile_', array(
    'engine' => $engine,
    'prefix' => $prefix . 'mediafile_',
    'path' => CACHE . 'Trois' . DS,
    'serialize' => ($engine === 'File'),
    'duration' => $duration,
    'groups' => array('trois_mediafile')
));



/* * *
 *       _____             .___.__        _____.__.__                 
 *      /     \   ____   __| _/|__|____ _/ ____\__|  |   ____   ______
 *     /  \ /  \_/ __ \ / __ | |  \__  \\   __\|  |  | _/ __ \ /  ___/
 *    /    Y    \  ___// /_/ | |  |/ __ \|  |  |  |  |_\  ___/ \___ \ 
 *    \____|__  /\___  >____ | |__(____  /__|  |__|____/\___  >____  >
 *            \/     \/     \/         \/                   \/     \/ 
 */


if (file_exists(APP . DS . 'Config' . DS . 'media.php'))
    require_once(APP . DS . 'Config' . DS . 'media.php');
else
    require_once('media.php');