<?php 
return array(
	"controllers"  => array(
		"invokables" => array(
			"Admin\Controller\Index"    => "Admin\Controller\IndexController",
			"Admin\Controller\Group"    => "Admin\Controller\GroupController",
			"Admin\Controller\User"     => "Admin\Controller\UserController",
			"Admin\Controller\Book"     => "Admin\Controller\BookController",
			"Admin\Controller\Cart"     => "Admin\Controller\CartController",
			"Admin\Controller\Config"   => "Admin\Controller\ConfigController",
			"Admin\Controller\Order"    => "Admin\Controller\OrderController",
			"Admin\Controller\Category" => "Admin\Controller\CategoryController",
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
			"layout/backend"  => PATH_TEMPLATE."backend/main.phtml",
			"layout/frontend" => PATH_TEMPLATE."frontend/layout.phtml",
			"layout/error"    => PATH_TEMPLATE."error/layout.phtml",
			"error/404"       => PATH_TEMPLATE."error/404.phtml",
			"error/index"     => PATH_TEMPLATE."error/index.phtml",
		),
		"default_template_suffix" => "phtml",
		"layout"  => "layout/frontend"
	),
	'view_helper_config' => array(
        "flashmessenger" => array(
            "message_open_format" => '<div class="alert alert-success alert-dismissable">
            							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               						 <h4><i class="icon fa fa-check"></i> Alert!</h4>',
            "message_separator_string" => "",
            "message_close_string" => "</div>"
        ),
    ),
);
?>