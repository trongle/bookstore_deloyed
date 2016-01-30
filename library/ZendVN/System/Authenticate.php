<?php 
namespace ZendVN\System;

use Zend\Authentication\AuthenticationService;

class Authenticate {
	protected $_authen;
	protected $_messageError;
	public function __construct(AuthenticationService $authenticate){
		return $this->_authen = $authenticate;
	}

	public function login($arrParams = null,$options = null){
		$this->_authen->getAdapter()->setIdentity($arrParams["email"]);
		$this->_authen->getAdapter()->setCredential($arrParams["password"]);

		$result = $this->_authen->authenticate();
		if(!$result->isValid()){
			$this->_messageError = "Tài khoản không đúng , vui lòng thử lại";
			return false;
		}else{
			//lưu thông tin User vào Session
			$userInfo = $this->_authen->getAdapter()->getResultRowObject(array("id","email","name"));
			$this->_authen->getStorage()->write($userInfo);
			return true;
		}
	}

	public function getMessages($arrParams = null ,$options = null){
		if(!empty($this->_messageError)) return '<div class="warning">'.$this->_messageError."</div>";
	} 

	public function logout($arrParams = null ,$options = null){
		$this->_authen->clearIdentity();
	}
}
?>