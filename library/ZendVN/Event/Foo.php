<?php 

namespace ZendVN\Event;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

class Foo implements EventManagerAwareInterface{
	protected $_event;
	public function showInfo($param1,$param2){
		echo "<h3 style='color:red;font-weight:bold'>".__METHOD__."</h3>";
		$params = array($param1,$param2);
		//get param  by COMpact
		//$params = compact("param1","param2");
		
/*---^ Above not important --^*/
/*---> Just CAre this -->*/$this->getEventManager()->trigger(__FUNCTION__,$this,$params);
	}

	public function setEventManager(EventManagerInterface $eventManager){
		$this->_event = $eventManager;
		$this->_event->setIdentifiers(__CLASS__);
		return $this;
	}

	public function getEventManager(){
		if(!$this->_event){
			$this->setEventManager(new EventManager(__CLASS__));
		}

		return $this->_event;
	}
}