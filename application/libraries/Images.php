<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Images {

    /**
     * Przetwarza obraz na base64, możliwy do przesyłania między stronami
     * jeśli obraz nie istnieje, to zostaje zwrcony specjalnie przygotowany obraz
     * parametry:
     * name - identyfikator serverowy
     * type - rozszerzenie pliku (jpg, png, gif)
     * url - głowny adres serwera
     */
    public function convertImage($params){

        $name = $params['name'];
        $type = $params['type'];
        $url = $params['url'];

        $location = $url.''.$name.'.'.$type;

        $image;

        if(!file_exists($location)){
            switch($type){
                case 'jpg': $image = imagecreatefromjpeg($location); break;
                case 'png': $image = imagecreatefrompng($location); break;
                case 'gif': $image = imagecreatefromgif($location); break;
            }

            ob_start();
                imagepng($image);
                $path = ob_get_contents();
            ob_end_clean();
            
            return base64_encode($path);
        }
    }
}