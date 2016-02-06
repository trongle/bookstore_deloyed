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

class SliderTable extends AbstractTableGateway{
	protected $_tableGateway;
	public function __construct(TableGateway $tableGateway){
		$this->_tableGateway = $tableGateway;
		return $this;
	}

	public function listItem($arrParam = null,$options = null){
		if($options['task'] == "list-item"){
			$result =   $this->_tableGateway->select(function(Select $select) use($arrParam){
				$select->columns(array("id","name","picture","price","description"))
				 	   ->where->equalTo("slider.status",1);
			});
		}
		return $result;
	}

	public function getItem($arrParam,$options = null){
		if($options["task"] == "book-special"){
			return 	$this->_tableGateway->select(function(select $select){
				$select->columns(array("id","name","description","picture","price","sale_off"))
					   ->order(new Expression("RAND()"))
					   ->where->equalTo("special",1)
					   ->where->equalTo("status",1);
			})->current();
		}	

		if($options["task"] == "book-popup"){
			return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","name","description","picture","price","sale_off"))
					   ->where->equalTo("id",$arrParam['id']);
			})->current();
		}	
	}


}
?>