<?php

App::uses('MediaView', 'View');
App::uses('CakeRequest', 'Network');
App::uses('Folder', 'Utility');

class TroisImageView extends MediaView {

    public function render($view = null, $layout = null) {

        // set vars
        $name = $download = $extension = $id = $modified = $path = $cache = $mimeType = $compress = null;
        extract($this->viewVars, EXTR_OVERWRITE);

        $this->viewVars['thumbName'] = $thumbName = md5(json_encode($this->viewVars['params']));
        $dir = new Folder(CACHE . 'thumbs', true, 0755);
        $files = $dir->find($this->viewVars['thumbName']);

        if (empty($files)){
            $pos = strpos($this->viewVars['params']['image'], 'http://');
            if ($pos !== FALSE){
                $this->_loadExternalFile();
                $this->_resizeFile();
                unlink($this->viewVars['params']['image']);
                
            }else {
                $this->viewVars['params']['image'] = APP . 'webroot/' . $this->viewVars['params']['image'];
                $this->_resizeFile();
            }
        }
        
        $pos1 = strrpos( $params['image'], '.' );
        $id = substr( $params['image'], $pos1 + 1, 8 );
        $this->response->type($id);
        $this->viewVars['path'] = CACHE . 'thumbs' . DS . $thumbName;
        $this->viewVars['download'] = false;
        parent::render();
        
    }

    private function _loadExternalFile() {

        extract($this->viewVars, EXTR_OVERWRITE);

        $fileName = tempnam(sys_get_temp_dir(), 'TroisFile_');
        $path = $params['image'];
        $config = Configure::read('Trois.media');

        if (array_key_exists('http_user', $config)) {
            $exp = explode('//', $path);
            $path = $exp[0] . '//' . $config['http_user'] . ':' . $config['http_pass'] . '@' . $exp[1];
        }

        if (($curl = curl_init($path)) == false) {
            throw new Exception("curl_init error for url $url.");
        }

        if (($fp = fopen($fileName, "wb")) === false) {
            throw new Exception("fopen error for filename $tmpFile");
        }
        curl_setopt($curl, CURLOPT_FILE, $fp);

        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);

        if (curl_exec($curl) === false) {
            fclose($fp);
            unlink($fileName);
            throw new Exception("curl_exec error for url $path.");
        } else {
            fclose($fp);
        }

        curl_close($curl);

