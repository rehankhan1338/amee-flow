<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( !function_exists('ImageResize')){			
	//function ImageResize($newwidth, $newwidth1, $img_name, $path){	
	function ImageResize($width1, $height1, $width2, $height2, $img_name, $path, $new_file_name, $extension){			
		$maxsize = 400;
		define ("MAX_SIZE",$maxsize);
		$errors=0;
		if(isset($new_file_name) && $_FILES["$img_name"]['tmp_name']!=''){
			//$image =$_FILES["$img_name"]["name"];
			$image = $new_file_name;
			$uploadedfile = $_FILES["$img_name"]['tmp_name'];
						
			/*$filename = stripslashes($_FILES["$img_name"]['name']);
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			$extension = strtolower($extension);*/
			
			if (($extension!="jpg") && ($extension!="JPG") && ($extension!="jpeg") && ($extension!="JPEG") && ($extension!="png") && ($extension!="PNG") && ($extension!="gif")){
				//echo ' Unknown Image extension ';
				$errors=1;
			}else{
				$size=filesize($_FILES["$img_name"]['tmp_name']);
			
				if ($size > MAX_SIZE*1024){
					//echo "You have exceeded the size limit";
					$errors=2;
				}

				if($extension=="jpg" || $extension=="JPG" || $extension=="jpeg" || $extension=="JPEG"){
					$uploadedfile = $_FILES["$img_name"]['tmp_name'];
					$src = imagecreatefromjpeg($uploadedfile);
				}else if($extension=="png" || $extension=="png"){
					$uploadedfile = $_FILES["$img_name"]['tmp_name'];
					$src = imagecreatefrompng($uploadedfile);
				}else{
					$src = imagecreatefromgif($uploadedfile);
				}

				list($width,$height)=getimagesize($uploadedfile);

				/*$newwidth=$newwidth;
				$newheight=($height/$width)*$newwidth;*/
				$tmp=imagecreatetruecolor($width1,$height1);//create the background 130x130
				//$tmp=imagecreatetruecolor($newwidth,$newheight);//create the background 130x130
				$whiteBackground = imagecolorallocate($tmp, 255, 255, 255); 
				imagefill($tmp,0,0,$whiteBackground); // fill the background with white
				imagecopyresampled($tmp,$src,0,0,0,0,$width1,$height1,$width,$height);
				$filename = $path. $new_file_name;				
				
				/*$newwidth1=$newwidth1;
				$newheight1=($height/$width)*$newwidth1;*/
				$tmp1=imagecreatetruecolor($width2,$height2);
				$whiteBackground = imagecolorallocate($tmp1, 255, 255, 255); 
				imagefill($tmp1,0,0,$whiteBackground); // fill the background with white
				imagecopyresampled($tmp1,$src,0,0,0,0,$width2,$height2,$width,$height);			
				$filename1 = $path."small/". $new_file_name;

				imagejpeg($tmp,$filename,100);
				imagejpeg($tmp1,$filename1,100);

				imagedestroy($src);
				imagedestroy($tmp);
				imagedestroy($tmp1);
				$errors=0;
			}		
		}
		
		return $errors;	   
	}
}
	
	
	
