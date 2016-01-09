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
		
			$space = str_repeat("-----|",$item->level);
			$xhtml .= "<p>".$space." ".$item->name ."</p>";
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
}
?>