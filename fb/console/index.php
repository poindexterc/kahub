<!doctype html>
<html>
  <!--
    Copyright Facebook Inc.

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
  -->
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport"
          content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <meta name="keywords"
          content="javascript, facebook, connect, library, share, publish, stream, api, json, fql">
    <meta name="description"
          content="JavaScript library to use Facebook Connect on your site.">
    <title>Connect JavaScript - Console</title>
    <link type="text/css" rel="stylesheet" href="console.css">
  </head>
  <body>
    <div id="sidebar" style="display: none">
      <ul>
        <li><a href="/">Home</a></li>
        <li>
          JavaScript library to use Facebook Connect on your site.
        </li>
        <li>
          The source code is hosted on
          <a href="http://github.com/facebook/connect-js">GitHub</a>.
        </li>
      </ul>
    </div>


    <div id="controls" style="display: none">
      <div id="connect">
        <h2>Connect</h2>

        <input type="button"
               value="Status"
               onclick="FB.getLoginStatus(null, true)">
        <input type="button"
               value="Login"
               onclick="FB.login()"
               id="bt-login"
               disabled="disabled">
        <input type="button"
               value="Disconnect"
               onclick="FB.api({ method: 'Auth.revokeAuthorization' })"
               id="bt-disconnect"
               disabled="disabled">
        <input type="button"
               value="Logout"
               onclick="FB.logout()"
               id="bt-logout"
               disabled="disabled">
      </div>

      <div id="connected" style="display: none">
        <div id="permissions">
          <h2>Permissions <span class="info" id="perms-info"></span></h2>

        
        </div>

        <div id="integration" style="display: none">
          <h2>Integration <span class="info" id="integration-info"></span></h2>

          <input type="button"
                 disabled="disabled"
                 value="Add Friend"
                 onclick="FB.addFriend('499029861', friendAdded)">
        </div>
      </div>

      <div id="sans-session" style="display: none">
        <h2>Sans Session <span class="info" id="sans-session-info"></span></h2>

        <input type="button" value="Publish" onclick="publishExample()">
        <input type="button" value="Share"   onclick="FB.share()">
      </div>
    </div>

    <div>
      <span id="status" style="display: none"></span>

      <a id="user-info" style="visibility: hidden; display: none;">
        <span id="user-name" style="display: none"></span>
        <img id="user-pic"
             src="http://static.ak.fbcdn.net/pics/t_silhouette.jpg"
             alt="User Picture">
      </a>
    </div>
    <div id="info" style="display: none"></div>


    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script src="console.js"></script>
	<?php
	$msg = $_GET['msg'];
	$url = $_GET['url'];
	echo "
    <div id=\"fb-root\"></div>
    <script>
      // monitor for any change
      FB.Event.subscribe('auth.sessionChange', gotStatus);

      // init
      FB.init({
        apiKey: '212dcc92fc9aba19273b83a3f250157e',
        cookie: true
      });

      // fetch status from facebook
      FB.getLoginStatus();
      onload=function graphStreamPublish()
       {
           var body = '".$msg."';
		   var url = '".$url."';
           FB.api('/me/feed', 'post', { message: body, link: url }, function(response) 
           {
               if (!response || response.error) 
               {
                   alert('Error occured');
               } 
               else 
               {
                   alert('Post ID: ' + response.id);
               }
           });
       }";
	?>
    </script>
  </body>
</html>
