<?php 
namespace Admin\Form;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\InputFilter\InputFilter;

class FormBookFilter extends InputFilter{
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
						"table"   => "book",
						"field"   => "name",
						"adapter" => GlobalAdapterFeature::getStaticAdapter(),
						"exclude" => $exclude,
						"messages" => array(
							\Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => "Username đã tồn tại"
						)
					),
					"break_chain_on_failure" => "true"
				),			
			)
			
		));

		//picture
		$this->add(array(
			'name'    => "image",
			"required" => false,
			"validators" => array(
				array(
					"name" => "FileSize",
					"options" => array(
						"min" => "2KB",
						"max" => "2MB",
						"messages" => array(
							\Zend\Validator\File\Size::TOO_BIG   => "Dung lượng lớn nhất cho phép là '%max%' nhưng '%size%' lớn hơn",
							\Zend\Validator\File\Size::TOO_SMALL => "Dung lượng nhỏ nhất cho phép là '%min%' nhưng '%size%' nhỏ hơn",
						)
					),
					"break_chain_on_failure" => "true"
				),
				array(
					"name" => "FileExtension",
					"options" => array(
						"extension" => array("png","jpg"),
						"messages" => array(
							\Zend\Validator\File\Extension::FALSE_EXTENSION => "phần mở rộng không phù hợp"
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