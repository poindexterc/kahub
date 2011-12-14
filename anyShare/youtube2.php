<?php
/*
Funções basicas para trabalhar com o link do youtube 
*/

    class YouTube2{
        
        
        //Get the ID of a video from any youtube link
        //Pega o ID do video de qualquer link do youtube
        function getID( $url ){

            if( !strpos($url, "#!v=") === false ){  //Em caso de ser um link de quando clica nos related
                                                    //In case of be a link from related
                $url = str_replace('#!v=','?v=',$url);
            }

            parse_str( parse_url( $url, PHP_URL_QUERY ) );

            if( isset( $v ) ){
                return $v;
            } else { //Se não achou, é por que é o link de um video de canal ex: http://www.youtube.com/user/laryssap#p/a/u/1/SAXVMaLL94g
                     //If not found, is because is a link from a user channel ex: http://www.youtube.com/user/laryssap#p/a/u/1/SAXVMaLL94g
                return substr( $url, strrpos( $url,'/') + 1, 11);
            }
        }
        
        
        //Generate a youtube link from a video ID
        //Gera um link para o youtube a partir de um ID de video
        function generateLink( $id ){
            return 'http://www.youtube.com/watch?v=' . trim($id);
        }
        
        
        //Generate a simple embedded code from a video ID
        //Gera um code de embedded simples, a partir de um ID de video
        function generateEmbedded( $id, $width = 507, $height = 285 ){
            $randID= rand(0,700);
            $embed = '<object style=\'height: '.$height.'px; width: '.$width.'px\'>
                  <param name=\'movie\' value=\'http://www.youtube.com/v/'.$id.'?version=3&autoplay=1&autohide=1&iv_load_policy=3&feature=player_embedded\'>
                  <param name=\'allowFullScreen\' value=\'true\'>
                  <param name=\'allowScriptAccess\' value=\'always\'>
                  <embed src=\'http://www.youtube.com/v/'.$id.'?version=3&autohide=1&iv_load_policy=3&autoplay=1&feature=player_embedded\' type=\'application/x-shockwave-flash\' allowfullscreen=\'true\' allowScriptAccess=\'always\' width=\''.$width.'\' height=\''.$height.'\'></object>';
        
            return  '<div class="videoInline phub" id="vidInline-'.sha1(md5($id).$randID).'"><div class="placeholderImg phub" onClick="jQuery(this).hide(); jQuery(\'#vidEmbed-'.sha1(md5($id).$randID).'\').show(); jQuery(\'#vidInline-'.sha1(md5($id).$randID).'\').height(281);"><p class="playVid phub">Play&rang;</p><img src="http://img.youtube.com/vi/'.$id.'/0.jpg"></div><div id="vidEmbed-'.sha1(md5($id).$randID).'" class="vidEmbed phub">'.$embed.'</div></div>';
        
        }
    }
    class Vimeo2{
        function curl_get($url) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            $return = curl_exec($curl);
            curl_close($curl);
            return $return;
        }
        function generateEmbed($video_url){
            $oembed_endpoint = 'http://vimeo.com/api/oembed';
            $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url) . '&width=507&autoplay=true&iframe=false';
            $oembed = simplexml_load_string(Vimeo2::curl_get($xml_url));
            $randID= rand(0,700);
            $thumb = html_entity_decode($oembed->thumbnail_url);
            $embed = html_entity_decode($oembed->html);
            $id = html_entity_decode($oembed->video_id);
            return '<div class="videoInline phub" id="vidInline-'.sha1(md5($id).$randID).'"><div class="placeholderImg phub" onClick="jQuery(this).hide(); jQuery(\'#vidEmbed-'.sha1(md5($id).$randID).'\').show(); jQuery(\'#vidInline-'.sha1(md5($id).$randID).'\').height(285);"><p class="playVid phub">Play&rang;</p><img src="'.$thumb.'"></div><div id="vidEmbed-'.sha1(md5($id).$randID).'" class="vidEmbed phub">'.$embed.'</div></div>';
        }
    }
    
?>