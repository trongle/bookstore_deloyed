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
		if($options['task'] == "list-item"){
			$result =   $this->_tableGateway->select(function(Select $select) use($arrParam){
				$select->columns(array("id","name","picture","ordering","modified","modified_by","created","created_by","status","special","price","sale_off"))
				       ->join(array("c"=>"category"),
				       		  "c.id = book.category_id",
				       		  array("ca_name"=>"name"),
				       		  $select::JOIN_LEFT
				       	)
				       ->order(array(sprintf("%s %s",$arrParam['order']['order_by'] , $arrParam['order']['order'])))
				       ->offset(($arrParam['paginator']['curentPage']-1) * $arrParam['paginator']['itemPerPage'])
				       ->limit($arrParam['paginator']['itemPerPage']);

				if(!empty($arrParam['filter_status'])){
					$status = ($arrParam['filter_status']=="active")? 1:0;
					$select->where->equalTo("book.status",$status);
				}

				if(!empty($arrParam['filter_special'])){
					$special = ($arrParam['filter_special']=="special")? 1:0;
					$select->where->equalTo("book.special",$special);
				}


				if(!empty($arrParam['filter_category'])){
					$select->where->equalTo("book.category_id",$arrParam['filter_category']);
				}

		

				if(!empty($arrParam['search']['search_value']) && !empty($arrParam['search']['search_key'])){
					if($arrParam['search']['search_key'] != "all"){
						$select->where->like("book.".$arrParam['search']['search_key'],
											 "%".$arrParam['search']['search_value']."%");
					}else{
						$select->where->NEST
						              ->like("book."."name","%".$arrParam['search']['search_value']."%")
									  ->or->equalTo("book."."id",$arrParam['search']['search_value'])
									  ->UNNEST;
					}	
					
				}
			  // echo $select->getSqlString();exit();
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