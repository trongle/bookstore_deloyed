<?php 

namespace ZendVN\File;

use PHPImageWorkshop\ImageWorkshop;
use ZendVN\File\Upload;

class Image 
{
	public function upload($fileInput,$prefix = "user_"){
		$uploadObj = new Upload();
		$directory = PATH_FILES."users";
		$fileName  = $uploadObj->UploadFile($fileInput,$directory,array("task"=>"rename"),$prefix);
		//resize
		$path  = PATH_FILES."users/".$fileName;
		$layer = ImageWorkshop::initFromPath($path);
		$layer->cropMaximumInPixel(0, 0, "MM");
		$layer->resizeInPixel(160, 160, true);
		$layer->save( PATH_FILES."users/thumb", $fileName, true);

		return $fileName;
	}

	public function removeAvatar($fileName){
		$avatarRoot   = PATH_FILES."users/".$fileName;
		$avatarResize = PATH_FILES."users/thumb/".$fileName;
		@unlink($avatarRoot);@unlink($avatarResize);
	}
}
?>