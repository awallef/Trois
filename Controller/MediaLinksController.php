<?php
App::uses('AppController', 'Controller');
/**
 * MediaLinks Controller
 *
 * @property MediaLink $MediaLink
 */
class MediaLinksController extends AppController {

	public $uses = array('Trois.MediaLink','Trois.MediaTag');
	
	public function admin_toto()
	{
		debug( $this->MediaLink->getCount('Album', 'album', 1));
	}
	
	public function admin_foreignsort( $foreign_model, $foreign_field, $foreign_key )
	{
		$this->set(compact('foreign_model','foreign_field','foreign_key') );
		
		$mediafiles = $this->MediaLink->find('all',array(
			'conditions' => array(
				'MediaLink.foreign_model' => $foreign_model,
				'MediaLink.foreign_field' => $foreign_field,
				'MediaLink.foreign_key' => $foreign_key
			)
		));
		
		//debug( $mediafiles );
		$this->set('tags', $this->MediaTag->find('all') );
		$this->set('sortMode',true);
		$this->set('mediafiles',$mediafiles);
	
	}
	
	public function admin_sortprocess( $foreign_model, $foreign_field, $foreign_key )
	{
		$reqData = $this->request->data;
		$data = array();
		
		if( !empty($reqData['Mediafile']))
		{
		
			foreach( $reqData['Mediafile'] as $id => $order )
			{
				$data[] = array(
					'id' => $id,
					'order' => $order
				);
			}
			
			if( $this->MediaLink->saveMany($data) )
			{
				$this->Session->setFlash(__('Madiafile list has been updated'));
			}else{
				$this->Session->setFlash(__('Madiafile list couldn\'t be updated'));
			}
		}
		$this->redirect(array('controller' => Inflector::pluralize($foreign_model), 'action' => 'edit', 'admin' => true, 'plugin' => false, $foreign_key ));
	}
	

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->MediaLink->recursive = 0;
		$this->set('mediaLinks', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->MediaLink->id = $id;
		if (!$this->MediaLink->exists()) {
			throw new NotFoundException(__('Invalid media link'));
		}
		$this->set('mediaLink', $this->MediaLink->read(null, $id));
	}
	
	
	public function admin_addmany()
	{
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		$data = array(
			'status' => 0,
			'message' => 'error 1',
			'request_data' => $this->request->data
		);
		
		if( !empty($this->request->data) )
		{
			if(!empty($this->request->data[0]['MediaLink']))
			{
				$results = $this->MediaLink->find('all',array(
					'conditions' => array(
						'MediaLink.foreign_model' => $this->request->data[0]['MediaLink']['foreign_field'],
						'MediaLink.foreign_field' => $this->request->data[0]['MediaLink']['foreign_field'],
						'MediaLink.foreign_key' => $this->request->data[0]['MediaLink']['foreign_key']
					)
				));
				
				$count = count( $results );
				
				$ids = array();
				foreach( $results as $result  ) array_push( $ids, $result['Mediafile']['id'] );
			}
			
			foreach( $this->request->data as $media)
			{
				if( !in_array($media['Mediafile']['id'], $ids) )
				{
					$this->MediaLink->create();
					$media['MediaLink']['order'] = $count;
					$media['MediaLink']['mediafile_id'] = $media['Mediafile']['id'];
					if( $this->MediaLink->save($media))
					{
						$data = array(
							'status' => 1,
							'message' => 'success'
						);
						
						$count++;
						
					}else{
						
						$data = array(
							'status' => 0,
							'message' => 'error 2',
							'request_data' => $this->request->data
						);
						break;
					}
				}else{
					$data = array(
						'status' => 1,
						'message' => 'success'
					);
				}
			}
		}
		
		$this->set('data', $data );
		$this->render('Common/json');
		
	}
	
/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->MediaLink->create();
			if ($this->MediaLink->save($this->request->data)) {
				$this->Session->setFlash(__('The media link has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media link could not be saved. Please, try again.'));
			}
		}
		$mediafiles = $this->MediaLink->Mediafile->find('list');
		$this->set(compact('mediafiles'));
	}


	public function admin_deletemany()
	{
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		$data = array(
			'status' => 0,
			'message' => 'error',
			'request_data' => $this->request->data
		);
		
		if( !empty($this->request->data) )
		{
			foreach( $this->request->data as $media)
			{
				if(!empty($media['MediaLink']))
				{
					$this->MediaLink->id = $media['MediaLink']['id'];
					if( $this->MediaLink->delete())
					{
						$data = array(
							'status' => 1,
							'message' => 'success'
						);
					}else{
						break;
					}
				}
			}
		}
		
		$this->set('data', $data );
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
		$this->MediaLink->id = $id;
		if (!$this->MediaLink->exists()) {
			throw new NotFoundException(__('Invalid media link'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MediaLink->save($this->request->data)) {
				$this->Session->setFlash(__('The media link has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media link could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->MediaLink->read(null, $id);
		}
		$mediafiles = $this->MediaLink->Mediafile->find('list');
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
		$this->MediaLink->id = $id;
		if (!$this->MediaLink->exists()) {
			throw new NotFoundException(__('Invalid media link'));
		}
		if ($this->MediaLink->delete()) {
			$this->Session->setFlash(__('Media link deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Media link was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
