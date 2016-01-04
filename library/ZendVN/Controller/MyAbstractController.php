<?php
namespace ZendVN\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\MvcEvent;

class MyAbstractController extends AbstractActionController
{
	public function setPluginManager(PluginManager $plugin){
		parent::setPluginManager($plugin);
		$this->getEventManager()->attach(MvcEvent::EVENT_DISPATCH,array($this,"onInit"),100);
	}

	public function onInit(MvcEvent $e){
		$routerMatch     = $e->getRouteMatch();
		$arrayController = explode("\\",$routerMatch->getParam("controller"));
		$module          = strtolower($arrayController[0]);

		$viewModel = $e->getViewModel();
		//truyền ra cho layout
		$viewModel->params = array(
			"module"      => strtolower($arrayController[0])
			,"controller" => strtolower($arrayController[2])
			,"action"     => strtolower($routerMatch->getParam("action"))
		);

		$config = $this->getServiceLocator()->get("config");
		$layout = $config["module_for_layouts"][strtolower($arrayController[0])]; 
		//set layout
		$this->layout($layout);
	}
}
?>