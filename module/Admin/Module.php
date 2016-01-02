<?php 
namespace Admin;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {
	public function onBootstrap(MvcEvent $e){
	   $eventManager = $e->getApplication()->getEventManager();
	   $moduleRouteListener = new ModuleRouteListener();
	   $moduleRouteListener->attach($eventManager);

	   $eventManager->attach("dispatch",array($this,"layoutForModule"));
	   $eventManager->attach("dispatch",array($this,"setHeader"));
	}

	public function layoutForModule(MvcEvent $e){
		$routerMatch     = $e->getRouteMatch();
		$arrayController = explode("\\",$routerMatch->getParam("controller"));
		$module          = strtolower($arrayController[0]);
		//đọc layout.config.php
		$config = $e->getApplication()->getServiceManager()->get("config");
		$layout = $config["module_for_layouts"][$module];
	
		$controller = $e->getTarget();
		$controller->layout($layout);
	}

	public function setHeader(MvcEvent $e){
		$routerMatch = $e->getRouteMatch();
		$arrayController = explode("\\",$routerMatch->getParam("controller"));

		$viewModel = $e->getViewModel();
		//truyền ra cho layout
		$viewModel->params = array(
			"module" => strtolower($arrayController[0])
			,"controller" => strtolower($arrayController[2])
			,"action" => strtolower($routerMatch->getParam("action"))
		);
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

	public function getServiceConfig(){
        return array(
            "factories" => array(
                "TableGateway" => function($sm){
                    $adapter = $sm->get("dbConfig");

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\Group());

                    return $tableGateway = new TableGateway("groups",$adapter,null,$resultSetPrototype);
                },
                "Admin\Model\Group" => function($sm){
                    $tableGateway = $sm->get("TableGateway");
                    return  new \Admin\Model\GroupTable($tableGateway);
                }
            ),
            "aliases" => array(
                "GroupTable" => "Admin\Model\Group"
            )
        );
    }

    public function getViewHelperConfig(){
    	return array(
    		"invokables" => array(
				"changeSortLink"   => "ZendVN\View\Helper\ChangeSortLink",
				"zvnFormSelectBox" => "ZendVN\Form\View\Helper\FormSelectBox",
				"zvnFormHidden"    => "ZendVN\Form\View\Helper\FormHidden",
				"zvnFormText"      => "ZendVN\Form\View\Helper\FormText",
				"zvnFormButton"    => "ZendVN\Form\View\Helper\FormButton",
				"changeStatusLink" => "ZendVN\View\Helper\ChangeStatusLink",
    		)
    	);
    }
}
?>