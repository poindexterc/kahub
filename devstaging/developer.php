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
	echo '		<title>connichiwah | Developer</title>';
	echo		MasterPage::GetHeadScript();
	echo '		<script type="text/javascript" src="' . $rootURL . 'js/si.files.js"></script>
	  <script type="text/javascript"
	   src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>			   
				<script type="text/javascript">
					$myjquery(document).ready(function(){
						SI.Files.stylizeAll();
					
					 			$("label.inlined + .input-text").each(function (type) {
							     	$(this).focus(function () {
							      		$(this).prev("label.inlined").addClass("focus");
							     	});
							     	$(this).keypress(function () {
							      		$(this).prev("label.inlined").addClass("has-text").removeClass("focus");
							     	});
							     	$(this).blur(function () {
							      		if($(this).val() == "") {
							      			$(this).prev("label.inlined").removeClass("has-text").removeClass("focus");
							      		}
							     	});
							    });
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
				label { display: block; font-size: 13px; font-weight: bold; line-height: 18px; cursor: pointer;  z-index: 1; }


		    		input.input-text, input.password, textarea { display: block; margin: 0 0 10px; padding: 3px 4px; border: 1px solid #e4bebd;
		        font-weight: normal; font-style: normal; font-family: "AvenirLTStd55Roman", sans-serif; font-size: 15pt;
		        height: 30px; }

		    		form input.input-text:focus, form textarea:focus { outline: none; border-color: #999; color: #333; padding: 2px 3px; border: 2px solid #C0311A; }

		    		label.inlined { padding: 3px 0 3px 6px; font-weight: normal; font-style: normal; font-size: 14pt; font-family: "AvenirLTStd35Light", sans-serif; color: #aaa; -webkit-transition: color 0.15s linear; background: #fff; width: 300px; -webkit-border-radius: 3px; -moz-border-radius: 3px; z-index: 1; }
		    		label.focus { color: #ccc; }
		    		label.has-text { color: #fff; -webkit-transition-duration: 0s; }
		    		label.inlined + input.input-text { margin-top: -25px; }
		    		label.inlined + textarea.input-text { margin-top: -43px; }

		    		label.inlined.mini { width: 94px; }
		    		label.inlined.small { width: 124px; }
		    		label.inlined.medium { width: 334px; }
		    		label.inlined.large { width: 584px; }
		    		label.inlined.textarea { height: 36px; }
				    input{
				      width: 500px;
				    }
				
				</style>';
	echo '<link type="text/css" rel="stylesheet" href="' . $rootURL . 'member/settingscss.css"/> ';
	echo '<link type="text/css" rel="stylesheet" href="' . $rootURL . 'member/privacycss.css"/> ';
	
	echo '	</head>';
	echo '	<body>';
	echo '	
						<div class="header">
    						<div class="reg-head">    							
    							<h1><a href="#">Developer</a></h1>
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
								<div id='pbody'><div id='devhead'></div><br>
								<div class='accordion'>
								        <div id='step1' class='section'>
								                <h3>
								                        <a href='#step1'>Step 1: Tell us about your site.</a>

								                </h3>

								                <div>
												<form> 
													<label class='inlined' for='siteName' style='padding-top:5px'>Name of your site</label> 
													<input type='text' class='input-text' id='siteName' />
													<label class='inlined' for='url' style='padding-left:100px'>Where is it located?</label> 
													<input type='text' class='input-text' id='url' value ='http://'/>
												</form>
											 </div>
								        </div>
								        <div id='step2' class='section'>
								                <h3>
								                        <a href='#step2'>Step 2: Tell us a little about you!</a>
								                </h3>
								                <div>
												<label class='inlined' for='name' style='padding-top:5px'>What's your name?</label> 
												<input type='text' class='input-text' id='name' />
												<label class='inlined' for='email' style='padding-left:12px'>What's your email?</label> 
												<input type='text' class='input-text' id='email'/>								                </div>
								        </div>
								        <div id='step3' class='section'>
								                <h3>
								                        <a href='#step3'>Step 3. Make your site even more awesome</a>
								                </h3>
								                <div><code>
												<textarea>&lt;link type=&quot;text/css&quot; rel=&quot;stylesheet&quot; href=&quot;http://www.connichiwah.com/extention/mystyles.css&quot; /&gt; &lt;script src =&quot;http://www.connichiwah.com/extention/jquery-latest.min.js&quot; type =&quot;text/javascript&quot; &gt;&lt;/script&gt;&lt;script src =&quot;http://www.connichiwah.com/extention/connichiwah-extention.js&quot; type =&quot;text/javascript&quot; &gt;&lt;/script&gt;
</textarea>
</code>
								                </div>
								        </div>
								</div>
								";
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