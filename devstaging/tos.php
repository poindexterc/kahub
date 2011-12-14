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
	echo '		<title>connichiwah | Terms Of Service</title>';
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
    							<h1><a href="#">Terms of Service</a></h1>
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
								<div id='pbody'><div class='headpriv'>Site Terms and Conditions of Use</div><br>
								<div class='headpriv'>1. User's Acknowledgment and Acceptance of Terms</div><br>
								ipsumedia limited ('Us' or 'We') provides the connichiwah site and  (collectively, the 'site') to you, the user, subject to your compliance with all the terms, conditions, and notices contained or referenced herein (the 'Terms of Use'), as well as any other written agreement between us and you. In addition, when using particular services or materials on this site, users shall be subject to any posted rules applicable to such services or materials that may contain terms and conditions in addition to those in these Terms of Use. All such guidelines or rules are hereby incorporated by reference into these Terms of Use.<br><br>
								BY USING THIS SITE, YOU AGREE TO BE BOUND BY THESE TERMS OF USE. IF YOU DO NOT WISH TO BE BOUND BY THE THESE TERMS OF USE, PLEASE EXIT THE SITE NOW. YOUR REMEDY FOR DISSATISFACTION WITH THIS SITE, OR ANY PRODUCTS, SERVICES, CONTENT, OR OTHER INFORMATION AVAILABLE ON OR THROUGH THIS SITE, IS TO STOP USING THE SITE AND/OR THOSE PARTICULAR PRODUCTS OR SERVICES. YOUR AGREEMENT WITH US REGARDING COMPLIANCE WITH THESE TERMS OF USE BECOMES EFFECTIVE IMMEDIATELY UPON COMMENCEMENT OF YOUR USE OF THIS SITE.<br><br>
								These Terms of Use are effective as of December 29, 2010. We expressly reserve the right to change these Terms of Use from time to time without notice to you. You acknowledge and agree that it is your responsibility to review this site and these Terms of Use from time to time and to familiarize yourself with any modifications. Your continued use of this site after such modifications will constitute acknowledgement of the modified Terms of Use and agreement to abide and be bound by the modified Terms of Use.<br><br>
								As used in these Terms of Use, references to our 'Affiliates' include our owners, subsidiaries, affiliated companies, officers, directors, suppliers, partners, sponsors, and advertisers, and includes (without limitation) all parties involved in creating, producing, and/or delivering this site and/or its contents.<br><br>
								<div class='headpriv'>2. Description of Services</div><br>
								We make various services available on this site including, but not limited to, Social News Service, and other like services. You are responsible for providing, at your own expense, all equipment necessary to use the services, including a computer, modem, and Internet access (including payment of all fees associated with such access).<br><br>
								We reserve the sole right to either modify or discontinue the site, including any of the sites features, at any time with or without notice to you. We will not be liable to you or any third party should we exercise such right. Any new features that augment or enhance the then-current services on this site shall also be subject to these Terms of Use.<br><br>
								<div class='headpriv'>3. Registration Data and Privacy</div><br>
								In order to access some of the services on this site, you will be required to use an account and password that can be obtained by completing our online registration form, which requests certain information and data ('Registration Data'), and maintaining and updating your Registration Data as required. By registering, you agree that all information provided in the Registration Data is true and accurate and that you will maintain and update this information as required in order to keep it current, complete, and accurate.<br><br>
								You also grant us the right to disclose to third parties certain Registration Data about you. The information we obtain through your use of this site, including your Registration Data, is subject to our Privacy Policy, which is specifically incorporated by reference into these Terms of Use.<br><br>
								<div class='headpriv'>4. Conduct on Site</div><br>
								Your use of the site is subject to all applicable laws and regulations, and you are solely responsible for the substance of your communications through the site. By posting information in or otherwise using any communications service, chat room, message board, newsgroup, software library, or other interactive service that may be available to you on or through this site, you agree that you will not upload, share, post, or otherwise distribute or facilitate distribution of any content -- including text, communications, software, images, sounds, data, or other information -- that:<br><br>
								a. to abuse, harass, threaten, impersonate or intimidate other Connichiwah users; <br>
								b. to post or transmit any content that is infringing, libelous, defamatory, obscene, pornographic, abusive, offensive, profane, or otherwise violates any law or right of any third party, or content that contains homophobia, ethnic slurs or religious intolerance;<br>
								c. for any illegal or unauthorized purpose. If you are an international user, you agree to comply with all local laws regarding online conduct and acceptable content; <br>
								d. to post or transmit any communication or solicitation designed or intended to obtain password, account, or private information from any Connichiwah user; <br>
								e. to create or submit unwanted email (“Spam”) to any other Connichiwah users or any URL; <br>
								f. to violate any laws in your jurisdiction (including but not limited to copyright laws); <br>
								g. to submit stories or comments linking to multi-level marketing schemes <br>
								h. with the exception of accessing RSS feeds, you will not use any robot, spider, scraper or other automated means to access the Site for any purpose without our express written permission. Additionally, you agree that you will not: (i) take any action that imposes, or may impose in our sole discretion an unreasonable or disproportionately large load on our infrastructure; (ii) interfere or attempt to interfere with the proper working of the Site or any activities conducted on the Site; or (iii) bypass any measures we may use to prevent or restrict access to the Site; <br>
								i. with the intention of artificially inflating or altering the comments, or any other Connichiwah service, including by way of creating separate user accounts for the purpose of artificially altering Connichiwah’s services; giving or receiving money or other remuneration in exchange for votes; or participating in any other organized effort that in any way artificially alters the results of Connichiwah’s services; <br>
								j. attempt to impersonate another user or person; <br>
								k. sell or otherwise transfer your profile.  In addition, you agree that you will not use the Service (including, without limitation by commenting or marking any content as interesting) on behalf of (or per the request or instruction of) any third party, or pay or otherwise attempt to influence any third to manipulate or otherwise affect the site in any manner (including, without limitation, by paying any other user to comment on any content).
							<br><br>
								We neither endorse nor assume any liability for the contents of any material uploaded or submitted by third party users of the site. We generally do not pre-screen, monitor, or edit the content posted by users of communications services, chat rooms, message boards, newsgroups, software libraries, or other interactive services that may be available on or through this site. However, we and our agents have the right at their sole discretion to remove any content that, in our judgment, does not comply with these Terms of Use and any other rules of user conduct for our site, or is otherwise harmful, objectionable, or inaccurate. We are not responsible for any failure or delay in removing such content. You hereby consent to such removal and waive any claim against us arising out of such removal of content. See 'Use of Your Materials' below for a description of the procedures to be followed in the event that any party believes that content posted on this site infringes on any patent, trademark, trade secret, copyright, right of publicity, or other proprietary right of any party.<br><br>
								In addition, you may not use your account to breach security of another account or attempt to gain unauthorized access to another network or server. Not all areas of the site may be available to you or other authorized users of the site. You shall not interfere with anyone elses use and enjoyment of the site or other similar services. Users who violate systems or network security may incur criminal or civil liability.<br><br>
								You agree that we may at any time, and at our sole discretion, terminate your membership, account, or other affiliation with our site without prior notice to you for violating any of the above provisions. In addition, you acknowledge that we will cooperate fully with investigations of violations of systems or network security at other sites, including cooperating with law enforcement authorities in investigating suspected criminal violations.<br><br>
								<div class='headpriv'>5. Third Party Sites and Information</div><br>
								This site may link you to other sites on the Internet or otherwise include references to information, documents, software, materials and/or services provided by other parties. These sites may contain information or material that some people may find inappropriate or offensive. These other sites and parties are not under our control, and you acknowledge that we are not responsible for the accuracy, copyright compliance, legality, decency, or any other aspect of the content of such sites, nor are we responsible for errors or omissions in any references to other parties or their products and services. The inclusion of such a link or reference is provided merely as a convenience and does not imply endorsement of, or association with, the site or party by us, or any warranty of any kind, either express or implied.<br><br>
								<div class='headpriv'>6. Intellectual Property Information</div><br>
								Copyright (c) December 29, 2010 ipsumedia limited All Rights Reserved.
								For purposes of these Terms of Use, 'content' is defined as any information, data, communications, software, photos, video, graphics, music, sounds, and other material and services that can be viewed by users on our site. This includes message boards, chat, and other original content.<br><br>
								By accepting these Terms of Use, you acknowledge and agree that all content presented to you on this site is protected by copyrights, trademarks, service marks, patents or other proprietary rights and laws, and is the sole property of ipsumedia limited and/or its Affiliates. You are only permitted to use the content as expressly authorized by us or the specific content provider. Except for a single copy made for personal use only, you may not copy, reproduce, modify, republish, upload, post, transmit, or distribute any documents or information from this site in any form or by any means without prior written permission from us or the specific content provider, and you are solely responsible for obtaining permission before reusing any copyrighted material that is available on this site. Any unauthorized use of the materials appearing on this site may violate copyright, trademark and other applicable laws and could result in criminal or civil penalties.<br><br>
								Neither we or our Affiliates warrant or represent that your use of materials displayed on, or obtained through, this site will not infringe the rights of third parties. See 'Users Materials' below for a description of the procedures to be followed in the event that any party believes that content posted on this site infringes on any patent, trademark, trade secret, copyright, right of publicity, or other proprietary right of any party.
								All custom graphics, icons, logos and service names are registered trademarks, trademarks or service marks of ipsumedia limited or its Affiliates. All other trademarks or service marks are property of their respective owners. Nothing in these Terms of Use grants you any right to use any trademark, service mark, logo, and/or the name of ipsumedia limited or its Affiliates.<br><br>
								<div class='headpriv'>7. Unauthorized Use of Materials</div><br>
								Subject to our Privacy Policy, any communication or material that you transmit to this site or to us, whether by electronic mail, post, or other means, for any reason, will be treated as non-confidential and non-proprietary. While you retain all rights in such communications or material, you grant us and our agents and affiliates a non-exclusive, paid-up, perpetual, and worldwide right to copy, distribute, display, perform, publish, translate, adapt, modify, and otherwise use such material for any purpose regardless of the form or medium (now known or not currently known) in which it is used.<br><br>
								Please do not submit confidential or proprietary information to us unless we have mutually agreed in writing otherwise. We are also unable to accept your unsolicited ideas or proposals, so please do not submit them to us in any circumstance.<br><br>
								We respect the intellectual property of others, and we ask you to do the same. If you or any user of this site believes its copyright, trademark or other property rights have been infringed by a posting on this site, you or the user should send notification to our Designated Agent (as identified below) immediately. To be effective, the notification must include:<br><br>
								1. Identify in sufficient detail the copyrighted work that you believe has been infringed upon or other information sufficient to specify the copyrighted work being infringed).<br>
								2. Identify the material that you claim is infringing the copyrighted work listed in item #1 above.<br>
								3. Provide information reasonably sufficient to permit us to contact you (email address is preferred).<br>
								4. Provide information, if possible, sufficient to permit us to notify the owner/administrator of the allegedly infringing webpage or other content (email address is preferred).<br>
								5. Include the following statement: 'I have a good faith belief that use of the copyrighted materials described above as allegedly infringing is not authorized by the copyright owner, its agent, or the law.'<br>
								6. Include the following statement: 'I swear, under penalty of perjury, that the information in the notification is accurate and that I am the copyright owner or am authorized to act on behalf of the owner of an exclusive right that is allegedly infringed.'<br>
								7. Sign the paper.<br>
								8. Send the written communication to the following address:<br>
								Designated Agent for Claimed Infringement:<br>
								Contact: Colin Poindexter<br>
								Address: 333 E. Lancaster Ave. #313, Wynnewood, PA, 19096<br>
								Phone: (610) 616-2911<br><br>
								You acknowledge and agree that upon receipt of a notice of a claim of copyright infringement, we may immediately remove the identified materials from our site without liability to you or any other party and that the claims of the complaining party and the party that originally posted the materials will be referred to the United States Copyright Office for adjudication as provided in the Digital Millennium Copyright Act.
								<div class='headpriv'>8. Disclaimer of Warranties</div><br>
								ALL MATERIALS AND SERVICES ON THIS SITE ARE PROVIDED ON AN 'AS IS' AND 'AS AVAILABLE' BASIS WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE, OR THE WARRANTY OF NON-INFRINGEMENT. WITHOUT LIMITING THE FOREGOING, WE MAKE NO WARRANTY THAT (A) THE SERVICES AND MATERIALS WILL MEET YOUR REQUIREMENTS, (B) THE SERVICES AND MATERIALS WILL BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR-FREE, (C) THE RESULTS THAT MAY BE OBTAINED FROM THE USE OF THE SERVICES OR MATERIALS WILL BE EFFECTIVE, ACCURATE OR RELIABLE, OR (D) THE QUALITY OF ANY PRODUCTS, SERVICES, OR INFORMATION PURCHASED OR OBTAINED BY YOU FROM THE SITE FROM US OR OUR AFFILIATES WILL MEET YOUR EXPECTATIONS OR BE FREE FROM MISTAKES, ERRORS OR DEFECTS.<br><br>
								THIS SITE COULD INCLUDE TECHNICAL OR OTHER MISTAKES, INACCURACIES OR TYPOGRAPHICAL ERRORS. WE MAY MAKE CHANGES TO THE MATERIALS AND SERVICES AT THIS SITE, INCLUDING THE PRICES AND DESCRIPTIONS OF ANY PRODUCTS LISTED HEREIN, AT ANY TIME WITHOUT NOTICE. THE MATERIALS OR SERVICES AT THIS SITE MAY BE OUT OF DATE, AND WE MAKE NO COMMITMENT TO UPDATE SUCH MATERIALS OR SERVICES.<br><br>
								THE USE OF THE SERVICES OR THE DOWNLOADING OR OTHER ACQUISITION OF ANY MATERIALS THROUGH THIS SITE IS DONE AT YOUR OWN DISCRETION AND RISK AND WITH YOUR AGREEMENT THAT YOU WILL BE SOLELY RESPONSIBLE FOR ANY DAMAGE TO YOUR COMPUTER SYSTEM OR LOSS OF DATA THAT RESULTS FROM SUCH ACTIVITIES.<br><br>
								Through your use of the site, you may have the opportunities to engage in commercial transactions with other users and vendors. You acknowledge that all transactions relating to any merchandise or services offered by any party, including, but not limited to the purchase terms, payment terms, warranties, guarantees, maintenance and delivery terms relating to such transactions, are agreed to solely between the seller or purchaser of such merchandize and services and you. WE MAKE NO WARRANTY REGARDING ANY TRANSACTIONS EXECUTED THROUGH, OR IN CONNECTION WITH THIS SITE, AND YOU UNDERSTAND AND AGREE THAT SUCH TRANSACTIONS ARE CONDUCTED ENTIRELY AT YOUR OWN RISK. ANY WARRANTY THAT IS PROVIDED IN CONNECTION WITH ANY PRODUCTS, SERVICES, MATERIALS, OR INFORMATION AVAILABLE ON OR THROUGH THIS SITE FROM A THIRD PARTY IS PROVIDED SOLELY BY SUCH THIRD PARTY, AND NOT BY US OR ANY OTHER OF OUR AFFILIATES.<br><br>
								Content available through this site often represents the opinions and judgments of an information provider, site user, or other person or entity not connected with us. We do not endorse, nor are we responsible for the accuracy or reliability of, any opinion, advice, or statement made by anyone other than an authorized ipsumedia limited spokesperson speaking in his/her official capacity. Please refer to the specific editorial policies posted on various sections of this site for further information, which policies are incorporated by reference into these Terms of Use.<br><br>
								You understand and agree that temporary interruptions of the services available through this site may occur as normal events. You further understand and agree that we have no control over third party networks you may access in the course of the use of this site, and therefore, delays and disruption of other network transmissions are completely beyond our control.<br><br>
								You understand and agree that the services available on this site are provided 'AS IS' and that we assume no responsibility for the timeliness, deletion, mis-delivery or failure to store any user communications or personalization settings.<br><br>
								SOME STATES OR JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF CERTAIN WARRANTIES, SO SOME OF THE ABOVE LIMITATIONS MAY NOT APPLY TO YOU.<br><br>
								<div class='headpriv'>9. Limitation of Liability</div><br>
								IN NO EVENT SHALL WE OR OUR AFFILIATES BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY SPECIAL, PUNITIVE, INCIDENTAL, INDIRECT OR CONSEQUENTIAL DAMAGES OF ANY KIND, OR ANY DAMAGES WHATSOEVER, INCLUDING, WITHOUT LIMITATION, THOSE RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER OR NOT WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES, AND ON ANY THEORY OF LIABILITY, ARISING OUT OF OR IN CONNECTION WITH THE USE OF THIS SITE OR OF ANY WEB SITE REFERENCED OR LINKED TO FROM THIS SITE.<br><br>
								FURTHER, WE SHALL NOT BE LIABLE IN ANY WAY FOR THIRD PARTY GOODS AND SERVICES OFFERED THROUGH THIS SITE OR FOR ASSISTANCE IN CONDUCTING COMMERCIAL TRANSACTIONS THROUGH THIS SITE, INCLUDING WITHOUT LIMITATION THE PROCESSING OF ORDERS.<br><br>
								SOME JURISDICTIONS PROHIBIT THE EXCLUSION OR LIMITATION OF LIABILITY FOR CONSEQUENTIAL OR INCIDENTAL DAMAGES, SO THE ABOVE LIMITATIONS MAY NOT APPLY TO YOU.<br><br>
								<div class='headpriv'>10. Indemnification</div><br>
								Upon a request by us, you agree to defend, indemnify, and hold us and our Affiliates harmless from all liabilities, claims, and expenses, including attorneys fees, that arise from your use or misuse of this site. We reserve the right, at our own expense, to assume the exclusive defense and control of any matter otherwise subject to indemnification by you, in which event you will cooperate with us in asserting any available defenses.<br><br>
								<div class='headpriv'>11. Security and Password</div><br>
								You are solely responsible for maintaining the confidentiality of your password and account and for any and all statements made and acts or omissions that occur through the use of your password and account. Therefore, you must take steps to ensure that others do not gain access to your password and account. Our personnel will never ask you for your password. You may not transfer or share your account with anyone, and we reserve the right to immediately terminate your account if you do transfer or share your account.<br><br>
								<div class='headpriv'>12. Participation in Promotions</div><br>
								From time to time, this site may include advertisements offered by third parties. You may enter into correspondence with or participate in promotions of the advertisers showing their products on this site. Any such correspondence or promotions, including the delivery of and the payment for goods and services, and any other terms, conditions, warranties or representations associated with such correspondence or promotions, are solely between you and the advertiser. We assume no liability, obligation or responsibility for any part of any such correspondence or promotion.<br><br>
								<div class='headpriv'>13. E-mail, Messaging, Blogging, and Chat Services</div><br>
								We may make email, messaging, blogging, or chat services (collectively, 'Communications') available to users of our site, either directly or through a third-party provider. We make available separate supplemental agreements characterizing the relationship between you and us that, except where expressly noted or contradictory, includes these Terms.<br><br>
								We will not inspect or disclose the contents of private Communications except with the consent of the sender or the recipient, or in the narrowly-defined situations provided under the Electronic Communications Privacy Act, or as other required by law or by court or governmental order. Further information is available in our Privacy Policy.<br><br>
								We may employ automated monitoring devices or techniques to protect our users from mass unsolicited communications (also known as 'spam') and/or other types of electronic communications that we deem inconsistent with our business purposes. However, such devices or techniques are not perfect, and we will not be responsible for any legitimate communication that is blocked, or for any unsolicited communication that is not blocked.<br><br>
								Mailboxes may have a limited storage capacity. If you exceed the maximum permitted storage space, we may employ automated devices that delete or block email messages that exceed the limit. We will not be responsible for such deleted or blocked messages.<br><br>
								<div class='headpriv'>14. International Use</div><br>
								Although this site may be accessible worldwide, we make no representation that materials on this site are appropriate or available for use in locations outside the United States, and accessing them from territories where their contents are illegal is prohibited. Those who choose to access this site from other locations do so on their own initiative and are responsible for compliance with local laws. Any offer for any product, service, and/or information made in connection with this site is void where prohibited.<br><br>
								<div class='headpriv'>15. Termination of Use</div><br>
								You agree that we may, in our sole discretion, terminate or suspend your access to all or part of the site with or without notice and for any reason, including, without limitation, breach of these Terms of Use. Any suspected fraudulent, abusive or illegal activity may be grounds for terminating your relationship and may be referred to appropriate law enforcement authorities.<br><br>
								Upon termination or suspension, regardless of the reasons therefore, your right to use the services available on this site immediately ceases, and you acknowledge and agree that we may immediately deactivate or delete your account and all related information and files in your account and/or bar any further access to such files or this site. We shall not be liable to you or any third party for any claims or damages arising out of any termination or suspension or any other actions taken by us in connection with such termination or suspension.<br><br>
								<div class='headpriv'>16. Governing Law</div><br>
								This site (excluding any linked sites) is controlled by us from our offices within the Pennsylvania, United States of America. It can be accessed from all 50 states, as well as from other countries around the world. As each of these places has laws that may differ from those of Pennsylvania, by accessing this site both of us agree that the statutes and laws of the State of Pennsylvania, without regard to the conflicts of laws principles thereof and the United Nations Convention on the International Sales of Goods, will apply to all matters relating to the use of this site and the purchase of products and services available through this site. Each of us agrees and hereby submits to the exclusive personal jurisdiction and venue any court of competent jurisdiction within the State of Pennsylvania with respect to such matters.<br><br>
								<div class='headpriv'>17. Notices</div><br>
								All notices to a party shall be in writing and shall be made either via email or conventional mail. Notices to us must be sent to the attention of Customer Service at help@ipsumedia.com, if by email, or at ipsumedia limited 333 E. Lancaster Ave. #313, Wynnewood, PA 19096 if by conventional mail. Notices to you may be sent to the address supplied by you as part of your Registration Data. In addition, we may broadcast notices or messages through the site to inform you of changes to the site or other matters of importance, and such broadcasts shall constitute notice to you at the time of sending.<br><br>
								<div class='headpriv'>18. Entire Agreement</div><br>
								These terms and conditions constitute the entire agreement and understanding between us concerning the subject matter of this agreement and supersedes all prior agreements and understandings of the parties with respect to that subject matter. These Terms of Use may not be altered, supplemented, or amended by the use of any other document(s). Any attempt to alter, supplement or amend this document or to enter an order for products or services which are subject to additional or altered terms and conditions shall be null and void, unless otherwise agreed to in a written agreement signed by you and us. To the extent that anything in or associated with this site is in conflict or inconsistent with these Terms of Use, these Terms of Use shall take precedence.<br><br>
								<div class='headpriv'>19. Miscellaneous</div><br>
								In any action to enforce these Terms of Use, the prevailing party will be entitled to costs and attorneys fees. Any cause of action brought by you against us or our Affiliates must be instituted with one year after the cause of action arises or be deemed forever waived and barred.<br><br>
								You may not assign your rights and obligations under these Terms of Use to any party, and any purported attempt to do so will be null and void. We may free assign our rights and obligations under these Terms of Use.<br><br>
								You agree not to sell, resell, reproduce, duplicate, copy or use for any commercial purposes any portion of this site, or use of or access to this site.<br><br>
								In addition to any excuse provided by applicable law, we shall be excused from liability for non-delivery or delay in delivery of products and services available through our site arising from any event beyond our reasonable control, whether or not foreseeable by either party, including but not limited to, labor disturbance, war, fire, accident, adverse weather, inability to secure transportation, governmental act or regulation, and other causes or events beyond our reasonable control, whether or not similar to those which are enumerated above.<br><br>
								If any part of these Terms of Use is held invalid or unenforceable, that portion shall be construed in a manner consistent with applicable law to reflect, as nearly as possible, the original intentions of the parties, and the remaining portions shall remain in full force and effect.<br><br>
								Any failure by us to enforce or exercise any provision of these Terms of Use or related rights shall not constitute a waiver of that right or provision.<br><br>
								<div class='headpriv'>20. Contact Information</div><br>
								Except as explicitly noted on this site, the services available through this site are offered by ipsumedia limited, an Limited Liability Company, located at 333 E. Lancaster Ave. #313, Wynnewood, PA 19096. Our telephone number is (610) 616-2911. If you notice that any user is violating these Terms of Use, please contact us at help@ipsumedia.com.<br><br>
								<div class='headpriv'>Comments Terms of Use</div><br>
								ipsumedia limited ('We' or 'Us' or 'Our') offers the use of its commenting services (along with the content posted thereon, the 'Services') subject to the terms and conditions of use (the 'Terms') contained herein. All references herein to 'We', 'Us', or 'Our' are intended to include ipsumedia limited and any other affiliated companies. By accessing, creating or contributing to any list of comments ('comment threads') by us (the 'comments'), and in consideration for the Services we provide to you, you agree to abide by these Terms. Please read them carefully before posting to, replying to, or creating any comment. We reserve the right to change, at any time, at our sole discretion, the Terms under which these Services are offered. You are responsible for regularly reviewing these Terms for changes. Your continued use of the Services constitutes your acceptance of all such Terms. If you do not agree with these Terms, please do not use the Services.<br><br>
								<div class='headpriv'>1. Disclaimer of Company Responsibility for Comment Content</div><br>
								You understand that all content posted to the comment (the 'Content') is the sole responsibility of the individual who originally posted the content. You understand, also, that all opinions expressed by users of this site are expressed strictly in their individual capacities, and not as Our representatives or any of Our sponsors or partners. The opinions that you or others post in the Blog do not necessarily reflect Our opinions.<br><br>
								<div class='headpriv'>2. Posting</div><br>
								(a) By posting your Content using the Services, you are granting an unrestricted, irrevocable, non-exclusive, royalty-free, perpetual, worldwide, and fully transferable, assignable, and sublicensable right and license to use, copy, reproduce, modify, adapt, publish, translate, create collective or derivative works from, distribute, perform and display your Content in whole or in part and to incorporate it in other works in any form, media, or technology now known or later developed. You further warrant that all so-called moral rights in the content have been waived.<br>
								(b) By posting content to comments, you warrant and represent that you either own or otherwise control all of the rights to that content, including, without limitation, all the rights necessary for you to provide, post, upload, input or submit the content, or that your use of the content is a protected fair use. You agree that you will not knowingly provide material and misleading false information. You represent and warrant also that the content you supply does not violate these Terms. It is your sole responsibility to ensure that your postings do not disclose confidential and/or proprietary information, including personal financial information, information covered by a nondisclosure agreement, and information that you are not authorized to disclose. We caution you not to disclose personal information about yourself or your children, such as social security numbers, credit card numbers, etc.<br>
								(c) You agree to indemnify and hold Us and Our affiliated companies, and their directors, officers and employees, harmless for any and all claims or demands, including reasonable attorney fees, that arise from or otherwise relate to your use of the comments, any content you supply to the comments, or your violation of these Terms or the rights of another.<br><br>
								<div class='headpriv'>3. Accessing</div><br>
								(a) You agree that We will not be liable, under any circumstances and in any way, for any errors or omissions, loss or damage of any kind incurred as a result of use of any content posted on this site. You agree that you must evaluate and bear all risks associated with the use of any content, including any reliance on the accuracy, completeness, or usefulness of such content. You agree not to collect information about others, including e-mail addresses, or to use information obtained from the Services to send other users unsolicited e-mail of any kind.<br>
								(b) The comments are provided for informational purposes only; we shall not be responsible or liable for the accuracy or availability of any information appearing or available on the comments.<br>
								(c) Comment postings may provide links to other websites on the Internet. We are not responsible or liable for such content and we make no express or implied warranty about the accuracy, copyright compliance, legality, merchantability, or any other aspect of the content of such postings. We are not responsible or liable for any advertising, products, or other materials on or available from such websites or resources. The inclusion of links does not imply endorsement of the Websites by Us or any association with their operators.<br>
								(d) We may enable you to establish an account with a username and password to access and use the Services. If so, you are responsible for maintaining the strict confidentiality of your password, and you are responsible for any activity occurring through use of your account and password. You agree to immediately notify us of any unauthorized use of your password or account or any other breach of security and ensure that you exit from your account at the end of each session. We are not responsible or liable for any loss or damage arising from your failure to comply with this provision.<br><br>
								<div class='headpriv'>4. Children</div><br>
								Collecting personal information from children under the age of 13 ('minor children') through the Services or the comment is prohibited. No Content should be directed toward minor children. Minor children are not eligible to use the site, and we ask that they do not submit any personal information to us.<br><br>
								<div class='headpriv'>5. Privacy Policy</div><br>
								Please be sure to read our Privacy Policy at www.connichiwah.com/privacy<br><br>
								<div class='headpriv'>6. Unauthorized Use of Materials</div><br>
								See Website Privacy Policy at www.connichiwah.com/privacy<br><br>
								<div class='headpriv'>7. Termination of Access/Removal of Content</div><br>
								We shall have the right in Our sole discretion to terminate your access to and use of the Services and/or remove any of your Content should We consider your statements or conduct to be inaccurate, illegal, obscene, defamatory, threatening, infringing of intellectual property rights, invasive of privacy, injurious, objectionable, or otherwise in violation of these Terms or applicable law.<br><br>
								<div class='headpriv'>8. Disclaimer of Warranties</div><br>
								See Website Privacy Policy at www.connichiwah.com/privacy<br><br>
								<div class='headpriv'>9. Limitation of Liability</div><br>
								See Website Privacy Policy at www.connichiwah.com/privacy<br><br>
								<div class='headpriv'>10. Acceptance and Acknowledgement of Terms</div><br>
								Use of this website constitutes acceptance of these Terms. You acknowledge that you have read and are bound by the Terms, as well as any other usage agreements of Ours, including the Website Terms of Use that may govern your conduct. Please do not hesitate to contact us at help@ipsumedia.com if you have questions.";
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