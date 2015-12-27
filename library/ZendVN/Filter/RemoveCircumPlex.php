<?php

namespace ZendVN\Filter;

use Zend\Filter\FilterInterface;

class RemoveCircumPlex implements FilterInterface
{
	
	public function filter($value){
		/*a à ả ã á ạ ă ằ ẳ ẵ ắ ặ â ầ ẩ ẫ ấ ậ b c d đ e è ẻ ẽ é ẹ ê ề ể ễ ế ệ
		 f g h i ì ỉ ĩ í ị j k l m n o ò ỏ õ ó ọ ô ồ ổ ỗ ố ộ ơ ờ ở ỡ ớ ợ
		p q r s t u ù ủ ũ ú ụ ư ừ ử ữ ứ ự v w x y ỳ ỷ ỹ ý ỵ z*/

		$characterA = "#(à|ả|ã|á|ạ|ă|ằ|ẳ|ẵ|ắ|ặ|â|ầ|ẩ|ẫ|ấ|ậ)#imsU";
		$value      = preg_replace($characterA,"a",$value);

		$characterD = "#(đ|Đ)#imsU";
		$value      = preg_replace($characterD,"d",$value);

		$characterE = "#(è|ẻ|ẽ|é|ẹ|ê|ề|ể|ễ|ế|ệ)#imsU";
		$value      = preg_replace($characterE,"e",$value);

		$characterI = "#(ì|ỉ|ĩ|í|ị)#imsU";
		$value      = preg_replace($characterI,"i",$value);

		$characterO = "#(ò|ỏ|õ|ó|ọ|ô|ồ|ổ|ỗ|ố|ộ|ơ|ờ|ở|ỡ|ớ|ợ)#imsU";
		$value      = preg_replace($characterO,"o",$value);

		$characterU = "#(ù|ủ|ũ|ú|ụ|ư|ừ|ử|ữ|ứ|ự)#imsU";
		$value      = preg_replace($characterU,"u",$value);

		$characterY = "#(ỳ|ỷ|ỹ|ý|ỵ)#imsU";
		$value      = preg_replace($characterY,"y",$value);

		return $value;
	}
}
?>