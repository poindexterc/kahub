var rootURL = "/connichiwah/";
var loadingimg = "images/website/loading.gif";
var servicepath = "webService/gen.php";
//var $j = jQuery.noConflict();

function CreateXMLHttpRequest()
{
    http_request = false;
    if (window.XMLHttpRequest) 
    { // Mozilla, Safari,...
        http_request = new XMLHttpRequest();
        if (http_request.overrideMimeType) 
        {
            // set type accordingly to anticipated content type
            // http_request.overrideMimeType('text/xml');
            http_request.overrideMimeType('text/html');
        }
    } 
    else if (window.ActiveXObject) 
    { // IE
         try 
         {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
         } 
         catch (e) 
         {
            try 
            {
               http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) 
            {
               alert("not good at all..");
            }
         }
     }
     if (!http_request) 
     {
        alert('Your Browser Do Not Support AJAX Request !!!');
        return false;
     }
     else
     {
        return http_request;
     }  
}