//COMMON UPLOAD
if( !function_exists('common_ImageResize')){
	function common_ImageResize($newwidth, $newwidth1, $img_name, $path, $new_file_name, $extension){			
		$maxsize = 400;
		define ("MAX_SIZE",$maxsize);
		$errors=0;
		if(isset($new_file_name) && $_FILES["$img_name"]['tmp_name']!=''){
		
			//$image =$_FILES["$img_name"]["name"];
			$image = $new_file_name;
			$uploadedfile = $_FILES["$img_name"]['tmp_name'];
			 
			/*$filename = stripslashes($_FILES["$img_name"]['name']);
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			$extension = strtolower($extension);*/
			
			if (($extension!="jpg") && ($extension!="JPG") && ($extension!="jpeg") && ($extension!="JPEG") && ($extension!="png") && ($extension!="PNG") && ($extension!="gif")){
				//echo ' Unknown Image extension ';
				$errors=1;
			}else{
				$size=filesize($_FILES["$img_name"]['tmp_name']);
			
				if ($size > MAX_SIZE*1024){
					//echo "You have exceeded the size limit";
					$errors=2;
				}

				if($extension=="jpg" || $extension=="JPG" || $extension=="jpeg" || $extension=="JPEG"){
					$uploadedfile = $_FILES["$img_name"]['tmp_name'];
					$src = imagecreatefromjpeg($uploadedfile);
				}else if($extension=="png" || $extension=="png"){
					$uploadedfile = $_FILES["$img_name"]['tmp_name'];
					$src = imagecreatefrompng($uploadedfile);
				}else{
					$src = imagecreatefromgif($uploadedfile);
				}

				list($width,$height)=getimagesize($uploadedfile);

				$newwidth=$newwidth;
				$newheight=($height/$width)*$newwidth;
				$tmp=imagecreatetruecolor($newwidth,$newheight);//create the background 130x130
				$whiteBackground = imagecolorallocate($tmp, 255, 255, 255); 
				imagefill($tmp,0,0,$whiteBackground); // fill the background with white
				imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
				$filename = $path. $new_file_name;				
				
				$newwidth1=$newwidth1;
				$newheight1=($height/$width)*$newwidth1;
				$tmp1=imagecreatetruecolor($newwidth1,$newheight1);//create the background 130x130
				$whiteBackground = imagecolorallocate($tmp1, 255, 255, 255); 
				imagefill($tmp1,0,0,$whiteBackground); // fill the background with white
				imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);			
				$filename1 = $path."small/". $new_file_name;

				imagejpeg($tmp,$filename,100);
				imagejpeg($tmp1,$filename1,100);

				imagedestroy($src);
				imagedestroy($tmp);
				imagedestroy($tmp1);
				$errors=0;
			}		
		}		
		return $errors;	   
	}
}


//COMMON UPLOAD
if( !function_exists('first_auto_height_common_ImageResize')){
	function first_auto_height_common_ImageResize($newwidth, $width2, $height2, $img_name, $path, $new_file_name, $extension){			
		$maxsize = 400;
		define ("MAX_SIZE",$maxsize);
		$errors=0;
		if(isset($new_file_name) && $_FILES["$img_name"]['tmp_name']!=''){
		
			//$image =$_FILES["$img_name"]["name"];
			$image = $new_file_name;
			$uploadedfile = $_FILES["$img_name"]['tmp_name'];
			 
			/*$filename = stripslashes($_FILES["$img_name"]['name']);
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			$extension = strtolower($extension);*/
			
			if (($extension!="jpg") && ($extension!="JPG") && ($extension!="jpeg") && ($extension!="JPEG") && ($extension!="png") && ($extension!="PNG") && ($extension!="gif")){
				//echo ' Unknown Image extension ';
				$errors=1;
			}else{
				$size=filesize($_FILES["$img_name"]['tmp_name']);
			
				if ($size > MAX_SIZE*1024){
					//echo "You have exceeded the size limit";
					$errors=2;
				}

				if($extension=="jpg" || $extension=="JPG" || $extension=="jpeg" || $extension=="JPEG"){
					$uploadedfile = $_FILES["$img_name"]['tmp_name'];
					$src = imagecreatefromjpeg($uploadedfile);
				}else if($extension=="png" || $extension=="png"){
					$uploadedfile = $_FILES["$img_name"]['tmp_name'];
					$src = imagecreatefrompng($uploadedfile);
				}else{
					$src = imagecreatefromgif($uploadedfile);
				}

				list($width,$height)=getimagesize($uploadedfile);

				$newwidth=$newwidth;
				$newheight=($height/$width)*$newwidth;
				$tmp=imagecreatetruecolor($newwidth,$newheight);//create the background 130x130
				$whiteBackground = imagecolorallocate($tmp, 255, 255, 255); 
				imagefill($tmp,0,0,$whiteBackground); // fill the background with white
				imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
				$filename = $path. $new_file_name;				
				
				$tmp1=imagecreatetruecolor($width2,$height2);
				$whiteBackground = imagecolorallocate($tmp1, 255, 255, 255); 
				imagefill($tmp1,0,0,$whiteBackground); // fill the background with white
				imagecopyresampled($tmp1,$src,0,0,0,0,$width2,$height2,$width,$height);			
				$filename1 = $path."small/". $new_file_name;

				imagejpeg($tmp,$filename,100);
				imagejpeg($tmp1,$filename1,100);

				imagedestroy($src);
				imagedestroy($tmp);
				imagedestroy($tmp1);
				$errors=0;
			}		
		}		
		return $errors;	   
	}
}