        $this->viewVars['params']['image'] = $fileName;
        
    }

    private function _resizeFile() {

        ini_set('memory_limit', '128M');

        extract($this->viewVars, EXTR_OVERWRITE);

        // Get the size and MIME type of the requested image
        $size = GetImageSize($params['image']);
        
        if(array_key_exists('cropratio', $params))
        {
            $s = explode(':', $params['cropratio']);
            $r = $s[0] / $s[1];
            if (!array_key_exists('width', $params) && array_key_exists('height', $params) ) {
                $params['width'] = $params['height'] * $r;
            }
            
            if (!array_key_exists('height', $params) && array_key_exists('width', $params) ) {
                $params['height'] = $params['width'] / $r;
            }
        }
        
        $width = (array_key_exists('width', $params))? $params['width'] : 0;
        $height = (array_key_exists('height', $params))? $params['height'] : 0;
        
        $maxWidth = $width;
        $maxHeight = $height;
        $width = $size[0];
        $height = $size[1];



        // Ratio cropping
        $offsetX = 0;
        $offsetY = 0;

        $ratioComputed = $width / $height;


        // no crop if asked...
        if ($maxWidth == null || $maxWidth == 0) {
            $maxWidth = $maxHeight * $ratioComputed;
        }

        if ($maxHeight == null || $maxHeight == 0) {
            $maxHeight = $maxWidth / $ratioComputed;
        }


        $cropRatioComputed = $maxWidth / $maxHeight;

        if ($ratioComputed < $cropRatioComputed) { // Image is too tall so we will crop the top and bottom
            $origHeight = $height;
            $height = $width / $cropRatioComputed;
            $offsetY = ($origHeight - $height) / 2;
        } else if ($ratioComputed > $cropRatioComputed) { // Image is too wide so we will crop off the left and right sides
            $origWidth = $width;
            $width = $height * $cropRatioComputed;
            $offsetX = ($origWidth - $width) / 2;
        }

        // Setting up the ratios needed for resizing. We will compare these below to determine how to
        // resize the image (based on height or based on width)
        $xRatio = $maxWidth / $width;
        $yRatio = $maxHeight / $height;

        if ($xRatio * $height < $maxHeight) { // Resize the image based on width
            $tnHeight = ceil($xRatio * $height);
            $tnWidth = $maxWidth;
        } else { // Resize the image based on height
            $tnWidth = ceil($yRatio * $width);
            $tnHeight = $maxHeight;
        }

        // Determine the quality of the output image
        $quality = 90;

        // Set up a blank canvas for our resized image (destination)
        $dst = imagecreatetruecolor($tnWidth, $tnHeight);
        $pos1 = strrpos( $params['image'], '.' );
        $extension = substr( $params['image'], $pos1 + 1, 8 );
        switch ($this->response->type($extension)) {
            case 'image/gif':
                // We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
                // This is maybe not the ideal solution, but IE6 can suck it
                $creationFunction = 'ImageCreateFromGif';
                $outputFunction = 'ImagePng';
                $mime = 'image/png'; // We need to convert GIFs to PNGs
                $doSharpen = FALSE;
                $quality = round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
                break;

            case 'image/x-png':
            case 'image/png':
                $creationFunction = 'ImageCreateFromPng';
                $outputFunction = 'ImagePng';
                $doSharpen = FALSE;
                $quality = round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
                break;

            default:
                $creationFunction = 'ImageCreateFromJpeg';
                $outputFunction = 'ImageJpeg';
                $doSharpen = TRUE;
                break;
        }

        if (in_array($this->response->type($extension), array('image/gif', 'image/png'))) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }

        // Read in the original image
        $src = $creationFunction($params['image']);

        // Resample the original image into the resized canvas we set up earlier
        ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);

        if ($doSharpen) {
            // Sharpen the image based on two things:
            //	(1) the difference between the original size and the final size
            //	(2) the final size
            $sharpness = $this->_findSharp($width, $tnWidth);

            $sharpenMatrix = array(
                array(-1, -2, -1),
                array(-2, $sharpness + 12, -2),
                array(-1, -2, -1)
            );
            $divisor = $sharpness;
            $offset = 0;
            imageconvolution($dst, $sharpenMatrix, $divisor, $offset);
        }

        // Write the resized image to the cache
        $outputFunction($dst, CACHE . 'thumbs' . DS . $thumbName, $quality);

        // Clean up the memory
        ImageDestroy($src);
        ImageDestroy($dst);
    }

    private function _findSharp($orig, $final) { // function from Ryan Rud (http://adryrun.com)
        $final = $final * (750.0 / $orig);
        $a = 52;
        $b = -0.27810650887573124;
        $c = .00047337278106508946;

        $result = $a + $b * $final + $c * $final * $final;

        return max(round($result), 0);
    }

    private function _deliverCacheFile() {

        $name = $download = $extension = $id = $modified = $path = $cache = $mimeType = $compress = null;
        extract($this->viewVars, EXTR_OVERWRITE);
        
        $pos1 = strrpos( $params['image'], '.' );
        $extention = substr( $params['image'], $pos1 + 1, 8 );
        
        $path = CACHE . 'thumbs' . DS . $thumbName;
        $download = false;
        $this->response->type($extention);

        if ($cache) {
                if (!empty($modified) && !is_numeric($modified)) {
                        $modified = strtotime($modified, time());
                } else {
                        $modified = time();
                }
                $this->response->cache($modified, $cache);
        } else {
                $this->response->disableCache();
        }

        if ($name !== null) {
                $name .= '.' . pathinfo($id, PATHINFO_EXTENSION);
        }
        $this->response->file($path, compact('name', 'download'));

        if ($compress) {
                $this->response->compress();
        }
        $this->response->send();
        return true;
    }

}
