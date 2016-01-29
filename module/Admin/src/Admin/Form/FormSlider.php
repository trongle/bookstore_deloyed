<?php
namespace Admin\Form;

use Admin\Model\BookTable;
use Admin\Model\SliderTable;
use Zend\Form\Form;

class FormSlider extends Form{
	public function __construct(BookTable $bookTable,SliderTable $sliderTable){
		parent::__construct();
		$ids_slider = $sliderTable->listItem(null,array("task"=>"list-id"));
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

		// //book
		// $this->add(array(
		// 	"type" => "select",
		// 	"name" => "book_id",
		// 	"required" => false,
		// 	"attributes" => array(
		// 		"class" => "form-control"
		// 	),
		// 	"options" => array(
		// 		"empty_option"  => "-- Select book --",
		// 		"value_options" => $bookTable->itemInSelectBox(null,$ids_slider,array("task"=>"list-slider")),
		// 		"label" => "Book",
		// 		"label_attributes" => array(
		// 			"class" => "col-sm-3 control-label",
		// 			"for"   => "book_id"
		// 		)
		// 	)	
		// ));

			//book
		$this->add(array(
			"type" => "text",
			"name" => "book_name",
			"required" => false,
			"attributes" => array(
				"class" => "form-control",
				"id"    => "keyword",
				"autocomplete" => "off"
			),
			"options" => array(
				"label" => "Book",
				"label_attributes" => array(
					"class" => "col-sm-3 control-label",
					"for"   => "book_id"
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
			"type" => "hidden",
		));
		$this->add(array(
			"name" => "book_id",
			"type" => "hidden",
			"attributes" => array(
				"id"    => "mID"
			),
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