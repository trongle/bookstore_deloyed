<?php
namespace Admin\Form;

use Admin\Model\CategoryTable;
use Zend\Form\Form;

class FormCategory extends Form{
	public function __construct(CategoryTable $categoryTable){
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
			));
		
		//name
		$this->add(array(
			"type" => "text",
			"name" => "name",
			"required" => false,
			"attributes" => array(
				"class"       => "form-control",
				"id"          => "name",
				"placeholder" => "Enter name of category",
			),
			"options" => array(
				"label" => "Name",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "name"
				),
			)	
		));

		//description
		$this->add(array(
			"type" => "textarea",
			"name" => "description",
			"required" => false,
			"attributes" => array(
				"class"       => "form-control",
				"id"          => "description",
			),
			"options" => array(
				"label" => "Description",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "description"
				),
			)	
		));

		//category
		$this->add(array(
			"type" => "select",
			"name" => "parent",
			"required" => false,
			"attributes" => array(
				"class" => "form-control"
			),
			"options" => array(
				"empty_option"  => "-- Select category --",
				"value_options" => $categoryTable->itemInSelectBox(null,array("task" => "list-form")),
				"label" => "Category",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "parent"
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
	
		$this->add(array(
			"name" => "id",
			"type" => "hidden"
		));

		$this->add(array(
			"name" => "action",
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