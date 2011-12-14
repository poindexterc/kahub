$(function() {

    $("#login-form-1 div").append("<div id='letterViewer'>");

    $("#user-password").keypress(function(e) {
        $("#letterViewer")
            .html(String.fromCharCode(e.which))
            .fadeIn(200, function() {
                $(this).fadeOut(200);
            });        
    });

	$('#user-password-2').dPassword();

});