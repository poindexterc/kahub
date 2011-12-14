<?php
/*
Author: Uvumi LLC
Website: http://tools.uvumi.com/
License: MIT
Date: 20080910

Notes:  You must have the GD library installed for php.  On many linux systems this is as simple as doing `yum install php-gd` or `apt-get install php-gd`on the command line as root. 
If your site is hosted somewhere else and you don't have root access to the system, then it is very likely that PHP and GD area already available for you.  

If you have any questions about this file or how to do this in another server side scripting language, you are welcome to ask us about it on our forum: http://tools.uvumi.com/forum/

Also, you need to define the folders where your images are stored.
*/

$images_path = "images/";  //replace this with the path where your images are stored, relative to the directory this script will run from
$quality = 100;

// first, we retrieve the form's value, presumably sent through the ost method.
$photo = isset($_GET['filename']) ? $_GET['filename'] : false; 
$top = isset($_GET['top']) ? $_GET['top'] : false;
$left = isset($_GET['left']) ? $_GET['left'] : false;
$width = isset($_GET['width']) ? $_GET['width'] : false;
$height = isset($_GET['height']) ? $_GET['height'] : false;
$max_width = isset($_GET['max_width']) ? $_GET['max_width'] : false;
$max_height = isset($_GET['max_height']) ? $_GET['max_height'] : false;

//we make sure all the required parameters are present
if(!($photo && is_numeric($top) && is_numeric($left) && is_numeric($width) && is_numeric($height) && is_numeric($max_height) && is_numeric($max_width))){
	die('Some of the required parameters are missing.');
}

//we verify the GD library is running.
if(! extension_loaded('gd')){
	die('The GD extension is not installed on the server.');
}

/*
we are going to suppose that $photo contains the source image file name, which it should if you passed it properly from UvumiCrop in the first place.
*/

$source_file = $images_path . $photo;

//we make sure the source path exists
if(!is_dir($images_path)) {
	die('The source directory could not be found.');
}
//we make sure the source file exists
if(!file_exists($source_file)) {
	die('The source image file could not be found.');
}

//We get the file extension from the file name. It's needed later
$filename = explode('.', $photo);
$extension = array_pop($filename);

$info = getimagesize($source_file);

if(!$info){
	die('The file type is not supported.');
}

// we use the the GD library to load the image, using the file extension to choose the right function
switch($info[2]) {
	case IMAGETYPE_GIF:
		if(!$source_image = imagecreatefromgif($source_file)){
			die('Could not open GIF file.');
		}
		break;
	case IMAGETYPE_PNG:
		if(!$source_image = imagecreatefrompng($source_file)){
			die('Could not open PNG file.');
		}
		break;
	case IMAGETYPE_JPEG:
		if(!$source_image = imagecreatefromjpeg($source_file)){
			die('Could not open JPG file.');
		}
		break;
	default:
		die('The file type is not supported.');
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
	die('Could not create new image from source file.');
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
	die('Could not crop the image with the provided coordinates.');
}

//just as we used $extension to pick the loading function, we'll use it again here to determine which GH function we need for outputting the cropped image
switch($info[2]) {
	case IMAGETYPE_GIF:
		header('Content-type: image/gif');
		header('Content-Disposition: attachment; filename="'.$photo.'"');
		imagegif($dest_image);
		break;
	case IMAGETYPE_PNG:
		header('Content-type: image/png');
		header('Content-Disposition: attachment; filename="'.$photo.'"');
		imagepng($dest_image,NULL,max(9 - floor($quality/10),0));
		break;
	case IMAGETYPE_JPEG:
		header('Content-type: image/jpeg');
		header('Content-Disposition: attachment; filename="'.$photo.'"');
		imagejpeg($dest_image,NULL,$quality);
		break;
}
?>
 