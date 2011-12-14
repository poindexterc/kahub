<?php
if(isset($_GET['imgurl']) && isset($_GET['x']) && isset($_GET['y']) && isset($_GET['t']))
{
	$src = $_GET['imgurl'];
	$x = $_GET['x'];
	$y = $_GET['y'];
	$t = $_GET['t'];
	echo <<<Content
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
		<head>
			<title>Generate Thumbnail</title>
			<script type="text/javascript" src="js/mootools-for-crop.js"> </script>
			<script type="text/javascript" src="js/UvumiCrop.js"> </script>
			
			<link rel="stylesheet" type="text/css" media="screen" href="css/uvumi-crop.css" />
			<style type="text/css">
				body,html{
					background-color:#F3F3F3;
					margin:0;
					padding:0;
					font-family:Helvetica, Arial, sans-serif;
				}
				
				hr{
					margin:20px 0;
				}
				
				#main{
					margin:5%;
					position:relative;
					overflow:auto;
					color:#333;
					padding:20px;
					background-color:#FFF;
					text-align:center;
				}

				#resize_coords{
					width:300px;
				}
				
				#previewExample3{
					margin:10px;
				}

				.yellowSelection{
					border: 2px dotted #FFB82F;
				}

				.blueMask{
					background-color:#00f;
					cursor:pointer;
				}
			</style>
			<script type="text/javascript">
				exampleCropper1 = new uvumiCropper('example1',{
					coordinates:true,
					preview:true,
					downloadButton:false,
					keepRatio:true,
					ThumbnailType:"{$t}",
					expandtomaxonload:true,
					saveButton:true,
					mini:{
					x:{$x},
					y:{$y}
					}
				});
				function returnStatus()
				{
					//alert("closing");					
				}
			</script>
		</head>
		<body onUnload = "javascript:returnStatus()">
			<div id="main">
				<div>
					<p id = "message-top">
						Create thumbnail.
						Click and Drag: Move thumbnail to Desired Position<br/>
						Double click on Picture: Maximize Selection
					</p>
					<p>
						<img id="example1" src="{$src}" alt="Cropping Subject Image"/>
					</p>
				</div>
			</div>
		</body>
		</html>
Content;
}
else
{
	echo <<<Content
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
		<head>
			<title>Missing Parameters</title>			
			<style type="text/css">
				body,html{
					background-color:#333;
					margin:0;
					padding:0;
					font-family:Helvetica, Arial, sans-serif;
				}
				
				hr{
					margin:20px 0;
				}
				
				#main{
					margin:5%;
					position:relative;
					overflow:auto;
					color:#aaa;
					padding:20px;
					border:1px solid #888;
					background-color:#FFF;
					text-align:center;
				}

				#resize_coords{
					width:300px;
				}
				
				#previewExample3{
					margin:10px;
				}

				.yellowSelection{
					border: 2px dotted #FFB82F;
				}

				.blueMask{
					background-color:#00f;
					cursor:pointer;
				}
			</style>			
			<div id="main">
				<div>					
					<p>
						Missing Parameters
					</p>
				</div>
			</div>
		</body>
		</html>
Content;
}

 

?>
