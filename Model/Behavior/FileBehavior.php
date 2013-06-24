<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('AuthComponent', 'Controller/Component');

class FileBehavior extends ModelBehavior {

    public $settings = array();
    private $_fileToRemove = false;

    public function setup(&$model, $settings) {

        $this->settings[$model->alias] = $settings;

        // check for a datafield field (there is no default)
        if (!isset($this->settings[$model->alias]['file_field']) || '' === $this->settings[$model->alias]['file_field']) {
            throw new Exception('Must specify a field for FileBehavior');
        }
    }

    public function getPath(&$model, $path, $type, $subtype) {

        //'{$modelName}{DS}{$group}{DS}{$user}{DS}{$year}{DS}{$month}{DS}{$type}{DS}{$subtype}{DS}{$fileName}';

        $user = AuthComponent::user();
        if ($user === null) {
            $group = 'public';
            $user = 'default';
        } else {
            $group = $user['group_id'];
            $user = $user['id'];
        }

        $path = str_replace(array(
            '{$modelName}',
            '{DS}',
            '{$group}',
            '{$user}',
            '{$year}',
            '{$month}',
            '{$type}',
            '{$subtype}'
                ), array(
            $model->alias,
            DS,
            $group,
            $user,
            date("Y"),
            date("m"),
            $type,
            $subtype
                ), $path);

        return $path;
    }

    public function beforeValidate(&$model) {
        $field = $this->settings[$model->alias]['file_field'];

        if (isset($model->data[$model->alias][$field])) {
            if ($model->data[$model->alias][$field] != '' && !empty($model->data[$model->alias][$field]) && is_array($model->data[$model->alias][$field])) {

                //if( $model->data[$model->alias][$field]['name'] == '' ) return true;

                if ($model->data[$model->alias][$field]['error'] != 0)
                    throw new Exception('Upload Error occured');

                $model->data[$model->alias]['type'] = $model->data[$model->alias][$field]['type'];
                $model->data[$model->alias]['size'] = $model->data[$model->alias][$field]['size'];
                $model->data[$model->alias]['date'] = date('Y-m-d H:i:s');

                // name of file...
                if (!isset($model->data[$model->alias]['name']))
                    $model->data[$model->alias]['name'] = $model->data[$model->alias][$field]['name'];

                if ($model->data[$model->alias]['name'] == '')
                    $model->data[$model->alias]['name'] = $model->data[$model->alias][$field]['name'];
            }
        }

        return true;
    }

    public function beforeSave(&$model) {
        $field = $this->settings[$model->alias]['file_field'];

        if (isset($model->data[$model->alias][$field])) {
            if ($model->data[$model->alias][$field] != '' && !empty($model->data[$model->alias][$field]) && is_array($model->data[$model->alias][$field])) {

                // NAME
                $name = time() . '_' . preg_replace('/[^a-z0-9_.]/i', '', $model->data[$model->alias][$field]['name']);

                // TEMPNAME
                $temp_name = $model->data[$model->alias][$field]['tmp_name'];

                // TYPE
                $fullType = $model->data[$model->alias][$field]['type'];
                $type = explode('/', $fullType);
                $subtype = $type[1];
                $type = $type[0];

                // GET CONFIG
                $conf = Configure::read('Trois.media');

                // CHECK type
                if (( in_array($fullType, $conf['types']) === false))
                    throw new Exception('This file type is not suported!');
                
                // CHECK Size
                if ($conf['maxsize'] < $model->data[$model->alias][$field]['size'])
                    throw new Exception('This file is too large ma size is : '  . ( $conf['maxsize'] / ( 1024 * 1024 * 1000 ) ) .' MB');

                switch ($conf['fileEngine']) {
                    case 'local':
                        $path = WWW_ROOT . $conf['base'] . DS . $this->getPath($model, $conf['path'], $type, $subtype);
                        $folder = new Folder();
                        $folder->create($path, false);

                        $model->data[$model->alias][$field] = $conf['base'] . DS . $this->getPath($model, $conf['path'], $type, $subtype) . DS . $name;
                        if( move_uploaded_file($temp_name, $path . DS . $name) )
                        {
                            return true;
                        }else
                            throw new Exception('Unable to move file on Server HD');
                        break;

                    case 'cloudFiles':
                        App::import('Vendor', 'Trois.Cloudfiles', array('file' => 'php-cloudfiles' . DS . 'cloudfiles.php'));

                        $auth = new CF_Authentication($conf['user'], $conf['secret']);
                        $auth->authenticate();
                        $conn = new CF_Connection($auth);

                        $container = $conn->get_container($conf['base']);

                        $path = $this->getPath($model, $conf['path'], $type, $subtype);

                        $file = $container->create_object($path . DS . $name);
                        $file->content_type = $fullType;
                        if ($file->load_from_filename($temp_name)) {
                            $model->data[$model->alias][$field] = $file->public_uri();
                            return true;
                        }else 
                            throw new Exception('Unable to upload file on Cloud File');

                        break;
                }

                /*
                  $folder = new Folder();
                  $path = WWW_ROOT . 'files' . DS . date("Y") . DS . date("m");
                  $folder->create($path, false);
                  $temp_name = $model->data[$model->alias][$field]['tmp_name'];

                  $model->data[$model->alias][$field] = 'files' . DS . date("Y") . DS . date("m") . DS . $name;

                  return move_uploaded_file($temp_name, $path . DS . $name);
                 * 
                 */
            }
        }

        return true;
    }

    function beforeDelete(&$model) {
        $field = $this->settings[$model->alias]['file_field'];
        $this->_fileToRemove = false;
        $model->read(null, $model->id);
        if (isset($model->data)) {

            $conf = Configure::read('Trois.media');

            if ($model->data[$model->alias][$field] != '' && $model->data[$model->alias]['size'] > 0 && $conf['delete']) {
                $this->_fileToRemove = $model->data[$model->alias][$field];
            }
        }
        return true;
    }

    function afterDelete(&$model) {
        if ($this->_fileToRemove) {
            $conf = Configure::read('Trois.media');

            switch ($conf['fileEngine']) {
                case 'local':
                    $file = new File(WWW_ROOT . $this->_fileToRemove);
                    return $file->delete();
                    break;

                case 'cloudFiles':
                    App::import('Vendor', 'Trois.Cloudfiles', array('file' => 'php-cloudfiles' . DS . 'cloudfiles.php'));

                    $auth = new CF_Authentication($conf['user'], $conf['secret']);
                    $auth->authenticate();
                    $conn = new CF_Connection($auth);

                    $container = $conn->get_container($conf['base']);
                    return $container->delete_object( $this->_fileToRemove );
                    
                    break;
            }
        }
        return true;
    }

}