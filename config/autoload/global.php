<?php 
return array(
	"db" => array(
		"driver"   => "Pdo_Mysql",
		"database" => "bookstore",
		"charset"  => "utf8"
	),
	"service_manager" => array(
		"factories" => array(
			"Zend\Db\Adapter\Adapter" => "Zend\Db\Adapter\AdapterServiceFactory",
		),
		"aliases"   => array(
			"dbConfig" => "Zend\Db\Adapter\Adapter"
		)
	)
)
?>