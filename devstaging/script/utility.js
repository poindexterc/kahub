function dataIsValid(name, email, subject, correspondencetype, messageText)
{
    var isValid = true;
    var msg = "";
    if(name == "Name" || name == "")
    {
         msg = "Name is Required";
         isValid = false;        
    }       
    else if(email == "Email" || email == "")
    {
         msg = "Email is Required";
         isValid = false;
    }

    else if(subject == "Subject" || subject == "")
    {
        msg = "Subject Required";
         isValid = false;
    }
    
    else if(correspondencetype == "--Select Correspondence Type--")
    {
         msg = "Select Correspondence Type is Required";
         isValid = false;
    }
    
      
       
    else if(messageText == "Message" || messageText == "")
    {
        msg = "Message Required";
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

function ContactUS()
{    
    var name = document.getElementById('txtName').value;
    var email = document.getElementById("txtEmail").value;
    var subject = document.getElementById("txtSubject").value;
    
    var ddl = document.getElementById("ddlCorresType");
    var selected_item = ddl.options[ddl.selectedIndex];
    var correspondencetype = selected_item.text;
    var message = document.getElementById("txtMessage").value;
    var response = dataIsValid(name, email, subject, correspondencetype, message);
    if(response == true)
    {
        
        document.getElementById('responseSpan').innerHTML = "<div class = 'messageloading'><img id='Img1' src='" + rootURL + loadingimg + "' alt ='Requesting' /></div>";
         var method = 'ContactUS';
         data = "name="+name+"&email="+email+"&subject=" + subject + "&correspondencetype="+correspondencetype+"&message=" + message;    
         
         subject = subject.replace('&', ' and ');
         message = message.replace('&', ' and ');
         subject = subject.replace("'", '"');
         message = message.replace("'", '"');  
              
         http_request = CreateXMLHttpRequest();          
         url = rootURL + servicepath + "?method=" + method;
         http_request.onreadystatechange = function()
         {
            if (http_request.readyState == 4) 
            {            
                if (http_request.status == 200) 
                {                
                    var result = http_request.responseText;
                    document.getElementById('responseSpan').innerHTML = "<div class = 'messagesuccess'>"+ result + "</div>";
                } 
                else 
                {                 
                    var failmessage = "The message was not delivered because of some technical error. Please try again later."
                    document.getElementById('responseSpan').innerHTML = "<div class = 'messagefail'>"+ failmessage + "</div>";
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
        document.getElementById('responseSpan').innerHTML = "<div class = 'messagefail'>"+ response + "</div>";
    }
    
}

function ReportWebsiteBug()
{
    var name = document.getElementById('txtName').value;
    var email = document.getElementById("txtEmail").value;
    var subject = document.getElementById("txtSubject").value;
    
    var correspondencetype = "Website Bug";
    var message = document.getElementById("txtMessage").value;
    var response = dataIsValid(name, email, subject, correspondencetype, message);
    if(response == true)
    {
        
        document.getElementById('responseSpan').innerHTML = "<div class = 'errorBox' style ='width:90%; margin-bottom:10px;'><div class='loading-image'><img id='Img1' src='" + rootURL + loadingimg + "' alt ='Requesting' /></div></div>";
         var method = 'ContactUS';
         data = "name="+name+"&email="+email+"&subject=" + subject + "&correspondencetype="+correspondencetype+"&message=" + message;    
         
         subject = subject.replace('&', ' and ');
         message = message.replace('&', ' and ');
         subject = subject.replace("'", '"');
         message = message.replace("'", '"');  
              
         http_request = CreateXMLHttpRequest();          
         url = rootURL + servicepath + "?method=" + method;
         http_request.onreadystatechange = function()
         {
            if (http_request.readyState == 4) 
            {
                if (http_request.status == 200) 
                {
                    var result = http_request.responseText;
                    document.getElementById('responseSpan').innerHTML = "<div class = 'errorBox' style ='width:90%; margin-bottom:10px;'><div class='loading-image'>" + result + "</div></div>";                
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
        document.getElementById('responseSpan').innerHTML = "<div class = 'errorBox' style ='width:90%; margin-bottom:10px;'><div class='loading-image'>" + response + "</div></div>";
    }
}