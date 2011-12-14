<?php

function d($v)
{
    echo "<pre>";
    print_r($v);
    echo "</pre>";
}

require_once 'src/musixmatch.php';



$apikey = 'edbb9f9d7c163a222eba64a5a479e40c';


$musix = new MusicXMatch($apikey);

$result = '';
try{
    $result = $musix->param_q_artist('zé ramalho')
        ->execute_request();
}
catch (Exception $e)
{
    d($e);
}



d($result);


?>
