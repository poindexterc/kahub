<?php 
$reqURL = $_GET["rURL"];
$url = file_get_contents($reqURL);
//echo "<script type='text/javascript' src='http://www.connichiwah.com/anyShare/jquery-latest.min.js'>";
echo $url;
echo '<script type="text/javascript">

window.onload = function() {
		readStyle = \'style-novel\';
	    readSize = \'size-medium\';
	    readMargin = \'margin-medium\';
	    _readability_script = document.createElement(\'SCRIPT\');
		_readability_jquery = document.createElement(\'SCRIPT\');
		  _readability_jquery.type = \'text/javascript\';
		  _readability_jquery.src = \'http://www.connichiwah.com/anyShare/jquery-latest.min.js\';
		  document.getElementsByTagName(\'head\')[0].appendChild(_readability_jquery);
		_readability_jquery2 = document.createElement(\'SCRIPT\');
		  _readability_jquery2.type = \'text/javascript\';
		  _readability_jquery2.src = \'http://www.connichiwah.com/js/jquery.js?x=\' + (Math.random());
	    _readability_script.type = \'text/javascript\';
	    _readability_script.src = \'http://www.connichiwah.com/dev/read/js/readability.js?x=\' + (Math.random());
	    document.getElementsByTagName(\'head\')[0].appendChild(_readability_script);
}
</script>
';
?>