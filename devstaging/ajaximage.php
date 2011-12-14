<?php
require_once '../AppCode/MemberDBMethods.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
require_once '../AppCode/MasterPageScript.php';
 //$session id
$path = "upload/";

	$valid_formats = array("jpg", "png", "gif", "bmp");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(1024*1024))
						{
							$actual_image_name = md5(time()).sha1(substr(str_replace(" ", "_", $txt), 5)).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
								    echo "<img src='upload/".$actual_image_name."'  class='preview'>";
									$imageID = HelpingDBMethods::SaveImageDataInDB('http://www.kahub.com/l/upload/'.$actual_image_name , 0);
									$MemberID = $GLOBALS['user']->userID;
									$img = MemberDBMethods::UpdateMemberImage($MemberID, $imageID);
									
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