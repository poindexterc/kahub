var memberServicePath = "webService/memberService.php";
function changename()
{
    var name = $j('#CN_Name').val();
    if(name == "")
    {
        $j("#status-message-change-name").addClass("messagefail-compact");
        $j('#status-message-change-name').html("Name Required");      
    }
    else
    {
        var method = 'ChangeName';    
        data = "name="+name;      
        $j("#status-message-change-name").html("<div style = 'text-align:center; width:100%;'><img src = '" + rootURL + loadingimg + "'/></div>");
        $j("#status-message-change-name").addClass("messagefail-compact");
        http_request = CreateXMLHttpRequest();          
        url = rootURL + memberServicePath + "?method=" + method;

        http_request.onreadystatechange = function()
        {     
            if (http_request.readyState == 4) 
            {
                if (http_request.status == 200) 
                {
                    var result = JSON.parse(http_request.responseText);                
                    $j('#status-message-change-name').html(result.message); 
                    if(result.status = 1)
                    {
                        $j('#span_name').html(name); 
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

function changeemail()
{
    var email = $j('#CN_Email').val();
    if(email == "")
    {
        $j("#status-message-change-email").addClass("messagefail-compact");
        $j('#status-message-change-email').html("Eamil Required");      
    }
    else
    {
        var method = 'ChangeEmail';    
        data = "email="+email;      
        $j("#status-message-change-email").html("<div style = 'text-align:center; width:100%;'><img src = '" + rootURL + loadingimg + "'/></div>");
        $j("#status-message-change-email").addClass("messagefail-compact");
        http_request = CreateXMLHttpRequest();          
        url = rootURL + memberServicePath + "?method=" + method;

        http_request.onreadystatechange = function()
        {     
            if (http_request.readyState == 4) 
            {
                if (http_request.status == 200) 
                {
                    var result = JSON.parse(http_request.responseText);                
                    $j('#status-message-change-email').html(result.message); 
                    if(result.status = 1)
                    {
                        $j('#span_email').html(email); 
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

function changepassword()
{
    var oldPassword = $j('#CN_Old_Password').val();
    var newPassword = $j('#CN_New_Password').val();
    var confirmPassword = $j('#CN_Confirm_Password').val();
    if(oldPassword == "" || newPassword == "" || newPassword != confirmPassword)
    {
        if(oldPassword == "")
        {
            $j("#status-message-change-password").addClass("messagefail-compact");
            $j('#status-message-change-password').html("Old Password Required");
        }
        else if(newPassword == "")
        {
            $j("#status-message-change-password").addClass("messagefail-compact");
            $j('#status-message-change-password').html("New Password Required");
        }
        else if(newPassword != confirmPassword)
        {
            $j("#status-message-change-password").addClass("messagefail-compact");
            $j('#status-message-change-password').html("Password Match Failed");
        }
              
    }
    else
    {
        var method = 'ChangePassword';    
        data = "oldPassword="+oldPassword+"&newPassword="+newPassword;      
        $j("#status-message-change-password").html("<div style = 'text-align:center; width:100%;'><img src = '" + rootURL + loadingimg + "'/></div>");
        $j("#status-message-change-password").addClass("messagefail-compact");
        http_request = CreateXMLHttpRequest();          
        url = rootURL + memberServicePath + "?method=" + method;

        http_request.onreadystatechange = function()
        {     
            if (http_request.readyState == 4) 
            {
                if (http_request.status == 200) 
                {
                    var result = JSON.parse(http_request.responseText);
                    //alert(http_request.responseText);                
                    $j('#status-message-change-password').html(result.message);                  
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

function changeDOB()
{
    var DOB = $j('#CN_DOB').val();
    if(DOB == "")
    {
        $j("#status-message-change-DOB").addClass("messagefail-compact");
        $j('#status-message-change-DOB').html("Date Of Birth Required");      
    }
    else
    {
        var method = 'ChangeDOB';    
        data = "DOB="+DOB;      
        $j("#status-message-change-DOB").html("<div style = 'text-align:center; width:100%;'><img src = '" + rootURL + loadingimg + "'/></div>");
        $j("#status-message-change-DOB").addClass("messagefail-compact");
        http_request = CreateXMLHttpRequest();          
        url = rootURL + memberServicePath + "?method=" + method;

        http_request.onreadystatechange = function()
        {     
            if (http_request.readyState == 4) 
            {
                if (http_request.status == 200) 
                {            
                    //var result = http_request.responseText;                    
                    //$j('#status-message-change-DOB').html(result);
                    var result = JSON.parse(http_request.responseText);                
                    $j('#status-message-change-DOB').html(result.message); 
                    if(result.status = 1)
                    {
                        $j('#span_dob').html(DOB); 
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

function changeaboutme()
{
    var aboutme = $j('#CN_About_ME').val();
    if(aboutme == "")
    {
        $j("#status-message-change-about-me").addClass("messagefail-compact");
        $j('#status-message-change-about-me').html("About Me Required");      
    }
    else
    {
        var method = 'ChangeAboutMe';    
        data = "aboutme="+aboutme;      
        $j("#status-message-change-about-me").html("<div style = 'text-align:center; width:100%;'><img src = '" + rootURL + loadingimg + "'/></div>");
        $j("#status-message-change-about-me").addClass("messagefail-compact");
        http_request = CreateXMLHttpRequest();          
        url = rootURL + memberServicePath + "?method=" + method;

        http_request.onreadystatechange = function()
        {     
            if (http_request.readyState == 4) 
            {
                if (http_request.status == 200) 
                {            
                    //var result = http_request.responseText;                    
                    //$j('#status-message-change-about-me').html(result); 
                    var result = JSON.parse(http_request.responseText);                
                    $j('#status-message-change-about-me').html(result.message); 
                    if(result.status = 1)
                    {
                        $j('#span_aboutme').html(aboutme); 
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
