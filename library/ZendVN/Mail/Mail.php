<?php 

namespace ZendVN\Mail;

use Zend\Mail\Message;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Mime;
use Zend\Mime\Part;


class Mail{
	protected $_config = array(
			"name" => "localhost",
			"connectionClass" => "login",
			"host" => "smtp.gmail.com",
			"port" => 587,   //465 25 587
			"connectionConfig" => array(
				"username" => "trongle1711@gmail.com",
				"password" => "ziydfvpluuxagbos",
				"ssl"      => "tls"
			)
		);

	public function sendMail($email,$fullname,$linkActive){
		$message = new \Zend\Mail\Message();
		$smtpOption = new SmtpOptions($this->_config);
		$message->setFrom($this->_config['connectionConfig']['username'],"bookStoreOnline");
		$message->setTo($email,$fullname);
		$message->setSubject("Kích hoạt tài khoản");
		$message->setEncoding("utf-8");
		//set HTML
		$content = new \Zend\Mime\Part(
			"<p>Xin chào ".$fullname."</p> 
			<p>Bạn vừa đăng ký tài khoản tại website BookOnline,
			để hoàn thành việc đăng ký bạn cui lòng <a href='".$linkActive."'>Click vào đây</a>
			để kích hoạt tài khoản</p>"

		);
		$content->type = Mime::TYPE_HTML;
		$content->charset = "utf-8";

		$mimeMessage = new \Zend\Mime\Message();
		$mimeMessage->setParts(array($content));
		$message->setBody($mimeMessage);
		
		$transport = new \Zend\Mail\Transport\Smtp($smtpOption);
		$transport->send($message);

	}
}
?>