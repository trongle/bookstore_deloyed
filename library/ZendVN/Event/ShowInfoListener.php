<?php 
namespace ZendVN\Event;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class ShowInfoListener implements ListenerAggregateInterface{

	protected $_listeners = array();

	public function attach(EventManagerInterface $events){
		$shareEventManager  = $events->getSharedManager();
	 	$this->_listeners[] = $shareEventManager->attach("ZendVN\Event\Foo","showInfo",array($this,"funcDoOne"));
	 	$this->_listeners[] = $shareEventManager->attach("ZendVN\Event\Foo","showInfo",array($this,"funcDoTwo"));
	}

	public function detach(EventManagerInterface $events){
		if(!empty($this->_listeners)){
			foreach($this->_listeners as $index => $listener){
				if($events->detach($listener)) unset($this->_listeners[$index]);
			}
		}
	}

	public function funcDoOne(){
		echo "<h3 style='color:red;font-weight:bold'>".__METHOD__."</h3>";
	}

	public function funcDoTwo(){
		echo "<h3 style='color:red;font-weight:bold'>".__METHOD__."</h3>";
	}
}