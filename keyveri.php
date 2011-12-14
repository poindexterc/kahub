<?
// Call to verify key function
// Call to comment check
$data = array('blog' => 'http://www.kahub.com',
              'user_ip' => $_SERVER['REMOTE_ADDR'],
              'user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
              'referrer' => 'http://www.google.com',
              'permalink' => 'http://kahub.com/',
              'comment_type' => 'comment',
              'comment_author' => 'admin',
              'comment_author_email' => 'test@test.com',
              'comment_author_url' => 'unkown',
              'comment_content' => 'viagra');
// Passes back true (it's spam) or false (it's ham)
function akismet_comment_check( $key, $data ) {
    $request = 'blog='. urlencode($data['blog']) .
               '&user_ip='. urlencode($data['user_ip']) .
               '&user_agent='. urlencode($data['user_agent']) .
               '&referrer='. urlencode($data['referrer']) .
               '&permalink='. urlencode($data['permalink']) .
               '&comment_type='. urlencode($data['comment_type']) .
               '&comment_author='. urlencode($data['comment_author']) .
               '&comment_author_email='. urlencode($data['comment_author_email']) .
               '&comment_author_url='. urlencode($data['comment_author_url']) .
               '&comment_content='. urlencode($data['comment_content']);
    $host = $http_host = $key.'.rest.akismet.com';
    $path = '/1.1/comment-check';
    $port = 80;
    $akismet_ua = "kahub Comments | Akismet/2.5.3";
    $content_length = strlen( $request );
    $http_request  = "POST $path HTTP/1.0\r\n";
    $http_request .= "Host: $host\r\n";
    $http_request .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $http_request .= "Content-Length: {$content_length}\r\n";
    $http_request .= "User-Agent: {$akismet_ua}\r\n";
    $http_request .= "\r\n";
    $http_request .= $request;
    $response = '';
    if( false != ( $fs = @fsockopen( $http_host, $port, $errno, $errstr, 10 ) ) ) {
         
        fwrite( $fs, $http_request );
 
        while ( !feof( $fs ) )
            $response .= fgets( $fs, 1160 ); // One TCP-IP packet
        fclose( $fs );
         
        $response = explode( "\r\n\r\n", $response, 2 );        
    }
	return $response[1];
     
}

function spamCheck($data){
	$akismet = akismet_comment_check( 'e897a16a72e1', $data );
	if($data['comment_content']=='nigger'||$data['comment_content']=='tits'||$data['comment_content']=='fag'||$data['comment_content']=='faggot'){
		$akismet= "true";
	}
	return $akismet;
}

echo spamCheck($data);
?>