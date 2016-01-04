<?php
namespace ZendVN\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\MvcEvent;

class MyAbstractController extends AbstractActionController
{
	protected $_mainParam;
	protected $_tableObj;
	protected $_formObj;
	protected $_options = ["tableName","formName"];
	protected $_configPaginator = [
		"pageRange"   => 3,
		"itemPerPage" => 5
	];
	protected $_orderList = [
		"order"    => "DESC",
		"order_by" => "id"
	];

	protected $_search = [
		"search_key"   => null,
		"search_value" => null
	];

	protected $_filter_status;

	public function setPluginManager(PluginManager $plugin){
		parent::setPluginManager($plugin);
		$this->getEventManager()->attach(MvcEvent::EVENT_DISPATCH,array($this,"onInit"),100);
	}

	public function getTable(){
		if($this->_tableObj == ""){
			$this->_tableObj = $this->getServiceLocator()->get($this->_options["tableName"]);
		};
		return $this->_tableObj;		
	}

	public function getForm(){
		if($this->_formObj == ""){
			$this->_formObj = $this->serviceLocator->get("FormElementManager")->get($this->_options['formName']);
		};
		return $this->_formObj;		
	}

	public function onInit(MvcEvent $e){
		$routerMatch     = $e->getRouteMatch();
		$arrayController = explode("\\",$routerMatch->getParam("controller"));
		$module          = strtolower($arrayController[0]);

		$viewModel = $e->getViewModel();

		$this->_mainParam['module']     = strtolower($arrayController[0]);
		$this->_mainParam['controller'] = strtolower($arrayController[2]);
		$this->_mainParam['action']     = strtolower($routerMatch->getParam("action"));

		//truyền ra cho layout
		$viewModel->params = array(
			"module"      => strtolower($arrayController[0])
			,"controller" => strtolower($arrayController[2])
			,"action"     => strtolower($routerMatch->getParam("action"))
		);

		$config = $this->getServiceLocator()->get("config");
		$layout = $config["module_for_layouts"][strtolower($arrayController[0])]; 
		//set layout
		$this->layout($layout);

		//func Init() giúp cho các controller extends có thể override onInit()
		$this->init();
	}
	public function init(){
	}

	public function toAction(array $actionInfo = null){
		$actionInfo["controller"] = (isset($actionInfo["controller"]))? $actionInfo["controller"] : $this->_mainParam['controller'];
		$actionInfo["action"]     = (isset($actionInfo["action"]))? $actionInfo["action"] : "index";
		return $this->redirect()->toRoute("adminRoute/default",array(
																"controller"=>$actionInfo["controller"],
																"action"=>$actionInfo["action"]));
	}
}
?>