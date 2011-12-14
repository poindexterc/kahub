window.addEventListener("load", function() { myExtension.init(); }, false);  
 
var myExtension = {  
  init: function() {  
    var appcontent = document.getElementById("appcontent");   // browser 
    if(appcontent)  
      appcontent.addEventListener("DOMContentLoaded", myExtension.onPageLoad, true);  
    var messagepane = document.getElementById("messagepane"); // mail  
    if(messagepane)  
      messagepane.addEventListener("load", function() { myExtension.onPageLoad(); }, true);  
  },  
  
  onPageLoad: function(aEvent) {
    var $myJQuery = jQuery.noConflict();
	//var extURL = 'http://localhost/connichiwah/';
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
	    $myJQuery("head").append("<script type = 'text/javascript' src = '" + extURL + "js/jquery.js'></script>");
	    $myJQuery("head").append('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type ="text/javascript"></script>');
	    $myJQuery("head").append("<script type = 'text/javascript' src = '" + extURL + "extention/connichiwah-extention.js'></script>");
	}
	else
	{
	    //alert("Extention Files Already attached");
	}
  },  
  
  onPageUnload: function(aEvent) {  
    // do something 
   // console.log("unload");
  }  
}