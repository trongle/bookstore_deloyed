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

class GroupTable extends AbstractTableGateway{
	protected $_tableGateway;
	public function __construct(TableGateway $tableGateway){
		$this->_tableGateway = $tableGateway;
		return $this;
	}

	public function getItem($arrParam,$options = null){
		if($options == null){
			return 	$this->_tableGateway->select(function(select $select) use($arrParam){
				$select->columns(array("id","group_acp"))
					   ->where(array("id" => $arrParam["group_id"]));
			})->current();
		}
		
	}


}
?>