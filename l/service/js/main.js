var $myJQuery = jQuery.noConflict();
var rootURL = "/connichiwah/";
var WebServiceURL = "service/webservice.php";
$myJQuery(document).ready(function(){
    $myJQuery("a.UI-Face-Image-Link").hover(function () 
	{
	    var un = $myJQuery(this).attr("rel");	
		$myJQuery(this).append("<span class = 'UI-Face-Image-Link-UserName'>"+ un + "</span>");
	}, function () 
	{
		$myJQuery(".UI-Face-Image-Link-UserName").remove();
	});
	
	$myJQuery(".trust-btn").click(function()
	{            
		$myJQuery(this).html("Trusted");
		$myJQuery(this).attr("disabled", "disabled");
		$myJQuery(this).removeClass("trust-btn");
		$myJQuery(this).addClass("trust-btn-disabled");
	});
	$myJQuery(".ok-button").click(function()
	{
		$myJQuery(this).html('<img alt="" src="images/uni-ok-clicked.png" class="middle"/>');
	});
});

    function lookup(inputString) 
    {
		if(inputString.length == 0) 
		{
			// Hide the suggestion box.
			$myJQuery('#suggestions').hide();
		}
        else
        {
			$myJQuery.post(rootURL + WebServiceURL + "?method=GetUserNameSuggestions", {txt: ""+inputString+""}, function(data){
				if(data.length >0) {
					$myJQuery('#suggestions').show();
					$myJQuery('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup
	
	function fill(thisValue) 
	{
		$myJQuery('#txtSource').val(thisValue);
		setTimeout("$myJQuery('#suggestions').hide();", 200);
	}


