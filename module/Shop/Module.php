<?php 
namespace Shop;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\Hydrator\ObjectProperty;

class Module {
	public function onBootstrap(MvcEvent $e){
	   $eventManager = $e->getApplication()->getEventManager();
	   $moduleRouteListener = new ModuleRouteListener();
	   $moduleRouteListener->attach($eventManager);

	   $adapter = $e->getApplication()->getServiceManager()->get("dbConfig");
	   GlobalAdapterFeature::setStaticAdapter($adapter);

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
                "CategoryTableGateway" => function($sm){
                    $adapter = $sm->get("dbConfig");
                    //hydratingResultSet()---->lấy field từ các bảng khác không cần đưa vào entities
                    $resultSetPrototype = new HydratingResultSet();
                    $resultSetPrototype->setHydrator(new ObjectProperty());
                    $resultSetPrototype->setObjectPrototype(new \Shop\Model\Entity\Category());

                    return $tableGateway = new TableGateway("category",$adapter,null,$resultSetPrototype);
                },
                "Shop\Model\Category" => function($sm){
                   $tableGateway = $sm->get("CategoryTableGateway");
                   return  new \Shop\Model\CategoryTable($tableGateway);
                },
            )
        );
    }

    public function getViewHelperConfig(){
    	return array(
    		"factories" => array(
                "blockCategory"   => function($sm){
                    $helper = new \Block\BlockCategory();
                    $helper->setData($sm->getServiceLocator()->get( "Shop\Model\Category"));
                    return $helper;
                }
    		)
    	);
    }

    // public function getFormElementConfig(){
    // 	return array(
    // 		"factories" => array(
    // 			"formAdminGroup" => function($sm){
    // 				$form = new \Admin\Form\FormGroup();
    //                 $form->setInputFilter(new \Admin\Form\FormGroupFilter());
    //                 return $form;
    // 			},
    // 			"formAdminUser" => function($sm){
    // 				$groupTable = $sm->getServiceLocator()->get("GroupTable");
    // 				$form = new \Admin\Form\FormUser($groupTable);
    //                 $form->setInputFilter(new \Admin\Form\FormUserFilter());
    //                 return $form;
    // 			},
    //             "formAdminCategory" => function($sm){
    //                 $categoryTable = $sm->getServiceLocator()->get("CategoryTable");
    //                 $form = new \Admin\Form\FormCategory($categoryTable);
    //                 $form->setInputFilter(new \Admin\Form\FormCategoryFilter());
    //                 return $form;
    //             },
    //             "formAdminBook" => function($sm){
    //                 $categoryTable = $sm->getServiceLocator()->get("CategoryTable");
    //                 $form = new \Admin\Form\FormBook($categoryTable);
    //                 $form->setInputFilter(new \Admin\Form\FormBookFilter());
    //                 return $form;
    //             },
    // 		)
    // 	);
    // }
}
?>