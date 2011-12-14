<?
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
require_once '../AppCode/MasterPageScript.php';
require_once '../AppCode/SideBarScript.php';
require_once '../AppCode/MemberDBMethods.php';
require_once '../AppCode/HelpingDBMethods.php';
$LiteralMessage = "";
$LiteralContent = "";
$LiteralSideBarContent = '';
$LiteralHeader = MasterPage::GetHeader();
$page = <<<HTML
  <!DOCTYPE HTML> 
  <html lang="en"> 
      <head>
          <meta http-equiv="content-type" content="text/html; charset=utf-8" />
          <title>kahub | Get Started</title>
          <style>
              body { padding: 20px 10px; color:#333; font: normal 12px sans-serif; }
              #devcontainer { margin: 0 auto; width: 940px; }
              </style>
              <!-- jquery -->
              <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>
            </head>
            <body>
              <div id="devcontainer">
              <!-- development area -->
              <script src="droparea.js" type="text/javascript"></script>
              <style>
                  .droparea {
                      position:relative;
                      text-align: center;
					width: 200px;
					height: 200px;
                    }
                    .droparea .instructions {
                      border: 0px dashed #ddd;
                      opacity: .8;
					  width: 200px;
					  height: 200px;
                    }
                    .droparea .instructions.over {
                      border: 2px dashed #000;
                      background: #ffa;
                    }
                    .droparea .progress {
                      position:absolute;
                      bottom: 0;
                      width: 100%;
                      height: 0;
                      color: #fff;
                      background: #6b0;
                    }
                    #areas { width: 480px; }
                    .spot {
                      width: 460px;
                      height: 345px;
                    }
                    .desc {
                      float:right;
                      width: 460px;
                    }
                    .signature a { color:#555; text-decoration:none; }
                    .signature img { margin-right:5px; vertical-align: middle; }
					.droparea {
					    position:relative;
					    text-align: center;
					}

					.droparea .instructions.over {
					    background: #ffa;
					}
					.droparea .progress {
					    position:absolute;
					    bottom: 0;
					    width: 100%;
					    height: 0;
					    color: #fff;
					    background: #6b0;
					}
					#areas { width: 480px; }
					.spot {
					    width: 200px;
					    height: 200px;
					    background-image: url("dragphoto.png");
					}
					.thumb {
					    float: left;
					    margin:20px 20px 0 0;
					    width: 140px;
					    min-height: 105px;
					}
					.desc {
					    float:right;
					    width: 460px;
					}
					.signature a { color:#555; text-decoration:none; }
					.signature img { margin-right:5px; vertical-align: middle; }
					a.promoBtn:hover {
					    cursor: pointer;
					}

					div.droparea.spot div {
					    -webkit-border-radius: 10px;
					    -moz-border-radius: 10px;
					    border-radius: 10px;
					}

					div.droparea.spot img {
					    -webkit-border-radius: 10px;
					    -moz-border-radius: 10px;
					    border-radius: 10px;
					}

					  html {
					    background-color: #F3F3F3;
					}

                  </style>
					<div class="gettingStarted">

                    <div class="droparea spot" data-width="200" data-height="200" data-type="jpg" data-crop="true" data-quality="70"></div>

                  <script>
                  // Calling jQuery "droparea" plugin
                    $('.droparea').droparea({
                      'post' : 'upload.php',
                      'init' : function(r){
                        //console.log('my init',r);
                      },
                      'start' : function(r){
                        //console.log('my start',r);
                      },
                      'error' : function(r){
                          //console.log('my error',r);
                        },
                        'complete' : function(r){
                          //console.log('my complete',r);
                        }
                      });
                  </script>

              <!-- /development area -->
            </div>
          </body>
          </html> 
HTML;

echo $page;
?>
