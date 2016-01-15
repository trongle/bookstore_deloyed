<?php 
namespace Admin\Form;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\InputFilter\InputFilter;

class FormSliderFilter extends InputFilter{
	public function __construct(array $options = null){
		$exclude = null;
		$required = true;
		//danh cho edit
		if($options["id"] != null){
			$exclude = array(
						"field" => "id",
						"value" => $options["id"]
					);
			$required = false;
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
						"table"   => "slider",
						"field"   => "name",
						"adapter" => GlobalAdapterFeature::getStaticAdapter(),
						"exclude" => $exclude,
						"messages" => array(
							\Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => "Name đã tồn tại"
						)
					),
					"break_chain_on_failure" => "true"
				),			
			)
			
		));

		
		//name
		$this->add(array(
			'name'    => "price",
			"validators" => array(
				array(
					"name" => "Digits",
					"options" => array(
						"messages" => array(
							\Zend\Validator\Digits::NOT_DIGITS => "Nội dung nhập vào phải là số",
						)
					),
					"break_chain_on_failure" => "true"
				)		
			)
			
		));

		//picture
		$this->add(array(
			'name'    => "image",
			'required' => $required,	
			"validators" => array(
				array(
					"name" => "FileSize",
					"options" => array(
						"min" => "2KB",
						"max" => "5MB",
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
				array(
					"name" => "FileImageSize",
					"options" => array(
						'minWidth'  => 870,  // Minimum image width
					    'maxWidth'  => 870,  // Maximum image width
					    'minHeight' => 370,  // Minimum image height
					    'maxHeight' => 370,  // Maximum image height
						"messages" => array(
							\Zend\Validator\File\ImageSize::WIDTH_TOO_BIG    => "Chỉ chấp nhận hình có chiều rộng = '%maxwidth%' ",
						    \Zend\Validator\File\ImageSize::WIDTH_TOO_SMALL  => "Chỉ chấp nhận hình có chiều rộng = '%minwidth%' ",
						    \Zend\Validator\File\ImageSize::HEIGHT_TOO_BIG   => "Chỉ chấp nhận hình có chiều cao =  '%maxheight%' ",
						    \Zend\Validator\File\ImageSize::HEIGHT_TOO_SMALL => "Chỉ chấp nhận hình có chiều cao =  '%minheight%' ",
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