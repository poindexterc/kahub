<?php
require_once '../AppCode/MemberDBMethods.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
require_once '../AppCode/MasterPageScript.php';
// Where the file is going to be placed 
$target_path = "upload/";

/* Add the original filename to our target path.  
Result is "uploads/filename.extension" */
$target_path = $target_path . basename($_FILES['uploadedfile']['name']);
$origImage = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
// Original image
$filename = $target_path;
class SimpleImage {
 
   var $image;
   var $image_type;
 
   function load($filename) {
 
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
 
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=70, $permissions=null) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
 
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image);
      }
   }
   function getWidth() {
 
      return imagesx($this->image);
   }
   function getHeight() {
 
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
 
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
 
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
 
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
 
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }      
 
}
$image = new SimpleImage();
$image->load($filename);
$image->resizeToWidth(250);
$randName = md5(sha1($filename)+rand(2,720));
$image->save("upload/".$randName.'.jpg');
$imageID = HelpingDBMethods::SaveImageDataInDB('http://www.kahub.com/l/upload/'.$randName.'.jpg' , 0);
echo "A ".$imageID;
echo "U http://www.kahub.com/l/upload/".$randName.".jpg";
$DBConnection = Settings::ConnectDB(); 		
if($DBConnection)
{
	$db_selected = mysql_select_db($GLOBALS['databaseName'], $DBConnection) or die(mysql_error());
	if($db_selected)
	{
        $MemberID = $GLOBALS['user']->userID;
        echo "B ".$MemberID;
        $img = MemberDBMethods::UpdateMemberImage($MemberID, $imageID);
        echo "C ".$img;
    }
}
unlink($filename);
header('Location:http://www.kahub.com/l/getstarted.php');
?>