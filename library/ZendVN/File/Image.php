<?php 

namespace ZendVN\File;

use PHPImageWorkshop\ImageWorkshop;
use ZendVN\File\Upload;

class Image 
{
	public function upload($fileInput,$prefix = "user_",$options = null){
		$uploadObj = new Upload();
		if($options == null){
			$directory = PATH_FILES."users";
			$fileName  = $uploadObj->UploadFile($fileInput,$directory,array("task"=>"rename"),$prefix);
			//resize
			$path  = PATH_FILES."users/".$fileName;
			$layer = ImageWorkshop::initFromPath($path);
			$layer->cropMaximumInPixel(0, 0, "MM");
			$layer->resizeInPixel(160, 160, true);
			$layer->save( PATH_FILES."users/thumb", $fileName, true);
		}
		
		if($options["task"] == "book"){
			$directory = PATH_FILES."books";
			$fileName  = $uploadObj->UploadFile($fileInput,$directory,array("task"=>"rename"),$prefix);

			//resize
			$path  = PATH_FILES."books/".$fileName;
			$layer = ImageWorkshop::initFromPath($path);

			$layer->resizeInPixel(140, 210, true);
			$layer->save( PATH_FILES."books/thumb/140x210", $fileName, true);

			$layer->resizeInPixel(210, 280, true);
			$layer->save( PATH_FILES."books/thumb/210x280", $fileName, true);

			$layer->resizeInPixel(80, 120, true);
			$layer->save( PATH_FILES."books/thumb/80x120", $fileName, true);
		}

		if($options["task"] == "slider"){
			$directory = PATH_FILES."sliders";
			$fileName  = $uploadObj->UploadFile($fileInput,$directory,array("task"=>"rename"),$prefix);
		}

		return $fileName;
	}

	public function removeAvatar($fileName,$options = null){
		if($options == null){
			$avatarRoot   = PATH_FILES."users/".$fileName;
			$avatarResize = PATH_FILES."users/thumb/".$fileName;
			@unlink($avatarRoot);@unlink($avatarResize);
		}
		if($options['task'] == 'slider'){
			$avatarRoot   = PATH_FILES."sliders/".$fileName;
			@unlink($avatarRoot);
		}
		if($options["task"] == "book"){
			$avatarRoot   = PATH_FILES."books/".$fileName;
			@unlink($avatarRoot);
			$avatarResize = PATH_FILES."books/thumb/140x210/".$fileName;
			@unlink($avatarResize);
			$avatarResize = PATH_FILES."books/thumb/210x280/".$fileName;
			@unlink($avatarResize);
			$avatarResize = PATH_FILES."books/thumb/80x120/".$fileName;
			@unlink($avatarResize);
		}
		
	}
}
?>