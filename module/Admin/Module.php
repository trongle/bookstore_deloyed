<?php 
namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {
	public function onBootstrap(MvcEvent $e){
	   $eventManager = $e->getApplication()->getEventManager();
	   $moduleRouteListener = new ModuleRouteListener();
	   $moduleRouteListener->attach($eventManager);

	   $eventManager->attach("dispatch",array($this,"layoutForModule"));
	}

	public function layoutForModule(MvcEvent $e){
		$routerMatch = $e->getRouteMatch();
		$arrayController = explode("\\",$routerMatch->getParam("controller"));
		$module = strtolower($arrayController[0]);
		//đọc layout.config.php
		$config = $e->getApplication()->getServiceManager()->get("config");
		$config["module_for_layouts"][$module];
	
		$controller = $e->getTarget();
		$controller->layout("layout/backend");

	}
	public function getConfig(){
		return array_merge(
			include __DIR__."/config/module.config.php",
			include __DIR__."/config/router.config.php"
		);	
	}

	public function getAutoloaderConfig(){
		return array(
			//Class Map nhanh hơn nhưng phải khai báo chi tiết từng controller
			"Zend\Loader\ClassMapAutoloader" => array(
				__DIR__."/autoload_classmap.php"
			),
			//Standard chỉ cần khai báo namespace
			"Zend\Loader\StandardAutoloader" => array(
				"namespaces" => array(
					__NAMESPACE__ => __DIR__."/src/".__NAMESPACE__,
				)
			)
		);
	}
}
?>