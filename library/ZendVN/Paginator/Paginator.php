<?php 
namespace ZendVN\Paginator;

class Paginator{
	public static function createPagination($totalItem,$configPaginator){
		$adapterPaginator = new \Zend\Paginator\Adapter\NullFill($totalItem);
		$paginator        = new \Zend\Paginator\Paginator($adapterPaginator);
		$paginator->setItemCountPerPage($configPaginator['ItemCountPerPage'])
		          ->setCurrentPageNumber($configPaginator['currentPage'])
		          ->setPageRange($configPaginator['PageRange']);
		return $paginator;
	}
}
?>