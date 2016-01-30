<?php
namespace Shop\Form;

use Admin\Model\CategoryTable;
use Zend\Form\Form;

class FormLogin extends Form{
	public function __construct(){
		parent::__construct();
		$this->setAttributes(
			array(
				"action"  => "#",
				"method"  => "POST",
				"class"   => "form-horizontal",
				"role"    => "form",
				"name"    => "loginForm",
				"id"      => "login",
				"style"   => "padding-top: 10px",
				"enctype" => "multipart/form-data",
			));
		
		//email
		$this->add(array(
			"type" => "text",
			"name" => "email",
			"attributes" => array(
				"class"       => "q1 margen-bottom",
			),
			"options" => array(
				"label" => "E-Mail Address:",
				"label_attributes" => array(
					"class" => "padd-form control-label col-sm-5",
					"for"   => "email"
				),
			)	
		));

		//password
		$this->add(array(
			"type" => "password",
			"name" => "password",
			"attributes" => array(
				"class"       => "q1 margen-bottom",
			),
			"options" => array(
				"label" => "Password:",
				"label_attributes" => array(
					"class" => "padd-form control-label col-sm-5",
					"for"   => "fullname"
				),
			)	
		));		
	}

	public function showError(){
		if(empty($this->getMessages())) return false;

		$error = '<div class="warning">';
		foreach($this->getMessages() as $key=>$val){
			$error .= sprintf('<span style="margin-left:5px"><strong>%s : </strong>%s</span><br/>',ucfirst($key),current($val));
		}
		$error .= '</div>';
		return $error;
	}
}
?>