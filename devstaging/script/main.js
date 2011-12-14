var rootURL = "/connichiwah/";
var $j = jQuery.noConflict();
$j(document).ready(function(){
	//$j(".login").colorbox();
	$j(".login").colorbox({inline:true, href:"#Login_SignUp_Box", onClosed:function(){ clearLoginRegisterControls();}});
	$j(".report-link").colorbox({inline:true, href:"#Report_Link_Box", onComplete:function(){
	    var sid = parseInt(this.id.replace("reportLink", ''));
	    $j("#reportStoryID").val(sid); 
	    }});
	$j(".forgot_password").colorbox({inline:true, href:"#Forgot_Change_Password_Box"});
	$j('textarea.elastic').elastic();
		
    $j("#Change_Name").colorbox({inline:true, href:"#Change_Name_Box"});
    $j("#Change_Email").colorbox({inline:true, href:"#Change_Email_Box"});
    $j("#Change_DOB").colorbox({inline:true, href:"#Change_DOB_Box"});
    $j("#Change_Password").colorbox({inline:true, href:"#Change_Password_Box"});
    $j("#Change_About_Me").colorbox({inline:true, href:"#Change_About_Me_Box"});
	$j("#Change_Picture").colorbox({iframe:true, innerWidth:700, innerHeight:500});					
});

function clearLoginRegisterControls()
{
    $j("#R_UN").val('');
    $j("#R_Email").val('');
    $j("#R_Password").val('');
    $j("#R_ConfirnmPassword").val('');
    $j("#L_UN").val('');
    $j("#L_Password").val('');
    $j("#status-message").html('');
    $j("#status-message").removeClass("messagefail-compact");
}
function wizard()
{    
    //$(document.body).css( "background", "black" );
    getFBCount();
    getTwitterCount();
    getDeliciousCount()
}

function getFBCount()
{
    var FBCount = $("span.fb_share_count_inner"); // its collection of elements
    $("span#result").html("Face Book Count : " + FBCount.attr("innerHTML"));
}

function getTwitterCount()
{    
    $.getJSON("http://api.tweetmeme.com/url_info.jsonc?url=http://www.elistmania.com/juice/10_bizarre_beauty_treatments/&callback=?",
	    function(data)
	    {
	        var TwitterCount = data.story.url_count;
	        $("span#result").html($("span#result").html() + "<br/>" + "Twitter Count : " + TwitterCount);
		}
    );
}
function getDeliciousCount(StoryID, sourceURL)
{
//http://feeds.delicious.com/v2/json/urlinfo/data?url=http://resources.savedelete.com/top-10-wordpress-themes-of-june-2010-for-free-download.html&callback=?
    $.getJSON("http://feeds.delicious.com/v2/json/urlinfo/data?url=" + sourceURL + "&callback=?",
	    function(data)
	    {
	        var DeliciousCount = data[0].total_posts;	        
	        $("a#delicious_count_" + StoryID).html("Dels : " + DeliciousCount);
		}
    );
}

function morestories(channel, region, category, timespan, offset, total, smt, type)
{
    var method = 'getmorestories';
    data = "channel="+channel+"&region="+region+"&category="+category+"&timespan=" + timespan+"&offset=" + offset + "&total=" + total + "&smt=" + smt + "&type=" + type;  
    document.getElementById("more-content").innerHTML = "<p class='sprites blue-box' id = 'more-content'><span class='more-loading'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></p>";
    http_request = CreateXMLHttpRequest();          
    url = rootURL + servicepath + "?method=" + method;

    http_request.onreadystatechange = function()
    {     
        if (http_request.readyState == 4) 
        {
            if (http_request.status == 200) 
            {            
                var result = http_request.responseText;
                //alert(result);
                $j("#more-content").remove();
                $j("#recent-posts").append(result);
                $j(".recent-posts li:hidden").css("height", "100px");
                $j(".recent-posts li:hidden").slideDown(1000, function(){
                    $j(".recent-posts li").css("height", "");
                });
                //document.getElementById("more-content").outerHTML = result;
                //$j.each($j(".recent-posts li"), function() {
                  //alert(i);
                  //$(this).css("height", "100px");
                  //$j(this).slideDown(5000, function(){
                    //$(this).css("height", "auto");
               //   });
                  //
               // });
            } 
            else 
            {
                alert('There was a problem with the request.');
            }
        }
    };
    http_request.open('POST', url, true);
    http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http_request.setRequestHeader("Content-length", data.length);
    http_request.setRequestHeader("Connection", "close");
    http_request.send(data);
}

