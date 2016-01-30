<?php 
namespace Shop\Form;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\InputFilter\InputFilter;

class FormLoginFilter extends InputFilter{
	public function __construct(array $options = null){
		//email
		$this->add(array(
			'name'    => "email",
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
			)
		));


		//password
		$this->add(array(
			'name'    => "password",
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
			)
		));
	}
}
?>