<?php 
namespace Shop\Model;

use PHPImageWorkshop\ImageWorkshop;
use ZendVN\File\Image;
use ZendVN\File\Upload;
use ZendVN\System\Info;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Json\Json;

class OrderTable extends AbstractTableGateway{
	protected $_tableGateway;
	public function __construct(TableGateway $tableGateway){
		$this->_tableGateway = $tableGateway;
		return $this;
	}

	public function saveItem($param,$option = null){
		if($option == null){
			$info = new Info();
			$data['id']       = substr(md5(time()),0,7);
			$data['username'] =  $info->getUserInfo('username');  
			$data['books']    =  Json::encode($param['books']); 
			$data['prices']   =  Json::encode($param['prices']);  
			$data['status']   =  0; 
			$data['qty']      =  Json::encode($param['qty']); 
			$data['date']     =  date("Y-m-d H-i-s");  
			$data['pictures'] =  Json::encode($param['pictures']);
			$data['names']    =  Json::encode($param['names']);  

			$this->_tableGateway->insert($data);

		}
	}
	public function getItem($option = null){
		if($option == null){
			$info = new Info();
			$username = $info->getUserInfo("username");
			return $this->_tableGateway->select(function($select) use($username){
				$select->columns(array("books","status","qty","prices","date","names","id","pictures"))
					   ->where->equalTo("username",$username);
			});
		}
	}


}
?>