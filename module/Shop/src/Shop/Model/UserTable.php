<?php 
namespace Shop\Model;

use PHPImageWorkshop\ImageWorkshop;
use ZendVN\File\Image;
use ZendVN\File\Upload;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Json\Json;

class UserTable extends AbstractTableGateway{
	protected $_tableGateway;
	public function __construct(TableGateway $tableGateway){
		$this->_tableGateway = $tableGateway;
		return $this;
	}

	public function saveItem($arrParam,$options = null){
		//Quenr@i3
		$data = array();
		if($options['task'] == "add-item"){
			if(!empty($arrParam)){
				$data['username']      = $arrParam['username'];
				$data['email']         = $arrParam['email'];
				$data['password']      = md5($arrParam['password']);
				$data['fullname']      = $arrParam['fullname'];
				$data['register_time'] = date("Y-m-d H:i:s");
				$data['register_ip']   = $_SERVER['REMOTE_ADDR'];
				$data['active_code']   = substr(md5(time()),4,10);
				$data['group_id']      = 4;
				$data['status']        = 0;

			}			
			$this->_tableGateway->insert($data);
			return $this->_tableGateway->getLastInsertValue();
		}

		if($options['task'] == "active-user"){
			if(!empty($arrParam)){
				$data['active_code']   = 1;
				$data['group_id']      = 3;
				$data['status']        = 1;
			}			
			$this->_tableGateway->update($data,array("id"=>$arrParam['id']));
			return $this->_tableGateway->getLastInsertValue();
		}
	}

	public function getItem($arrParam,$options = null){
		if($options == null){
			return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","fullname","active_code","email"))
					   ->where(array("id"=>$arrParam["id"]));
			})->current();
		}
		if($options['task'] == 'active-user'){
			return $this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","fullname","active_code","email"))
					   ->where->equalTo('id',$arrParam['id'])
					          ->equalTo('active_code',$arrParam['active_code'])
					          ->noEqualTo('active_code',$arrParam['active_code']);
			})->count();
		}
	}


}
?>