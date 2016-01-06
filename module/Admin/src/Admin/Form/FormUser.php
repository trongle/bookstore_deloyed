<?php
namespace Admin\Form;

use Admin\Model\GroupTable;
use Zend\Form\Form;

class FormUser extends Form{
	public function __construct(GroupTable $groupTable){
		parent::__construct();
		$this->setAttributes(
			array(
				"action"  => "#",
				"method"  => "POST",
				"class"   => "form-horizontal",
				"role"    => "form",
				"name"    => "adminForm",
				"id"      => "adminForm",
				"style"   => "padding-top: 10px",
				"enctype" => "multipart/form-data",
			));
		
		//name
		$this->add(array(
			"type" => "text",
			"name" => "username",
			"required" => false,
			"attributes" => array(
				"class"       => "form-control",
				"id"          => "username",
				"placeholder" => "Enter username",
			),
			"options" => array(
				"label" => "Username",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "username"
				),
			)	
		));

		//password
		$this->add(array(
			"type" => "password",
			"name" => "password",
			"required" => false,
			"attributes" => array(
				"class"       => "form-control",
				"id"          => "password",
				"placeholder" => "Enter password",
			),
			"options" => array(
				"label" => "Password",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "password"
				),
			)	
		));

		//fullname
		$this->add(array(
			"type" => "text",
			"name" => "fullname",
			"required" => false,
			"attributes" => array(
				"class"       => "form-control",
				"id"          => "fullname",
				"placeholder" => "Enter fullname",
			),
			"options" => array(
				"label" => "Fullname",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "fullname"
				),
			)	
		));

		//email
		$this->add(array(
			"type" => "text",
			"name" => "email",
			"required" => false,
			"attributes" => array(
				"class"       => "form-control",
				"id"          => "email",
				"placeholder" => "Enter email",
			),
			"options" => array(
				"label" => "Email",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "email"
				),
			)	
		));

		//ordering
		$this->add(array(
			"type" => "text",
			"name" => "ordering",
			"required" => false,
			"attributes" => array(
				"class"       => "form-control",
				"id"          => "ordering",
				"placeholder" => "Enter ordering",
			),
			"options" => array(
				"label" => "Ordering",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "ordering"
				),
			)	
		));

		//group
		$this->add(array(
			"type" => "select",
			"name" => "group",
			"required" => false,
			"attributes" => array(
				"class" => "form-control"
			),
			"options" => array(
				"empty_option"  => "-- Select group --",
				"value_options" => $groupTable->itemInSelectBox(),
				"label" => "Group",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "group_id"
				)
			)	
		));

		//status
		$this->add(array(
			"type" => "select",
			"name" => "status",
			"required" => false,
			"attributes" => array(
				"class" => "form-control"
			),
			"options" => array(
				"empty_option"  => "-- Select status --",
				"value_options" => array(
					"active"   => "Active",
					"inactive" => "InActive",
				),
				"label" => "Status",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "status"
				)
			)	
		));

		//fileImg
		$this->add(array(
			"type" => "file",
			"name" => "image",
			"required" => false,
			"attributes" => array(
				"class" => "form-control"
			),
			"options" => array(
				"label" => "Avatar",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "image"
				)
			)	
		));

	
		$this->add(array(
			"name" => "id",
			"type" => "hidden"
		));

		$this->add(array(
			"name" => "action",
			"type" => "hidden"
		));
		$this->add(array(
			"name" => "avatar",
			"type" => "hidden"
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