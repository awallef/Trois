<?php
App::uses('AppController', 'Controller');
/**
 * MediaTags Controller
 *
 * @property MediaTag $MediaTag
 */
class MediaTagsController extends AppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->MediaTag->recursive = 0;
		$this->set('mediaTags', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->MediaTag->id = $id;
		if (!$this->MediaTag->exists()) {
			throw new NotFoundException(__('Invalid media tag'));
		}
		$this->set('mediaTag', $this->MediaTag->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->MediaTag->create();
			if ($this->MediaTag->save($this->request->data)) {
				$this->Session->setFlash(__('The media tag has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media tag could not be saved. Please, try again.'));
			}
		}
		$mediafiles = $this->MediaTag->Mediafile->find('list');
		$this->set(compact('mediafiles'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->MediaTag->id = $id;
		if (!$this->MediaTag->exists()) {
			throw new NotFoundException(__('Invalid media tag'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MediaTag->save($this->request->data)) {
				$this->Session->setFlash(__('The media tag has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media tag could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->MediaTag->read(null, $id);
		}
		$mediafiles = $this->MediaTag->Mediafile->find('list');
		$this->set(compact('mediafiles'));
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
		$this->MediaTag->id = $id;
		if (!$this->MediaTag->exists()) {
			throw new NotFoundException(__('Invalid media tag'));
		}
		if ($this->MediaTag->delete()) {
			$this->Session->setFlash(__('Media tag deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Media tag was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
