<?php 
$reqURL = $_GET["rURL"];
$rand = $_GET["rand"];
$ft = $_GET["ft"];
$read = $_GET["read"];
if ($ft=="1"){
	$url = file_get_contents($reqURL);
	//echo "<script type='text/javascript' src='http://www.connichiwah.com/anyShare/jquery-latest.min.js'>";
	echo '<script type="text/javascript">
	function urlChange(){
		var urlEntered = document.getElementById(\'urlTextField\').value;
		var share ="http://www.connichiwah.com/anyShare/index.php?rand=0&rURL=";

		window.location.href=share+urlEntered;
	}

	function goRandom(){
		document.getElementById(\'shuffle\').innerHTML = \'<p>Shufflin&#8217;</p>\';
		window.location.href="http://www.connichiwah.com/anyShare/index.php?rand=1";
	}
	function closeRandBar(){
		window.location.href="'.$reqURL.'";
	}
	</script>';
	echo '<div class="bar-02cb69451d8d746d8944e745949dfce4"><div id="random-02cb69451d8d746d8944e745949dfce4" onClick="goRandom()"><div id="shuffle" class="shuffle"><p>Shuffle</p></div></div><input type="text" id="urlTextField" class="urlTextField" value="'.$reqURL.'" /><div id="gotoURL" onClick="urlChange()">GO</div><div id="closerandbar" onClick="closeRandBar()">&#215;</div></div>';
	echo $url;
	echo '<script type="text/javascript">
	function urlChange(){
		var urlEntered = document.getElementById(\'urlTextField\');
		var share ="http://www.connichiwah.com/anyShare/index.php?rand=0&rURL=";
		window.location.href=share+urlEntered;
	}


	onload = function () {
		for (var i = 0; i < document.links.length; i++) {
			document.links[i].href = \'http://www.connichiwah.com/anyShare/index.php?rand=0&rURL=\' + document.links[i].href
		}
		document.getElementsByTagName(\'head\')[0].appendChild(<scipt type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>);

		var $myJQuery = jQuery.noConflict();

		$myJQuery("head").append("<link type=\'text/css\' rel=\'stylesheet\' href=\'http://www.connichiwah.com/extention/styles-frame.css\' />");
		$myJQuery("head").append("<script type = \'text/javascript\' src = \'http://www.connichiwah.com/js/jquery.js\'></script>");
		$myJQuery("head").append("<script type = \'text/javascript\' src = \'http://www.connichiwah.com/extention/connichiwah-extention-frame.js\'></script>");
		$myJQuery("head").append("<link type=\'text/css\' rel=\'stylesheet\' href=\'http://www.connichiwah.com/anyShare/css/jquerytour.css\' />");
		$myJQuery("head").append("<script type = \'text/javascript\' src = \'http://www.connichiwah.com/anyShare/js/jquery.easing.1.3.js\'></script>");
		$myJQuery("head").append("<script type = \'text/javascript\' src = \'http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php\'></script>");
		
		
		
		
	}
	 <script type="text/javascript">
	$myJQuery(function() {
		/*
		the json config obj.
		name: the class given to the element where you want the tooltip to appear
		bgcolor: the background color of the tooltip
		color: the color of the tooltip text
		text: the text inside the tooltip
		time: if automatic tour, then this is the time in ms for this step
		position: the position of the tip. Possible values are
			TL	top left
			TR  top right
			BL  bottom left
			BR  bottom right
			LT  left top
			LB  left bottom
			RT  right top
			RB  right bottom
			T   top
			R   right
			B   bottom
			L   left
		 */
		var config = [
			{
				"name" 		: "tourcontrols",
				"bgcolor"	: "white",
				"color"		: "black",
				"position"	: "BL",
				"text"		: "It\'s never been easier, more fun, or more convienent to share. <br> Let\'s see how.",
				"time" 		: 5000
			},
			{
				"name" 		: "tourcontrols",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "Highlight any text on this page, anywhere. Go on, try it!",
				"position"	: "BL",
				"time" 		: 5000
			},
			{
				"name" 		: "connichiClass-Main587",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "Type a comment into this box (It can be anything, try, \"Wow, cool\" for starters, or type whatever you want)",
				"position"	: "B",
				"time" 		: 5000
			},
			{
				"name" 		: "UI-Privacy-lock-Hover",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "You can even share with just one person, in only a few clicks by clicking on this lock.",
				"position"	: "BL",
				"time" 		: 5000
			},
			{
				"name" 		: "share-btn",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "Now, click Share.",
				"position"	: "BR",
				"time" 		: 5000
			},
			{
				"name" 		: "span-underline-commented-text",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "Congrats! You\'ve just commented on your first story! Yay you! <br> Now, do you see a yellow underline under where you just highlighted and commented? You can hover over it to read your comment, and reply to other peoples comments. (If you don\'t see anything something went wrong on our end, we\'re working on it but in the meantime, try highlighting something else.)",
				"position"	: "B",
				"time" 		: 5000
			},
			{
				"name" 		: "span-underline-commented-text",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "If anyone else has said anything on this page, what they highlighted would be underlined, and you can read and reply to what they said. Cool, right?",
				"position"	: "B",
				"time" 		: 5000
			},
			{
				"name" 		: "urlTextField",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "See this URL bar? Use this to navigate to anywhere, click GO, and have the ability to comment anywhere on that page. If you download the extension, you don\'t even have to do this, you can comment anywhere your mouse takes you.",
				"position"	: "T",
				"time" 		: 5000
			},
			{
				"name" 		: "shuffle",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "See this Shuffle button? Click it and our super-auto-randomizer will take you to a completly random story to read every single time.",
				"position"	: "TL",
				"time" 		: 5000
			},
			{
				"name" 		: "tourcontrols",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "Well, that\'s all folks. Hope you\'ve enjoyed the tour! Now, go forth and comment!",
				"position"	: "BL",
				"time" 		: 5000
			}

		],
		//define if steps should change automatically
		autoplay	= false,
		//timeout for the step
		showtime,
		//current step of the tour
		step		= 0,
		//total number of steps
		total_steps	= config.length;

		//show the tour controls
		showControls();

		/*
		we can restart or stop the tour,
		and also navigate through the steps
		 */
		$(\'#activatetour\').live(\'click\',startTour);
		$(\'#canceltour\').live(\'click\',endTour);
		$(\'#endtour\').live(\'click\',endTour);
		$(\'#restarttour\').live(\'click\',restartTour);
		$(\'#nextstep\').live(\'click\',nextStep);
		$(\'#prevstep\').live(\'click\',prevStep);

		function startTour(){
			$(\'#activatetour\').remove();
			$(\'#endtour,#restarttour\').show();
			if(!autoplay && total_steps > 1)
				$(\'#nextstep\').show();
			showOverlay();
			nextStep();
		}

		function nextStep(){
			if(!autoplay){
				if(step > 0)
					$(\'#prevstep\').show();
				else
					$(\'#prevstep\').hide();
				if(step == total_steps-1)
					$(\'#nextstep\').hide();
				else
					$(\'#nextstep\').show();	
			}	
			if(step >= total_steps){
				//if last step then end tour
				endTour();
				return false;
			}
			
			if(total_steps=3){
				hideOverlay();
			}
			
			++step;
			showTooltip();
		}

		function prevStep(){
			if(!autoplay){
				if(step > 2)
					$(\'#prevstep\').show();
				else
					$(\'#prevstep\').hide();
				if(step == total_steps)
					$(\'#nextstep\').show();
			}		
			if(step <= 1)
				return false;
			--step;
			showTooltip();
		}

		function endTour(){
			step = 0;
			if(autoplay) clearTimeout(showtime);
			removeTooltip();
			hideControls();
			hideOverlay();
		}

		function restartTour(){
			step = 0;
			if(autoplay) clearTimeout(showtime);
			nextStep();
		}

		function showTooltip(){
			//remove current tooltip
			removeTooltip();

			var step_config		= config[step-1];
			var $elem			= $(\'.\' + step_config.name);

			if(autoplay)
				showtime	= setTimeout(nextStep,step_config.time);

			var bgcolor 		= step_config.bgcolor;
			var color	 		= step_config.color;

			var $tooltip		= $(\'<div>\',{
				id			: \'tour_tooltip\',
				className 	: \'tooltip\',
				html		: \'<p>\'+step_config.text+\'</p><span class="tooltip_arrow"></span>\'
			}).css({
				\'display\'			: \'none\',
				\'background-color\'	: bgcolor,
				\'color\'				: color
			});

			//position the tooltip correctly:

			//the css properties the tooltip should have
			var properties		= {};

			var tip_position 	= step_config.position;

			//append the tooltip but hide it
			$myJQuery("body").append($tooltip);

			//get some info of the element
			var e_w				= $elem.outerWidth();
			var e_h				= $elem.outerHeight();
			var e_l				= $elem.offset().left;
			var e_t				= $elem.offset().top;


			switch(tip_position){
				case \'TL\'	:
					properties = {
						\'left\'	: e_l,
						\'top\'	: e_t + e_h + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_TL\');
					break;
				case \'TR\'	:
					properties = {
						\'left\'	: e_l + e_w - $tooltip.width() + \'px\',
						\'top\'	: e_t + e_h + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_TR\');
					break;
				case \'BL\'	:
					properties = {
						\'left\'	: e_l + \'px\',
						\'top\'	: e_t - $tooltip.height() + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_BL\');
					break;
				case \'BR\'	:
					properties = {
						\'left\'	: e_l + e_w - $tooltip.width() + \'px\',
						\'top\'	: e_t - $tooltip.height() + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_BR\');
					break;
				case \'LT\'	:
					properties = {
						\'left\'	: e_l + e_w + \'px\',
						\'top\'	: e_t + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_LT\');
					break;
				case \'LB\'	:
					properties = {
						\'left\'	: e_l + e_w + \'px\',
						\'top\'	: e_t + e_h - $tooltip.height() + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_LB\');
					break;
				case \'RT\'	:
					properties = {
						\'left\'	: e_l - $tooltip.width() + \'px\',
						\'top\'	: e_t + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_RT\');
					break;
				case \'RB\'	:
					properties = {
						\'left\'	: e_l - $tooltip.width() + \'px\',
						\'top\'	: e_t + e_h - $tooltip.height() + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_RB\');
					break;
				case \'T\'	:
					properties = {
						\'left\'	: e_l + e_w/2 - $tooltip.width()/2 + \'px\',
						\'top\'	: e_t + e_h + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_T\');
					break;
				case \'R\'	:
					properties = {
						\'left\'	: e_l - $tooltip.width() + \'px\',
						\'top\'	: e_t + e_h/2 - $tooltip.height()/2 + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_R\');
					break;
				case \'B\'	:
					properties = {
						\'left\'	: e_l + e_w/2 - $tooltip.width()/2 + \'px\',
						\'top\'	: e_t - $tooltip.height() + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_B\');
					break;
				case \'L\'	:
					properties = {
						\'left\'	: e_l + e_w  + \'px\',
						\'top\'	: e_t + e_h/2 - $tooltip.height()/2 + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_L\');
					break;
			}


			/*
			if the element is not in the viewport
			we scroll to it before displaying the tooltip
			 */
			var w_t	= $(window).scrollTop();
			var w_b = $(window).scrollTop() + $(window).height();
			//get the boundaries of the element + tooltip
			var b_t = parseFloat(properties.top,10);

			if(e_t < b_t)
				b_t = e_t;

			var b_b = parseFloat(properties.top,10) + $tooltip.height();
			if((e_t + e_h) > b_b)
				b_b = e_t + e_h;


			if((b_t < w_t || b_t > w_b) || (b_b < w_t || b_b > w_b)){
				$(\'html, body\').stop()
				.animate({scrollTop: b_t}, 500, \'easeInOutExpo\', function(){
					//need to reset the timeout because of the animation delay
					if(autoplay){
						clearTimeout(showtime);
						showtime = setTimeout(nextStep,step_config.time);
					}
					//show the new tooltip
					$tooltip.css(properties).show();
				});
			}
			else
			//show the new tooltip
				$tooltip.css(properties).show();
		}

		function removeTooltip(){
			$(\'#tour_tooltip\').remove();
		}

		function showControls(){
			/*
			we can restart or stop the tour,
			and also navigate through the steps
			 */
			var $tourcontrols  = \'<div id="tourcontrols" class="tourcontrols">\';
			$tourcontrols += \'<p>First time here?</p>\';
			$tourcontrols += \'<span class="button" id="activatetour">Start the tour</span>\';
				if(!autoplay){
					$tourcontrols += \'<div class="nav"><span class="button" id="prevstep" style="display:none;">< Previous</span>\';
					$tourcontrols += \'<span class="button" id="nextstep" style="display:none;">Next ></span></div>\';
				}
				$tourcontrols += \'<a id="restarttour" style="display:none;">Restart the tour</span>\';
				$tourcontrols += \'<a id="endtour" style="display:none;">End the tour</a>\';
				$tourcontrols += \'<span class="close" id="canceltour"></span>\';
			$tourcontrols += \'</div>\';

			$myJQuery("body").append($tourcontrols);
			$(\'#tourcontrols\').animate({\'right\':\'30px\'},500);
		}

		function hideControls(){
			$(\'#tourcontrols\').remove();
		}

		function showOverlay(){
			var $overlay	= \'<div id="tour_overlay" class="overlay"></div>\';
			$myJQuery("body").append($overlay);
		}

		function hideOverlay(){
			$(\'#tour_overlay\').remove();
		}

	});

	</script>
		<!-- Start of Woopra Code -->
		<script type="text/javascript">
		var woo_settings = {idle_timeout:\'300000\', domain:\'connichiwah.com\'};
		var woo_actions = [{type:\'pageview\',url:window.location.pathname+window.location.search,title:document.title}];
		(function(){
		var wsc = document.createElement(\'script\');
		wsc.src = document.location.protocol+\'//static.woopra.com/js/woopra.js\';
		wsc.type = \'text/javascript\';
		wsc.async = true;
		var ssc = document.getElementsByTagName(\'script\')[0];
		ssc.parentNode.insertBefore(wsc, ssc);
		})();
		</script>
		<!-- End of Woopra Code -->';
} else if ($read=="1"){
$url = file_get_contents($reqURL);
//echo "<script type='text/javascript' src='http://www.connichiwah.com/anyShare/jquery-latest.min.js'>";
echo '<div id="fb-root"></div>
<script type="text/javascript">
function urlChange(){
	var urlEntered = document.getElementById(\'urlTextField\').value;
	var share ="http://www.connichiwah.com/anyShare/index.php?ref=frame_url_bar&rand=0&rURL=";
	
	window.location.href=share+urlEntered;
}

function goRandom(){
	document.getElementById(\'shuffle\').innerHTML = \'<p>Shufflin&#8217;</p>\';
	window.location.href="http://www.connichiwah.com/anyShare/index.php?rand=1";
}
function closeRandBar(){
	window.location.href="'.$reqURL.'";
}

function replace_url(elem, attr) {
    var elems = document.getElementsByTagName(elem);
    for (var i = 0; i < elems.length; i++)
        elems[i][attr] = elems[i][attr].replace(\'/\', \'yahoo.com\');
}

function extractlinks(){
var links=document.all.tags("A")
var total=links.length
var win2=window.open("","","menubar,scrollbars")
win2.document.write("<h2>Total Links="+total+"</h2><br>")
for (i=0;i<total-1;i++){
win2.document.write(links[i].outerHTML+"<br>")
}
}
// init
FB.init({
apiKey: \'212dcc92fc9aba19273b83a3f250157e\',
cookie: true
});

</script>
<style type="text/css" media="screen">
	.bg-jfakeuaoieae{
		position: fixed; 
		height: 100%;
		width: 100%;
		background:  url("http://connichiwah.com/images/website/bg.png");;
		z-index: 100;
		display: none;
		top: 0;
		left: 0; 
}

</style>';
echo '<div class=bg-jfakeuaoieae>';
echo $url;
echo '</div>';
echo '<script type="text/javascript">

onload = function () {
	readStyle = \'style-novel\';
	    readSize = \'size-medium\';
	    readMargin = \'margin-medium\';
	    _readability_jquery = document.createElement(\'SCRIPT\');
	    _readability_jquery.type = \'text/javascript\';
	    _readability_jquery.src = \'http://www.connichiwah.com/anyShare/jquery-latest.min.js\';
	    document.getElementsByTagName(\'head\')[0].appendChild(_readability_jquery);
		_readability_jquery2 = document.createElement(\'SCRIPT\');
	    _readability_jquery2.type = \'text/javascript\';
	    _readability_jquery2.src = \'http://www.connichiwah.com/js/jquery.js?x=\' + (Math.random());
	    document.getElementsByTagName(\'head\')[0].appendChild(_readability_jquery2);
		_readability_framejs = document.createElement(\'SCRIPT\');
	    _readability_framejs.type = \'text/javascript\';
	    _readability_framejs.src = \'http://www.connichiwah.com/extention/connichiwah-extention-frame.js?x=\' + (Math.random());
	    document.getElementsByTagName(\'head\')[0].appendChild(_readability_framejs);
	    _readability_script = document.createElement(\'SCRIPT\');
	    _readability_script.type = \'text/javascript\';
	    _readability_script.src = \'http://www.connichiwah.com/dev/read/js/readability.js?x=\' + (Math.random());
	    document.getElementsByTagName(\'head\')[0].appendChild(_readability_script);
	    _readability_css = document.createElement(\'LINK\');
	    _readability_css.rel = \'stylesheet\';
	    _readability_css.href = \'http://www.connichiwah.com/dev/read/css/readability.css\';
	    _readability_css.type = \'text/css\';
	    _readability_css.media = \'screen\';
	    document.getElementsByTagName(\'head\')[0].appendChild(_readability_css);
	    _readability_print_css = document.createElement(\'LINK\');
	    _readability_print_css.rel = \'stylesheet\';
	    _readability_print_css.href = \'http://www.connichiwah.com/dev/read/css/readability-print.css\';
	    _readability_print_css.media = \'print\';
	    _readability_print_css.type = \'text/css\';
	    document.getElementsByTagName(\'head\')[0].appendChild(_readability_print_css);
	    _readability_frame_css = document.createElement(\'LINK\');
	    _readability_frame_css.rel = \'stylesheet\';
	    _readability_frame_css.href = \'http://www.connichiwah.com/extention/connichi_styles-frame.css\';
	    _readability_frame_css.type = \'text/css\';
	    _readability_frame_css.media = \'screen\';
	    document.getElementsByTagName(\'head\')[0].appendChild(_readability_frame_css);
}




</script>

	<!-- Start of Woopra Code -->
	<script type="text/javascript">
	var woo_settings = {idle_timeout:\'300000\', domain:\'connichiwah.com\'};
	var woo_actions = [{type:\'pageview\',url:window.location.pathname+window.location.search,title:document.title}];
	(function(){
	var wsc = document.createElement(\'script\');
	wsc.src = document.location.protocol+\'//static.woopra.com/js/woopra.js\';
	wsc.type = \'text/javascript\';
	wsc.async = true;
	var ssc = document.getElementsByTagName(\'script\')[0];
	ssc.parentNode.insertBefore(wsc, ssc);
	})();
	</script>
	<!-- End of Woopra Code -->
	<!--footer ends-->';
	
} else if ($rand !="1"){
$url = file_get_contents($reqURL);
//echo "<script type='text/javascript' src='http://www.connichiwah.com/anyShare/jquery-latest.min.js'>";
echo '<script type="text/javascript">
function urlChange(){
	var urlEntered = document.getElementById(\'urlTextField\').value;
	var share ="http://www.connichiwah.com/anyShare/index.php?ref=frame_url_bar&rand=0&rURL=";
	
	window.location.href=share+urlEntered;
}

function goRandom(){
	document.getElementById(\'shuffle\').innerHTML = \'<p>Shufflin&#8217;</p>\';
	window.location.href="http://www.connichiwah.com/anyShare/index.php?rand=1";
}
function closeRandBar(){
	window.location.href="'.$reqURL.'";
}

function replace_url(elem, attr) {
    var elems = document.getElementsByTagName(elem);
    for (var i = 0; i < elems.length; i++)
        elems[i][attr] = elems[i][attr].replace(\'/\', \'yahoo.com\');
}

function extractlinks(){
var links=document.all.tags("A")
var total=links.length
var win2=window.open("","","menubar,scrollbars")
win2.document.write("<h2>Total Links="+total+"</h2><br>")
for (i=0;i<total-1;i++){
win2.document.write(links[i].outerHTML+"<br>")
}
}

</script>';
echo '<div class="bar-02cb69451d8d746d8944e745949dfce4"><div id="random-02cb69451d8d746d8944e745949dfce4" onClick="goRandom()"><div id="shuffle"><p>Shuffle</p></div></div><input type="text" id="urlTextField" value="'.$reqURL.'" /><div id="gotoURL" onClick="urlChange()">GO</div><div id="closerandbar" onClick="closeRandBar()">&#215;</div></div>';
echo $url;
echo '<script type="text/javascript">
function urlChange(){
	var urlEntered = document.getElementById(\'urlTextField\');
	var share ="http://www.connichiwah.com/anyShare/index.php?ref=frame_url_bar&rand=0&rURL=";
	window.location.href=share+urlEntered;
}




window.onload = function () {
	for (var i = 0; i < document.links.length; i++) {
		alert(document.links[i].href);
		document.links[i].href = "\'http://www.connichiwah.com/anyShare/index.php?rand=0&rURL=\' + document.links[i].href"
	}
	extractlinks();
	replace_url(\'a\', \'href\');
    replace_url(\'img\', \'src\');
	document.getElementsByTagName(\'head\')[0].appendChild(<scipt type="text/javascript" src="http://www.connichiwah.com/anyShare/jquery-latest.min.js"></script>);
	var $myJQuery = jQuery.noConflict();
	
	$myJQuery("head").append("<link type=\'text/css\' rel=\'stylesheet\' href=\'http://www.connichiwah.com/extention/styles-frame.css\' />");
	$myJQuery("head").append("<script type = \'text/javascript\' src = \'http://www.connichiwah.com/js/jquery.js\'></script>");
	$myJQuery("head").append("<script type = \'text/javascript\' src = \'http://www.connichiwah.com/extention/connichiwah-extention-frame.js\'></script>");
	$myJQuery("head").append("<script type = \'text/javascript\' src = \'http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php\'></script>");
	
	


}




</script>
	 <script type="text/javascript">
	$(function() {
		/*
		the json config obj.
		name: the class given to the element where you want the tooltip to appear
		bgcolor: the background color of the tooltip
		color: the color of the tooltip text
		text: the text inside the tooltip
		time: if automatic tour, then this is the time in ms for this step
		position: the position of the tip. Possible values are
			TL	top left
			TR  top right
			BL  bottom left
			BR  bottom right
			LT  left top
			LB  left bottom
			RT  right top
			RB  right bottom
			T   top
			R   right
			B   bottom
			L   left
		 */
		var config = [
			{
				"name" 		: "tourcontrols",
				"bgcolor"	: "white",
				"color"		: "black",
				"position"	: "TL",
				"text"		: "You can create a tour to explain the functioning of your app",
				"time" 		: 5000
			},
			{
				"name" 		: "tour_2",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "Give a class to the points of your walkthrough",
				"position"	: "BL",
				"time" 		: 5000
			},
			{
				"name" 		: "tour_3",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "Customize the navigation buttons",
				"position"	: "BL",
				"time" 		: 5000
			},
			{
				"name" 		: "tour_4",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "You can also use the autoplay function where the user can just sit back and watch the whole tour",
				"position"	: "TL",
				"time" 		: 5000
			},
			{
				"name" 		: "tour_5",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "You can indicate the direction of the tooltip arrow for each tour point",
				"position"	: "TL",
				"time" 		: 5000
			},
			{
				"name" 		: "tour_6",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "Mark important tour points in a different color",
				"position"	: "BL",
				"time" 		: 5000
			},
			{
				"name" 		: "tour_7",
				"bgcolor"	: "white",
				"color"		: "black",
				"text"		: "Automatically scrolls to the right place of the website",
				"position"	: "TL",
				"time" 		: 5000
			}

		],
		//define if steps should change automatically
		autoplay	= false,
		//timeout for the step
		showtime,
		//current step of the tour
		step		= 0,
		//total number of steps
		total_steps	= config.length;

		//show the tour controls
		showControls();

		/*
		we can restart or stop the tour,
		and also navigate through the steps
		 */
		$(\'#activatetour\').live(\'click\',startTour);
		$(\'#canceltour\').live(\'click\',endTour);
		$(\'#endtour\').live(\'click\',endTour);
		$(\'#restarttour\').live(\'click\',restartTour);
		$(\'#nextstep\').live(\'click\',nextStep);
		$(\'#prevstep\').live(\'click\',prevStep);

		function startTour(){
			$(\'#activatetour\').remove();
			$(\'#endtour,#restarttour\').show();
			if(!autoplay && total_steps > 1)
				$(\'#nextstep\').show();
			showOverlay();
			nextStep();
		}

		function nextStep(){
			if(!autoplay){
				if(step > 0)
					$(\'#prevstep\').show();
				else
					$(\'#prevstep\').hide();
				if(step == total_steps-1)
					$(\'#nextstep\').hide();
				else
					$(\'#nextstep\').show();	
			}	
			if(step >= total_steps){
				//if last step then end tour
				endTour();
				return false;
			}
			++step;
			showTooltip();
		}

		function prevStep(){
			if(!autoplay){
				if(step > 2)
					$(\'#prevstep\').show();
				else
					$(\'#prevstep\').hide();
				if(step == total_steps)
					$(\'#nextstep\').show();
			}		
			if(step <= 1)
				return false;
			--step;
			showTooltip();
		}

		function endTour(){
			step = 0;
			if(autoplay) clearTimeout(showtime);
			removeTooltip();
			hideControls();
			hideOverlay();
		}

		function restartTour(){
			step = 0;
			if(autoplay) clearTimeout(showtime);
			nextStep();
		}

		function showTooltip(){
			//remove current tooltip
			removeTooltip();

			var step_config		= config[step-1];
			var $elem			= $(\'.\' + step_config.name);

			if(autoplay)
				showtime	= setTimeout(nextStep,step_config.time);

			var bgcolor 		= step_config.bgcolor;
			var color	 		= step_config.color;

			var $tooltip		= $(\'<div>\',{
				id			: \'tour_tooltip\',
				className 	: \'tooltip\',
				html		: \'<p>\'+step_config.text+\'</p><span class="tooltip_arrow"></span>\'
			}).css({
				\'display\'			: \'none\',
				\'background-color\'	: bgcolor,
				\'color\'				: color
			});

			//position the tooltip correctly:

			//the css properties the tooltip should have
			var properties		= {};

			var tip_position 	= step_config.position;

			//append the tooltip but hide it
			$(\'BODY\').prepend($tooltip);

			//get some info of the element
			var e_w				= $elem.outerWidth();
			var e_h				= $elem.outerHeight();
			var e_l				= $elem.offset().left;
			var e_t				= $elem.offset().top;


			switch(tip_position){
				case \'TL\'	:
					properties = {
						\'left\'	: e_l,
						\'top\'	: e_t + e_h + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_TL\');
					break;
				case \'TR\'	:
					properties = {
						\'left\'	: e_l + e_w - $tooltip.width() + \'px\',
						\'top\'	: e_t + e_h + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_TR\');
					break;
				case \'BL\'	:
					properties = {
						\'left\'	: e_l + \'px\',
						\'top\'	: e_t - $tooltip.height() + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_BL\');
					break;
				case \'BR\'	:
					properties = {
						\'left\'	: e_l + e_w - $tooltip.width() + \'px\',
						\'top\'	: e_t - $tooltip.height() + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_BR\');
					break;
				case \'LT\'	:
					properties = {
						\'left\'	: e_l + e_w + \'px\',
						\'top\'	: e_t + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_LT\');
					break;
				case \'LB\'	:
					properties = {
						\'left\'	: e_l + e_w + \'px\',
						\'top\'	: e_t + e_h - $tooltip.height() + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_LB\');
					break;
				case \'RT\'	:
					properties = {
						\'left\'	: e_l - $tooltip.width() + \'px\',
						\'top\'	: e_t + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_RT\');
					break;
				case \'RB\'	:
					properties = {
						\'left\'	: e_l - $tooltip.width() + \'px\',
						\'top\'	: e_t + e_h - $tooltip.height() + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_RB\');
					break;
				case \'T\'	:
					properties = {
						\'left\'	: e_l + e_w/2 - $tooltip.width()/2 + \'px\',
						\'top\'	: e_t + e_h + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_T\');
					break;
				case \'R\'	:
					properties = {
						\'left\'	: e_l - $tooltip.width() + \'px\',
						\'top\'	: e_t + e_h/2 - $tooltip.height()/2 + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_R\');
					break;
				case \'B\'	:
					properties = {
						\'left\'	: e_l + e_w/2 - $tooltip.width()/2 + \'px\',
						\'top\'	: e_t - $tooltip.height() + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_B\');
					break;
				case \'L\'	:
					properties = {
						\'left\'	: e_l + e_w  + \'px\',
						\'top\'	: e_t + e_h/2 - $tooltip.height()/2 + \'px\'
					};
					$tooltip.find(\'span.tooltip_arrow\').addClass(\'tooltip_arrow_L\');
					break;
			}


			/*
			if the element is not in the viewport
			we scroll to it before displaying the tooltip
			 */
			var w_t	= $(window).scrollTop();
			var w_b = $(window).scrollTop() + $(window).height();
			//get the boundaries of the element + tooltip
			var b_t = parseFloat(properties.top,10);

			if(e_t < b_t)
				b_t = e_t;

			var b_b = parseFloat(properties.top,10) + $tooltip.height();
			if((e_t + e_h) > b_b)
				b_b = e_t + e_h;


			if((b_t < w_t || b_t > w_b) || (b_b < w_t || b_b > w_b)){
				$(\'html, body\').stop()
				.animate({scrollTop: b_t}, 500, \'easeInOutExpo\', function(){
					//need to reset the timeout because of the animation delay
					if(autoplay){
						clearTimeout(showtime);
						showtime = setTimeout(nextStep,step_config.time);
					}
					//show the new tooltip
					$tooltip.css(properties).show();
				});
			}
			else
			//show the new tooltip
				$tooltip.css(properties).show();
		}

		function removeTooltip(){
			$(\'#tour_tooltip\').remove();
		}

		function showControls(){
			/*
			we can restart or stop the tour,
			and also navigate through the steps
			 */
			var $tourcontrols  = \'<div id="tourcontrols" class="tourcontrols">\';
			$tourcontrols += \'<p>First time here?</p>\';
			$tourcontrols += \'<span class="button" id="activatetour">Start the tour</span>\';
				if(!autoplay){
					$tourcontrols += \'<div class="nav"><span class="button" id="prevstep" style="display:none;">< Previous</span>\';
					$tourcontrols += \'<span class="button" id="nextstep" style="display:none;">Next ></span></div>\';
				}
				$tourcontrols += \'<a id="restarttour" style="display:none;">Restart the tour</span>\';
				$tourcontrols += \'<a id="endtour" style="display:none;">End the tour</a>\';
				$tourcontrols += \'<span class="close" id="canceltour"></span>\';
			$tourcontrols += \'</div>\';

			$(\'BODY\').prepend($tourcontrols);
			$(\'#tourcontrols\').animate({\'right\':\'30px\'},500);
		}

		function hideControls(){
			$(\'#tourcontrols\').remove();
		}

		function showOverlay(){
			var $overlay	= \'<div id="tour_overlay" class="overlay"></div>\';
			$(\'BODY\').prepend($overlay);
		}

		function hideOverlay(){
			$(\'#tour_overlay\').remove();
		}

	});
	  </script>
		
	<!-- Start of Woopra Code -->
	<script type="text/javascript">
	var woo_settings = {idle_timeout:\'300000\', domain:\'connichiwah.com\'};
	var woo_actions = [{type:\'pageview\',url:window.location.pathname+window.location.search,title:document.title}];
	(function(){
	var wsc = document.createElement(\'script\');
	wsc.src = document.location.protocol+\'//static.woopra.com/js/woopra.js\';
	wsc.type = \'text/javascript\';
	wsc.async = true;
	var ssc = document.getElementsByTagName(\'script\')[0];
	ssc.parentNode.insertBefore(wsc, ssc);
	})();
	</script>
	<!-- End of Woopra Code -->
	<!--footer ends-->';
	


} else {
	require_once '../AppCode/access.class.php';
	$user = new flexibleAccess();
	require_once '../AppCode/HelpingDBMethods.php';
	if($user->is_loaded())
	{
		$MemberID = $user->userID;

		$noOfFriends = HelpingDBMethods::GetNoOfFriends($friendID);
		$imageID = HelpingDBMethods::GetMemberImageID($friendID);
					$Query = "SELECT s.StoryID, s.Story_URL
								FROM tbl_story s
								INNER JOIN tbl_comments c ON s.StoryID = c.StoryID				
								ORDER BY c.Date_Time DESC LIMIT 0, 1";	

					$QueryResult = mysql_query($Query);
					$row = mysql_fetch_array($QueryResult);
					if($row != false)
					{
						//echo '3--' . $url;
						$maxStory = $row['Story_ID'];

				}
					$Query = "SELECT s.StoryID, s.Story_URL
								FROM tbl_story s
								INNER JOIN tbl_comments c ON s.StoryID = c.StoryID				
								ORDER BY c.Date_Time ASC LIMIT 0, 1";	

					$QueryResult = mysql_query($Query);
					$row = mysql_fetch_array($QueryResult);
					if($row != false)
					{
						//echo '3--' . $url;
						$minStory = $row['Story_ID'];

				}

					$storyRand = rand(100, $minStory);
					$Query = "SELECT s.StoryID, s.Story_URL
								FROM tbl_story s
								INNER JOIN tbl_comments c ON s.StoryID = c.StoryID	
								WHERE (s.StoryID = $storyRand)
								ORDER BY c.Date_Time DESC LIMIT 0, 1";	

					$QueryResult = mysql_query($Query);
					$row = mysql_fetch_array($QueryResult);
					if($row != false)
					{
						$url = $row['Story_URL'];
						//echo '3--' . $url;
						header('Location:http://www.connichiwah.com/anyShare/index.php?ref=shuffle&rand=0&rURL=' . $url);

				} else {

				}
			}


	else
	{
		echo 'You Are Not Loged In.';
	}

}
?>