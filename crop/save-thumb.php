<?php
require_once '../AppCode/ApplicationSettings.php';
/*
Author: Uvumi LLC
Website: http://tools.uvumi.com/
License: MIT
Date: 20080910

Notes:  You must have the GD library installed for php.  On many linux systems this is as simple as doing `yum install php-gd` or `apt-get install php-gd`on the command line as root. 
If your site is hosted somewhere else and you don't have root access to the system, then it is very likely that PHP and GD area already available for you.  

If you have any questions about this file or how to do this in another server side scripting language, you are welcome to ask us about it on our forum: http://tools.uvumi.com/forum/

Also, you need to define the folders where your images and thumbnails will be stored, and make sure they are either owned by the web server user, or they are world writeable (chmod 777)
*/

$images_path = "images/";  //replace this with the path where your images are stored, relative to the directory this script will run from
$thumbs_path = $images_path . "thumbs/"; //this is you destination thumbmail folder, you can change it if you want, just be sure the folder actually exists and is writeable by the web server.  In this example, we don't deal with duplicate names, so we just store the cropped verion in a different folder.

$quality = 80;

// first, we retrieve the form's value, presumably sent through the ost method.
$photo = isset($_POST['filename']) ? $_POST['filename'] : false; 
$top = isset($_POST['top']) ? $_POST['top'] : false;
$left = isset($_POST['left']) ? $_POST['left'] : false;
$width = isset($_POST['width']) ? $_POST['width'] : false;
$height = isset($_POST['height']) ? $_POST['height'] : false;
$max_width = isset($_POST['max_width']) ? $_POST['max_width'] : false;
$max_height = isset($_POST['max_height']) ? $_POST['max_height'] : false;
$thumbnail_type = isset($_POST['ThumbnailType']) ? $_POST['ThumbnailType'] : false;
$srcPath = isset($_POST['srcPath']) ? $_POST['srcPath'] : false;
//we set the response header to a JSON string, this is not mandatory, but it's cleaner.
header('Content-type: application/json');

//we make sure all the required parameters are present // My Custom Code : Added Check on Thumbnail Folder Name and Src Path
if(!($photo && $thumbnail_type && $srcPath && is_numeric($top) && is_numeric($left) && is_numeric($width) && is_numeric($height) && is_numeric($max_height) && is_numeric($max_width))){
	die('{"error":"Some of the required parameters are missing."}');
}

//we verify the GD library is running.
if(! extension_loaded('gd')){
	die('{"error":"The GD extension is not installed on the server."}');
}

/*
we are going to suppose that $photo contains the source image file name, which it should if you passed it properly from UvumiCrop in the first place.
*/

//$source_file = str_replace("/images/", "../images/", $srcPath) . "/" . $photo;
//$images_path = str_replace("/images/", "../images/", $srcPath);  // My Custom Code : Set Source Folder Path
$source_file = str_replace(Settings::GetRootURL() . 'images/', "../images/", $srcPath) . "/" . $photo;
$images_path = str_replace(Settings::GetRootURL() . 'images/', "../images/", $srcPath);  // My Custom Code : Set Source Folder Path
$thumbs_path = str_replace("/Original/", "/" . $thumbnail_type . "/", $images_path); // My Custom Code : Set Destination Folder Path with file name

//we make sure the source path exists
if(!is_dir($images_path)) {
	die('{"error":"The source directory could not be found.' . $images_path . '"}');
}
//we make sure the source file exists
if(!file_exists($source_file)) {
	die('{"error":"The source image file could not be found."}');
}

//try create the target folder if it doesn't exist
if(!is_dir(substr($thumbs_path, 0, strlen($thumbs_path)-1))) {
	if(!mkdir(substr($thumbs_path, 0, strlen($thumbs_path)-1),0777)){
		die('{"error":"The destination directory could not be created."}');
	}
}

//Make sure the target folder is writable
if(!is_writable($thumbs_path)){
	die('{"error":"The server does not have permission to write in the destination folder."}');
}

