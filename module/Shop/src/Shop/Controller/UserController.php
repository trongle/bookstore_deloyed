<?php 
namespace Shop\Controller;

use ZendVN\Controller\MyAbstractController;
use ZendVN\System\Info;
use Zend\Form\FormInterface;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class UserController extends MyAbstractController{

	public function init(){
		$this->_options['tableName'] = "shopUserTable";
		$this->_options['formName']  = "formRegisterShop";

		//nhân các tham so trả về từ request của các Action
		$this->_mainParam["data"] = array_merge($this->params()->fromRoute(),
												$this->request->getPost()->toArray(),
			                                    $this->request->getFiles()->toArray());
	}

	public function activeAction(){
		//check active_code
		$check = $this->getTable()->getItem($this->_mainParam['data'],array('task' => 'active-code'));
		if($check == 0){
			return $this->redirect()->toRoute('shopRoute/default',array('controller' => 'notice','action' => 'actived'));
		}

		$lastId = $this->getTable()->saveItem($this->_mainParam['data'],array('task' => 'active-user'));
		return $this->redirect()->toRoute('shopRoute/default',array('controller' => 'notice','action' => 'active-success'));
	}

	public function adminAction(){
		return $this->redirect()->toRoute('adminRoute/default');
	}

	public function orderAction(){
		
		$bookID = $this->_mainParam['data']['id'];
		$price  = $this->_mainParam['data']['price'];
		$qty    = $this->_mainParam['data']['qty'];
		$ssOrder = new Container(BOOKONLINE_KEY."_order");
		$ssOrder->setExpirationSeconds(600);
		
		if(empty($ssOrder->qty)){
			$ssOrder->price = array($bookID => $price * $qty);
			$ssOrder->qty   = array($bookID => $qty);
		}else{
			if($ssOrder->qty[$bookID] > 0){
				$ssOrder->qty[$bookID]   += $qty;
				$ssOrder->price[$bookID] = $price * $ssOrder->qty[$bookID];
			}else{
				$ssOrder->qty[$bookID]   = $qty;
				$ssOrder->price[$bookID] = $price *$qty;
			}
			
		}
		return $this->redirect()->toRoute('shopRoute/default',array('controller'=>'user','action'=>'viewCart'));
	}

	public function viewCartAction(){
		$ssOrder = new Container(BOOKONLINE_KEY."_order");
		$this->_options['tableName'] = "shopBookTable";
		$books = $this->getTable()->getItem($ssOrder->qty,array('task' => 'book-view-cart'));
		return array(
			"books" => $books,
		);
	}

	public function checkOutAction(){
		if($this->request->isPost()){
			$this->_options['tableName'] = "shopOrderTable";
			$this->getTable()->saveItem($this->_mainParam['data']);


			$ssOrder = new Container(BOOKONLINE_KEY."_order");
			$ssOrder->getManager()->getStorage()->clear(BOOKONLINE_KEY."_order");
		}
		return $this->redirect()->toRoute("homeShop");
	}

	public function historyAction(){
		$this->_options['tableName'] = "shopOrderTable";
		$histories                   = $this->getTable()->getItem();
		return array(
			"histories" => $histories
		);
	}
}
?>