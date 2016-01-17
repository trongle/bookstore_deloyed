<?php 
//default Route
$home = array(
	"type"=> "Zend\Mvc\Router\Http\Literal",
	"options" => array(
		"route" => "/",
		"defaults" => array(
			"__NAMESPACE__" => "Shop\Controller",
			"controller"    => "Shop\Controller\Index",
			"action"        => "index"
		)
	)
);

//Module Shop route
$shopRoute = array(
	"type" => "Literal",
	"options" => array(
		"route" => "/shop",
		"defaults" => array(
			"__NAMESPACE__" => "Shop\Controller",
			"controller"    => "Shop\Controller\index",
			"action"        => "index"
		)
	),
	'may_terminate' => true,
    'child_routes' => array(
        'default' => array(
            'type'    => 'Segment',
            'options' => array(
                'route'    => '/[:controller[/:action[/:id]]]',
                'constraints' => array(
                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id'    	 => '[0-9]*',
                ),
                'defaults' => array(
                    '__NAMESPACE__' => 'Shop\Controller',
                    'controller'    => 'index',
                    'action'        => 'index',
                ),
            ),
        ),
        'category' => array(
            'type'    => 'Segment',
            'options' => array(
                'route'    => '/category/index/:id[/display/:display][/order/:order][/dir/:dir][/limit/:limit][/page/:page][/]',
                'constraints' => array(
                    'id'      => '[0-9]*',
                    'page'    => '[0-9]*',
                    'limt'    => '[0-9]',
                    'order'   => 'name|id|price',
                    'dir'     => 'asc|desc',
                    'display' => 'list|grid'
                ),
                'defaults' => array(
                    '__NAMESPACE__' => 'Shop\Controller',
                    'controller'    => 'category',
                    'action'        => 'index',
                ),
            ),
        ),
        'paginator' => array(
            'type'    => 'Segment',
            'options' => array(
                'route'    => '/[:controller]/index/page[/:page]',
                'constraints' => array(
					'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'page'       => '[0-9]*',
                ),
                'defaults' => array(
                ),
            ),
        ),
	)
);
return array(
	"router"       => array(
		"routes" => array(
			"homeShop" => $home,
			"shopRoute" => $shopRoute
		)
	)
);

?>