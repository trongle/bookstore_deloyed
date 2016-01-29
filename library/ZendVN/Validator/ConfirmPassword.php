<?php 
namespace ZendVN\Validator;

use Zend\Validator\AbstractValidator;

class ConfirmPassword extends AbstractValidator{
	const CONFIRM_PASS   = 'confirmPasswordInvalid';
	protected $messageTemplates = array(
        self::CONFIRM_PASS   => "Password và re-password không hợp lệ"
    );

    // protected $messageVariables = array(
    //     'pattern' => array('options' => 'pattern')
    // );

    protected $options = array(
        're_password'      => "", 
   	);
    public function __construct($options = array())
    {
        if (!is_array($options)) {
            $options     = func_get_args();
            $temp['re_password'] = array_shift($options);
            $options = $temp;
        }

        parent::__construct($options);
    }

    public function getRePassword(){
    	return $this->options['re_password'];
    }

    public function setRePassword($re_password){
    	$this->options['re_password'] = $re_password;
        return $this;
    }

    public function isValid($password){
    	$re_password = $this->getRePassword();
    	if (strcmp($password,$re_password) != 0){
            $this->error(self::CONFIRM_PASS);
            return false;
        }
        return true;
    }
}
?>