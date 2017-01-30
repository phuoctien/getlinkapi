<?php
function viewsource($url){
    $ch      = curl_init();
    $timeout = 15;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.69 Safari/537.36");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function GetLinkAPI($curl){ // Use for JWPlayer
    $get = viewsource('https://api.anivn.com/?url=' . $curl);
    $remove = str_replace('\/','/',$get);
    preg_match_all('#"(.+?)":"(.+?)"#',$remove,$data);
    foreach ($data[2] as $i => $quality) {
        if (strpos($data[1][$i], '1080') !== false) {
            $anivn .= '{file: "'.$data[2][$i].'",label: "1080p", type: "video/mp4"},';
        } elseif (strpos($data[1][$i], '720') !== false) {
            $anivn .= '{file: "'.$data[2][$i].'",label: "720p", type: "video/mp4", "default": "true"},';
        } elseif (strpos($data[1][$i], '480') !== false) {
            $anivn .= '{file: "'.$data[2][$i].'",label: "480p", type: "video/mp4"},';
        } elseif (strpos($data[1][$i], '360') !== false) {
            $anivn .= '{file: "'.$data[2][$i].'",label: "360p", type: "video/mp4"}';
        }
    }
    return $anivn;
}

function GetLinkAPI($curl){ // Use for VideoJS
    $get    = viewsource('https://api.anivn.com/?url=' . $curl);
    $remove = str_replace('\/', '/', $get);
    preg_match_all('#"(.+?)":"(.+?)"#', $remove, $data);
    foreach ($data[2] as $i => $quality) {
        if (strpos($data[1][$i], '1080') !== false) {
            $anivn .= '<source src="' . $data[2][$i] . '" type="video/mp4" data-res="1080" />';
        } elseif (strpos($data[1][$i], '720') !== false) {
            $anivn .= '<source src="' . $data[2][$i] . '" type="video/mp4" data-res="720" />';
        } elseif (strpos($data[1][$i], '480') !== false) {
            $anivn .= '<source src="' . $data[2][$i] . '" type="video/mp4" data-res="480" />';
        } elseif (strpos($data[1][$i], '360') !== false) {
            $anivn .= '<source src="' . $data[2][$i] . '" type="video/mp4" data-res="360" />';
        }
    }
    return $anivn;
}

echo GetLinkAPI('Link API for support');
?>