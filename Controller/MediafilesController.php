<?php

App::uses('AppController', 'Controller');

/**
 * Mediafiles Controller
 *
 * @property Mediafile $Mediafile
 */
class MediafilesController extends AppController {

    public $paginate = array(
        'limit' => 25,
        'order' => array(
            'Mediafile.id' => 'desc'
        )
    );
    public $helpers = array('Trois.Media','Trois.Storage');
    public $uses = array('Trois.Mediafile', 'Trois.MediaTag', 'Trois.MediafilesMediaTags');
    public $components = array('Trois.Storage');

    public function admin_clearcache() {
        $this->Storage->rrmdir(CACHE . 'thumbs' . DS );
        $this->Storage->mkdir( CACHE . 'thumbs' );
        $this->Session->setFlash(__('Cache has been deleted!'));
        $this->redirect($this->referer());
    }
    
    public function admin_browse() {

        if (!empty($this->request->params['named'])) {

            $named = $this->request->params['named'];
            if (array_key_exists('mode', $named) && array_key_exists('param', $named)) {

                $named['param'] = $this->request->params['named']['param'] = urldecode($this->request->params['named']['param']);

                switch ($named['mode']) {

                    case 1:
                        // name or src
                        $mediafiles = $this->paginate('Mediafile', array('Mediafile.name LIKE' => '%' . $named['param'] . '%'));
                        break;

                    case 2:
                        // tag
                        $this->MediaTag->recursive = 0;
                        $tag = $this->MediaTag->findById($named['param']);
                        $this->Mediafile->bindModel(array('hasOne' => array('MediafilesMediaTags')), false);
                        $mediafiles = $this->paginate('Mediafile', array('MediafilesMediaTags.media_tag_id' => $tag['MediaTag']['id']));
                        break;
                }
            }else
                $mediafiles = $this->paginate('Mediafile');
        }else
            $mediafiles = $this->paginate('Mediafile');

        $this->set('mediafiles', $mediafiles);
    }
    
    public function admin_usage() {
        $filesCount = $this->Mediafile->find('count');
        $filesUsage = $this->Mediafile->query('SELECT SUM(size) FROM mediafiles as Mediafile');
        $filesUsage = $filesUsage[0][0]['SUM(size)'];
        $fileAverage = $filesUsage / $filesCount;
        $cacheUsage = $this->Storage->foldersize(CACHE . 'thumbs');
        
        $this->set(compact('cacheUsage', 'filesUsage','filesCount','fileAverage','totalUsage'));
    }
    
    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->set('tags', $this->MediaTag->find('all'));
        $this->set('sortMode', false);
    }
    
    public function admin_config() {

        $conf = Configure::read('Trois.media');
        $data = array(
            'maxsize' => $conf['maxsize'],
            'types' => $conf['types'],
        );
        $this->set('data', $data);
        $this->render('Common/json');
    }
    
    public function admin_uploadprocess() {

        if ($this->request->is('post')) {

            $this->Mediafile->create();
            if ($this->Mediafile->save($this->request->data)) {
                $data = array(
                    'status' => 1,
                    'message' => 'success'
                );
            } else {
                $data = array(
                    'status' => 0,
                    'message' => 'error'
                );
            }
        }

        $this->set('data', $data);
        $this->render('Common/json');
    }

    public function admin_foreignupload($foreign_model, $foreign_field, $foreign_key) {
        $this->set(compact('foreign_model', 'foreign_field', 'foreign_key'));
    }

    public function admin_upload() {
        
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Mediafile->id = $id;
        if (!$this->Mediafile->exists()) {
            throw new NotFoundException(__('Invalid mediafile'));
        }
        $this->set('mediafile', $this->Mediafile->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Mediafile->create();
            if ($this->Mediafile->save($this->request->data)) {
                $this->Session->setFlash(__('The mediafile has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The mediafile could not be saved. Please, try again.'));
            }
        }
        $mediaTags = $this->Mediafile->MediaTag->find('list');
        $this->set(compact('mediaTags'));

        // datafield
        $this->set('datafield_model', 'Mediafile');
        $this->set('datafield_field', 'metadata');
        $this->set('datafield_data', array());
    }

    public function admin_editmany($id = null) {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $data = array(
            'status' => 0,
            'message' => 'error',
            'request_data' => $this->request->data
        );

        foreach ($this->request->data as $media) {
            if ($this->Mediafile->save($media)) {
                $data = array(
                    'status' => 1,
                    'message' => 'success'
                );
            } else {
                $data = array(
                    'status' => 0,
                    'message' => 'error',
                    'request_data' => $this->request->data
                );
                break;
            }
        }
        $this->set('data', $data);
        $this->render('Common/json');
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Mediafile->id = $id;
        if (!$this->Mediafile->exists()) {
            throw new NotFoundException(__('Invalid mediafile'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Mediafile->save($this->request->data)) {
                $this->Session->setFlash(__('The mediafile has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The mediafile could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Mediafile->read(null, $id);
        }
        $mediaTags = $this->Mediafile->MediaTag->find('list');
        $this->set(compact('mediaTags'));

        // datafield
        $this->set('datafield_model', 'Mediafile');
        $this->set('datafield_field', 'metadata');
        $this->set('datafield_data', $this->request->data['Mediafile']['metadata']);
    }

    public function admin_deletemany() {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $data = array(
            'status' => 0,
            'message' => 'error',
            'request_data' => $this->request->data
        );

        if (!empty($this->request->data)) {
            foreach ($this->request->data as $media) {
                if (!empty($media['Mediafile'])) {
                    $this->Mediafile->id = $media['Mediafile']['id'];
                    if ($this->Mediafile->delete()) {
                        $data = array(
                            'status' => 1,
                            'message' => 'success'
                        );
                    } else {
                        break;
                    }
                }
            }
        }

        $this->set('data', $data);
        $this->render('Common/json');
    }

    /**
     * admin_delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Mediafile->id = $id;
        if (!$this->Mediafile->exists()) {
            throw new NotFoundException(__('Invalid mediafile'));
        }
        if ($this->Mediafile->delete()) {
            $this->Session->setFlash(__('Mediafile deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Mediafile was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