function morestoriessearch(query, type, offset, total)
{
    var method = 'getmorestoriessearch';
    data = "query="+query+"&type="+type+"&offset=" + offset + "&total=" + total;
    //alert("query="+query+"&type="+type+"&offset=" + offset + "&total=" + total); 
    document.getElementById("more-content").innerHTML = "<p class='sprites blue-box' id = 'more-content'><span class='more-loading'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></p>";
    http_request = CreateXMLHttpRequest();          
    url = rootURL + servicepath + "?method=" + method;

    http_request.onreadystatechange = function()
    {     
        if (http_request.readyState == 4) 
        {
            if (http_request.status == 200) 
            {            
                var result = http_request.responseText;
                $j("#more-content").remove();
                $j("#recent-posts").append(result);
                $j(".recent-posts li:hidden").css("height", "100px");
                $j(".recent-posts li:hidden").slideDown(1000, function(){
                    $j(".recent-posts li").css("height", "");
                });
            } 
            else 
            {
                alert('There was a problem with the request.');
            }
        }
    };
    http_request.open('POST', url, true);
    http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http_request.setRequestHeader("Content-length", data.length);
    http_request.setRequestHeader("Connection", "close");
    http_request.send(data);
}

function getComments(storyid, offset, limit, total)
{
    if($j("#comments" + storyid).css('display') == 'none')
    {        
        if(offset >= 7)
        {
            var storyurl = $j("#story-" + storyid + "-url").attr("href");
            location.href = storyurl;
        }
        else
        {
            var method = 'getComments';    
            data = "storyid="+storyid+"&offset="+offset+"&limit=" + limit + "&total=" + total;      
            $j("#comments" + storyid).html("<div id = 'loading-timer" + storyid + "' style = 'text-align:center; width:100%;'><img src = '" + rootURL + loadingimg + "'/></div>");
            $j("#comments" + storyid).slideDown("slow");
            http_request = CreateXMLHttpRequest();          
            url = rootURL + servicepath + "?method=" + method;

            http_request.onreadystatechange = function()
            {     
                if (http_request.readyState == 4) 
                {
                    if (http_request.status == 200) 
                    {            
                        var result = http_request.responseText;
                        //alert(result);
                        //if(total > 7)
                        //{
                        //    $j("#comment-link-" + storyid).attr("href", rootURL + "pages/story.php?storyid=" + storyid);
                        //    $j("#comment-link-" + storyid).html("View All " + total + " Comments");
                        //}
                        
                        $j("#comments" + storyid).append(result);
                        $j("#comments" + storyid).slideDown("slow");
                        $j("#loading-timer" + storyid).slideUp("slow");
                        $j(".login").colorbox({inline:true, href:"#Login_SignUp_Box"}); // Bind new html to login control box
                        //jQuery("textarea[class*=expand]").TextAreaExpander(); // bind new new text area to text area resizer
                        $j('textarea.elastic').elastic();
                    } 
                    else 
                    {
                        alert('There was a problem with the request.');
                    }
                }
            };
            http_request.open('POST', url, true);
            http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http_request.setRequestHeader("Content-length", data.length);
            http_request.setRequestHeader("Connection", "close");
            http_request.send(data);
        }
    }
    else
    {
        $j("#comments" + storyid).slideUp("slow");
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function postComment(storyid, replyto, level)
{  
    try
    {
        var name = "";//document.getElementById('inputName').value;        
        //name = escape(name);        
        var email = "";//document.getElementById("inputEmail").value;        
        //var website = document.getElementById("inputWebsite").value;
        var text = document.getElementById("inputText-" + storyid).value;  
              
        //var oEditor = CKEDITOR.instances.inputText;
        //var text = oEditor.getData();
        //text = escape(text); 
        
        var response = dataIsValid(text);
        
        if(response == true)
        {            
            //var responseContainer = 'divcomment' + commentID;
            //response = postCommentInitialize(articleID, name, email, website, text, memberID, replyto, level, 'divcomment'+commentID, commentID, ipaddress);                           
            var method = 'PostComment';    
            data = "storyid="+storyid+"&replyto="+replyto+"&level=" + level + "&name=" + name+"&email=" + email + "&text=" + text;      
            $j("#loading-timer").html("<img src = '" + rootURL + loadingimg + "'/>");
            $j("#loading-timer").removeClass('errorBox');
            $j("#loading-timer").slideDown("slow");
            http_request = CreateXMLHttpRequest();          
            url = rootURL + servicepath + "?method=" + method;

            http_request.onreadystatechange = function()
            {     
                if (http_request.readyState == 4) 
                {
                    if (http_request.status == 200) 
                    {            
                        var result = http_request.responseText;
                        var postcommentsection = $j("#post-comment-li-" + storyid).html();
                        $j("#post-comment-li-" + storyid).remove(); 
                        $j("#ul-comments" + storyid).append(result); 
                        $j("#ul-comments" + storyid).append('<li class="bg-white" id = "post-comment-li-' + storyid + '">' + postcommentsection + '</li>');                      
                        //$j("#comments" + storyid).append(result); // for index page
                        //$j("#comments" + storyid).slideDown("slow"); // for index page
                        
                        //$j(".comments-list").append(result); // for story page
                        //$j(".comments-list").slideDown("slow"); // for story page
                        $j("#loading-timer").slideUp("slow");
                        var lastCount = parseInt($j("#comment-link-count-" + storyid).html());
                        $j("#comment-link-count-" + storyid).html(lastCount + 1);
                        
                    } 
                    else 
                    {
                        alert('There was a problem with the request.');
                    }
                }
            };
            http_request.open('POST', url, true);
            http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http_request.setRequestHeader("Content-length", data.length);
            http_request.setRequestHeader("Connection", "close");
            http_request.send(data);
        }
        else
        { 
            $j("#loading-timer").html(response);
            $j("#loading-timer").addClass('errorBox');
            $j("#loading-timer").slideDown("slow");
        }        
    }
    catch(err)
    {
        alert(err);
    }
}



function dataIsValid(commentsText)
{
    var isValid = true;
    var msg = "";
           
    if(commentsText == "Comments" || commentsText == "")
    {
        msg = "Comments are Required";
         isValid = false;
    }  
    
    if(isValid)
    {
        return true;
    }   
    else
    {
        return msg;
    } 
}


function postCommentInitialize(articleID, name, email, website, text, memberID, replyto, level, responseContainer, commentID, ipaddress)
{  
    var returnmsg = ""; 
    var method = 'RepliedToComment';
    if(level == 1)
    {
        method = 'RepliedToArticle';
    }    
    //text = text.replace(/&/g, ' and ');
    //text = text.replace(/'/g, '`');
    data = "articleID="+articleID+"&replyTo=" + replyto + "&name="+name+"&website="+website+"&email="+email+"&message="+text+"&level="+level+"&commentID=" + commentID + "&IPAddress=" + ipaddress + "&memberID=" + memberID;
            
     http_request = CreateXMLHttpRequest();          
     url = "/webservice/elistmania.php?method=" + method;
     http_request.onreadystatechange = function()
     {
        if (http_request.readyState == 4) 
        {            
            if (http_request.status == 200) 
            {
                var result = http_request.responseText;
                if(result != "failed:Admin Approval")
                {
                    result = result.replace(/\.\.\//g, "../../");
                    if(replyto == "0")
                    {
                        var commentsData = document.getElementById('commentsList').innerHTML;
                        document.getElementById('commentsList').innerHTML = commentsData + result;
                        SetCommentsCountBox(articleID);
                        document.getElementById('commenterror').innerHTML = "<div class='loading-image'>Comments Posted</div>";
                        document.getElementById('commenterror').style.display =  'block'; 
                        document.getElementById('loaderimage').style.display =  'none';
                    }
                    else
                    {
    //                    var pre = "<div class='replynreplyto'><a href='javascript:hidereply(\"" + commentID + "\");'>Hide</a></div>";
    //                    var po = "<div class = 'clear'></div><div class = 'errorBox'>Comments Posted</div><div class = 'clear'></div>";
    //                    document.getElementById("divreply" + commentID).innerHTML = pre + result + po; 
    //                    document.getElementById('divcomment' + commentID).style.display =  'none';
    //                    SetCommentsCountBox(articleID);

                          var commentsData = document.getElementById('commentsList').innerHTML;
                          document.getElementById('commentsList').innerHTML = commentsData + result;
                          SetCommentsCountBox(articleID);
                          document.getElementById('commenterror').innerHTML = "<div class='loading-image'>Comments Posted</div>";
                          document.getElementById('commenterror').style.display =  'block'; 
                          document.getElementById('loaderimage').style.display =  'none';
                    }
                }
                else
                {
                    document.getElementById('commenterror').innerHTML = "<div class='loading-image'>Your Comment is waiting for Administrator Approval</div>";
                    document.getElementById('commenterror').style.display =  'block'; 
                    document.getElementById('loaderimage').style.display =  'none';
                }
                
            } 
            else 
            {
                alert('There was a problem with the request.');
            }
        }
     };
     http_request.open('POST', url, true);
     http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 http_request.setRequestHeader("Content-length", data.length);
	 http_request.setRequestHeader("Connection", "close");
	 http_request.send(data);     
}

function login()
{
    var username = $j('#L_UN').val();
    var password = $j('#L_Password').val();
    if(username == "" || password == "")
    {
        $j("#status-message").addClass("messagefail-compact");
        if(username == "")
        {
            $j('#status-message').html("User Name Required");
        }
        else if(password == "")
        {
            $j('#status-message').html("Password Required");
        }
    }
    else
    {
        var method = 'isValidUser';    
        data = "username="+username+"&password="+password;      
        $j("#status-message").html("<div style = 'text-align:center; width:100%;'><img src = '" + rootURL + loadingimg + "'/></div>");
        $j("#status-message").addClass("messagefail-compact");
        http_request = CreateXMLHttpRequest();          
        url = rootURL + servicepath + "?method=" + method;

        http_request.onreadystatechange = function()
        {     
            if (http_request.readyState == 4) 
            {
                if (http_request.status == 200) 
                {            
                    var result = http_request.responseText;
                    if(result == "true")
                    {
                        $j('#status-message').html("Login Successfull");
                        timedRefresh(0);
                        
                    }
                    else
                    {
                        $j('#status-message').html("Invalid Account Information");
                    }
                } 
                else 
                {
                    alert('There was a problem with the request.');
                }
            }
        };
        http_request.open('POST', url, true);
        http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http_request.setRequestHeader("Content-length", data.length);
        http_request.setRequestHeader("Connection", "close");
        http_request.send(data);
    }
}

function register()
{
    var username = $j('#R_UN').val();
    var email = $j('#R_Email').val();
    var password = $j('#R_Password').val();
    var confirmpassword = $j('#R_ConfirnmPassword').val();
    if(username == "" || email == "" || password == "" || password != confirmpassword)
    {
        $j("#status-message").addClass("messagefail-compact");
        if(username == "")
        {
            $j('#status-message').html("User Name Required");
        }
        else if(email == "")
        {
            $j('#status-message').html("Email Required");
        }
        else if(password == "")
        {
            $j('#status-message').html("Password Required");
        }
        else if(password != confirmpassword)
        {
            $j('#status-message').html("Password Confirmation Mismatch");
        }
    }
    else
    {
        var method = 'RegisterUser';    
        data = "username="+username+"&email="+email+"&password="+password;      
        $j("#status-message").html("<div id = 'loading-timer' style = 'text-align:center; width:100%;'><img src = '" + rootURL + loadingimg + "'/></div>");
        $j("#status-message").addClass("messagefail-compact");
        http_request = CreateXMLHttpRequest();          
        url = rootURL + servicepath + "?method=" + method;

        http_request.onreadystatechange = function()
        {     
            if (http_request.readyState == 4) 
            {
                if (http_request.status == 200) 
                {            
                    var result = http_request.responseText;
                    if(result == "true")
                    {
                        $j('#status-message').html("Account Created");
                        timedRefresh(0);
                        
                    }
                    else if(result == "false")
                    {
                        // Incase Auto Login Is Disabled on Registration
                        $j('#status-message').html("Account Registeration Completed, Please Login");
                    }
                    else
                    {
                        $j('#status-message').html(result);
                    }
                } 
                else 
                {
                    alert('There was a problem with the request.');
                }
            }
        };
        http_request.open('POST', url, true);
        http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http_request.setRequestHeader("Content-length", data.length);
        http_request.setRequestHeader("Connection", "close");
        http_request.send(data);
    }
}

function forgotpassword()
{
    var username = $j('#FP_UN').val();
    if(username == "")
    {
        $j("#status-message-password").addClass("messagefail-compact");
        $j('#status-message-password').html("User Name Required");      
    }
    else
    {
        var method = 'ForgotPassword';    
        data = "username="+username;      
        $j("#status-message-password").html("<div style = 'text-align:center; width:100%;'><img src = '" + rootURL + loadingimg + "'/></div>");
        $j("#status-message-password").addClass("messagefail-compact");
        http_request = CreateXMLHttpRequest();          
        url = rootURL + servicepath + "?method=" + method;

        http_request.onreadystatechange = function()
        {     
            if (http_request.readyState == 4) 
            {
                if (http_request.status == 200) 
                {            
                    var result = http_request.responseText;
                    if(result == "true")
                    {
                        $j('#status-message-password').html("You Password is Been Emailed to You");                        
                    }
                    else
                    {
                        $j('#status-message-password').html(result);
                    }
                } 
                else 
                {
                    alert('There was a problem with the request.');
                }
            }
        };
        http_request.open('POST', url, true);
        http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http_request.setRequestHeader("Content-length", data.length);
        http_request.setRequestHeader("Connection", "close");
        http_request.send(data);
    }
}

function reportlink()
{
    var storyid = $j('#reportStoryID').val();
    var message = $j('#txtReportLink').val();
    if(message.length ==0 )
    {
        $j("#status-message-Report-link").addClass("messagefail-compact");
        $j('#status-message-Report-link').html("Message Required");      
    }
    else
    {
        var method = 'ReportLink';    
        data = "storyid="+storyid+"&message="+message;      
        $j("#status-message-Report-link").html("<div style = 'text-align:center; width:100%;'><img src = '" + rootURL + loadingimg + "'/></div>");
        $j("#status-message-Report-link").addClass("messagefail-compact");
        http_request = CreateXMLHttpRequest();          
        url = rootURL + servicepath + "?method=" + method;

        http_request.onreadystatechange = function()
        {     
            if (http_request.readyState == 4) 
            {
                if (http_request.status == 200) 
                {            
                    var result = http_request.responseText;               
                    $j('#status-message-Report-link').html(result); 
                } 
                else 
                {
                    alert('There was a problem with the request.');
                }
            }
        };
        http_request.open('POST', url, true);
        http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http_request.setRequestHeader("Content-length", data.length);
        http_request.setRequestHeader("Connection", "close");
        http_request.send(data);
    }
}

function postvote(storyid, votevalue)
{
    var method = 'PostVote';
    data = "storyid="+storyid+"&voteValue="+votevalue;
            
     http_request = CreateXMLHttpRequest();          
     url = rootURL + servicepath + "?method=" + method;
     http_request.onreadystatechange = function()
     {
        if (http_request.readyState == 4) 
        {
            if (http_request.status == 200) 
            {
                var result = http_request.responseText;
                //alert(result);
                var votes = result.split(","); 
                var forvotes = votes[0]
                var againstvotes = votes[1];          
                           
                document.getElementById('divLikeIt' + storyid).innerHTML =  "Like it";
                document.getElementById('divDisLikeIt' + storyid).innerHTML =  "Dislike it";
                document.getElementById('divLikeItCount' + storyid).innerHTML =  forvotes;
                document.getElementById('divDisLikeItCount' + storyid).innerHTML =  againstvotes;
                document.getElementById('LikeDislike' + storyid).style.backgroundImage = "url(../images/website/likedislike-disabled.jpg)";
            } 
            else 
            {
                alert('There was a problem with the request.');
            }
        }
     };
     http_request.open('POST', url, true);
     http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 http_request.setRequestHeader("Content-length", data.length);
	 http_request.setRequestHeader("Connection", "close");
	 http_request.send(data);
}

function timedRefresh(timeoutPeriod) 
{
	setTimeout("location.reload(true);",timeoutPeriod);
}