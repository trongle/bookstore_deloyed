<?php 
namespace ZendVN\File;

class Upload extends \Zend\File\Transfer\Adapter\Http{
	public function UploadFile($inputName,$directory,$options = null,$prefix = "img_"){
		if($options == null){
			$fileName  = $this->getFileName($inputName,false);
			$this->setDestination($directory,$inputName);
			$this->receive($inputName);
		}

		if($options['task'] == "rename"){
			$fileName = $prefix.$this->randomString().".".pathinfo($this->getFileName($inputName),PATHINFO_EXTENSION);
			$this->addFilter("rename",array(
				"target"    => $directory."/".$fileName,
				"overwrite" => true
			),$inputName);
			$this->receive($inputName);
		}
		return $fileName;
	}

	protected function randomString($length = 5){
		$arrChar = array_merge(range("a","z"),range("A","Z"),range(0,9));
		$randomString = shuffle($arrChar);
		$randomString = implode("",$arrChar);
		$randomString = substr($randomString,0,$length);
		return $randomString;
	}
}
?>