<?php
require_once '../AppCode/MemberDBMethods.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
require_once '../AppCode/MasterPageScript.php';
 //$session id
$path = "upload/";
    if($_FILES['photoimg1']['name']!=""){
        $pnum = 1;
    } else if($_FILES['photoimg2']['name']!=""){
        $pnum = 2;
    } else if ($_FILES['photoimg3']['name']!=""){
        $pnum = 3;
    } else if ($_FILES['photoimg4']['name']!=""){
        $pnum = 4;
    }
	$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg'.$pnum]['name'];
			$size = $_FILES['photoimg'.$pnum]['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(1024*1024))
						{
							$actual_image_name = md5(time()).sha1(substr(str_replace(" ", "_", $txt), 5)).".".$ext;
							$tmp = $_FILES['photoimg'.$pnum]['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
								    echo "<img src='upload/".$actual_image_name."'  class='preview' id='photopreview'>";
									$imageID = HelpingDBMethods::SaveImageDataInDB('http://www.kahub.com/l/upload/'.$actual_image_name , 0);
								}
							else
								echo "failed";
						}
						else
						echo "Image file size max 1 MB";					
						}
						else
						echo "Invalid file format..";	
				}
				
			else
				echo "Please select image..!";
				
			exit;
		}
?>