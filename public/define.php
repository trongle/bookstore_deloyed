<?php 
	define("BOOKONLINE_KEY",'tronghandsome');
	define("PATH_APPLICATION",realpath(dirname(__DIR__)));
	define("PATH_LIBRARY",PATH_APPLICATION."/library/");
	define("PATH_PUBLIC",PATH_APPLICATION."/public/");
	define("PATH_CAPTCHA",PATH_PUBLIC."captcha/");
	define("PATH_TEMPLATE",PATH_PUBLIC."template/");
	define("PATH_VENDOR",PATH_APPLICATION."/vendor/");
	define("PATH_FILES",PATH_PUBLIC."files/");
	define("HTMLPURIFIER_PREFIX",PATH_APPLICATION."/vendor/");
	define("PATH_SCRIPT",PATH_PUBLIC."script/");
	
	define("URL_APPLICATION","/bookstore/");
	define("URL_PUBLIC",URL_APPLICATION."public/");
	define("URL_TEMPLATE",URL_PUBLIC."template/");
	define("URL_CSS_LAYOUT",URL_PUBLIC."template/backend/css/");
	define("URL_JS_LAYOUT",URL_PUBLIC."template/backend/js/");
	define("URL_IMG_LAYOUT",URL_PUBLIC."template/backend/img/");

	define("URL_FILES",URL_PUBLIC."files/");
	define("URL_SCRIPT",URL_PUBLIC."script/");

	//fontend
	define("URL_IMG_SHOP",URL_PUBLIC."template/frontend/image/");
	define("URL_JS_SHOP",URL_PUBLIC."template/frontend/js/");
	define("URL_CSS_SHOP",URL_PUBLIC."template/frontend/css/");
?>