//We get the file extension from the file name. It's needed later
$filename = explode('.', $photo);
$extension = array_pop($filename);

//we create a new filename from the original with the "thumb" suffix.
$thumb = $photo; // My Custom Code File Name Remains Same So NO need To Add Suffix : Original : implode('.',$filename) . "-thumb." . $extension;

//the full target path + file name
$target_file = $thumbs_path . $thumb;
$info = getimagesize($source_file);

if(!$info){
	die('{"error":"The file type is not supported."}');
}

// we use the the GD library to load the image, using the file extension to choose the right function
switch($info[2]) {
	case IMAGETYPE_GIF:
		if(!$source_image = imagecreatefromgif($source_file)){
			die('{"error":"Could not open GIF file."}');
		}
		break;
	case IMAGETYPE_PNG:
		if(!$source_image = imagecreatefrompng($source_file)){
			die('{"error":"Could not open PNG file."}');
		}
		break;
	case IMAGETYPE_JPEG:
		if(!$source_image = imagecreatefromjpeg($source_file)){
			die('{"error":"Could not open JPG file."}');
		}
		break;
	default:
		die('{"error":"The file type is not supported."}');
		break;
}

//Calculate the new size based on the selected area and the minimums
if($width > $height) {
	$dest_width = $max_width;
	$dest_height = round($max_width*$height/$width);
} else {
	$dest_width = round($max_height*$width/$height);
	$dest_height = $max_height;
}

//we generate a new image object of the size calculated above, using PHP's GD functions
if(!$dest_image = imagecreatetruecolor($dest_width, $dest_height)){
	die('{"error":"Could not create new image from source file."}');
}

//hack to keep transparency in gif and png
if($info[2]==IMAGETYPE_GIF||$info[2]==IMAGETYPE_PNG){
	if($info[2]==IMAGETYPE_PNG){
		imageAntiAlias($dest_image,true);
	}
	imagecolortransparent($dest_image, imagecolorallocatealpha($dest_image, 0, 0, 0,127));
	imagealphablending($dest_image, false);
	imagesavealpha($dest_image, true);
}

/*
this is where we crop the image,
-the first parameter is the destinatation image (not a physical file, but a GD image object)
-second is the source image. Again it's not the physical file but a GD object (which was generated from an image file this time)
-third and fourth params are the X and Y coordinates to paste the copied region in the destination image. In this case we want both of them to be 0,
-fifth and sixth are the X and Y coordinates to start cropping in the source image. So they are pretty much the coordinates we got from UvumiCrop.
-seventh and eighth are the width and height of the destination image, the one calculated right above
-ninth and tenth are the width and height of the cropping region, directly from UvumiCrop again

By just setting $max_width and $max_height above, you should not have to worry about this
*/
if(!imagecopyresampled($dest_image, $source_image, 0, 0, $left, $top, $dest_width, $dest_height, max($width, $max_width), max($height, $max_height))){
	die('{"error":"Could not crop the image with the provided coordinates."}');
}

//just as we used $extension to pick the loading function, we'll use it again here to determine which GH function we need for outputting the cropped image
switch($info[2]) {
	case IMAGETYPE_GIF:
		if(!imagegif($dest_image, $target_file)){
			die('{"error":"Could not save GIF file."}');
		}
		break;
	case IMAGETYPE_PNG:
		if(!imagepng($dest_image, $target_file, max(9 - floor($quality/10),0))){
			die('{"error":"Could not save PNG file."}');
		}
		break;
	case IMAGETYPE_JPEG:
		if(!imagejpeg($dest_image, $target_file, $quality)){
			die('{"error":"Could not save JPG file."}');
		}
		break;
}
imagedestroy($dest_image);
imagedestroy($source_image);
//If we made it that far with no error, we can return a success message, with the thumb filename
die('{"success":"'.$thumb.'"}');
?>
 