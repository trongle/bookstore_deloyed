<?php 
namespace ZendVN\Paginator;

class Paginator{
	public static function createPagination($totalItem,$configPaginator){
		$adapterPaginator = new \Zend\Paginator\Adapter\NullFill($totalItem);
		$paginator        = new \Zend\Paginator\Paginator($adapterPaginator);
		$paginator->setItemCountPerPage($configPaginator['itemPerPage'])
		          ->setCurrentPageNumber($configPaginator['curentPage'])
		          ->setPageRange($configPaginator['pageRange']);
		return $paginator;
	}
}
?>