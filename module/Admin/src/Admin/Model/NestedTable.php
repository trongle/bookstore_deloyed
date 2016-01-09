<?php 
namespace Admin\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class NestedTable extends AbstractTableGateway{
	protected $_tableGateway;
	public function __construct(TableGateway $tableGateway){
		$this->_tableGateway = $tableGateway;
		return $this;
	}

	public function listNode($arr = null,$options = null){
		if($options == null){
			$result = $this->_tableGateway->select(function(select $select){
				$select->columns(array("id","name","right","left","level"))
				       ->order(array("left ASC"));
			});
		}

		if($options["task"] == "list-level"){
			$result = $this->_tableGateway->select(function(select $select) use($arr){
					$select->columns(array("id","name","right","left","level"))
					       ->order(array("left ASC"))
					       ->where->greaterThan("level",0)
					       ->where->lessThanOrEqualTo("level",$arr["level"]);
			});
		}

		if($options["task"] == "list-branch"){
			$nodeMain = $this->getInfoNode($arr["id"]);
			$result = $this->_tableGateway->select(function(select $select) use($nodeMain){
					$select->columns(array("id","name","right","left","level"))
					       ->order(array("left ASC"))
					       ->where->greaterThan("level",0)
					       ->where->between("left",$nodeMain->left,$nodeMain->right);
			});
		}

		if($options["task"] == "list-breadcrumd"){
			$nodeMain = $this->getInfoNode($arr["id"]);
			$result = $this->_tableGateway->select(function(select $select) use($nodeMain){
						$select->columns(array("id","name","right","left","level"))
						       ->order(array("left ASC"))
						       ->where->greaterThan("level",0)
						       ->where->greaterThanOrEqualTo("right",$nodeMain->left)
						       ->where->lessThanOrEqualTo("left",$nodeMain->right);
			});
		}
		
		return $result;
	}

	public function getInfoNode($id = null,$options = null){
		if($options == null){
			$result = $this->_tableGateway->select(function(select $select) use($id){
				$select->columns(array("id","name","right","left","level"))
				       ->where->equalTo("id",$id);
			})->current();
		}
		return $result;
	}

}
?>