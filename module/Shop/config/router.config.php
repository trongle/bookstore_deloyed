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

//login Route
$login = array(
    "type"=> "Zend\Mvc\Router\Http\Segment",
    "options" => array(
        "route" => "/login.html",
        "defaults" => array(
            "__NAMESPACE__" => "Shop\Controller",
            "controller"    => "Shop\Controller\Index",
            "action"        => "login"
        )
    )
);

//register Route
$register = array(
    "type"=> "Zend\Mvc\Router\Http\Segment",
    "options" => array(
        "route" => "/register.html",
        "defaults" => array(
            "__NAMESPACE__" => "Shop\Controller",
            "controller"    => "Shop\Controller\Index",
            "action"        => "register"
        )
    )
);

//logout Route
$logout = array(
    "type"=> "Zend\Mvc\Router\Http\Segment",
    "options" => array(
        "route" => "/logout.html",
        "defaults" => array(
            "__NAMESPACE__" => "Shop\Controller",
            "controller"    => "Shop\Controller\Index",
            "action"        => "logout"
        )
    )
);

//viewcart Route
$viewCart = array(
    "type"=> "Zend\Mvc\Router\Http\Segment",
    "options" => array(
        "route" => "/user/cart.html",
        "defaults" => array(
            "__NAMESPACE__" => "Shop\Controller",
            "controller"    => "Shop\Controller\User",
            "action"        => "viewCart"
        )
    )
);

//history Route
$history = array(
    "type"=> "Zend\Mvc\Router\Http\Segment",
    "options" => array(
        "route" => "/user/history.html",
        "defaults" => array(
            "__NAMESPACE__" => "Shop\Controller",
            "controller"    => "Shop\Controller\User",
            "action"        => "history"
        )
    )
);

//Register
//bookstore.dev/category/laptrinhphp-12.html
$category = array(
    'type' => 'Regex',
    'options' => array(
        'regex' => '/category/(?<name>[a-zA-Z0-9_-]*)-(?<id>[0-9]*).(?<extension>(html|php))',
        'defaults' => array(
            '__NAMESPACE__' => 'Shop\Controller',
            'controller'    => 'Shop\Controller\Category',
            'action'        => 'index',
            'extension'     => 'html'
        ),
        'spec' => '/category/%name%-%id%.%extension%',
    ),
    'may_terminate' => true,
    'child_routes' => array(
         'filter' => array(
            'type'    => 'Segment',
            'options' => array(
                'route'    => '[/display/:display][/order/:order][/dir/:dir][/limit/:limit][/page/:page][/]',
                'constraints' => array(
                    'page'    => '[0-9]*',
                    'limit'   => '3|6|9|12',
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
    )
);

//book
//bookstore.dev/webdesign/laptrinhphp-12.html
$book = array(
    'type' => 'Regex',
    'options' => array(
        'regex' => '/(?<category>[a-zA-Z0-9_-]*)/(?<name>[a-zA-Z0-9_-]*)/(?<id>[0-9]*).(?<extension>(html|php))',
        'defaults' => array(
            '__NAMESPACE__' => 'Shop\Controller',
            'controller'    => 'Shop\Controller\Book',
            'action'        => 'index',
            'extension'     => 'html'
        ),
        'spec' => '/%category%/%name%/%id%.%extension%',
    ),
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
                    'limit'   => '3|6|9|12',
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
        'cart' => array(
            'type'    => 'Segment',
            'options' => array(
                'route'    => '/user/order/:id/[price/:price/qty/:qty][/]',
                'constraints' => array(
                    'id'    => '[0-9]*',
                    'price' => '[0-9]*',
                    'qty'   => '[0-9]*'
                ),
                'defaults' => array(
                    '__NAMESPACE__' => 'Shop\Controller',
                    'controller'    => 'user',
                    'action'        => 'order',
                    'qty'           => 1
                ),
            ),
        ),
        'active' => array(
            'type'    => 'Segment',
            'options' => array(
                'route'    => '/user/active/:id/code/:code[/]',
                'constraints' => array(
                    'id'      => '[0-9]*',
                    'code'    => '[a-zA-Z0-9]*',
                ),
                'defaults' => array(
                    '__NAMESPACE__' => 'Shop\Controller',
                    'controller'    => 'user',
                    'action'        => 'active',
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
            "homeShop"     => $home,
            "loginShop"    => $login,
            "registerShop" => $register,
            "logoutShop"   => $logout,
            "viewCartShop" => $viewCart,
            "historyShop"  => $history,
            "bookShop"     => $book,
            "categoryShop" => $category,
            "shopRoute"    => $shopRoute
		)
	)
);

?>