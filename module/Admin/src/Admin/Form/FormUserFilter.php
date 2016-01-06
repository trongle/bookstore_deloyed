<?php 
namespace Admin\Form;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\InputFilter\InputFilter;

class FormUserFilter extends InputFilter{
	public function __construct(array $options = null){
		$exclude = null;
		$requirePassword = true;
		//danh cho edit
		if($options["id"] != null){
			$exclude = array(
						"field" => "id",
						"value" => $options["id"]
					);
			$requirePassword = false;
		}



		//name
		$this->add(array(
			'name'    => "username",
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
						"table"   => "user",
						"field"   => "username",
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

		//email
		$this->add(array(
			'name'    => "email",
			"validators" => array(
				array(
					"name" => "EmailAddress",
					"options" => array(
						"messages" => array(
							\Zend\Validator\EmailAddress::INVALID_FORMAT   => "Email không hợp lệ",
							\Zend\Validator\EmailAddress::INVALID_HOSTNAME => "Email không hợp lệ",
							\Zend\Validator\EmailAddress::INVALID          => "Email không hợp lệ",
							\Zend\Validator\EmailAddress::DOT_ATOM         => "Email không hợp lệ",
						)
					),
					"break_chain_on_failure" => "true"
				),
				array(
					"name" => "DbNoRecordExists",
					"options" => array(
						"table"   => "user",
						"field"   => "email",
						"adapter" => GlobalAdapterFeature::getStaticAdapter(),
						"exclude" => $exclude,
						"messages" => array(
							\Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => "Email đã tồn tại"
						)
					),
					"break_chain_on_failure" => "true"
				),
			)
		));

		//password
		$this->add(array(
			'name'    => "password",
			"required" => $requirePassword,
			"validators" => array(
				array(
					"name" => "Regex",
					"options" => array(
						"pattern"  => "#^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,15}$#",
						"messages" => array(
							\Zend\Validator\Regex::NOT_MATCH => "password phải có ít nhất 1 ký tự HOA,1 thường ,1 đặc biệt @,một số 1"
						),
					),
					"break_chain_on_failure" => "true"
				),
				array(
					"name" => "StringLength",
					"options" => array(
						"min"  => "8",
						"max"  => "15",
						"messages" => array(
							\Zend\Validator\StringLength::TOO_SHORT => "mật khẩu phải có ít nhất 8 ký tự",
							\Zend\Validator\StringLength::TOO_LONG  => "mật khẩu phải ngắn hơn 15 ký tự",
						),
					),
					"break_chain_on_failure" => "true"
				),
			)
		));

		//email
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