<?php 
namespace Admin;

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
                "GroupTableGateway" => function($sm){
                    $adapter = $sm->get("dbConfig");

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \ZendVN\Model\Entity\Group());

                    return $tableGateway = new TableGateway("groups",$adapter,null,$resultSetPrototype);
                },
                "Admin\Model\Group" => function($sm){
                    $tableGateway = $sm->get("GroupTableGateway");
                    return  new \Admin\Model\GroupTable($tableGateway);
                },
                "UserTableGateway" => function($sm){
                    $adapter = $sm->get("dbConfig");
                    //hydratingResultSet()---->lấy field từ các bảng khác không cần đưa vào entities
                    $resultSetPrototype = new HydratingResultSet();
                    $resultSetPrototype->setHydrator(new ObjectProperty());
                    $resultSetPrototype->setObjectPrototype(new \ZendVN\Model\Entity\User());

                    return $tableGateway = new TableGateway("user",$adapter,null,$resultSetPrototype);
                },
                "Admin\Model\User" => function($sm){
                    $tableGateway = $sm->get("UserTableGateway");
                    return  new \Admin\Model\UserTable($tableGateway);
                },
                "NestedTableGateway" => function($sm){
                    $adapter = $sm->get("dbConfig");
                    //hydratingResultSet()---->lấy field từ các bảng khác không cần đưa vào entities
                    $resultSetPrototype = new HydratingResultSet();
                    $resultSetPrototype->setHydrator(new ObjectProperty());
                    $resultSetPrototype->setObjectPrototype(new \ZendVN\Model\Entity\Nested());

                    return $tableGateway = new TableGateway("nested",$adapter,null,$resultSetPrototype);
                },
                "Admin\Model\Nested" => function($sm){
                    $tableGateway = $sm->get("NestedTableGateway");
                    return  new \Admin\Model\NestedTable($tableGateway);
                },
                "CategoryTableGateway" => function($sm){
                    $adapter = $sm->get("dbConfig");
                    //hydratingResultSet()---->lấy field từ các bảng khác không cần đưa vào entities
                    $resultSetPrototype = new HydratingResultSet();
                    $resultSetPrototype->setHydrator(new ObjectProperty());
                    $resultSetPrototype->setObjectPrototype(new \ZendVN\Model\Entity\Category());

                    return $tableGateway = new TableGateway("category",$adapter,null,$resultSetPrototype);
                },
                "Admin\Model\Category" => function($sm){
                   $tableGateway = $sm->get("CategoryTableGateway");
                   return  new \Admin\Model\CategoryTable($tableGateway);
                },
                "BookTableGateway" => function($sm){
                    $adapter = $sm->get("dbConfig");
                    //hydratingResultSet()---->lấy field từ các bảng khác không cần đưa vào entities
                    $resultSetPrototype = new HydratingResultSet();
                    $resultSetPrototype->setHydrator(new ObjectProperty());
                    $resultSetPrototype->setObjectPrototype(new \ZendVN\Model\Entity\Book());

                    return $tableGateway = new TableGateway("book",$adapter,null,$resultSetPrototype);
                },
                "Admin\Model\Book" => function($sm){
                    $tableGateway = $sm->get("BookTableGateway");
                    return  new \Admin\Model\BookTable($tableGateway);
                },
            ),
            "aliases" => array(
                "GroupTable"    => "Admin\Model\Group",
                "UserTable"     => "Admin\Model\User",
                "NestedTable"   => "Admin\Model\Nested",
                "CategoryTable" => "Admin\Model\Category",
                "BookTable"     => "Admin\Model\Book",
            ),
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
				"changeSpecialLink" => "ZendVN\View\Helper\ChangeSpecialLink",
				"linkToGo" 		   => "ZendVN\View\Helper\LinkToGo",
				"buttonTool" 	   => "ZendVN\View\Helper\ButtonTool",
				"createTd" 	   	   => "ZendVN\View\Helper\CreateTd",
                "createTdName"     => "ZendVN\View\Helper\CreateTdName",
                "changeMoveNode"   => "ZendVN\View\Helper\ChangeMoveNode",
				"createPrice"      => "ZendVN\View\Helper\CreatePrice",
    		)
    	);
    }

    public function getFormElementConfig(){
    	return array(
    		"factories" => array(
    			"formAdminGroup" => function($sm){
    				$form = new \Admin\Form\FormGroup();
                    $form->setInputFilter(new \Admin\Form\FormGroupFilter());
                    return $form;
    			},
    			"formAdminUser" => function($sm){
    				$groupTable = $sm->getServiceLocator()->get("GroupTable");
    				$form = new \Admin\Form\FormUser($groupTable);
                    $form->setInputFilter(new \Admin\Form\FormUserFilter());
                    return $form;
    			},
                "formAdminCategory" => function($sm){
                    $categoryTable = $sm->getServiceLocator()->get("CategoryTable");
                    $form = new \Admin\Form\FormCategory($categoryTable);
                    $form->setInputFilter(new \Admin\Form\FormCategoryFilter());
                    return $form;
                },
                "formAdminBook" => function($sm){
                    $categoryTable = $sm->getServiceLocator()->get("CategoryTable");
                    $form = new \Admin\Form\FormBook($categoryTable);
                    $form->setInputFilter(new \Admin\Form\FormBookFilter());
                    return $form;
                },
    		)
    	);
    }
}
?>