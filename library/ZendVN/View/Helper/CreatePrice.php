<?php 
namespace ZendVN\View\Helper;

use Zend\Json\Json;
use Zend\View\Helper\AbstractHelper;

class CreatePrice extends AbstractHelper
{
	public function __invoke($price,$sale_off,$options = null){
        $xhtmlPrice = $price;
        if(!empty($sale_off)){
            $sale_off      = Json::decode($sale_off);
            if($sale_off->type == "percent"){
              $price_sale_off  =  $price * (100 - $sale_off->value)/100;
            }else{
               $price_sale_off =  $price - $sale_off->value;
            } 
            $xhtmlPrice  = sprintf("<p class='price'>%s</p><small class='badge bg-blue'>%s</small>",
                                  number_format($price,0,",","."),
                                  number_format($price_sale_off,0,",",".")) ;
        }
             
        return  $xhtmlPrice;
    }
}
?>