var $myJQuery = jQuery.noConflict();
//var extURL = 'http://192.168.1.4/connichiwah/';
var extURL = 'http://www.connichiwah.com/';
var isAllowed = true;
$myJQuery('script').each(function() {
    if($myJQuery(this).attr("src") == extURL + "extention/connichiwah-extention.js")
    {
       isAllowed = false; 
    }
});

if(isAllowed == true)
{
    $myJQuery("head").append("<link type='text/css' rel='stylesheet' href='" + extURL + "extention/styles.css' />");
    $myJQuery("head").append("<script type = 'text/javascript' src = '" + extURL + "extention/connichiwah-extention-frame.js'></script>");	

    $myJQuery("head").append("<script type = 'text/javascript' src = '" + extURL + "js/jquery.js'></script>");
}
else
{
    alert("Extention Files Already attached");
}