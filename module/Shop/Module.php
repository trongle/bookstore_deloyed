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
                "Shop\Model\User" => function($sm){
                   $tableGateway = $sm->get("UserTableGateway");
                   return  new \Shop\Model\UserTable($tableGateway);
                },
            ),
            "aliases" => array(
                "shopBookTable" => "Shop\Model\Book" ,
                "shopUserTable" => "Shop\Model\User" ,
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
                "createFormError"  => "ZendVN\View\Helper\ElementErrors",
            )
    	);
    }

    public function getFormElementConfig(){
    	return array(
    		"factories" => array(
    			"formRegisterShop" => function($sm){
    				$form = new \Shop\Form\FormRegister();
                    $form->setInputFilter(new \Shop\Form\FormRegisterFilter());
                    return $form;
    			},
    		)
    	);
    }
}
?>