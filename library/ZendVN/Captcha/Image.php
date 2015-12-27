<?php 
namespace ZendVN\Captcha;

use Zend\Captcha\Image as ZendImage;

class Image extends ZendImage{
	protected $imgDir         = CAPTCHA_PATH."images";
	protected $imgUrl         = CAPTCHA_URL."images";
	protected $imgAlt         = "";
	protected $suffix         = ".png";
	protected $width          = 200;
	protected $height         = 50;
	protected $fsize          = 24;
	protected $font           = CAPTCHA_PATH."fonts/Vharis.ttf";
	protected $expiration     = 3;
	protected $dotNoiseLevel  = 100;
	protected $lineNoiseLevel = 5;
	protected $wordlen        = 8;
	public function __construct($height = null,$width = null,$options = null){
		parent::__construct();
		$this->height         = (!empty($height))? $height : $this->height;
		$this->width          = (!empty($width))? $width : $this->width;
		$this->imgDir         = (!empty($options['imgDir']))? $options['imgDir'] : $this->imgDir;
		$this->imgUrl         = (!empty($options['imgUrl']))? $options['imgUrl'] : $this->imgUrl;
		$this->font           = (!empty($options['font']))? $options['font'] : $this->font;
		$this->fsize          = (!empty($options['fsize']))? $options['fsize'] : $this->fsize;
		$this->wordlen        = (!empty($options['wordlen']))? $options['wordlen'] : $this->wordlen;
		$this->dotNoiseLevel  = (!empty($options['dotNoiseLevel']))? $options['dotNoiseLevel'] : $this->dotNoiseLevel;
		$this->lineNoiseLevel = (!empty($options['lineNoiseLevel']))? $options['lineNoiseLevel'] : $this->lineNoiseLevel;
		$this->expiration     = (!empty($options['expiration']))? $options['expiration'] : $this->expiration;

		$this->setImgDir($this->imgDir);
		$this->setImgUrl($this->imgUrl);
		$this->setFont($this->font);
		$this->setFontSize($this->fsize);
		$this->setWordlen($this->wordlen);
		$this->setWidth($this->width);
		$this->setHeight($this->height);
		$this->setDotNoiseLevel($this->dotNoiseLevel);
		$this->setLineNoiseLevel($this->lineNoiseLevel);
		$this->setExpiration($this->expiration);
		// parent::$VN = array("t");
		// parent::$CN = array("r");
		$this->generate();
	}

	public function removeOldCaptcha($captchaId,$options = null){
		$imgLink = $this->getImgDir().$captchaId.$this->getSuffix();
		unlink($imgLink);	
	}
}
?>