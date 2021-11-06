<?php

function getCountryCode($ip): string
{
    $curl = curl_init();
    $url = "http://www.geoplugin.net/json.gp?ip=$ip";

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);

    curl_close($curl);
    return json_decode($result, true)['geoplugin_countryCode'];
}
