<?php

class DatafieldBehavior extends ModelBehavior
{
	
	public $settings = array();
	
	public function setup(&$model, $settings)
	{
		
		$this->settings[$model->alias] = $settings;

		// check for a datafield field (there is no default)
		if (!isset($this->settings[$model->alias]['data_field']) || '' === $this->settings[$model->alias]['data_field']) {
			throw new Exception('Must specify a field for DatafieldBehavior');
		}
		
	}
	
	public function afterFind(&$model, $results, $primary)
	{
		$data_field = $this->settings[$model->alias]['data_field'];
		for( $i = 0; $i < count( $results ); $i++ )
		{
			if (isset($results[$i][$model->alias][$data_field]))
			{
				if( $results[$i][$model->alias][$data_field] != '' )
				{
					$results[$i][$model->alias][$data_field] = unserialize($results[$i][$model->alias][$data_field]);
				}
			}
		}
		
		return $results;
	}
	
	public function beforeSave(&$model)
	{
		$data_field = $this->settings[$model->alias]['data_field'];
		
		if (isset($model->data[$model->alias][$data_field])) {
			if( !empty( $model->data[$model->alias][$data_field]) )
			{
				$array = array();
				for( $i = 0; $i < count($model->data[$model->alias][$data_field] ); $i++ )
				{
					if( $model->data[$model->alias][$data_field][$i]['key'] != '' &&  $model->data[$model->alias][$data_field][$i]['value'] != '')
					{
						$array[ $model->data[$model->alias][$data_field][$i]['key'] ] = $model->data[$model->alias][$data_field][$i]['value'];
					}
				}				
				$model->data[$model->alias][$data_field] = serialize( $array );
			}	
		}
		
		return true;
	}
}