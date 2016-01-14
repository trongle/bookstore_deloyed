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
			"home" => $home,
			"shopRoute" => $shopRoute
		)
	)
);

?>