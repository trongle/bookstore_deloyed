<?php 
namespace Admin\Form;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\InputFilter\InputFilter;

class FormCategoryFilter extends InputFilter{
	public function __construct(array $options = null){
		$exclude = null;
		//danh cho edit
		if($options["id"] != null){
			$exclude = array(
						"field" => "id",
						"value" => $options["id"]
					);
		}

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
				),
				array(
					"name" => "DbNoRecordExists",
					"options" => array(
						"table"   => "category",
						"field"   => "name",
						"adapter" => GlobalAdapterFeature::getStaticAdapter(),
						"exclude" => $exclude,
						"messages" => array(
							\Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => "Category name đã tồn tại"
						)
					),
					"break_chain_on_failure" => "true"
				),			
			)
			
		));
	

		//status
		$this->add(array(
			'name'    => "status",
			"required" => true
		));
	}
}
?>