<?php 

	define("APPLICATION_PATH",realpath(dirname(__DIR__)));
	define("LIBRARY_PATH",APPLICATION_PATH."/library/");
	define("PUBLIC_PATH",APPLICATION_PATH."/public/");
	define("CAPTCHA_PATH",PUBLIC_PATH."captcha/");
	define("TEMPLATE_PATH",PUBLIC_PATH."template/");

	define("APPLICATION_URL","/");
	define("PUBLIC_URL",APPLICATION_URL."public/");
	define("TEMPLATE_URL",PUBLIC_URL."template/");
?>