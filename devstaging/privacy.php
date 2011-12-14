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
	echo '		<title>connichiwah | Your Privacy</title>';
	echo		MasterPage::GetHeadScript();
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
    							<h1><a href="#">Privacy Policy</a></h1>
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
								<div id='pbody'><div class='headpriv'>What information do we collect?</div><br> 

								We collect information from you when you register on our site, place an order, respond to a survey, fill out a form or comment on something.<br><br>  

								When ordering or registering on our site, as appropriate, you may be asked to enter your: name, e-mail address or info@ipsumedia.com. You may, however, visit our site anonymously.<br><br>

								<div class='headpriv'>What do we use your information for?</div><br> 

								Any of the information we collect from you may be used in one of the following ways: <br><br>

								<li>To personalize your experience</li>
								(your information helps us to better respond to your individual needs)<br><br>

								 <li>To improve our website</li>
								(we continually strive to improve our website offerings based on the information and feedback we receive from you)<br><br>

								 <li>To improve customer service</li>
								(your information helps us to more effectively respond to your customer service requests and support needs)<br><br>

								<li>To process transactions</li>
								Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested.<br><br>

								<li>To administer a contest, promotion, survey or other site feature</li><br>


								<li>To send periodic emails</li>
								The email address you provide for order processing, will only be used to send you information and updates pertaining to your order.<br><br>
								Note: If at any time you would like to unsubscribe from receiving future emails, we include detailed unsubscribe instructions at the bottom of each email.<br><br>



								<div class='headpriv'>How do we protect your information?</div><br>

								We implement a variety of security measures to maintain the safety of your personal information when you place an order.<br><br>

								We offer the use of a secure server. All supplied sensitive/credit information is transmitted via Secure Socket Layer (SSL) technology and then encrypted into our Payment gateway providers database only to be accessible by those authorized with special access rights to such systems, and are required to?keep the information confidential.<br><br>

								After a transaction, your private information (credit cards, social security numbers, financials, etc.) will not be kept on file for more than 60 days.<br><br>

								<div class='headpriv'>Do we use cookies?</div><br>

								Yes (Cookies are small files that a site or its service provider transfers to your computers hard drive through your Web browser (if you allow) that enables the sites or service providers systems to recognize your browser and capture and remember certain information.<br><br>

								We use cookies to help us remember and process the items in your shopping cart, understand and save your preferences for future visits, keep track of advertisements and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.<br><br>

								<div class='headpriv'>Do we disclose any information to outside parties?</div><br>

								We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.<br><br>

								<div class='headpriv'>Third party links </div><br>

								Occasionally, at our discretion, we may include or offer third party products or services on our website. These third party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.<br><br>

								<div class='headpriv'>California Online Privacy Protection Act Compliance</div><br>

								Because we value your privacy we have taken the necessary precautions to be in compliance with the California Online Privacy Protection Act. We therefore will not distribute your personal information to outside parties without your consent.<br><br>

								As part of the California Online Privacy Protection Act, all users of our site may make any changes to their information at anytime by logging into their control panel and going to the 'Settings' page.<br><br>

								<div class='headpriv'>Childrens Online Privacy Protection Act Compliance</div><br>

								We are in compliance with the requirements of COPPA (Childrens Online Privacy Protection Act), we do not collect any information from anyone under 13 years of age. Our website, products and services are all directed to people who are at least 13 years old or older.<br><br>

								<div class='headpriv'>Information Gathered by Our Browser Extension</div><br>

								By installing our browser extension, you allow us to collect data about a webpage that you are currently viewing, only if you elect to take action on that page by highlighting text and commenting, liking a comment, or replying to a comment.<br><br>

								<div class='headpriv'>Terms and Conditions</div><br>

								Please also visit our Terms and Conditions section establishing the use, disclaimers, and limitations of liability governing the use of our website at http://www.connichiwah.com/tos<br><br>

								<div class='headpriv'>Your Consent</div><br>

								By using our site, you consent to our websites privacy policy.<br><br>

								<div class='headpriv'>Changes to our Privacy Policy</div><br>

								If we decide to change our privacy policy, we will post those changes on this page, and/or update the Privacy Policy modification date below.<br><br> 

								This policy was last modified on December 19, 2010<br><br>

								<div class='headpriv'>Contacting Us</div><br> 

								If there are any questions regarding this privacy policy you may contact us using the information below. <br><br>

								www.connichiwah.com<br>
								333 E. Lancaster Ave. #313<br>
								Wynnewood, PA 19096<br>
								USA<br>
								info@ipsumedia.com<br>
								6106162911";
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