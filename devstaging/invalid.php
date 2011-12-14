<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
include('../AppCode/image.thumbnail.php');
include_once "../AppCode/FBConnect/fbmain.php";
require_once '../AppCode/HelpingDBMethods.php';

$user = new flexibleAccess();

	require_once '../AppCode/MasterPageScript.php';
	

	$LiteralMessage = "";
	$LiteralContent = "";
       


	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '	<head>';
	echo '		<title>connichiwah | Error</title>';
	echo		MasterPage::GetHeadScript();
	echo '<meta http-equiv="Refresh" content="2; URL=http://www.connichiwah.com/member/settings.php">' ;
	
	echo '		<script type="text/javascript" src="' . $rootURL . 'js/si.files.js"></script>
				<script type="text/javascript">
					$myjquery(document).ready(function(){
						SI.Files.stylizeAll();
					});
				function showreasons(){
					$("#reason").show();
				}
				</script>
				<style type="text/css" title="text/css">
				/* <![CDATA[ */

				.SI-FILES-STYLIZED label.cabinet
				{
					width: 294px;
					height: 180px;
					background: url(../images/website/uploadphot-2.jpg) 0 0 no-repeat;
					display: block;
					overflow: hidden;
					cursor: pointer;
				}

				.SI-FILES-STYLIZED label.cabinet input.file
				{
					position: relative;
					height: 100%;
					width: auto;
					opacity: 0;
					-moz-opacity: 0;
					filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
				}

				/* ]]> */
				</style>';
	echo '<link type="text/css" rel="stylesheet" href="' . $rootURL . 'member/privacycss.css"/> ';
	echo '	</head>';
	echo '	<body>';
	echo '	
						<div class="header">
    						<div class="reg-head">    							
    							<h1><a href="#">Error</a></h1>
								<a href = "' . $rootURL . '"><img alt="" src="../images/website/form-logo.jpg" class="reg-logo"/></a>
				            
								<div class="cl"></div>							
    						</div>
						</div>
	
	
	
				<div class="container">';
	//echo			MasterPage::GetHeader();
	echo '			<div class="mainDiv">';	
	echo '				<!-- Content Page Code Starts -->
						
						
						<div class="main">
							<div class="reg1-main">	';
								//Home Page Content Area Starts
	echo "			
								<div id='pbody'><div class='headpriv'>Invalid key or verification. Process could not be completed.</div><br>";
								//Home Page Content Area Ends	
									    
	echo '						</div>    
							</div>	
							<!-- Content Page Code Ends --> ';
	echo '				<div class="clear" ></div>';
	echo '			</div>';
	echo			MasterPage::GetFooter();
	echo '	    </div>';
	echo '	</body>';
	echo '</html>';


?>