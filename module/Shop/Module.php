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
                "Shop\Model\Category" => function($sm){
                   $tableGateway = $sm->get("CategoryTableGateway");
                   return  new \Shop\Model\CategoryTable($tableGateway);
                },
                "Shop\Model\Book" => function($sm){
                   $tableGateway = $sm->get("BookTableGateway");
                   return  new \Shop\Model\BookTable($tableGateway);
                },
                "Shop\Model\Slider" => function($sm){
                   $tableGateway = $sm->get("SliderTableGateway");
                   return  new \Shop\Model\SliderTable($tableGateway);
                },
            ),
            "aliases" => array(
                "shopBookTable" => "Shop\Model\Book" 
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
                },
                "blockSpecial"   => function($sm){
                    $helper = new \Block\BlockSpecial();
                    $helper->setData($sm->getServiceLocator()->get( "Shop\Model\Book"));
                    return $helper;
                },
                "blockSlider"   => function($sm){
                    $helper = new \Block\BlockSlider();
                    $helper->setData($sm->getServiceLocator()->get( "Shop\Model\Slider"));
                    return $helper;
                },
                "blockNewBook"   => function($sm){
                    $helper = new \Block\BlockNewBook();
                    $helper->setData($sm->getServiceLocator()->get( "Shop\Model\Book"));
                    return $helper;
                }
    		),
            "invokables" => array(
                "blockFacebook"    => "Block\BlockFacebook",
                "createBreadcrumb" => "ZendVN\View\Helper\CreateBreadcrumb",
                "createLinkDetail" => "ZendVN\View\Helper\CreateLinkDetail",
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