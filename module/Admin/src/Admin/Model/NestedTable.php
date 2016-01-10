<?php 
namespace Admin\Model;

use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\where;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class NestedTable extends AbstractTableGateway{
	protected $_tableGateway;
	public function __construct(TableGateway $tableGateway){
		$this->_tableGateway = $tableGateway;
		return $this;
	}

	protected function setRight(){
		return array(
			"right" => new Expression("(`right` + 2)")
		);
	}

	protected function setLeft(){
		return array(
			"left" => new Expression("(`left` + 2)")
		);
	}

	public function listNode($arr = null,$options = null){
		if($options == null){
			$result = $this->_tableGateway->select(function(select $select){
				$select->columns(array("id","name","right","left","level","parent"))
				       ->order(array("left ASC"))
				       ->where->notEqualTo("parent",0);
			});
		}

		if($options["task"] == "list-level"){
			$result = $this->_tableGateway->select(function(select $select) use($arr){
					$select->columns(array("id","name","right","left","level","parent"))
					       ->order(array("left ASC"))
					       ->where->greaterThan("level",0)
					       ->where->lessThanOrEqualTo("level",$arr["level"]);
			});
		}

		if($options["task"] == "list-branch"){
			$nodeMain = $this->getInfoNode($arr["id"]);
			$result = $this->_tableGateway->select(function(select $select) use($nodeMain){
					$select->columns(array("id","name","right","left","level","parent"))
					       ->order(array("left ASC"))
					       ->where->greaterThan("level",0)
					       ->where->between("left",$nodeMain->left,$nodeMain->right);
			});
		}

		if($options["task"] == "list-breadcrumd"){
			$nodeMain = $this->getInfoNode($arr["id"]);
			$result = $this->_tableGateway->select(function(select $select) use($nodeMain){
						$select->columns(array("id","name","right","left","level","parent"))
						       ->order(array("left ASC"))
						       ->where->greaterThan("level",0)
						       ->where->greaterThanOrEqualTo("right",$nodeMain->left)
						       ->where->lessThanOrEqualTo("left",$nodeMain->right);
			});
		}
		
		return $result;
	}

	public function insertNode($nodeNew,$nodeID,$options){
		//lấy info nodeBefore
		$nodeInfo   = $this->getInfoNode($nodeID);
		$setRight   = $this->setRight();
		$setLeft    = $this->setLeft();
		$whereRight = new where();
		$whereLeft  = new where();

		switch ($options["position"]) {
			case 'before':
				$whereRight->greaterThan("right",$nodeInfo->left);
				$whereLeft->greaterThanOrEqualTo("left",$nodeInfo->left);
				$data = array(
					"parent" => $nodeInfo->parent,
					"level"  => $nodeInfo->level,
					"left"   => $nodeInfo->left,
					"right"  => $nodeInfo->right 
				);
				break;
			case 'left':
				$whereRight->greaterThan("right",$nodeInfo->left);
				$whereLeft->greaterThan("left",$nodeInfo->left);
				$data = array(
					"parent" => $nodeInfo->id,
					"level"  => $nodeInfo->level + 1,
					"left"   => $nodeInfo->left + 1,
					"right"  => $nodeInfo->left +2 
				);	
				break;
			case 'after':
				$whereRight->greaterThan("right",$nodeInfo->right);
				$whereLeft->greaterThan("left",$nodeInfo->right);
				$data = array(
					"parent" => $nodeInfo->parent,
					"level"  => $nodeInfo->level,
					"left"   => $nodeInfo->right + 1,
					"right"  => $nodeInfo->right + 2 
				);
				break;
			case 'right':
			default:
				$whereLeft->greaterThan("left",$nodeInfo->right);
				$whereRight->greaterThanOrEqualTo("right",$nodeInfo->right);
				$data = array(
					"parent" => $nodeInfo->id,
					"level"  => $nodeInfo->level + 1,
					"left"   => $nodeInfo->right,
					"right"  => $nodeInfo->right + 1
				);			
			
				break;
		}
		$data["name"]   = $nodeNew["name"];
		$data["status"] = $nodeNew["status"];
		$this->_tableGateway->update($setRight,$whereRight);
		$this->_tableGateway->update($setLeft,$whereLeft);
		$this->_tableGateway->insert($data);
	}

	public function getInfoNode($obj = null,$options = null){
		if($options == null){
			$result = $this->_tableGateway->select(function(select $select) use($obj){
				$select->columns(array("id","name","right","left","level","parent"))
				       ->where->equalTo("id",$obj);
			})->current();
		}

		if($options['action'] == "move-up"){
			$result = $this->_tableGateway->select(function(select $select) use($obj){
				$select->columns(array("id","name","right","left","level","parent"))
				       ->order("left DESC")
				       ->limit(1)
				       ->where->notEqualTo("id",$obj->id)
				       ->where->lessThan("right",$obj->left)
				       ->where->equalTo("parent",$obj->parent);
			})->current();
		}

		if($options['action'] == "move-down"){
			$result = $this->_tableGateway->select(function(select $select) use($obj){
				$select->columns(array("id","name","right","left","level","parent"))
					   ->order("left ASC")
					   ->limit(1)
				       ->where->notEqualTo("id",$obj->id)
				       ->where->greaterThan("left",$obj->right)
				       ->where->equalTo("parent",$obj->parent);
			})->current();
		}

		if($options['action'] == "list-child"){
			$result = $this->_tableGateway->select(function(select $select) use($obj){
				$select->columns(array("id","name","right","left","level","parent"))
					   ->order("left ASC")
				       ->where->equalTo("parent",$obj->id);
			});
		}
		return $result;
	}

	public function detachNode($nodeID,$options = null){
		$nodeInfo = $this->getInfoNode($nodeID);
		//tính độ dài của nhánh
		$nodeLength = $nodeInfo->right - $nodeInfo->left + 1 ;

	
		if($options == null){
		//tách nhánh ra khỏi cây
			$setBranch = array(
			"left"  => new Expression("`left` - ?",array($nodeInfo->left)), 
			"right" => new Expression("`right` - ?",array($nodeInfo->right))
			);
			$whereBranch = new where();
			$whereBranch->between("left",$nodeInfo->left,$nodeInfo->right);
			$this->_tableGateway->update($setBranch,$whereBranch);
		}

		if($options["task"] == "remove"){
		//xóa nhánh được tách
			$whereBranch = new where();
			$whereBranch->between("left",$nodeInfo->left,$nodeInfo->right);
			$this->_tableGateway->delete($whereBranch);
		}
		

		//update cho các node còn lại
			//left
		$setLeft = array( "left" => new Expression("`left` - ?",array($nodeLength)) );
		$whereLeft = new where();
		$whereLeft->greaterThan("left",$nodeInfo->right);
		$this->_tableGateway->update($setLeft,$whereLeft);

			//right
		$setRight = array( "right" => new Expression("`right` - ?",array($nodeLength)) );
		$whereRight = new where();
		$whereRight->greaterThan("right",$nodeInfo->right);
		$this->_tableGateway->update($setRight,$whereRight);

		return $nodeLength;
	}

	public function moveNode($nodeMoveID,$nodeSelectID,$options){
		switch ($options["position"]) {
			case 'left':
				$this->moveLeft($nodeMoveID,$nodeSelectID);
				break;
			case 'before':
				$this->moveBefore($nodeMoveID,$nodeSelectID);
				break;
			case 'after':
				$this->moveAfter($nodeMoveID,$nodeSelectID);
				break;
			case 'right':
			default:
				$this->moveRight($nodeMoveID,$nodeSelectID);
				break;

		}
	}

	public function moveRight($nodeMoveID,$nodeSelectID){
		//=================Tách nhánh====================
		$nodeLength = $this->detachNode($nodeMoveID);
		//=================get Info ==================
		$nodeMove   = $this->getInfoNode($nodeMoveID);
		$nodeSelect = $this->getInfoNode($nodeSelectID);

		//================cập nhật các node trên cây===============
			//Left
		$set   = array("left" => new Expression("`left` + ?",array($nodeLength)) );
		$where = new where();
		$where->greaterThan("left",$nodeSelect->right);
		$where->greaterThan("right",0);
		$this->_tableGateway->update($set,$where);
			//Right
		$set   = array("right" => new Expression("`right` + ?",array($nodeLength)) );
		$where = new where();
		$where->greaterThanOrEqualTo("right",$nodeSelect->right);
		$this->_tableGateway->update($set,$where);

		//==============update Level cho nodeMove==================
		$set = array("level" => new Expression("`level` + ?",array($nodeSelect->level - $nodeMove->level + 1)) );
		$where = new where();
		$where->lessThanOrEqualTo("right",0);
		$this->_tableGateway->update($set,$where);

		//==============cập nhật các node trên nhánh detach==================
			//Left	
		$set = array("left" => new Expression("`left` + ?",array($nodeSelect->right)));
		$this->_tableGateway->update($set,$where);
			//Right	
		$set = array("right" => new Expression("`right` + ?",array($nodeSelect->right + $nodeLength - 1)));
		$this->_tableGateway->update($set,$where);

		//==============cập nhật parent cho các node trên detach==================
		$set = array("parent" => $nodeSelect->id);
		$where = new where();
		$where->equalTo("id",$nodeMove->id);
		$this->_tableGateway->update($set,$where);
	}


	public function moveLeft($nodeMoveID,$nodeSelectID){
		//=================Tách nhánh====================
		$nodeLength = $this->detachNode($nodeMoveID);
		//=================get Info ==================
		$nodeMove   = $this->getInfoNode($nodeMoveID);
		$nodeSelect = $this->getInfoNode($nodeSelectID);

		//================cập nhật các node trên cây===============
			//Left
		$set   = array("left" => new Expression("`left` + ?",array($nodeLength)) );
		$where = new where();
		$where->greaterThan("left",$nodeSelect->left);
		$where->greaterThan("right",0);
		$this->_tableGateway->update($set,$where);
			//Right
		$set   = array("right" => new Expression("`right` + ?",array($nodeLength)) );
		$where = new where();
		$where->greaterThan("right",$nodeSelect->left);
		$this->_tableGateway->update($set,$where);

		//==============update Level cho nodeMove==================
		$set = array("level" => new Expression("`level` + ?",array($nodeSelect->level - $nodeMove->level + 1)) );
		$where = new where();
		$where->lessThanOrEqualTo("right",0);
		$this->_tableGateway->update($set,$where);

		//==============cập nhật các node trên nhánh detach==================
			//Left	
		$set = array("left" => new Expression("`left` + ?",array($nodeSelect->left + 1)) );
		$this->_tableGateway->update($set,$where);
			//Right	
		$set = array("right" => new Expression("`right` + ?",array($nodeSelect->left + $nodeLength)) );
		$this->_tableGateway->update($set,$where);

		//==============cập nhật parent cho các node trên detach==================
		$set = array("parent" => $nodeSelect->id);
		$where = new where();
		$where->equalTo("id",$nodeMove->id);
		$this->_tableGateway->update($set,$where);
	}

	public function moveBefore($nodeMoveID,$nodeSelectID){
		//=================Tách nhánh====================
		$nodeLength = $this->detachNode($nodeMoveID);
		//=================get Info ==================
		$nodeMove   = $this->getInfoNode($nodeMoveID);
		$nodeSelect = $this->getInfoNode($nodeSelectID);

		//================cập nhật các node trên cây===============
			//Left
		$set   = array("left" => new Expression("`left` + ?",array($nodeLength)) );
		$where = new where();
		$where->greaterThanOrEqualTo("left",$nodeSelect->left);
		$this->_tableGateway->update($set,$where);
			//Right
		$set   = array("right" => new Expression("`right` + ?",array($nodeLength)) );
		$where = new where();
		$where->greaterThan("right",$nodeSelect->left);
		$this->_tableGateway->update($set,$where);

		//==============update Level cho nodeMove==================
		$set = array("level" => new Expression("`level` + ?",array($nodeSelect->level - $nodeMove->level )) );
		$where = new where();
		$where->lessThanOrEqualTo("right",0);
		$this->_tableGateway->update($set,$where);

		//==============cập nhật các node trên nhánh detach==================
			//Left	
		$set = array("left" => new Expression("`left` + ?",array($nodeSelect->left )) );
		$this->_tableGateway->update($set,$where);
			//Right	
		$set = array("right" => new Expression("`right` + ?",array($nodeSelect->left + $nodeLength - 1)) );
		$this->_tableGateway->update($set,$where);

		//==============cập nhật parent cho các node trên detach==================
		$set = array("parent" => $nodeSelect->parent);
		$where = new where();
		$where->equalTo("id",$nodeMove->id);
		$this->_tableGateway->update($set,$where);

	}

	public function moveAfter($nodeMoveID,$nodeSelectID){
		//=================Tách nhánh====================
		$nodeLength = $this->detachNode($nodeMoveID);
		//=================get Info ==================
		$nodeMove   = $this->getInfoNode($nodeMoveID);
		$nodeSelect = $this->getInfoNode($nodeSelectID);

		//================cập nhật các node trên cây===============
			//Left
		$set   = array("left" => new Expression("`left` + ?",array($nodeLength)) );
		$where = new where();
		$where->greaterThan("left",$nodeSelect->right);
		$this->_tableGateway->update($set,$where);
			//Right
		$set   = array("right" => new Expression("`right` + ?",array($nodeLength)) );
		$where = new where();
		$where->greaterThan("right",$nodeSelect->right);
		$this->_tableGateway->update($set,$where);

		//==============update Level cho nodeMove==================
		$set = array("level" => new Expression("`level` + ?",array($nodeSelect->level - $nodeMove->level )) );
		$where = new where();
		$where->lessThanOrEqualTo("right",0);
		$this->_tableGateway->update($set,$where);

		//==============cập nhật các node trên nhánh detach==================
			//Left	
		$set = array("left" => new Expression("`left` + ?",array($nodeSelect->right + 1 )) );
		$this->_tableGateway->update($set,$where);
			//Right	
		$set = array("right" => new Expression("`right` + ?",array($nodeSelect->right + $nodeLength )) );
		$this->_tableGateway->update($set,$where);

		//==============cập nhật parent cho các node trên detach==================
		$set = array("parent" => $nodeSelect->parent);
		$where = new where();
		$where->equalTo("id",$nodeMove->id);
		$this->_tableGateway->update($set,$where);

	}

	public function moveUp($nodeID){
		$nodeInfo = $this->getInfoNode($nodeID);
		$nodeBefore = $this->getInfoNode($nodeInfo,array("action"=>"move-up"));
		if(!empty($nodeBefore)) $this->moveBefore($nodeInfo->id,$nodeBefore->id);

	}

	public function moveDown($nodeID){
		$nodeInfo = $this->getInfoNode($nodeID);
		$nodeAfter = $this->getInfoNode($nodeInfo,array("action"=>"move-down"));
		if(!empty($nodeAfter)) $this->moveAfter($nodeInfo->id,$nodeAfter->id);
	}

	public function updateNode($data,$nodeID,$nodeParentID = null,$options = null){
		if(!empty($nodeID) && !empty($data)){
			$this->_tableGateway->update($data,array("id" => $nodeID));
			if(!empty($nodeParentID)){
				$nodeParent = $this->getInfoNode($nodeParentID);
				$node       = $this->getInfoNode($nodeID);
				if(!empty($nodeParent) && $node->parent != $nodeParent->id ){
					$this->moveRight($nodeID,$nodeParentID);
				}
			}
		}
	}

	public function removeNode($nodeID,$options){
		switch ($options["action"]) {
			case 'one':
				$this->removeOne($nodeID);
				break;
			case 'branch':
			default:
				$this->removeBranch($nodeID);
				break;
		}

	}

	protected function removeBranch($nodeID){
		if(!empty($nodeID)){
			$this->detachNode($nodeID,array("task" => "remove"));
		}
	}

	protected function removeOne($nodeID){
		if(!empty($nodeID)){
			$nodeRemove = $this->getInfoNode($nodeID);
			if(!empty($nodeRemove)){
				//tìm node con
				$nodeChild = $this->getInfoNode($nodeRemove,array("action" => "list-child"));
				//gắn các node vào parent của nodeRemove
				foreach($nodeChild as $node){
					$this->moveRight($node->id,$nodeRemove->parent);
				}

				//xóa nodeRemove
				$this->detachNode($nodeID,array("task"=>"remove"));
			}	
		}	
	}

	

}
?>