<?php 
return array(
	"controllers"  => array(
		"invokables" => array(
			"Admin\Controller\Index" => "Admin\Controller\IndexController"
		)
	),
	"view_manager" => array(
		"doctype" => "HTML5",
		"display_not_found_reason" => true,
		"not_found_template" => "error/404",

		"display_exceptions" => true,
		"exception_template" => "error/index",

		"template_path_stack" => array(__DIR__."/../view"),
		"template_map" => array(
			"layout/layout" => __DIR__."/../view/layout/layout.phtml",
			"layout/error"  => TEMPLATE_PATH."error/layout.phtml",
			"error/404"     => TEMPLATE_PATH."error/404.phtml",
			"error/index"   => TEMPLATE_PATH."error/index.phtml",
		),
		"default_template_suffix" => "phtml",
		"layout"  => "layout/layout"
	),
);
?>