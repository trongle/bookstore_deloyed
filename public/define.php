<?php 

	define("PATH_APPLICATION",realpath(dirname(__DIR__)));
	define("PATH_LIBRARY",PATH_APPLICATION."/library/");
	define("PATH_PUBLIC",PATH_APPLICATION."/public/");
	define("PATH_CAPTCHA",PATH_PUBLIC."captcha/");
	define("PATH_TEMPLATE",PATH_PUBLIC."template/");

	define("URL_APPLICATION","/");
	define("URL_PUBLIC",URL_APPLICATION."public/");
	define("URL_TEMPLATE",URL_PUBLIC."template/");
?>