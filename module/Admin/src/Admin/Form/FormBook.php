<?php
namespace Admin\Form;

use Admin\Model\CategoryTable;
use Zend\Form\Form;

class FormBook extends Form{
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
				"enctype" => "multipart/form-data",
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

		//price
		$this->add(array(
			"type" => "text",
			"name" => "price",
			"required" => true,
			"attributes" => array(
				"class"       => "form-control",
				"id"          => "price",
				"placeholder" => "Enter price",
			),
			"options" => array(
				"label" => "Price",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "price"
				),
			)	
		));

		//sale off value
		$this->add(array(
			"type" => "text",
			"name" => "sale_off_value",
			"required" => false,
			"attributes" => array(
				"class"       => "form-control",
				"id"          => "sale_off_value",
				"placeholder" => "Enter sale off value",
			),
			"options" => array(
				"label" => "Sale off value",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "sale_off_value"
				),
			)	
		));

		

		//ordering
		$this->add(array(
			"type" => "text",
			"name" => "ordering",
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

		//category
		$this->add(array(
			"type" => "select",
			"name" => "category_id",
			"required" => false,
			"attributes" => array(
				"class" => "form-control"
			),
			"options" => array(
				"empty_option"  => "-- Select category --",
				"value_options" => $categoryTable->itemInSelectBox(null,array("task"=>"list-book")),
				"label" => "Category",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "category_id"
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

		//special
		$this->add(array(
			"type" => "select",
			"name" => "special",
			"required" => false,
			"attributes" => array(
				"class" => "form-control"
			),
			"options" => array(
				"empty_option"  => "-- Select Special --",
				"value_options" => array(
					"normal"   => "Normal",
					"special"  => "Special",
				),
				"label" => "Special",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "special"
				)
			)	
		));

		//sale_off type
		$this->add(array(
			"type" => "select",
			"name" => "sale_off_type",
			"required" => false,
			"attributes" => array(
				"class" => "form-control"
			),
			"options" => array(
				"empty_option"  => "-- Select sale off type --",
				"value_options" => array(
					"percent"  => "Percent",
					"number" => "Number",
				),
				"label" => "Sale off type",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "sale_off_type"
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

		//description
		$this->add(array(
			"type" => "textarea",
			"name" => "description",
			"required" => false,
			"attributes" => array(
				"class" => "form-control",
				"id"    => "description"
			),
			"options" => array(
				"label" => "Description",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "description",
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
			"name" => "picture",
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