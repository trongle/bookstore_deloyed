<?php 
include_once "define.php";
include_once PATH_LIBRARY."Zend/Loader/AutoloaderFactory.php";

chdir(dirname(__DIR__));
if(!class_exists("Zend\Loader\AutoloaderFactory")){
	die(" server is busy now !");
}

Zend\Loader\AutoLoaderFactory::Factory(array(
	"Zend\Loader\StandardAutoloader" => array(
		"autoregister_zf" => true,
		"namespaces" => array(
			"ZendVN"           => PATH_LIBRARY."ZendVN",
			"PHPImageWorkshop" => PATH_VENDOR."PHPImageWorkshop",
			"Block"			   => PATH_APPLICATION."/block",
		),
		"prefixes" => array(
			"HTMLPurifier" => PATH_VENDOR."HTMLPurifier"
		)
	)
));

$config = require "config/application.config.php";

Zend\Mvc\Application::init($config)->run();

?>