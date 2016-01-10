<?php 
namespace Admin\Controller;

use ZendVN\Controller\MyAbstractController;
use Zend\Session\Container;

class NestedController extends MyAbstractController
{

	protected $_orderList = [
		"order"    => "DESC",
		"order_by" => "id"
	];

	protected $_search = [
		"search_key"   => null,
		"search_value" => null
	];

	protected $_filter_status;
	protected $_filter_group;

	public function init(){
		$ssOrder = new Container(__CLASS__);
		//SET FILTER 
		$this->_orderList['order']     = !empty($ssOrder->order)? $ssOrder->order : $this->_orderList['order'] ;
		$this->_orderList['order_by']  = !empty($ssOrder->order_by)? $ssOrder->order_by : $this->_orderList['order_by'];
		$this->_filter_status          = $ssOrder->filter_status;
		$this->_filter_group           = $ssOrder->filter_group;
		$this->_search['search_key']   = $ssOrder->search_key;
		$this->_search['search_value'] = $ssOrder->search_value;

		//SET PAGINATOR
		$this->_configPaginator['pageRange']   = 3;
		$this->_configPaginator['itemPerPage'] = 5;
		$this->_configPaginator['curentPage']  = $this->params()->fromRoute("page",1);
		//SET OPTIONS 
		$this->_options["tableName"] = "NestedTable";
		$this->_options["formName"]  = "formAdminUser";
		// echo "<pre>";
		// print_r($this->request->getFiles()->toArray());
		// echo "</pre>";
		$this->_mainParam =array_merge($this->_mainParam,array(
													"paginator"     => $this->_configPaginator,
													"order"         => $this->_orderList,
													"filter_status" => $this->_filter_status,
													"filter_group"  => $this->_filter_group,
													"search"        => $this->_search
												));


		//nhân các tham so trả về từ request của các Action
		$this->_mainParam["data"] = array_merge($this->request->getPost()->toArray(),
			 									$this->request->getFiles()->toArray());
	}
	public function index01Action(){
		$items = $this->getTable()->listNode();
		$xhtml = "";
		foreach($items as $item){
			$data[$item->parent][] = $item->id;
			$ordering = array_search($item->id,$data[$item->parent]) +1;
			$space = str_repeat("----------|",$item->level - 1);
			$xhtml .= sprintf("<p>%s %s %s</p>",$space,$ordering,$item->name);
		}
		echo $xhtml;
		return $this->response;
	}

	//hien thi menu tùy chọn
		//level
	public function index02Action(){
		$items = $this->getTable()->listNode(array("level"=>1),array("task"=>"list-level"));
		$xhtml = "";
		foreach($items as $item){

			$space = str_repeat("----------|",$item->level - 1);
			$xhtml .= "<p>".$space." ".$item->name ."</p>";
		}
		echo $xhtml;
		return $this->response;
	}
		//branch
	public function index03Action(){
		$items = $this->getTable()->listNode(array("id"=>4),array("task"=>"list-branch"));
		$xhtml = "";
		foreach($items as $item){

			$space = str_repeat("----------|",$item->level - 1);
			$xhtml .= "<p>".$space." ".$item->name ."</p>";
		}
		echo $xhtml;
		return $this->response;
	}

		//breadcrumd
	public function index04Action(){
		$items = $this->getTable()->listNode(array("id"=>11),array("task"=>"list-breadcrumd"));
		$xhtml = "";
		foreach($items as $item){

			$space = str_repeat("----------|",$item->level - 1);
			$xhtml .= "<p>".$space." ".$item->name ."</p>";
		}
		echo $xhtml;
		return $this->response;
	}

		//insert
	public function insert01Action(){
		$nodeNew = array("status" => "1","name" => "C");
		$nodeID = "1";
		$options["position"] = "right";
		$this->getTable()->insertNode($nodeNew,$nodeID,$options);

		return $this->response;
	}

		//detach
	public function detachAction(){
		$this->getTable()->detachNode(3);
		return $this->response;
	}

		//moveNode
	public function moveAction(){
		$nodeMoveID = 3	;
		$this->getTable()->moveDown($nodeMoveID);
		return $this->response;
	}

		//update
			//+ thay đổi thông tin
			//+ thay đổi parent
	public function updateAction(){
		$data   = array(
			"name" => "node B1 -> D3",
		);
		$nodeID = 6;
		$nodeParentID = 5;
		$this->getTable()->updateNode($data,$nodeID,$nodeParentID);
		return $this->response;
	}

		//Remove
			//+ branch
			//+ one
	public function removeAction(){
		$nodeID = 5;
		$this->getTable()->removeNode($nodeID,array("action"=>"branch"));
		return $this->response;
	}


}
?>