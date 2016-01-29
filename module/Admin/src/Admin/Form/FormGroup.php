<?php
namespace Admin\Form;

use Zend\Form\Form;

class FormGroup extends Form{
	public function __construct(){
		parent::__construct();
		$this->setAttributes(
			array(
				"action" => "#",
				"method" => "POST",
				"class"  => "form-horizontal",
				"role"   => "form",
				"name"   => "adminForm",
				"id"     => "adminForm",
				"style"  => "padding-top: 10px"
			));
		
		//name
		$this->add(array(
			"type" => "text",
			"name" => "name",
			"required" => false,
			"attributes" => array(
				"class"       => "form-control",
				"id"          => "name",
				"placeholder" => "Enter name",
			),
			"options" => array(
				"label" => "Name",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "name"
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
		$this->add(array(
			"name" => "id",
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