<?php 
namespace ZendVN\Validator;

class StringLength extends \Zend\Validator\StringLength{
	protected $messageTemplates = array(
        self::INVALID   => "Dữ liệu không hơp lệ",
        self::TOO_SHORT => "Chiều dài của '%value%' phải lớn hơn %min%",
        self::TOO_LONG  => "Chiều dài của '%value%' phải nhỏ hon %max%",
    );
}
?>