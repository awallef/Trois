<?php

App::uses('View', 'View');

class TroisView extends View {
	
	
	protected function _getLayoutFileName($name = null) {
		if ($name === null) {
			$name = $this->layout;
		}
		$subDir = null;
		
		if( $name != 'troisAdmin' ){
		
			if (!is_null($this->layoutPath)) {
				$subDir = $this->layoutPath . DS;
			}
			list($plugin, $name) = $this->pluginSplit($name);
			$paths = $this->_paths($plugin);
			$file = 'Layouts' . DS . $subDir . $name;
	
			$exts = $this->_getExtensions();
			foreach ($exts as $ext) {
				foreach ($paths as $path) {
					if (file_exists($path . $file . $ext)) {
						return $path . $file . $ext;
					}
				}
			}
			
		}else{	
			return APP.'..'.DS.'plugins'.DS.'Trois'.DS.'View'.DS.'Layouts'.DS.'troisAdmin.ctp';
		}
		
		throw new MissingLayoutException(array('file' => $paths[0] . $file . $this->ext));
	}
	
}