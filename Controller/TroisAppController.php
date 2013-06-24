<?php

App::uses('Controller', 'Controller');

class TroisAppController extends Controller {
    
    
    function beforeFilter() {
        
        if( $this->isAdmin() )
		{
		    if( property_exists($this, 'Auth') )
		    {
		    	$this->Auth->deny();
		    	$this->Auth->allow(array('admin_login','logout','admin_logout'));
		    }
		    $this->layout = 'troisAdmin';
		}
		else
		{
		    if( property_exists($this, 'Auth') ) $this->Auth->allow();
		    $this->layout = 'default';
		    //debug( $this->Auth );
		}
		
		if( property_exists($this, 'Auth') ) $this->set('loggedIn', $this->Auth->loggedIn());
		else $this->set('loggedIn', true);
    }
        
    function isAdmin(){
    	return (array_key_exists('admin', $this->request->params))? true : false;
    }
    
    
    
    
    /*  Force admin layout if request /admin/*
    ***********************************************/
    
    public function render($view = null, $layout = null) {
		$event = new CakeEvent('Controller.beforeRender', $this);
		$this->getEventManager()->dispatch($event);
		if ($event->isStopped()) {
			$this->autoRender = false;
			return $this->response;
		}

		if (!empty($this->uses) && is_array($this->uses)) {
			foreach ($this->uses as $model) {
				list($plugin, $className) = pluginSplit($model);
				$this->request->params['models'][$className] = compact('plugin', 'className');
			}
		}

		$viewClass = $this->viewClass;
		if ($this->viewClass != 'View') {
			list($plugin, $viewClass) = pluginSplit($viewClass, true);
			$viewClass = $viewClass . 'View';
			App::uses($viewClass, $plugin . 'View');
			
		}else{
			
			// ELSE IS CUSTOM In ORDER To Provide the right layout even were we are ( as plugin ... )
			list($plugin, $viewClass) = pluginSplit($viewClass, true);
			$viewClass = 'Trois' . 'View';
			App::uses($viewClass, 'Trois.' . 'View');
		}

		$View = new $viewClass($this);

		$models = ClassRegistry::keys();
		foreach ($models as $currentModel) {
			$currentObject = ClassRegistry::getObject($currentModel);
			if (is_a($currentObject, 'Model')) {
				$className = get_class($currentObject);
				list($plugin) = pluginSplit(App::location($className));
				$this->request->params['models'][$currentObject->alias] = compact('plugin', 'className');
				$View->validationErrors[$currentObject->alias] =& $currentObject->validationErrors;
			}
		}
		
		$this->autoRender = false;
		$this->View = $View;
		$this->response->body($View->render($view, $layout));
		return $this->response;
	}
	

}

