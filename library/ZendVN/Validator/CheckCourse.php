<?php 
namespace ZendVN\Validator ;
use Zend\Validator\AbstractValidator;


class CheckCourse extends AbstractValidator{
	const INVALID   = 'checkCourseInvalid';
	protected $messageTemplates = array(
        self::INVALID   => "ID khóa học không hợp lệ"
    );

    // protected $messageVariables = array(
    //     'pattern' => array('options' => 'pattern')
    // );

    protected $options = array(
        'pattern'      => "#^[a-zA-Z]{3}-[\d]{2}$#", 
   	);
    public function __construct($options = array())
    {
        if (!is_array($options)) {
            $options     = func_get_args();
            $temp['pattern'] = array_shift($options);
            $options = $temp;
        }

        parent::__construct($options);
    }

    public function getPattern(){
    	return $this->options['pattern'];
    }

    public function setPattern($pattern){
    	$this->options['pattern'] = $pattern;
        return $this;
    }

    public function isValid($value){
    	$pattern = $this->getPattern();
    	if (!preg_match($pattern,$value)){
            $this->error(self::INVALID);
            return false;
        }
        return true;
    }

  
}
?>