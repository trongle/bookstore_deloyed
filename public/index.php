<?php 
include_once "define.php";
include_once PATH_LIBRARY."Zend/Loader/AutoLoaderFactory.php";

chdir(dirname(__DIR__));
if(!class_exists("Zend\Loader\AutoloaderFactory")){
	die(" server is busy now !");
}

Zend\Loader\AutoLoaderFactory::Factory(array(
	"Zend\Loader\StandardAutoLoader" => array(
		"autoregister_zf" => true,
		"namespaces" => array(
			"ZendVN" => PATH_LIBRARY."ZendVN",
		)
	)
));

Zend\Mvc\Application::init(require "/config/application.config.php")->run();

?>