<?php 
namespace ZendVN\Validator ;
use Zend\Validator\AbstractValidator;


class Captcha extends AbstractValidator{
	const NOT_EQUAL   = 'captchaNotEqual';
	protected $messageTemplates = array(
        self::NOT_EQUAL  => "Mã captcha không chính xác"
    );
    protected $_captcha_hidden;
    public function __construct($captcha_hidden)
    {
        parent::__construct($options);
        // if (!is_array($options)) {
        //     $options     = func_get_args();
        //     $temp['pattern'] = array_shift($options);
        //     $options = $temp;
        // }
        $this->_captcha_hidden = $captcha_hidden;
        
    }

    public function isValid($captcha_user){
    	$captchaSession = new \Zend\Session\Container("Zend_Form_Captcha_".$this->_captcha_hidden);
      
        if(strcmp($captchaSession->word,$captcha_user) != 0){
            $this->error(self::NOT_EQUAL);
            return false;  
        } 
        return true;
    }
}
?>