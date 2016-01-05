<?php 
namespace Admin\Form;

use Zend\InputFilter\InputFilter;

class FormUserFilter extends InputFilter{
	public function __construct(){
		//name
		$this->add(array(
			'name'    => "name",
			"validators" => array(
				array(
					"name" => "NotEmpty",
					"options" => array(
						"messages" => array(
							\Zend\Validator\NotEmpty::IS_EMPTY => "Dữ liệu không được rỗng"
						)
					),
					"break_chain_on_failure" => "true"
				),
				array(
					"name" => "StringLength",
					"options" => array(
						"min" => "3",
						"max" => "200",
						"messages" => array(
							\Zend\Validator\StringLength::TOO_SHORT => "Số ký tự phải lớn hơn hoặc bằng %min%",
							\Zend\Validator\StringLength::TOO_LONG  => "Số ký tự phải nhỏ hơn hoặc bằng %max%",
						)
					),
					"break_chain_on_failure" => "true"
				)			
			)
			
		));

		//PASSWORD
		$this->add(array(
			'name'    => "ordering",
			"validators" => array(
				array(
					"name" => "Digits",
					"options" => array(
						"messages" => array(
							\Zend\Validator\Digits::NOT_DIGITS => "ký tự phải là số"
						)
					),
					"break_chain_on_failure" => "true"
				),
			)
		));

		//PASSWORD
		$this->add(array(
			'name'    => "status",
			"required" => true
		));
	}
}
?>