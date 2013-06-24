<?php

/**
 * CakePHP Helper
 * @author juda
 */
class StorageHelper extends AppHelper {

    public function format_size($size) {
        $units = explode(' ', 'B KB MB GB TB PB');
        $mod = 1024;
        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }
        $endIndex = strpos($size, ".")+3;
        return round($size, 3).' '.$units[$i];
    }
}
