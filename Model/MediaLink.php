<?php
App::uses('TroisAppModel', 'Trois.Model');
/**
 * MediaLink Model
 *
 * @property Mediafile $Mediafile
 */
class MediaLink extends TroisAppModel {

	public $order = "MediaLink.order DESC";
	
	private $_dataToReOrder = array();
	
	public function getCount( $m, $f, $k )
	{
		return $this->find('count',array(
				'conditions' => array(
					'MediaLink.foreign_model' => $m,
					'MediaLink.foreign_field' => $f,
					'MediaLink.foreign_key' => $k
				)
			));
	}
	
	public function beforeDelete( $cascade )
	{
		
         $this->_dataToReOrder = $this->read(null, $this->id);
		//$d = $this->_dataToReOrder['MediaLink'];
		//Cache::delete( $d['foreign_model'].'_'.$d['foreign_field'].'_'.$d['foreign_key'] , '_mediafile_');
                 
		return true;
	}
	
	public function afterSave($created)
	{
		/*
                $d = $this->read(null, $this->id);
		$d = $d['MediaLink'];
		Cache::delete( $d['foreign_model'].'_'.$d['foreign_field'].'_'.$d['foreign_key'] , '_mediafile_');
                 */
		return true;
	}
	
	public function afterDelete()
	{
		$this->_dataToReOrder = $this->find('all',array(
			'conditions' => array(
				'MediaLink.foreign_model' => $this->_dataToReOrder['MediaLink']['foreign_model'],
				'MediaLink.foreign_field' => $this->_dataToReOrder['MediaLink']['foreign_field'],
				'MediaLink.foreign_key' => $this->_dataToReOrder['MediaLink']['foreign_key']
			)
		));
		
		if( !empty($this->_dataToReOrder) )
		{
			$data = array();
			for( $i = count($this->_dataToReOrder) - 1; $i >= 0; $i-- )
			{
				$link = $this->_dataToReOrder[$i];
				$link['MediaLink']['order'] = $i;
				array_push($data, $link);
			}
			
			$this->saveMany($data);
		}
		
		return true;
	}
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'mediafile_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'order' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'foreign_key' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'foreign_field' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'foreign_model' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Mediafile' => array(
			'className' => 'Mediafile',
			'foreignKey' => 'mediafile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
