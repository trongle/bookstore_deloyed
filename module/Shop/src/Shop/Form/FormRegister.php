<?php
namespace Shop\Form;

use Admin\Model\CategoryTable;
use Zend\Form\Form;

class FormRegister extends Form{
	public function __construct(){
		parent::__construct();
		$this->setAttributes(
			array(
				"action"  => "#",
				"method"  => "POST",
				"class"   => "form-horizontal",
				"role"    => "form",
				"name"    => "registerForm",
				"id"      => "register",
				"style"   => "padding-top: 10px",
				"enctype" => "multipart/form-data",
			));
		
		//username
		$this->add(array(
			"type" => "text",
			"name" => "username",
			"attributes" => array(
				"class"       => "q1",
				"placeholder" => "Enter username",
			),
			"options" => array(
				"label" => "Username",
				"label_attributes" => array(
					"class" => "control-label col-sm-5",
					"for"   => "username"
				),
			)	
		));

		//fullname
		$this->add(array(
			"type" => "text",
			"name" => "fullname",
			"attributes" => array(
				"class"       => "q1",
				"placeholder" => "Enter fullname",
			),
			"options" => array(
				"label" => "Fullname",
				"label_attributes" => array(
					"class" => "control-label col-sm-5",
					"for"   => "fullname"
				),
			)	
		));

		//fullname
		$this->add(array(
			"type" => "password",
			"name" => "password",
			"attributes" => array(
				"class"       => "q1",
				"placeholder" => "Enter password",
			),
			"options" => array(
				"label" => "Password",
				"label_attributes" => array(
					"class" => "control-label col-sm-5",
					"for"   => "password"
				),
			)	
		));

		//email
		$this->add(array(
			"type" => "text",
			"name" => "email",
			"attributes" => array(
				"class"       => "q1",
				"placeholder" => "Enter email",
			),
			"options" => array(
				"label" => "Email",
				"label_attributes" => array(
					"class" => "control-label col-sm-5",
					"for"   => "email"
				),
			)	
		));

		
	}

	public function showError(){
		if(empty($this->getMessages())) return false;

		$error = '<div class="callout callout-danger">';
		foreach($this->getMessages() as $key=>$val){
			$error .= sprintf('<p><b>%s : </b>%s</p>',ucfirst($key),current($val));
		}
		$error .= '</div>';
		return $error;
	}
}
?>