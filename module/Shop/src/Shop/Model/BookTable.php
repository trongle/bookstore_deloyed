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

class BookTable extends AbstractTableGateway{
	protected $_tableGateway;
	public function __construct(TableGateway $tableGateway){
		$this->_tableGateway = $tableGateway;
		return $this;
	}

	public function listItem($arrParam = null,$options = null){
		if($options['task'] == 'book-new'){
			$result = $this->_tableGateway->select(function(select $select){
				$select->columns(array("id","name","description","picture","price","sale_off"))
					   ->order(array("id DESC"))
					   ->limit(6)
					   ->where->equalTo("status",1);
			});	
		}

		if($options['task'] == 'list-book-by-category'){
			$result = $this->_tableGateway->select(function(select $select) use($arrParam){
				$filter = $arrParam['filter'] ;
				$select->columns(array("id","name","description","picture","price","sale_off"))
					   ->order(array($filter['order'] ." ". $filter['dir']))
					   ->limit((int)$arrParam['pagination']['itemPerPage'])
					   ->offset(($arrParam['pagination']['curentPage']-1) * $arrParam['pagination']['itemPerPage'])
					   ->where->in("category_id",$arrParam['catIDs'])
					   ->where->equalTo("status",1);
			});	
		}
		
		return $result;
	}

	public function countItem($arrParam = null,$options = null){
		if($options['task'] == 'count-book'){
			$result = $this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","name","description","picture","price","sale_off"))
					   ->order(array("id DESC"))
					   ->where->in("category_id",$arrParam)
					   ->where->equalTo("status",1);
			});	
		}
		return $result->count();
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

		if($options["task"] == "book-info"){
			return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","name","description","picture","price","sale_off"))
					   ->where->equalTo("id",$arrParam['id']);
			})->current();
		}		

		if($options["task"] == "book-popup"){
			return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","name","description","picture","price","sale_off"))
					   ->where->equalTo("id",$arrParam['id']);
			})->current();
		}	

		if($options["task"] == "book-slider"){
			return 	$this->_tableGateway->select(function(select $select) use($arrParam){
					$select->columns(array("id","name"))
						   ->where->like("name","%".$arrParam['keyword']."%");
					
			});
		}	
	}


}
?>